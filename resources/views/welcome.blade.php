<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Builder CRM - Tier 1</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <style>
        /* ===== Base ===== */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f5ee; /* lighter cream-beige */
            color: #222;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            background-color: #0e0e0e; /* near black sidebar */
            width: 260px;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.5);
        }

        .sidebar img {
            width: 140px;
            margin-bottom: 15px;
            filter: drop-shadow(0 0 4px rgba(201,164,76,0.6));
        }

        .sidebar h2 {
            color: #c9a44c;
            font-size: 19px;
            font-weight: 600;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        .nav-item {
            width: 100%;
            padding: 12px 16px;
            margin: 6px 0;
            background-color: #1b1b1b;
            border-radius: 6px;
            text-align: left;
            color: #e4e4e4;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .nav-item:hover {
            background-color: #d6b15d; /* lighter gold hover */
            color: #111;
        }

        .nav-item.active {
            background-color: #d6b15d; /* gold highlight like Destiny */
            color: #111;
            font-weight: 600;
            box-shadow: 0 0 6px rgba(214,177,93,0.6);
        }

        /* ===== Main Dashboard Area ===== */
        .main {
            flex-grow: 1;
            background-color: #f8f5ee; /* light beige background */
            padding: 40px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 28px;
            color: #111;
            margin: 0;
            letter-spacing: 0.5px;
            font-weight: 700;
        }

        .header p {
            font-size: 15px;
            color: #555;
            margin: 0;
        }

        /* ===== Dashboard Cards ===== */
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background-color: #fffdfa; /* cream panel */
            border: 1px solid #e0d8c8;
            border-radius: 10px;
            padding: 25px 30px;
            width: 220px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(214,177,93,0.2);
        }

        .card h3 {
            color: #b4903d;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 16px;
        }

        .card p {
            font-size: 24px;
            margin: 0;
            color: #222;
            font-weight: 600;
        }

        /* ===== Scrollbar Styling ===== */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: #c9a44c;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-track {
            background: #f8f5ee;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="/assets/images/logo.png" alt="Agency Builder Logo" onerror="this.src='https://via.placeholder.com/140x140?text=Logo'">
        <h2>Agency Builder</h2>

        <div class="nav-item active">🏠 Dashboard</div>
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
