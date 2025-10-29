<?php
// Agency Builder CRM Dashboard (Warm white-gold aesthetic)
date_default_timezone_set('America/Detroit');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=agencybuilder_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $col = $pdo->query("SHOW COLUMNS FROM activity_log LIKE 'answered'")->fetch();
    if (!$col) $pdo->exec("ALTER TABLE activity_log ADD COLUMN answered INT DEFAULT 0");
} catch (PDOException $e) { die("Database connection failed: " . $e->getMessage()); }

$hour = (int)date('H');
$greeting = ($hour < 12) ? "Good Morning, Agent 👋" : (($hour < 18) ? "Good Afternoon, Agent 👋" : "Good Evening, Agent 👋");
$currentTime = date('l, F j, Y — g:i A');
$today = date('Y-m-d');
$weekStart = date('Y-m-d', strtotime('monday this week'));
$monthStart = date('Y-m-01');

function getTotals($pdo, $start, $end) {
    $stmt = $pdo->prepare("
        SELECT SUM(calls) AS calls, SUM(answered) AS answered, SUM(stops) AS stops,
               SUM(presentations) AS presentations, SUM(nos) AS nos,
               SUM(sales_apps) AS sales_apps, SUM(sales_premium) AS sales_premium
        FROM activity_log WHERE log_date BETWEEN ? AND ?
    ");
    $stmt->execute([$start, $end]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$daily   = getTotals($pdo, $today, $today);
$weekly  = getTotals($pdo, $weekStart, $today);
$monthly = getTotals($pdo, $monthStart, $today);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Agency Builder CRM | Dashboard</title>
<style>
:root {
  --gold:#D4AF37;
  --cream:#fffdf7;
  --light:#f8f8f8;
  --dark:#111;
  --text:#000;
  --soft-border:#e7e3cc;
}
body {
  margin:0;
  font-family:'Segoe UI',Arial,sans-serif;
  background:var(--cream);
  color:var(--text);
  overflow:hidden;
}
.layout {
  display:flex;
  height:100vh;
}
/* Sidebar */
.sidebar {
  width:270px;
  background:url("../assets/dazz.png") center/cover no-repeat;
  position:relative;
  display:flex;
  flex-direction:column;
  align-items:center;
  padding:24px 16px;
}
.sidebar::before {
  content:"";
  position:absolute;
  inset:0;
  background:rgba(0,0,0,0.7);
}
.sidebar * { position:relative; z-index:1; }
.sidebar-logo {
  width:160px;
  max-width:100%;
  filter:drop-shadow(0 0 6px rgba(212,175,55,0.9));
  margin-bottom:15px;
}
.sidebar h2 {
  color:var(--gold);
  font-weight:700;
  font-size:20px;
  margin-bottom:20px;
}
.sidebar-nav { width:100%; margin-top:10px; }
.sidebar-nav a {
  display:block;
  color:#fff;
  text-decoration:none;
  padding:10px 12px;
  margin-bottom:6px;
  border-radius:8px;
  border:1px solid rgba(212,175,55,0.25);
  background:linear-gradient(180deg,rgba(255,255,255,0.02),rgba(0,0,0,0.25));
  transition:.2s;
  font-size:14px;
}
.sidebar-nav a:hover {
  border-color:var(--gold);
  box-shadow:0 0 10px rgba(212,175,55,0.35);
}
.sidebar-nav a.active {
  background:rgba(212,175,55,0.25);
  border-color:var(--gold);
  font-weight:600;
}

/* Main Content */
.content {
  flex:1;
  background:linear-gradient(180deg,var(--light),var(--cream));
  overflow-y:auto;
  padding:40px 60px;
  box-shadow:inset 0 0 12px rgba(0,0,0,0.08);
}
h1 {
  font-size:32px;
  font-weight:800;
  margin:0;
  color:var(--dark);
}
.greeting {
  font-size:20px;
  font-weight:700;
  color:var(--gold);
  margin-top:4px;
}
.time {
  font-size:14px;
  color:#555;
  font-weight:600;
  margin-bottom:10px;
}
.dashboard-header {
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  margin-bottom:30px;
}
.search-bar {
  display:flex;
  align-items:center;
  border:2px solid var(--gold);
  border-radius:10px;
  overflow:hidden;
  background:var(--cream);
}
.search-bar input {
  border:none;
  padding:10px 12px;
  width:220px;
  font-size:14px;
  outline:none;
  background:var(--cream);
}
.search-bar button {
  background:var(--gold);
  border:none;
  padding:10px 14px;
  cursor:pointer;
  font-weight:bold;
  color:#000;
}

/* Cards */
.dashboard-grid {
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:25px;
  margin-top:25px;
}
.card {
  border:1px solid var(--soft-border);
  border-radius:12px;
  background:var(--cream);
  box-shadow:0 6px 16px rgba(0,0,0,0.08);
  padding:20px 25px;
  transition:transform .15s ease, box-shadow .15s ease;
}
.card:hover {
  transform:translateY(-3px);
  box-shadow:0 8px 18px rgba(0,0,0,0.12);
}
.card h3 {
  border-left:4px solid var(--gold);
  padding-left:8px;
  font-size:18px;
  color:var(--dark);
  margin-top:0;
  font-weight:800;
}
.card ul { list-style:none; padding-left:0; margin:0; }
.card li { margin-bottom:6px; font-size:15px; color:#222; }

.footer {
  text-align:center;
  font-size:13px;
  color:#777;
  margin-top:40px;
}

/* Scrollbar */
::-webkit-scrollbar {
  width:8px;
}
::-webkit-scrollbar-thumb {
  background:var(--gold);
  border-radius:4px;
}
</style>
</head>
<body>
<div class="layout">
  <!-- Sidebar -->
  <aside class="sidebar">
    <img src="../assets/agencybuilder_logo.png" class="sidebar-logo" alt="Agency Builder Logo">
    <h2>Agency Builder</h2>
    <nav class="sidebar-nav">
      <a href="dashboard.php" class="active">🏠 Dashboard</a>
      <a href="all_contacts.php">👥 All Contacts</a>
      <a href="book_of_business.php">📘 Book of Business</a>
      <a href="leads.php">💬 Leads</a>
      <a href="service.php">🧰 Service</a>
      <a href="calendar_activity.php">📅 Calendar / Activity</a>
      <a href="activity.php">📊 Activity</a>
      <a href="billing.php">💳 Billing</a>
      <a href="settings.php">⚙️ Settings</a>
      <a href="logout.php">🚪 Logout</a>
    </nav>
  </aside>

  <!-- Content -->
  <main class="content">
    <div class="dashboard-header">
      <div>
        <h1>CRM Dashboard</h1>
        <div class="greeting"><?= $greeting ?></div>
      </div>
      <div class="header-right">
        <div class="time"><?= $currentTime ?></div>
        <form class="search-bar" method="GET" action="search_results.php">
          <input type="text" name="q" placeholder="Search by name, phone, or email..." />
          <button type="submit">🔍</button>
        </form>
      </div>
    </div>

    <!-- Grid Cards -->
    <div class="dashboard-grid">
      <div class="card">
        <h3>📈 Current Production</h3>
        <ul>
          <li><strong>Today:</strong> <?= $daily['calls'] ?? 0 ?> calls / <?= $daily['answered'] ?? 0 ?> answered / <?= $daily['stops'] ?? 0 ?> stops</li>
          <li><strong>Week:</strong> <?= $weekly['calls'] ?? 0 ?> calls / <?= $weekly['answered'] ?? 0 ?> answered / <?= $weekly['stops'] ?? 0 ?> stops / <?= $weekly['presentations'] ?? 0 ?> pres / <?= $weekly['nos'] ?? 0 ?> no’s</li>
          <li><strong>Month:</strong> <?= $monthly['sales_apps'] ?? 0 ?> apps / $<?= number_format($monthly['sales_premium'] ?? 0, 2) ?> premium</li>
          <li><strong>Annualized Premium:</strong> $<?= number_format(($monthly['sales_premium'] ?? 0) * 12, 2) ?></li>
        </ul>
      </div>

      <div class="card">
        <h3>📅 Upcoming Appointments</h3>
        <ul>
          <li>Tomorrow — John Doe (Policy Review)</li>
          <li>Friday — Sarah Lee (New Client)</li>
          <li>Monday — Team Meeting</li>
        </ul>
      </div>

      <div class="card">
        <h3>🌟 Today’s Insights</h3>
        <ul>
          <li>🎂 <strong>Birthdays:</strong> 2 upcoming this week</li>
          <li>💍 <strong>Anniversaries:</strong> None in next 10 days</li>
        </ul>
      </div>

      <div class="card">
        <h3>🆕 Recently Added Contacts</h3>
        <ul>
          <li>James Carter — Added today</li>
          <li>Alicia Barnes — Added 2 days ago</li>
          <li>Henry Wilson — Added 4 days ago</li>
        </ul>
      </div>
    </div>

    <div class="footer">© 2025 Agency Builder CRM — Tier 1 Edition</div>
  </main>
</div>
</body>
</html>
