<?php
// -------------------------------------------------------------
// Agency Builder CRM (Tier 1) — Minimal Router (no framework)
// -------------------------------------------------------------
$routes = [
    'dashboard'         => 'dashboard.php',
    'all-contacts'      => 'all_contacts.php',
    'book-of-business'  => 'book_of_business.php',
    'leads'             => 'leads.php',
    'service'           => 'service.php',
    'calendar-activity' => 'calendar_activity.php',
    'activity'          => 'activity.php',
    'billing'           => 'billing.php',
    'settings'          => 'settings.php',
    'logout'            => 'logout.php',
];

$labels = [
    'dashboard'         => 'Dashboard',
    'all-contacts'      => 'All Contacts',
    'book-of-business'  => 'Book of Business',
    'leads'             => 'Leads',
    'service'           => 'Service',
    'calendar-activity' => 'Calendar / Activity',
    'activity'          => 'Activity',
    'billing'           => 'Billing',
    'settings'          => 'Settings',
    'logout'            => 'Logout',
];

$tab = $_GET['tab'] ?? 'dashboard';
if (!array_key_exists($tab, $routes)) {
    $tab = 'dashboard';
}

$page_title = $labels[$tab];

$viewFile = __DIR__ . "/../resources/views/{$routes[$tab]}";
if (!file_exists($viewFile)) {
    http_response_code(404);
    echo "View not found";
    exit;
}

// Render view into buffer:
ob_start();
include $viewFile;     // each view prints its content (no <html> wrapper)
$body = ob_get_clean();

// Layout will use: $page_title, $tab, $body
include __DIR__ . "/../resources/views/layout.php";
