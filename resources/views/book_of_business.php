<?php
/** Agency Builder CRM — AJAX Actions (upload, notes, sms, email) */
declare(strict_types=1);
session_start();

header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
header('Content-Security-Policy: default-src \'self\'; img-src \'self\' data: blob:; style-src \'self\' \'unsafe-inline\'; script-src \'self\' \'unsafe-inline\';');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
$resp = function(array $d){ header('Content-Type: application/json'); echo json_encode($d); exit; };

// CSRF
if (empty($_POST['csrf']) || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    http_response_code(400); $resp(['ok'=>false,'error'=>'Invalid CSRF token']);
}

// Config (ENV)
$dbDsn  = getenv('DB_DSN') ?: 'mysql:host=127.0.0.1;dbname=lacrm_db;charset=utf8mb4';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$tenantId = isset($_SESSION['tenant_id']) ? (int)$_SESSION['tenant_id'] : null;

try {
    $pdo = new PDO($dbDsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Throwable $e) {
    http_response_code(500); $resp(['ok'=>false,'error'=>'DB connect failed']);
}

$action = $_POST['action'] ?? '';
$clientId = isset($_POST['client_id']) ? (int)$_POST['client_id'] : 0;

// Tenant check helper
function assertClientInTenant(PDO $pdo, ?int $tenantId, int $clientId): bool {
    if (!$clientId) return false;
    if ($tenantId === null) return true;
    $st = $pdo->prepare("SELECT COUNT(*) FROM book_of_business WHERE id=:id AND tenant_id=:t");
    $st->execute([':id'=>$clientId, ':t'=>$tenantId]);
    return (int)$st->fetchColumn() === 1;
}
if ($clientId && !assertClientInTenant($pdo, $tenantId, $clientId)) {
    http_response_code(403); $resp(['ok'=>false,'error'=>'Forbidden']);
}

// ---------- Actions ----------
if ($action === 'add_note') {
    $note = trim((string)($_POST['note'] ?? ''));
    if ($note === '') $resp(['ok'=>false,'error'=>'Empty note']);
    $clientType = 'book_of_business';
    $st = $pdo->prepare("INSERT INTO notes (client_type, client_id, note, created_at) VALUES (:ct,:id,:note,NOW())");
    $st->execute([':ct'=>$clientType, ':id'=>$clientId, ':note'=>$note]);
    $resp(['ok'=>true]);
}

if ($action === 'upload_file') {
    if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        $resp(['ok'=>false,'error'=>'No file uploaded']);
    }
    $f = $_FILES['file'];
    if ($f['size'] > 15 * 1024 * 1024) { $resp(['ok'=>false,'error'=>'Max 15MB']); }
    $allowed = [
        'application/pdf'=>'.pdf',
        'image/jpeg'=>'.jpg',
        'image/png'=>'.png',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'=>'.xlsx',
        'application/vnd.ms-excel'=>'.xls',
    ];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $f['tmp_name']); finfo_close($finfo);
    if (!isset($allowed[$mime])) { $resp(['ok'=>false,'error'=>'Invalid file type']); }

    $ext = $allowed[$mime];
    $base = bin2hex(random_bytes(16)).$ext;
    $dir = __DIR__ . '/uploads/documents';
    if (!is_dir($dir)) { mkdir($dir, 0755, true); }
    $dest = $dir . '/' . $base;

    if (!move_uploaded_file($f['tmp_name'], $dest)) {
        $resp(['ok'=>false,'error'=>'Upload move failed']);
    }

    // Store path against client (or use dedicated table)
    $publicPath = '/uploads/documents/'.$base;
    $sql = "UPDATE book_of_business SET document_path=:p WHERE id=:id";
    if ($tenantId !== null) $sql .= " AND tenant_id=:t";
    $st = $pdo->prepare($sql);
    $st->bindValue(':p', $publicPath);
    $st->bindValue(':id', $clientId, PDO::PARAM_INT);
    if ($tenantId !== null) $st->bindValue(':t', $tenantId, PDO::PARAM_INT);
    $st->execute();

    $resp(['ok'=>true,'path'=>$publicPath]);
}

if ($action === 'send_sms') {
    $to = preg_replace('/\D+/', '', (string)($_POST['to'] ?? ''));
    $msg = trim((string)($_POST['message'] ?? ''));
    if (!$to || $msg==='') $resp(['ok'=>false,'error'=>'Missing to/message']);
    $sid = getenv('TWILIO_ACCOUNT_SID');
    $token = getenv('TWILIO_AUTH_TOKEN');
    $from = preg_replace('/\D+/', '', (string)getenv('TWILIO_FROM'));

    if (!$sid || !$token || !$from) { $resp(['ok'=>false,'error'=>'Twilio not configured']); }

    $payload = http_build_query([
        'From' => '+'.$from,
        'To'   => '+'.$to,
        'Body' => $msg,
    ]);
    $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_USERPWD => $sid.':'.$token,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
    ]);
    $res = curl_exec($ch);
    $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    if ($http>=200 && $http<300) $resp(['ok'=>true]);
    $resp(['ok'=>false,'error'=>$err ?: "Twilio HTTP $http", 'response'=>$res]);
}

if ($action === 'send_email') {
    $to = filter_var((string)($_POST['to'] ?? ''), FILTER_VALIDATE_EMAIL);
    $subject = trim((string)($_POST['subject'] ?? ''));
    $message = trim((string)($_POST['message'] ?? ''));
    if (!$to || $subject==='' || $message==='') $resp(['ok'=>false,'error'=>'Missing to/subject/message']);

    $fromEmail = getenv('SMTP_FROM_EMAIL') ?: 'no-reply@your-domain.tld';
    $fromName  = getenv('SMTP_FROM_NAME') ?: 'Agency Builder CRM';

    $smtpHost = getenv('SMTP_HOST');
    $smtpUser = getenv('SMTP_USER');
    $smtpPass = getenv('SMTP_PASS');
    $smtpPort = (int)(getenv('SMTP_PORT') ?: 587);
    $smtpSecure = getenv('SMTP_SECURE') ?: 'tls';

    $sent = false;
    // Try PHPMailer if available
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        try{
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            if ($smtpHost && $smtpUser && $smtpPass) {
                $mail->isSMTP();
                $mail->Host = $smtpHost;
                $mail->SMTPAuth = true;
                $mail->Username = $smtpUser;
                $mail->Password = $smtpPass;
                $mail->SMTPSecure = $smtpSecure;
                $mail->Port = $smtpPort;
            } else {
                $mail->isMail(); // fall back to mail()
            }
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();
            $sent = true;
        } catch(Throwable $e){
            // will fall through
        }
    }

    // Fallback to mail()
    if (!$sent) {
        $headers = "From: ".sprintf('"%s" <%s>', $fromName, $fromEmail)."\r\n".
                   "Reply-To: ".$fromEmail."\r\n".
                   "MIME-Version: 1.0\r\n".
                   "Content-Type: text/plain; charset=UTF-8\r\n";
        $sent = @mail($to, $subject, $message, $headers);
    }

    if ($sent) $resp(['ok'=>true]);
    $resp(['ok'=>false,'error'=>'Email send failed']);
}

$resp(['ok'=>false,'error'=>'Unknown action']);
