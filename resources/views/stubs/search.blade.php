<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Search</title></head>
<body>
<h2>Results for “{{ $q }}”</h2>
<h3>Clients</h3>
<ul>
@forelse($clients as $c)
  <li>{{ $c->first_name }} {{ $c->last_name }} — {{ $c->email }} {{ $c->phone }}</li>
@empty <li>None</li>
@endforelse
</ul>

<h3>Leads</h3>
<ul>
@forelse($leads as $l)
  <li>{{ $l->first_name }} {{ $l->last_name }} — {{ $l->email }} {{ $l->phone }}</li>
@empty <li>None</li>
@endforelse
</ul>
</body></html>
