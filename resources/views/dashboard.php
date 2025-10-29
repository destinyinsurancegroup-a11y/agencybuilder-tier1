<?php
// Agency Builder CRM - Tier 1 Dashboard
date_default_timezone_set('America/Detroit');

$hour = (int)date('H');
$agentName = "Agent"; // later, dynamically pull from login session
$greeting = ($hour < 12) ? "Good Morning, $agentName 👋" : (($hour < 18) ? "Good Afternoon, $agentName 👋" : "Good Evening, $agentName 👋");
$currentTime = date('l, F j, Y — g:i A');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Agency Builder CRM | Dashboard</title>
<style>
:root {
  --gold: #D4AF37;
  --cream: #fffdf7;
  --dark: #111;
  --light: #f8f8f8;
  --border: #e7e3cc;
}
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: var(--cream);
  color: var(--dark);
  overflow: hidden;
  display: flex;
  height: 100vh;
}

/* Sidebar */
.sidebar {
  width: 260px;
  background: #1a1a1a;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 30px 20px;
  box-shadow: 2px 0 10px rgba(0,0,0,0.4);
}
.sidebar img {
  width: 130px;
  margin-bottom: 15px;
  filter: drop-shadow(0 0 6px rgba(212,175,55,0.8));
}
.sidebar h2 {
  color: var(--gold);
  font-size: 20px;
  margin-bottom: 20px;
}
.nav-item {
  width: 100%;
  background: #222;
  color: #ddd;
  text-decoration: none;
  padding: 10px 15px;
  margin-bottom: 8px;
  border-radius: 6px;
  display: block;
  transition: 0.3s;
  border: 1px solid #333;
}
.nav-item:hover, .nav-item.active {
  background: var(--gold);
  color: #111;
}

/* Main Content */
.main {
  flex-grow: 1;
  background: linear-gradient(180deg, var(--light), var(--cream));
  overflow-y: auto;
  padding: 40px 60px;
}

/* Header */
.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}
.dashboard-header h1 {
  margin: 0;
  font-size: 30px;
  color: var(--dark);
}
.greeting {
  font-size: 20px;
  font-weight: bold;
  color: var(--gold);
  margin-top: 5px;
}
.time {
  font-size: 14px;
  color: #555;
  font-weight: 600;
}
.search-bar {
  display: flex;
  align-items: center;
  border: 2px solid var(--gold);
  border-radius: 8px;
  overflow: hidden;
  background: var(--cream);
}
.search-bar input {
  border: none;
  padding: 10px;
  width: 220px;
  font-size: 14px;
  background: var(--cream);
  outline: none;
}
.search-bar button {
  background: var(--gold);
  border: none;
  padding: 10px 15px;
  cursor: pointer;
  font-weight: bold;
}

/* Cards */
.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 25px;
}
.card {
  background: var(--cream);
  border: 1px solid var(--border);
  border-radius: 12px;
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
  padding: 20px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.card h3 {
  border-left: 4px solid var(--gold);
  padding-left: 8px;
  color: var(--dark);
  margin-top: 0;
  font-size: 18px;
  font-weight: bold;
}
.card ul {
  list-style: none;
  margin: 10px 0 0;
  padding: 0;
}
.card li {
  margin-bottom: 6px;
  font-size: 15px;
}

/* Footer */
.footer {
  margin-top: 40px;
  text-align: center;
  color: #777;
  font-size: 13px;
  padding-bottom: 20px;
}
</style>
</head>
<body>

<div class="sidebar">
  <img src="/assets/images/logo.png" alt="Agency Builder Logo">
  <h2>Agency Builder</h2>
  <a href="dashboard.php" class="nav-item active">🏠 Dashboard</a>
  <a href="all_contacts.php" class="nav-item">👥 All Contacts</a>
  <a href="book_of_business.php" class="nav-item">📘 Book of Business</a>
  <a href="leads.php" class="nav-item">💬 Leads</a>
  <a href="service.php" class="nav-item">🧰 Service</a>
  <a href="calendar_activity.php" class="nav-item">📅 Calendar / Activity</a>
  <a href="activity.php" class="nav-item">📊 Activity</a>
  <a href="billing.php" class="nav-item">💳 Billing</a>
  <a href="settings.php" class="nav-item">⚙️ Settings</a>
  <a href="logout.php" class="nav-item">🚪 Logout</a>
</div>

<div class="main">
  <div class="dashboard-header">
    <div>
      <h1>Dashboard</h1>
      <div class="greeting"><?= $greeting ?></div>
      <div class="time"><?= $currentTime ?></div>
    </div>
    <form class="search-bar" method="GET" action="search_results.php">
      <input type="text" name="q" placeholder="Search by name, phone, or email...">
      <button type="submit">🔍</button>
    </form>
  </div>

  <div class="dashboard-grid">
    <div class="card">
      <h3>📈 Current Production</h3>
      <ul>
        <li><strong>Today:</strong> 5 calls / 3 answered / 1 stop</li>
        <li><strong>Week:</strong> 25 calls / 15 answered / 10 pres / 3 sales</li>
        <li><strong>Month:</strong> 8 apps / $4,200 premium</li>
        <li><strong>Annualized Premium:</strong> $50,400</li>
      </ul>
    </div>

    <div class="card">
      <h3>📅 Upcoming Appointments</h3>
      <ul>
        <li>Tomorrow — Jane Smith (Policy Review)</li>
        <li>Friday — Tom Harris (New Client)</li>
        <li>Monday — Team Call</li>
      </ul>
    </div>

    <div class="card">
      <h3>🌟 Today’s Insights</h3>
      <ul>
        <li>🎂 <strong>Birthdays:</strong> 1 upcoming this week</li>
        <li>💍 <strong>Anniversaries:</strong> None this week</li>
      </ul>
    </div>

    <div class="card">
      <h3>🆕 Recently Added Contacts</h3>
      <ul>
        <li>James Carter — Added today</li>
        <li>Maria Lopez — Added yesterday</li>
        <li>Henry Wilson — Added 3 days ago</li>
      </ul>
    </div>
  </div>

  <div class="footer">
    © 2025 Agency Builder CRM — Tier 1 Edition
  </div>
</div>

</body>
</html>
