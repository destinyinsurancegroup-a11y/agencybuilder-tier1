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
            background-color: #111;
            color: #f8f8f8;
            display: flex;
            height: 100vh;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            background-color: #1a1a1a;
            width: 260px;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.4);
        }

        .sidebar img {
            width: 120px;
            margin-bottom: 30px;
        }

        .sidebar h2 {
            color: #c9a44c;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .nav-item {
            width: 100%;
            padding: 12px 16px;
            margin: 6px 0;
            background-color: #222;
            border-radius: 6px;
            text-align: left;
            color: #ddd;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .nav-item:hover {
            background-color: #c9a44c;
            color: #111;
        }

        /* ===== Main Area ===== */
        .main {
            flex-grow: 1;
            background-color: #181818;
            padding: 40px;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #c9a44c;
            margin: 0;
        }

        .stats {
            display: flex;
            gap: 20px;
        }

        .card {
            background-color: #222;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 20px 30px;
            width: 200px;
            text-align: center;
        }

        .card h3 {
            color: #c9a44c;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 22px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <!-- placeholder for logo -->
        <img src="https://via.placeholder.com/120x120?text=Logo" alt="Agency Builder Logo">
        <h2>Agency Builder</h2>
        <div class="nav-item">🏠 Dashboard</div>
        <div class="nav-item">📈 My Numbers</div>
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
