<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Leads | Agency Builder CRM</title>
<style>
<?php include 'dashboard_styles.css'; ?>
</style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main">
  <h1>Leads</h1>
  <p class="greeting">Upload new leads or manage existing ones.</p>

  <div class="dashboard-grid">
    <div class="card">
      <h3>📥 Upload Leads</h3>
      <form>
        <input type="file" accept=".csv">
        <button type="submit">⬆️ Upload CSV</button>
      </form>
    </div>

    <div class="card">
      <h3>📋 Recently Added Leads</h3>
      <ul>
        <li>Michael Brown — Pending</li>
        <li>Olivia Chen — Contacted</li>
      </ul>
    </div>
  </div>

  <div class="footer">© 2025 Agency Builder CRM — Tier 1 Edition</div>
</div>
</body>
</html>
