<?php
$title = "Dashboard | Agency Builder CRM";
$activeTab = "dashboard";
$viewFile = __FILE__;
include('layout.php');
?>

<div class="dashboard-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;">
  <div>
    <h1 style="font-size:28px;color:#1a1a1a;margin:0;">CRM Dashboard</h1>
    <div style="font-size:18px;color:#d4af37;font-weight:600;">Good Morning, Agent 👋</div>
  </div>

  <form class="search-bar" style="display:flex;border:2px solid #d4af37;border-radius:8px;overflow:hidden;width:280px;">
    <input type="text" placeholder="Search by name, phone, or email..." style="flex:1;border:none;outline:none;padding:8px 10px;background:#fffdf7;">
    <button type="submit" style="background:#d4af37;border:none;padding:8px 14px;cursor:pointer;">🔍</button>
  </form>
</div>

<div class="dashboard-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:25px;">
  <div class="card" style="background:#fffdf7;border:1px solid #e6e0c7;border-left:6px solid #d4af37;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.08);padding:20px;">
    <h2 style="margin-top:0;color:#1a1a1a;border-bottom:2px solid #d4af37;padding-bottom:5px;">📈 Current Production</h2>
    <ul style="list-style:none;padding-left:0;margin:0;">
      <li><strong>Today:</strong> 3 calls / 2 answered / 0 stops</li>
      <li><strong>Week:</strong> 15 calls / 12 answered / 3 pres / 1 sale</li>
      <li><strong>Month:</strong> 5 apps / $3,800 premium</li>
      <li><strong>Annualized Premium:</strong> $45,600</li>
    </ul>
  </div>

  <div class="card" style="background:#fffdf7;border:1px solid #e6e0c7;border-left:6px solid #d4af37;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.08);padding:20px;">
    <h2 style="margin-top:0;color:#1a1a1a;border-bottom:2px solid #d4af37;padding-bottom:5px;">📅 Upcoming Appointments</h2>
    <ul style="list-style:none;padding-left:0;margin:0;">
      <li>Tomorrow — John Doe (Policy Review)</li>
      <li>Friday — Sarah Lee (New Client)</li>
      <li>Monday — Team Meeting</li>
    </ul>
  </div>

  <div class="card" style="background:#fffdf7;border:1px solid #e6e0c7;border-left:6px solid #d4af37;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.08);padding:20px;">
    <h2 style="margin-top:0;color:#1a1a1a;border-bottom:2px solid #d4af37;padding-bottom:5px;">🌟 Today’s Insights</h2>
    <ul style="list-style:none;padding-left:0;margin:0;">
      <li>🎂 <strong>Birthdays:</strong> 2 upcoming this week</li>
      <li>💍 <strong>Anniversaries:</strong> None in next 10 days</li>
    </ul>
  </div>

  <div class="card" style="background:#fffdf7;border:1px solid #e6e0c7;border-left:6px solid #d4af37;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.08);padding:20px;">
    <h2 style="margin-top:0;color:#1a1a1a;border-bottom:2px solid #d4af37;padding-bottom:5px;">🆕 Recently Added Contacts</h2>
    <ul style="list-style:none;padding-left:0;margin:0;">
      <li>James Carter — Added today</li>
      <li>Alicia Barnes — Added 2 days ago</li>
      <li>Henry Wilson — Added 4 days ago</li>
    </ul>
  </div>
</div>

<div class="footer" style="margin-top:40px;text-align:center;color:#888;font-size:13px;">
  © 2025 Agency Builder CRM — Tier 1 Edition
</div>
