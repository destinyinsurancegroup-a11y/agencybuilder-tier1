<?php
/**
 * Agency Builder CRM — Book of Business (Destiny parity, no SMS/email)
 * Secure version for DigitalOcean / multi-tenant deployment.
 */
declare(strict_types=1);
session_start();

ini_set('display_errors','0');
error_reporting(E_ALL);

/* ---------------- ENV CONFIG ---------------- */
$dbDsn  = getenv('DB_DSN')  ?: 'mysql:host=127.0.0.1;dbname=lacrm_db;charset=utf8mb4';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$tenantId = $_SESSION['tenant_id'] ?? null;

/* ---------------- SECURITY ---------------- */
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
$CSRF = $_SESSION['csrf'];

/* ---------------- DB CONNECT ---------------- */
try {
    $pdo = new PDO($dbDsn,$dbUser,$dbPass,[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
    ]);
} catch(Throwable $e){ exit('DB connection failed.'); }

/* ---------------- HELPERS ---------------- */
function h($v){ return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8'); }
function fmt_us_date($d){ if(!$d||$d==='0000-00-00')return''; $t=strtotime($d); return $t?date('m/d/Y',$t):''; }
function only_digits($s){ return preg_replace('/\D+/','',(string)$s); }

/* ---------------- PAGINATION ---------------- */
$perPage=50;
$page=max(1,(int)($_GET['page']??1));
$offset=($page-1)*$perPage;

$countSql="SELECT COUNT(*) FROM book_of_business".($tenantId?" WHERE tenant_id=:t":"");
$st=$pdo->prepare($countSql);
if($tenantId)$st->bindValue(':t',$tenantId,PDO::PARAM_INT);
$st->execute();
$total=(int)$st->fetchColumn();
$totalPages=max(1,ceil($total/$perPage));

/* ---------------- SEARCH ENDPOINT ---------------- */
if(isset($_GET['find_q'])){
    header('Content-Type:application/json;charset=utf-8');
    $q=trim((string)$_GET['find_q']); if($q===''){echo json_encode(['ok'=>false]);exit;}
    $qLike='%'.$q.'%'; $qLower=mb_strtolower($q); $qLowerLike='%'.$qLower.'%';

    $where="(name LIKE :like OR phone LIKE :like OR LOWER(email) LIKE :llike)";
    if($tenantId)$where.=" AND tenant_id=:t";
    $sql="SELECT id,name FROM book_of_business WHERE $where ORDER BY name ASC LIMIT 1";
    $s=$pdo->prepare($sql);
    $s->bindValue(':like',$qLike); $s->bindValue(':llike',$qLowerLike);
    if($tenantId)$s->bindValue(':t',$tenantId,PDO::PARAM_INT);
    $s->execute(); $row=$s->fetch();

    if(!$row){
        $sql="SELECT id,name FROM book_of_business WHERE name>=:q".($tenantId?" AND tenant_id=:t":"")." ORDER BY name ASC LIMIT 1";
        $s=$pdo->prepare($sql); $s->bindValue(':q',$q); if($tenantId)$s->bindValue(':t',$tenantId,PDO::PARAM_INT);
        $s->execute(); $row=$s->fetch();
    }
    if(!$row){
        $sql="SELECT id,name FROM book_of_business".($tenantId?" WHERE tenant_id=:t":"")." ORDER BY name DESC LIMIT 1";
        $s=$pdo->prepare($sql); if($tenantId)$s->bindValue(':t',$tenantId,PDO::PARAM_INT);
        $s->execute(); $row=$s->fetch();
    }
    if($row){
        $rankSql="SELECT COUNT(*) FROM book_of_business WHERE name<:nm".($tenantId?" AND tenant_id=:t":"");
        $r=$pdo->prepare($rankSql);
        $r->bindValue(':nm',$row['name']); if($tenantId)$r->bindValue(':t',$tenantId,PDO::PARAM_INT);
        $r->execute(); $rank=(int)$r->fetchColumn();
        echo json_encode(['ok'=>true,'page'=>floor($rank/$perPage)+1,'id'=>(int)$row['id']]);exit;
    }
    echo json_encode(['ok'=>false]);exit;
}

/* ---------------- LIST + SELECTED CONTACT ---------------- */
$list="SELECT b.id,b.name,b.phone,b.email,
       CASE WHEN EXISTS(
         SELECT 1 FROM beneficiaries WHERE client_id=b.id AND contacted=0
         UNION SELECT 1 FROM emergency_contacts WHERE client_id=b.id AND contacted=0
       ) THEN 0 ELSE 1 END AS all_contacted
       FROM book_of_business b".($tenantId?" WHERE b.tenant_id=:t":"")." ORDER BY b.name ASC LIMIT :l OFFSET :o";
$s=$pdo->prepare($list);
if($tenantId)$s->bindValue(':t',$tenantId,PDO::PARAM_INT);
$s->bindValue(':l',$perPage,PDO::PARAM_INT);
$s->bindValue(':o',$offset,PDO::PARAM_INT);
$s->execute(); $clients=$s->fetchAll();

$selectedId=(int)($_GET['id']??($clients[0]['id']??0));

$c=null; if($selectedId){
    $sql="SELECT * FROM book_of_business WHERE id=:id".($tenantId?" AND tenant_id=:t":"");
    $s=$pdo->prepare($sql); $s->bindValue(':id',$selectedId,PDO::PARAM_INT);
    if($tenantId)$s->bindValue(':t',$tenantId,PDO::PARAM_INT);
    $s->execute(); $c=$s->fetch();
}
$benef=[];$emer=[];$notes=[];
if($selectedId){
    $b=$pdo->prepare("SELECT * FROM beneficiaries WHERE client_id=?");$b->execute([$selectedId]);$benef=$b->fetchAll();
    $e=$pdo->prepare("SELECT * FROM emergency_contacts WHERE client_id=?");$e->execute([$selectedId]);$emer=$e->fetchAll();
    $n=$pdo->prepare("SELECT note,created_at FROM notes WHERE client_type='book_of_business' AND client_id=? ORDER BY created_at DESC");
    $n->execute([$selectedId]);$notes=$n->fetchAll();
}
$from=$total?($offset+1):0;$to=min($offset+$perPage,$total);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book of Business | Agency Builder CRM</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<style>
:root{--gold:#D4AF37;--bg:#0b0b0c;--panel:#131316;--soft:#1b1b20;--red:#b60000;--green:#0b9e21;}
body{margin:0;font-family:'Segoe UI',Arial,sans-serif;background:var(--bg);color:#fff;overflow:hidden;}
.layout{display:flex;height:100vh;}
.sidebar{width:270px;background:url("/assets/dazz.png") no-repeat center/cover;position:relative;display:flex;flex-direction:column;align-items:center;padding:24px 16px;}
.sidebar::before{content:"";position:absolute;inset:0;background:rgba(0,0,0,0.72);}
.sidebar *{position:relative;z-index:1;}
.sidebar-logo{width:360px;max-width:100%;filter:drop-shadow(0 0 6px rgba(212,175,55,0.9));margin-bottom:10px;}
.sidebar-nav{width:100%;margin-top:10px;}
.sidebar-nav a{display:block;color:#fff;text-decoration:none;padding:10px 12px;margin-bottom:6px;border-radius:8px;border:1px solid rgba(212,175,55,0.25);transition:.18s;font-size:14px;}
.sidebar-nav a:hover{border-color:var(--gold);}
.sidebar-nav a.active{background:rgba(212,175,55,0.15);border-color:var(--gold);font-weight:600;}
.middle{width:330px;background:var(--panel);border-right:1px solid rgba(212,175,55,0.35);display:flex;flex-direction:column;}
.middle-actions{display:flex;gap:8px;align-items:center;justify-content:space-between;padding:12px;border-bottom:1px solid rgba(212,175,55,0.25);}
.btn{background:var(--gold);color:#000;padding:8px 12px;border:none;border-radius:8px;font-weight:700;cursor:pointer;}
.pager{display:flex;align-items:center;justify-content:space-between;padding:8px 12px;border-bottom:1px solid rgba(255,255,255,0.06);background:var(--soft);}
.pg-btn{background:var(--gold);color:#000;border:none;padding:6px 10px;border-radius:8px;font-weight:800;cursor:pointer;}
.search-wrap{padding:8px 12px;border-bottom:1px solid rgba(255,255,255,0.06);}
.search-input{width:100%;padding:8px 10px;border-radius:8px;border:1px solid var(--gold);background:#0a0a0a;color:#fff;}
.contact-list{flex:1;overflow-y:auto;padding:8px;}
.contact-item{display:flex;align-items:center;gap:8px;padding:10px;border-radius:10px;margin-bottom:6px;background:rgba(255,255,255,0.02);}
.contact-item.active{background:rgba(212,175,55,0.15);border:1px solid var(--gold);}
a.name{color:var(--gold);text-decoration:none;font-weight:700;font-size:14.5px;flex:1;}
.dot{width:10px;height:10px;border-radius:50%;}.dot.red{background:var(--red);}.dot.green{background:var(--green);}
.right{flex:1;background:#f7f7f7;color:#000;overflow-y:auto;padding:20px 40px;}
.section{margin-top:22px;background:#fff;border:1px solid #e7e3cc;border-radius:10px;padding:16px 20px;}
.section h3{font-size:18px;font-weight:700;color:#111;border-left:4px solid var(--gold);padding-left:8px;}
.field-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:6px 18px;}
.field label{display:block;font-size:12px;color:#b07900;text-transform:uppercase;}
.field span{display:block;font-size:16px;font-weight:600;color:#000;}
.btn-flat{background:var(--gold);color:#000;border:none;padding:7px 16px;border-radius:8px;font-weight:700;cursor:pointer;}
.note{border-top:1px solid #e5e5e5;padding-top:8px;margin-top:8px;font-size:16px;color:#222;}
</style>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <img src="/assets/images/logo.png" class="sidebar-logo" alt="Agency Builder Logo">
    <nav class="sidebar-nav">
      <a href="/index.php?page=dashboard">Dashboard</a>
      <a href="/index.php?page=all_contacts">All Contacts</a>
      <a href="/index.php?page=book_of_business" class="active">Book of Business</a>
      <a href="/index.php?page=leads">Leads</a>
      <a href="/index.php?page=service">Service</a>
      <a href="/index.php?page=calendar_activity">Calendar / Activity</a>
      <a href="/index.php?page=billing">Billing</a>
      <a href="/index.php?page=settings">Settings</a>
      <a href="/index.php?page=logout">Logout</a>
    </nav>
  </aside>

  <section class="middle">
    <div class="middle-actions">
      <button class="btn" onclick="window.location.href='/contact_form.php?type=book_of_business'">+ Add New Client</button>
      <form action="/import_wizard_step1.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?=h($CSRF)?>">
        <label class="btn" style="cursor:pointer;">Upload CSV<input type="file" name="bulk_file" hidden onchange="this.form.submit()"></label>
      </form>
    </div>
    <div class="pager">
      <span>Showing <?=$from?>–<?=$to?> of <?=$total?></span>
      <div>
        <button class="pg-btn" <?=$page<=1?'disabled':''?> onclick="window.location.href='?page=<?=max(1,$page-1)?>'">◄</button>
        <button class="pg-btn" <?=$page>=$totalPages?'disabled':''?> onclick="window.location.href='?page=<?=min($totalPages,$page+1)?>'">►</button>
      </div>
    </div>
    <div class="search-wrap">
      <input type="text" id="clientSearch" class="search-input" placeholder="Search by name, phone, or email...">
    </div>
    <div class="contact-list" id="contactList">
      <?php foreach($clients as $r):
        $dot=$r['all_contacted']?'green':'red';
        $nm=$r['name'];$ph=$r['phone']??'';$em=$r['email']??'';
      ?>
      <div class="contact-item <?=$r['id']==$selectedId?'active':''?>" data-id="<?=$r['id']?>" data-name="<?=mb_strtolower(h($nm))?>" data-email="<?=mb_strtolower(h($em))?>" data-phone="<?=only_digits($ph)?>">
        <span class="dot <?=$dot?>"></span><a class="name" href="?page=<?=$page?>&id=<?=$r['id']?>"><?=h($nm)?></a>
      </div>
      <?php endforeach;?>
    </div>
  </section>

  <section class="right">
  <?php if($c):?>
    <h1><?=h($c['name'])?></h1>
    <div><strong><?=h($c['phone'])?></strong></div>

    <div class="section">
      <h3>Contact Information</h3>
      <div class="field-grid">
        <div class="field"><label>Address</label><span><?=nl2br(h($c['address']))?></span></div>
        <div class="field"><label>Email</label><span><?=h($c['email'])?></span></div>
        <div class="field"><label>Date of Birth</label><span><?=fmt_us_date($c['dob'])?></span></div>
        <div class="field"><label>Policy Type</label><span><?=h($c['policy_type'])?></span></div>
        <div class="field"><label>Premium</label><span>$<?=number_format((float)$c['premium_amount'],2)?></span></div>
      </div>
    </div>

    <div class="section">
      <h3>Beneficiaries & Emergency Contacts</h3>
      <?php foreach($benef as $b):?>
        <div><?=h($b['name'])?> — <?=h($b['relationship'])?> <?=h($b['phone'])?></div>
      <?php endforeach;?>
      <?php foreach($emer as $e):?>
        <div><?=h($e['name'])?> — <?=h($e['relationship'])?> <?=h($e['phone'])?></div>
      <?php endforeach;?>
    </div>

    <div class="section">
      <h3>Attachments</h3>
      <form method="POST" action="/ajax_actions.php" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?=h($CSRF)?>">
        <input type="hidden" name="action" value="upload_file">
        <input type="hidden" name="client_id" value="<?=$selectedId?>">
        <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.xlsx,.xls">
        <button class="btn-flat">Upload</button>
      </form>
      <?php if(!empty($c['document_path'])):?>
        <div><a href="<?=h($c['document_path'])?>" target="_blank"><?=basename($c['document_path'])?></a></div>
      <?php else:?><div>No attachments uploaded.</div><?php endif;?>
    </div>

    <div class="section">
      <h3>Notes</h3>
      <form method="POST" action="/ajax_actions.php">
        <input type="hidden" name="csrf" value="<?=h($CSRF)?>">
        <input type="hidden" name="action" value="add_note">
        <input type="hidden" name="client_type" value="book_of_business">
        <input type="hidden" name="client_id" value="<?=$selectedId?>">
        <textarea name="note" rows="3" style="width:100%;padding:8px;" placeholder="Add a note..." required></textarea>
        <button class="btn-flat" style="margin-top:6px;">Save Note</button>
      </form>
      <?php foreach($notes as $n):?>
        <div class="note"><small><?=h($n['created_at'])?></small><div><?=nl2br(h($n['note']))?></div></div>
      <?php endforeach;?>
    </div>
  <?php else:?><p>No client selected.</p><?php endif;?>
  </section>
</div>

<script>
function debounce(fn,ms){let t;return function(...a){clearTimeout(t);t=setTimeout(()=>fn.apply(this,a),ms);}}
function digitsOnly(s){return(s||'').replace(/\D+/g,'');}
function focusItemById(id){const i=document.querySelector('.contact-item[data-id="'+id+'"]');if(i){i.scrollIntoView({behavior:'smooth',block:'center'});i.classList.add('active');}}
function findLocal(t){const l=document.getElementById('contactList');const q=t.trim().toLowerCase();if(!q)return null;const d=digitsOnly(q);
const items=[...l.querySelectorAll('.contact-item')];let m=items.find(it=>it.dataset.name.startsWith(q)||it.dataset.email.startsWith(q)||(d&&it.dataset.phone.startsWith(d)));if(m)return parseInt(m.dataset.id);m=items.find(it=>it.dataset.name.includes(q)||it.dataset.email.includes(q)||(d&&it.dataset.phone.includes(d)));return m?parseInt(m.dataset.id):null;}
const onType=debounce(async ev=>{const v=ev.target.value||'';const id=findLocal(v);const cur=<?=$page?>;if(id){focusItemById(id);return;}if(!v.trim())return;
const r=await fetch(`?find_q=${encodeURIComponent(v)}`,{headers:{'Accept':'application/json'}});const d=await r.json().catch(()=>null);
if(d&&d.ok){if(d.page===cur)focusItemById(d.id);else{const p=new URLSearchParams(window.location.search);p.set('page',d.page);p.set('id',d.id);window.location.href=`?${p}`;}}},200);
document.getElementById('clientSearch').addEventListener('input',onType);
</script>
</body>
</html>
