<?php
// ==============================================
// Agency Builder CRM - Tier 1 (Bootstrap)
// ==============================================

// Basic routing simulation (for demo)
$request = $_SERVER['REQUEST_URI'];

if ($request === '/' || $request === '/index.php') {
    include __DIR__ . '/../resources/views/welcome.blade.php';
    exit;
}

// Handle missing routes
http_response_code(404);
echo "<h1>404 - Page Not Found</h1>";
?>
