<?php
date_default_timezone_set('America/Detroit');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book of Business | Agency Builder CRM</title>
<style>
<?php include 'dashboard_styles.css'; ?>
</style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main">
  <h1>Book of Business</h1>
  <p class="greeting">Your active client portfolio and policy data.</p>

  <div class="dashboard-grid">
    <div class="card">
      <h3>📊 Active Clients</h3>
      <ul>
        <li>John Doe — Life Policy — $250/mo</li>
        <li>Sarah Lee — Health Policy — $190/mo</li>
        <li>Paul Nguyen — Auto Policy — $115/mo</li>
      </ul>
    </div>

    <div class="card">
      <h3>💰 Monthly Premium</h3>
      <ul>
        <li>Total Collected: $3,750</li>
        <li>Projected Annual: $45,000</li>
      </ul>
    </div>
  </div>

  <div class="footer">© 2025 Agency Builder CRM — Tier 1 Edition</div>
</div>
</body>
</html>
