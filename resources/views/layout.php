<?php
// $page_title (string), $tab (slug), $body (HTML) are available.
function is_active($current, $tab) { return $current === $tab ? 'active' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> | Agency Builder CRM</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <style>
        /* ===== Base ===== */
        :root{
            --cream: #f8f5ee;
            --cream-panel: #fffdfa;
            --gold: #d6b15d;
            --gold-deep: #b4903d;
            --black: #0e0e0e;
            --ink: #222;
            --muted: #555;
            --card-border: #e0d8c8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--cream);
            color: var(--ink);
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            background: var(--black);
            width: 280px;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            box-shadow: 2px 0 14px rgba(0,0,0,0.5);
        }
        .brand {
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 10px;
        }
        .brand img{
            width: 140px;
            filter: drop-shadow(0 0 4px rgba(201,164,76,0.6));
        }
        .brand h2{
            color: var(--gold);
            font-size: 18px;
            margin: 0;
            letter-spacing: .4px;
            font-weight: 600;
        }

        .nav-item {
            background: #1b1b1b;
            color: #e6e6e6;
            padding: 12px 14px;
            border-radius: 8px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: all .2s ease;
            border: 1px solid #222;
        }
        .nav-item:hover{
            background: var(--gold);
            color: #111;
            transform: translateX(6px);
        }
        .nav-item.active{
            background: var(--gold);
            color: #111;
            font-weight: 700;
            box-shadow: 0 0 6px rgba(214,177,93,.6);
        }

        /* ===== Main ===== */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: var(--cream);
        }
        .main-inner{
            padding: 36px;
            height: 100%;
            overflow: auto;
        }
        .page-header{
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 28px;
        }
        .page-title{
            margin: 0; font-size: 28px; color: #111; font-weight: 800;
        }
        .page-sub{ margin: 0; color: var(--muted); }

        /* Reusable cards */
        .cards{ display: flex; flex-wrap: wrap; gap: 18px; }
        .card{
            background: var(--cream-panel);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 22px 24px;
            box-shadow: 0 6px 12px rgba(0,0,0,.06);
            transition: .25s ease;
        }
        .card:hover{ transform: translateY(-5px); box-shadow: 0 10px 18px rgba(214,177,93,.22); }
        .card h3{ color: var(--gold-deep); margin: 0 0 6px 0; font-size: 15px; font-weight: 700; }
        .card .big{ font-size: 30px; font-weight: 800; color: #111; }

        /* Tables */
        table{ width: 100%; border-collapse: collapse; background: var(--cream-panel); border:1px solid var(--card-border); border-radius: 10px; overflow: hidden;}
        th, td{ padding: 12px 14px; border-bottom:1px solid #eee7d7; }
        th{ background:#fbf7ef; text-align: left; color:#333; font-size: 14px; }
        tr:hover td{ background:#fff9f0; }

        /* Forms */
        .form-card{ max-width: 900px; }
        .row{ display:flex; gap:14px; flex-wrap: wrap;}
        .input{ flex:1; display:flex; flex-direction:column; gap:6px; }
        .input input, .input select, .input textarea{
            padding:12px 12px; border-radius:8px; border:1px solid #dbcfb9; background:#fffdfa; outline:none;
        }
        .btn{
            background: var(--gold); color:#111; border:none; padding:12px 16px; border-radius:8px; cursor:pointer;
            font-weight:700; box-shadow: 0 6px 12px rgba(214,177,93,.2);
        }
        .btn:hover{ filter: brightness(1.05); }

        /* Scrollbar */
        ::-webkit-scrollbar{ width: 10px; } 
        ::-webkit-scrollbar-thumb{ background: var(--gold); border-radius: 6px; } 
        ::-webkit-scrollbar-track{ background: var(--cream); }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand">
            <img src="/assets/images/logo.png" alt="Agency Builder Logo" onerror="this.src='https://via.placeholder.com/140x140?text=Logo'">
            <h2>Agency Builder</h2>
        </div>

        <a class="nav-item <?= is_active('dashboard',$tab)         ?>" href="/?tab=dashboard">🏠 Dashboard</a>
        <a class="nav-item <?= is_active('all-contacts',$tab)      ?>" href="/?tab=all-contacts">👥 All Contacts</a>
        <a class="nav-item <?= is_active('book-of-business',$tab)  ?>" href="/?tab=book-of-business">📚 Book of Business</a>
        <a class="nav-item <?= is_active('leads',$tab)             ?>" href="/?tab=leads">💬 Leads</a>
        <a class="nav-item <?= is_active('service',$tab)           ?>" href="/?tab=service">🛠 Service</a>
        <a class="nav-item <?= is_active('calendar-activity',$tab) ?>" href="/?tab=calendar-activity">🗓 Calendar / Activity</a>
        <a class="nav-item <?= is_active('activity',$tab)          ?>" href="/?tab=activity">📈 Activity</a>
        <a class="nav-item <?= is_active('billing',$tab)           ?>" href="/?tab=billing">💳 Billing</a>
        <a class="nav-item <?= is_active('settings',$tab)          ?>" href="/?tab=settings">⚙️ Settings</a>
        <a class="nav-item <?= is_active('logout',$tab)            ?>" href="/?tab=logout">🚪 Logout</a>
    </aside>

    <main class="main">
        <div class="main-inner">
            <div class="page-header">
                <h1 class="page-title"><?= htmlspecialchars($page_title) ?></h1>
                <p class="page-sub">Elegant • Secure • Professional</p>
            </div>
            <?= $body ?>
        </div>
    </main>
</body>
</html>
