<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Builder CRM - Tier 1</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0e0e0e;
            color: #f8f8f8;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            background-color: #161616;
            width: 260px;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.5);
        }

        .sidebar img {
            width: 280px; /* 200% bigger logo */
            margin-bottom: 20px;
        }

        .sidebar h2 {
            color: #c9a44c;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .nav-item {
            width: 100%;
            padding: 12px 16px;
            margin: 6px 0;
            background-color: #1f1f1f;
            border-radius: 6px;
            text-align: left;
            color: #ccc;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.25s;
        }

        .nav-item:hover {
            background-color: #c9a44c;
            color: #111;
        }

        .nav-item.active {
            background-color: #c9a44c;
            color: #111;
            font-weight: 600;
        }

        .main {
            flex-grow: 1;
            background-color: #181818;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 28px;
            color: #c9a44c;
            margin: 0;
        }

        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background-color: #222;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 25px 30px;
            width: 200px;
            text-align: center;
        }

        .card h3 {
            color: #c9a44c;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 24px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="/assets/images/logo.png" alt="Agency Builder Logo">
        <h2>Agency Builder</h2>

        <div class="nav-item active">🏠 Dashboard</div>
        <div class="nav-item" onclick="window.location='/mynumbers'">📈 My Numbers</div>
        <div class="nav-item">💬 Leads</div>
        <div class="nav-item">📞 Calls</div>
        <div class="nav-item">🧾 Sales</div>
    </div>

    <div class="main">
        <div class="header">
            <h1>Tier 1 Dashboard</h1>
            <p>Welcome, Agent</p>
        </div>

        <div class="stats">
            <div class="card">
                <h3>Leads</h3>
                <p>45</p>
            </div>
            <div class="card">
                <h3>Presentations</h3>
                <p>12</p>
            </div>
            <div class="card">
                <h3>Sales</h3>
                <p>5</p>
            </div>
            <div class="card">
                <h3>Conversion</h3>
                <p>41%</p>
            </div>
        </div>
    </div>
</body>
</html>
