<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agency Builder CRM — Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root{
            --abc-gold:#C6A135;
            --abc-black:#111111;
            --abc-cream:#FAF8F0;
            --abc-soft:#e9e2c9;
            --abc-text:#0b0b0b;
        }
        *{box-sizing:border-box}
        body{margin:0;font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;background:var(--abc-cream);color:var(--abc-text)}
        .layout{display:flex;min-height:100vh}
        .sidebar{width:260px;background:var(--abc-black);color:#fff;padding:22px 18px;display:flex;flex-direction:column;gap:14px}
        .logo{display:flex;align-items:center;gap:10px;font-weight:800;letter-spacing:.4px}
        .logo img{height:42px}
        .nav a{display:block;color:#fff;text-decoration:none;padding:10px 12px;border-radius:10px;border:1px solid rgba(198,161,53,.18);margin-bottom:8px;background:rgba(255,255,255,.03)}
        .nav a:hover,.nav a.active{border-color:var(--abc-gold);background:rgba(198,161,53,.18)}
        .content{flex:1;padding:28px 40px}
        .header{display:flex;justify-content:space-between;gap:20px;align-items:flex-start}
        h1{margin:0;font-size:28px}
        .greet{color:var(--abc-gold);font-weight:700;margin-top:6px}
        .time{font-size:13px;opacity:.8;text-align:right}
        .search{display:flex;border:2px solid var(--abc-gold);border-radius:10px;overflow:hidden}
        .search input{border:0;padding:10px 12px;width:220px;background:var(--abc-cream);outline:0}
        .search button{border:0;background:var(--abc-gold);font-weight:700;padding:10px 14px;cursor:pointer}
        .panel{margin-top:18px;border:1px solid var(--abc-soft);border-radius:12px;background:#fff;box-shadow:0 6px 16px rgba(0,0,0,.07);padding:18px 22px}
        .panel h2{margin:0 0 10px;border-left:4px solid var(--abc-gold);padding-left:8px;font-size:18px}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:22px;margin-top:18px}
        .card{border:1px solid var(--abc-soft);border-radius:12px;background:#fff;box-shadow:0 6px 16px rgba(0,0,0,.06);padding:18px;min-height:140px}
        .card h3{margin:0 0 10px;border-left:4px solid var(--abc-gold);padding-left:8px;font-size:17px}
        .list{list-style:none;padding:0;margin:6px 0}
        .list li{margin:6px 0}
        .recent{margin-top:22px}
        .muted{opacity:.7}
        footer{margin-top:24px;text-align:center;font-size:12px;opacity:.7}
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('assets/abc_logo_gold.png') }}" alt="ABC">
            <div>AGENCY BUILDER<br>CRM</div>
        </div>
        <nav class="nav">
            <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
            <a href="{{ route('contacts.index') }}">All Contacts</a>
            <a href="{{ route('book.index') }}">Book of Business</a>
            <a href="{{ route('service.index') }}">Service</a>
            <a href="{{ route('leads.index') }}">Leads</a>
            <a href="{{ route('calendar.index') }}">Calendar / Activity</a>
            <a href="{{ route('billing.index') }}">Billing</a>
            <a href="{{ route('settings.index') }}">Settings</a>
            <a href="{{ route('logout') }}">Logout</a>
        </nav>
    </aside>

    <main class="content">
        <div class="header">
            <div>
                <h1>Dashboard</h1>
                <div class="greet">{{ $greeting }}</div>

                <section class="panel">
                    <h2>📈 Current Production</h2>
                    <div><strong>Today:</strong>
                        {{ $daily->calls ?? 0 }} calls /
                        {{ $daily->answered ?? 0 }} answered /
                        {{ $daily->stops ?? 0 }} stops
                    </div>
                    <div><strong>Week:</strong>
                        {{ $weekly->calls ?? 0 }} calls /
                        {{ $weekly->answered ?? 0 }} answered /
                        {{ $weekly->stops ?? 0 }} stops /
                        {{ $weekly->presentations ?? 0 }} presentations /
                        {{ $weekly->nos ?? 0 }} no’s
                    </div>
                    <div><strong>Month:</strong>
                        {{ $monthly->sales_apps ?? 0 }} apps /
                        ${{ number_format((float)($monthly->sales_premium ?? 0),2) }} premium
                    </div>
                    <div><strong>Annualized Premium:</strong>
                        ${{ number_format(((float)($monthly->sales_premium ?? 0))*12,2) }}
                    </div>
                </section>
            </div>

            <div>
                <div class="time">{{ $now->format('l, F j, Y — g:i A') }}</div>
                <form class="search" method="GET" action="{{ route('search') }}">
                    <input type="text" name="q" placeholder="Search clients, leads, or email/phone…" value="{{ request('q') }}">
                    <button type="submit">🔍</button>
                </form>
            </div>
        </div>

        <div class="grid">
            <section class="card">
                <h3>📅 Upcoming Appointments</h3>
                <ul class="list">
                    @forelse($appointments as $a)
                        <li>{{ $a->client_name ?? 'Appointment' }} — {{ $a->starts_at->timezone(config('app.timezone'))->format('D g:i A') }}</li>
                    @empty
                        <li class="muted">No upcoming appointments.</li>
                    @endforelse
                </ul>
            </section>

            <section class="card">
                <h3>🌟 Today’s Insights</h3>

                <div><strong>🎂 Birthdays (next 10 days)</strong></div>
                <ul class="list">
                    @forelse($birthdays as $b)
                        <li>{{ $b->full_name }} — {{ \Illuminate\Support\Carbon::parse($b->dob)->format('M j') }}</li>
                    @empty
                        <li class="muted">No birthdays coming up.</li>
                    @endforelse
                </ul>

                <div style="margin-top:8px;"><strong>💍 Anniversaries (next 10 days)</strong></div>
                <ul class="list">
                    @forelse($anniversaries as $a)
                        <li>{{ $a->full_name }} — {{ \Illuminate\Support\Carbon::parse($a->anniversary_date)->format('M j') }}</li>
                    @empty
                        <li class="muted">No anniversaries coming up.</li>
                    @endforelse
                </ul>
            </section>
        </div>

        <section class="card recent">
            <h3>🆕 Recently Added</h3>
            <ul class="list">
                @forelse($recentClients as $c)
                    <li>{{ $c->full_name }} — Client ({{ $c->created_at->diffForHumans() }})</li>
                @empty
                    <li class="muted">No recent clients.</li>
                @endforelse

                @forelse($recentLeads as $l)
                    <li>{{ $l->full_name }} — Lead ({{ $l->created_at->diffForHumans() }})</li>
                @empty
                    <li class="muted">No recent leads.</li>
                @endforelse
            </ul>
        </section>

        <footer>© {{ date('Y') }} Agency Builder CRM — Tier 1</footer>
    </main>
</div>
</body>
</html>
