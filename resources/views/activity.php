<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Activity Tracker | Agency Builder CRM</title>
<style>
<?php include 'dashboard_styles.css'; ?>
</style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main">
  <h1>Activity Tracker</h1>
  <p class="greeting">Record your daily, weekly, and monthly numbers.</p>

  <div class="card">
    <h3>🧮 Enter Activity</h3>
    <form>
      <label>Calls:</label><input type="number" min="0">
      <label>Answered:</label><input type="number" min="0">
      <label>Stops:</label><input type="number" min="0">
      <label>Presentations:</label><input type="number" min="0">
      <label>Sales:</label><input type="number" min="0">
      <label>Premium ($):</label><input type="number" step="0.01" min="0">
      <button type="submit">💾 Save</button>
    </form>
  </div>

  <div class="footer">© 2025 Agency Builder CRM — Tier 1 Edition</div>
</div>
</body>
</html>
