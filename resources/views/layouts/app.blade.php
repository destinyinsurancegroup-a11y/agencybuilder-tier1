<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Builder CRM — Tier 1</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <!-- Optional: Add other component styles here -->
    @stack('styles')
</head>

<body>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="{{ asset('assets/img/agencybuilder_logo.png') }}" alt="Agency Builder CRM" style="max-width:180px;">
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
                <a href="{{ route('contacts.index') }}" class="{{ request()->routeIs('contacts.*') ? 'active' : '' }}">👥 All Contacts</a>
                <a href="{{ route('book.business') }}" class="{{ request()->routeIs('book.business') ? 'active' : '' }}">📘 Book of Business</a>
                <a href="{{ route('leads.index') }}" class="{{ request()->routeIs('leads.*') ? 'active' : '' }}">🎯 Leads</a>
                <a href="{{ route('service.index') }}" class="{{ request()->routeIs('service.*') ? 'active' : '' }}">🛠 Service</a>
                <a href="{{ route('calendar.index') }}" class="{{ request()->routeIs('calendar.*') ? 'active' : '' }}">📅 Calendar / Activity</a>
                <a href="{{ route('activity.index') }}" class="{{ request()->routeIs('activity.*') ? 'active' : '' }}">📊 Activity</a>
                <a href="{{ route('billing.index') }}" class="{{ request()->routeIs('billing.*') ? 'active' : '' }}">💳 Billing</a>
                <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">⚙️ Settings</a>
                <a href="{{ route('logout') }}">🚪 Logout</a>
            </nav>
        </aside>

        <!-- Main content area -->
        <main class="content">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
