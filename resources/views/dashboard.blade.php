@extends('layouts.app')

@section('content')
<div class="content-area">
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
</div>
@endsection
