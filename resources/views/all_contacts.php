<?php
date_default_timezone_set('America/Detroit');
$currentTime = date('l, F j, Y — g:i A');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Contacts | Agency Builder CRM</title>
<style>
<?php include 'dashboard_styles.css'; ?>
</style>
</head>
<body>

<div class="sidebar">
  <img src="/assets/images/logo.png" alt="Agency Builder Logo">
  <h2>Agency Builder</h2>
  <a href="?page=dashboard" class="nav-item">🏠 Dashboard</a>
  <a href="?page=all_contacts" class="nav-item active">👥 All Contacts</a>
  <a href="?page=book_of_business" class="nav-item">📘 Book of Business</a>
  <a href="?page=leads" class="nav-item">💬 Leads</a>
  <a href="?page=service" class="nav-item">🧰 Service</a>
  <a href="?page=calendar_activity" class="nav-item">📅 Calendar / Activity</a>
  <a href="?page=activity" class="nav-item">📊 Activity</a>
  <a href="?page=billing" class="nav-item">💳 Billing</a>
  <a href="?page=settings" class="nav-item">⚙️ Settings</a>
  <a href="?page=logout" class="nav-item">🚪 Logout</a>
</div>

<div class="main">
  <h1>All Contacts</h1>
  <p class="greeting">Here you can view and manage everyone in your CRM.</p>
  <form class="search-bar">
    <input type="text" placeholder="Search contacts by name, email, or phone...">
    <button type="submit">🔍</button>
  </form>

  <div class="dashboard-grid">
    <div class="card">
      <h3>👥 Contact List</h3>
      <ul>
        <li>James Carter — (555) 123-4567</li>
        <li>Maria Lopez — (555) 987-6543</li>
        <li>Henry Wilson — (555) 444-1212</li>
      </ul>
    </div>
  </div>

  <div class="footer">© 2025 Agency Builder CRM — Tier 1 Edition</div>
</div>

</body>
</html>
