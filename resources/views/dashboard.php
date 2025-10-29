<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agency Builder CRM - Dashboard</title>

  <style>
    :root {
      --gold: #d4af37;
      --cream: #fffdf7;
      --dark: #1a1a1a;
      --gray: #555;
      --border: #e6e0c7;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: var(--cream);
      color: var(--dark);
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background: linear-gradient(180deg, #0d0d0d, #1e1e1e);
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px 20px;
      box-shadow: 3px 0 10px rgba(0, 0, 0, 0.4);
    }

    .sidebar img {
      width: 140px;
      margin-bottom: 20px;
      filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.8));
    }

    .sidebar h2 {
      color: var(--gold);
      font-size: 20px;
      margin-bottom: 25px;
      text-align: center;
    }

    .nav-item {
      width: 100%;
      background-color: #222;
      border: 1px solid #333;
      border-radius: 8px;
      color: #ddd;
      font-size: 15px;
      padding: 10px 15px;
      margin-bottom: 10px;
      text-align: left;
      cursor: pointer;
      transition: 0.3s;
    }

    .nav-item:hover,
    .nav-item.active {
      background-color: var(--gold);
      color: var(--dark);
    }

    /* Main Area */
    .main {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      height: 100vh;
      padding: 40px 50px;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .header h1 {
      font-size: 28px;
      margin: 0;
      color: var(--dark);
    }

    .header .greeting {
      font-size: 18px;
      font-weight: 600;
      color: var(--gold);
    }

    /* Search bar */
    .search-bar {
      display: flex;
      align-items: center;
      border: 2px solid var(--gold);
      border-radius: 8px;
      overflow: hidden;
      width: 280px;
    }

    .search-bar input {
      flex: 1;
      border: none;
      outline: none;
      padding: 8px 10px;
      font-size: 14px;
      background: var(--cream);
      color: var(--dark);
    }

    .search-bar button {
      background: var(--gold);
      border: none;
      padding: 8px 14px;
      cursor: pointer;
      font-weight: bold;
      color: var(--dark);
    }

    /* Dashboard Content */
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 15px;
    }

    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 25px;
      margin-top: 25px;
    }

    .card {
      background: var(--cream);
      border: 1px solid var(--border);
      border-left: 6px solid var(--gold);
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      padding: 20px 25px;
      transition: all 0.2s ease;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    }

    .card h2 {
      font-size: 18px;
      color: var(--dark);
      border-bottom: 2px solid var(--gold);
      padding-bottom: 5px;
      margin-top: 0;
      margin-bottom: 12px;
    }

    .card ul {
      list-style: none;
      padding-left: 0;
      margin: 0;
    }

    .card li {
      font-size: 15px;
      color: var(--gray);
      padding: 4px 0;
    }

    .footer {
      text-align: center;
      font-size: 13px;
      color: #888;
      margin-top: 40px;
    }
  </style>
</head>

<body>
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <img src="/assets/images/logo.png" alt="Agency Builder Logo" />
    <h2>Agency Builder</h2>

    <div class="nav-item active">🏠 Dashboard</div>
    <div class="nav-item">👥 All Contacts</div>
    <div class="nav-item">📘 Book of Business</div>
    <div class="nav-item">💬 Leads</div>
    <div class="nav-item">🧰 Service</div>
    <div class="nav-item">📅 Calendar / Activity</div>
    <div class="nav-item">📊 Activity</div>
    <div class="nav-item">💳 Billing</div>
    <div class="nav-item">⚙️ Settings</div>
    <div class="nav-item">🚪 Logout</div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main">
    <div class="dashboard-header">
      <div>
        <h1>CRM Dashboard</h1>
        <div class="greeting">Good Morning, Agent 👋</div>
      </div>

      <form class="search-bar">
        <input type="text" placeholder="Search by name, phone, or email..." />
        <button type="submit">🔍</button>
      </form>
    </div>

    <div class="dashboard-grid">
      <div class="card">
        <h2>📈 Current Production</h2>
        <ul>
          <li><strong>Today:</strong> 3 calls / 2 answered / 0 stops</li>
          <li><strong>Week:</strong> 15 calls / 12 answered / 3 pres / 1 sale</li>
          <li><strong>Month:</strong> 5 apps / $3,800 premium</li>
          <li><strong>Annualized Premium:</strong> $45,600</li>
        </ul>
      </div>

      <div class="card">
        <h2>📅 Upcoming Appointments</h2>
        <ul>
          <li>Tomorrow — John Doe (Policy Review)</li>
          <li>Friday — Sarah Lee (New Client)</li>
          <li>Monday — Team Meeting</li>
        </ul>
      </div>

      <div class="card">
        <h2>🌟 Today’s Insights</h2>
        <ul>
          <li>🎂 <strong>Birthdays:</strong> 2 upcoming this week</li>
          <li>💍 <strong>Anniversaries:</strong> None in next 10 days</li>
        </ul>
      </div>

      <div class="card">
        <h2>🆕 Recently Added Contacts</h2>
        <ul>
          <li>James Carter — Added today</li>
          <li>Alicia Barnes — Added 2 days ago</li>
          <li>Henry Wilson — Added 4 days ago</li>
        </ul>
      </div>
    </div>

    <div class="footer">© 2025 Agency Builder CRM — Tier 1 Edition</div>
  </main>
</body>
</html>
