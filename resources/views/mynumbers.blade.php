<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Numbers - Agency Builder CRM</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0e0e0e;
            color: #f8f8f8;
            display: flex;
            height: 100vh;
            overflow: hidden;
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
            width: 280px;
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
            overflow-y: auto;
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

        .form-container {
            background-color: #222;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 30px;
            width: 400px;
        }

        label {
            display: block;
            color: #c9a44c;
            font-weight: 500;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-bottom: 15px;
            background-color: #333;
            color: #f8f8f8;
            font-size: 16px;
        }

        button {
            background-color: #c9a44c;
            color: #111;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            padding: 12px 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #e3b958;
        }

        .results {
            margin-top: 25px;
            padding: 20px;
            background-color: #1f1f1f;
            border-radius: 8px;
            text-align: center;
        }

        .results h3 {
            color: #c9a44c;
            margin-bottom: 10px;
        }

        .results p {
            font-size: 20px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="/assets/images/logo.png" alt="Agency Builder Logo">
        <h2>Agency Builder</h2>

        <div class="nav-item" onclick="window.location='/'">🏠 Dashboard</div>
        <div class="nav-item active">📈 My Numbers</div>
        <div class="nav-item">💬 Leads</div>
        <div class="nav-item">📞 Calls</div>
        <div class="nav-item">🧾 Sales</div>
    </div>

    <div class="main">
        <div class="header">
            <h1>My Numbers</h1>
            <p>Track your daily performance metrics</p>
        </div>

        <div class="form-container">
            <label for="leads">Leads</label>
            <input type="number" id="leads" placeholder="Enter number of leads">

            <label for="presentations">Presentations</label>
            <input type="number" id="presentations" placeholder="Enter presentations">

            <label for="sales">Sales</label>
            <input type="number" id="sales" placeholder="Enter sales made">

            <button onclick="calculate()">Calculate</button>

            <div class="results">
                <h3>Conversion Rate</h3>
                <p id="conversion">0%</p>
            </div>
        </div>
    </div>

    <script>
        // Load saved values from localStorage
        window.onload = function() {
            const leads = localStorage.getItem('leads');
            const pres = localStorage.getItem('presentations');
            const sales = localStorage.getItem('sales');
            if (leads) document.getElementById('leads').value = leads;
            if (pres) document.getElementById('presentations').value = pres;
            if (sales) document.getElementById('sales').value = sales;
            calculate();
        }

        // Calculate conversion and save
        function calculate() {
            const leads = parseInt(document.getElementById('leads').value) || 0;
            const pres = parseInt(document.getElementById('presentations').value) || 0;
            const sales = parseInt(document.getElementById('sales').value) || 0;

            const conversion = leads > 0 ? ((sales / leads) * 100).toFixed(1) : 0;

            document.getElementById('conversion').textContent = conversion + "%";

            // Save values
            localStorage.setItem('leads', leads);
            localStorage.setItem('presentations', pres);
            localStorage.setItem('sales', sales);
        }
    </script>
</body>
</html>
