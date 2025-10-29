<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book of Business | Agency Builder CRM</title>
<style>
<?php echo file_get_contents(__DIR__ . '/dashboard.php', false, null, strpos(file_get_contents(__DIR__ . '/dashboard.php'), '<style>') + 7, strpos(file_get_contents(__DIR__ . '/dashboard.php'), '</style>') - strpos(file_get_contents(__DIR__ . '/dashboard.php'), '<style>') - 7); ?>
</style>
</head>
<body>
<div class="sidebar">
  <img src="/assets/images/logo.png" alt="Agency Builder Logo">
  <nav class="sidebar-nav">
    <a href="/index.php?page=dashboard" class="nav-item">🏠 Dashboard</a>
    <a href="/index.php?page=all_contacts" class="nav-item">👥 All Contacts</a>
    <a href="/index.php?page=book_of_business" class="nav-item">📘 Book of Business</a>
    <a href="/index.php?page=leads" class="nav-item">💬 Leads</a>
    <a href="/index.php?page=service" class="nav-item">🧰 Service</a>
    <a href="/index.php?page=calendar_activity" class="nav-item">📅 Calendar / Activity</a>
    <a href="/index.php?page=activity" class="nav-item">📊 Activity</a>
    <a href="/index.php?page=billing" class="nav-item">💳 Billing</a>
    <a href="/index.php?page=settings" class="nav-item">⚙️ Settings</a>
    <a href="/index.php?page=logout" class="nav-item">🚪 Logout</a>
  </nav>
</div>

<div class="main">
  <h1>Book of Business</h1>
  <p class="greeting">Your active client policies and accounts.</p>

  <div class="dashboard-grid">
    <div class="card">
      <h3>📄 Active Policies</h3>
      <ul>
        <li>John Doe — Auto — $125/mo</li>
        <li>Maria Lopez — Home — $90/mo</li>
      </ul>
    </div>

    <div class="card">
      <h3>💰 Monthly Premium Summary</h3>
      <ul>
        <li>Total Clients: 42</li>
        <li>Average Premium: $118</li>
        <li>Total Monthly Volume: $4,956</li>
      </ul>
    </div>
  </div>

  <div class="footer">© 2025 Agency Builder CRM — Tier 1</div>
</div>
</body>
</html>
