<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'Agency Builder CRM'; ?></title>
  <link rel="icon" href="/assets/images/logo.png">

  <style>
    :root {
      --gold: #d4af37;
      --cream: #fffdf7;
      --dark: #1a1a1a;
      --border: #e6e0c7;
      --gray: #555;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      height: 100vh;
      overflow: hidden;
      background: var(--cream);
      color: var(--dark);
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background: linear-gradient(180deg, #0d0d0d, #1e1e1e);
      padding: 30px 20px;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      box-shadow: 3px 0 10px rgba(0, 0, 0, 0.4);
    }

    .sidebar img {
      width: 140px;
      margin-bottom: 20px;
      filter: drop-shadow(0 0 8px rgba(212,175,55,0.8));
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

    .nav-item:hover, .nav-item.active {
      background-color: var(--gold);
      color: var(--dark);
    }

    /* Main Area */
    .main {
      flex-grow: 1;
      overflow-y: auto;
      height: 100vh;
      padding: 40px 50px;
    }
  </style>
</head>

<body>
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <img src="/assets/images/logo.png" alt="Agency Builder Logo">
    <h2>Agency Builder</h2>

    <a href="dashboard.php" class="nav-item <?php if ($activeTab=='dashboard') echo 'active'; ?>">🏠 Dashboard</a>
    <a href="all_contacts.php" class="nav-item <?php if ($activeTab=='all_contacts') echo 'active'; ?>">👥 All Contacts</a>
    <a href="book_of_business.php" class="nav-item <?php if ($activeTab=='book') echo 'active'; ?>">📘 Book of Business</a>
    <a href="leads.php" class="nav-item <?php if ($activeTab=='leads') echo 'active'; ?>">💬 Leads</a>
    <a href="service.php" class="nav-item <?php if ($activeTab=='service') echo 'active'; ?>">🧰 Service</a>
    <a href="calendar_activity.php" class="nav-item <?php if ($activeTab=='calendar') echo 'active'; ?>">📅 Calendar / Activity</a>
    <a href="activity.php" class="nav-item <?php if ($activeTab=='activity') echo 'active'; ?>">📊 Activity</a>
    <a href="billing.php" class="nav-item <?php if ($activeTab=='billing') echo 'active'; ?>">💳 Billing</a>
    <a href="settings.php" class="nav-item <?php if ($activeTab=='settings') echo 'active'; ?>">⚙️ Settings</a>
    <a href="logout.php" class="nav-item <?php if ($activeTab=='logout') echo 'active'; ?>">🚪 Logout</a>
  </aside>

  <!-- MAIN CONTENT AREA -->
  <main class="main">
    <?php include($viewFile); ?>
  </main>
</body>
</html>
