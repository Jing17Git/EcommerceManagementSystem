<x-admin-layout>
<x-slot name="header">Dashboard</x-slot>

<style>
:root {
  --orange:#f97316; --orange-d:#ea6c0a; --orange-l:#fff7ed;
  --orange-m:#fed7aa; --border:#f0f0f0; --txt:#111827;
  --muted:#9ca3af; --sec:#6b7280; --bg:#f9f9f9;
}

/* PAGE HEADER */
.ph { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; }
.ph h1 { font-size:20px; font-weight:700; color:var(--txt); letter-spacing:-.03em; }
.ph p  { font-size:13px; color:var(--muted); margin-top:3px; }
.ph-r  { display:flex; gap:8px; align-items:center; }
.date-chip {
  display:flex; align-items:center; gap:6px;
  border:1px solid var(--border); border-radius:9px;
  padding:7px 14px; font-size:13px; color:var(--sec);
  background:#fff; cursor:pointer; font-family:inherit; transition:border .15s;
}
.date-chip:hover { border-color:var(--orange-m); }
.date-chip svg { width:14px; height:14px; stroke:var(--muted); stroke-width:2; fill:none; }
.btn-primary {
  display:inline-flex; align-items:center; gap:7px;
  background:var(--orange); color:#fff; border:none; border-radius:9px;
  padding:8px 16px; font-size:13.5px; font-weight:600; font-family:inherit;
  cursor:pointer; box-shadow:0 2px 10px rgba(249,115,22,.28); transition:background .15s;
}
.btn-primary:hover { background:var(--orange-d); }
.btn-primary svg { width:15px; height:15px; stroke:#fff; stroke-width:2.5; fill:none; }

/* STAT CARDS */
.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:20px; }
.stat-card {
  background:#fff; border:1px solid var(--border); border-radius:14px; padding:20px;
  transition:box-shadow .15s, transform .15s;
}
.stat-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.07); transform:translateY(-1px); }
.stat-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
.stat-label { font-size:12.5px; font-weight:500; color:var(--muted); }
.stat-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; }
.stat-icon svg { width:17px; height:17px; stroke-width:1.75; fill:none; }
.si-orange { background:var(--orange-l); } .si-orange svg { stroke:var(--orange); }
.si-blue   { background:#eff6ff; }         .si-blue svg   { stroke:#3b82f6; }
.si-green  { background:#f0fdf4; }         .si-green svg  { stroke:#22c55e; }
.si-purple { background:#faf5ff; }         .si-purple svg { stroke:#a855f7; }
.stat-val { font-size:24px; font-weight:700; color:var(--txt); letter-spacing:-.04em; margin-bottom:6px; }
.stat-foot { display:flex; align-items:center; gap:6px; }
.pill { display:inline-flex; align-items:center; gap:4px; font-size:11.5px; font-weight:600; padding:2px 8px; border-radius:20px; }
.pill svg { width:10px; height:10px; stroke:currentColor; stroke-width:2.5; fill:none; }
.pill.up   { background:#f0fdf4; color:#16a34a; }
.pill.down { background:#fef2f2; color:#dc2626; }
.stat-note { font-size:11.5px; color:var(--muted); }

/* GRID LAYOUTS */
.mid-grid { display:grid; grid-template-columns:1fr 320px; gap:16px; margin-bottom:20px; }
.bot-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

/* CARD */
.card { background:#fff; border:1px solid var(--border); border-radius:14px; overflow:hidden; }
.card-head {
  display:flex; align-items:center; justify-content:space-between;
  padding:18px 20px; border-bottom:1px solid var(--border);
}
.card-title { font-size:14px; font-weight:600; color:var(--txt); }
.card-sub   { font-size:12px; color:var(--muted); margin-top:2px; }
.card-body  { padding:20px; }
.btn-ghost {
  font-size:12.5px; font-weight:500; color:var(--orange);
  background:none; border:none; cursor:pointer; font-family:inherit;
  padding:5px 8px; border-radius:7px; transition:background .15s;
}
.btn-ghost:hover { background:var(--orange-l); }

/* CHART TABS */
.tab-row { display:flex; gap:4px; }
.tab {
  font-size:12px; font-weight:500; padding:5px 12px; border-radius:7px;
  border:1px solid transparent; cursor:pointer; font-family:inherit;
  background:none; color:var(--muted); transition:all .15s;
}
.tab.active { background:var(--orange-l); color:var(--orange-d); border-color:var(--orange-m); }
.tab:hover:not(.active) { background:#f9f9f9; color:var(--sec); }
.chart-wrap { height:200px; margin-top:8px; }
.chart-wrap svg { width:100%; height:100%; }

/* TOP PRODUCTS */
.prod-item {
  display:flex; align-items:center; gap:12px;
  padding:13px 20px; border-bottom:1px solid var(--border); transition:background .12s;
}
.prod-item:last-child { border-bottom:none; }
.prod-item:hover { background:#fffaf7; }
.prod-rank {
  width:22px; height:22px; border-radius:6px;
  background:var(--orange-l); color:var(--orange-d);
  font-size:11px; font-weight:700;
  display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.prod-rank.gold { background:#fef9c3; color:#a16207; }
.prod-img {
  width:36px; height:36px; border-radius:8px;
  background:var(--bg); border:1px solid var(--border);
  display:flex; align-items:center; justify-content:center;
  flex-shrink:0; font-size:18px;
}
.prod-info { flex:1; min-width:0; }
.prod-name { font-size:13px; font-weight:500; color:var(--txt); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.prod-cat  { font-size:11.5px; color:var(--muted); margin-top:1px; }
.prod-amt  { font-size:13.5px; font-weight:600; color:var(--txt); }
.prod-qty  { font-size:11px; color:var(--muted); margin-top:1px; text-align:right; }

/* ORDERS TABLE */
table { width:100%; border-collapse:collapse; }
th {
  font-size:11px; font-weight:600; letter-spacing:.06em;
  text-transform:uppercase; color:var(--muted);
  padding:10px 16px; text-align:left;
  background:#fafafa; border-bottom:1px solid var(--border);
}
td { font-size:13px; color:var(--sec); padding:12px 16px; border-bottom:1px solid var(--border); }
tr:last-child td { border-bottom:none; }
tr:hover td { background:#fffaf7; }
.oid { font-weight:600; color:var(--txt); font-size:12.5px; }
.amt { font-weight:600; color:var(--txt); }
.s-pill { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }
.s-dot  { width:5px; height:5px; border-radius:50%; background:currentColor; }
.s-delivered  { background:#f0fdf4; color:#16a34a; }
.s-pending    { background:#fff7ed; color:#ea580c; }
.s-processing { background:#eff6ff; color:#2563eb; }
.s-cancelled  { background:#fef2f2; color:#dc2626; }

/* QUICK ACTIONS */
.qa-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; padding:20px; }
.qa-btn {
  display:flex; flex-direction:column; align-items:center; gap:8px;
  padding:16px 12px; border-radius:12px; border:1.5px solid var(--border);
  background:#fff; cursor:pointer; transition:all .15s; font-family:inherit;
}
.qa-btn:hover { border-color:var(--orange-m); background:var(--orange-l); }
.qa-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; }
.qa-icon svg { width:17px; height:17px; stroke-width:1.75; fill:none; }
.qa-label { font-size:12.5px; font-weight:500; color:var(--sec); }

/* ACTIVITY FEED */
.feed-item {
  display:flex; gap:12px;
  padding:12px 20px; border-bottom:1px solid var(--border);
}
.feed-item:last-child { border-bottom:none; }
.feed-dot {
  width:32px; height:32px; border-radius:9px;
  display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.fd-orange { background:var(--orange-l); } .fd-orange svg { stroke:var(--orange); }
.fd-green  { background:#f0fdf4; }         .fd-green svg  { stroke:#22c55e; }
.fd-blue   { background:#eff6ff; }         .fd-blue svg   { stroke:#3b82f6; }
.fd-red    { background:#fef2f2; }         .fd-red svg    { stroke:#ef4444; }
.feed-dot svg { width:15px; height:15px; stroke-width:2; fill:none; }
.feed-msg  { font-size:13px; color:var(--txt); font-weight:500; line-height:1.4; }
.feed-msg span { color:var(--orange-d); font-weight:600; }
.feed-time { font-size:11px; color:var(--muted); margin-top:2px; }
</style>

<!-- Page Header -->
<div class="ph">
  <div>
    <h1>Dashboard</h1>
    <p>Welcome back. Here's your store overview for today.</p>
  </div>
  <div class="ph-r">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn-primary" style="background:#dc2626;">
        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        Logout
      </button>
    </form>
  </div>
</div>

<!-- Stat Cards -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-label">Total Revenue</div>
      <div class="stat-icon si-orange"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
    </div>
    <div class="stat-val">₱{{ number_format($totalRevenue ?? 0) }}</div>
    <div class="stat-foot">
      <span class="pill up"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>+12.5%</span>
      <span class="stat-note">vs last month</span>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-label">Total Orders</div>
      <div class="stat-icon si-blue"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
    </div>
    <div class="stat-val">{{ number_format($totalOrders ?? 0) }}</div>
    <div class="stat-foot">
      <span class="pill up"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>+8.2%</span>
      <span class="stat-note">vs last month</span>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-label">Total Customers</div>
      <div class="stat-icon si-green"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
    </div>
    <div class="stat-val">{{ number_format($totalCustomers ?? 0) }}</div>
    <div class="stat-foot">
      <span class="pill up"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>+4.6%</span>
      <span class="stat-note">vs last month</span>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-label">Pending Orders</div>
      <div class="stat-icon si-purple"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
    </div>
    <div class="stat-val">{{ $pendingOrders ?? 0 }}</div>
    <div class="stat-foot">
      <span class="pill down"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>-2.1%</span>
      <span class="stat-note">vs last month</span>
    </div>
  </div>
</div>

<!-- Middle Row -->
<div class="mid-grid">

  <!-- Revenue Chart -->
  <div class="card">
    <div class="card-head">
      <div>
        <div class="card-title">Revenue Overview</div>
        <div class="card-sub">Monthly revenue performance</div>
      </div>
      <div class="tab-row">
        <button class="tab" onclick="setTab(this)">7D</button>
        <button class="tab active" onclick="setTab(this)">30D</button>
        <button class="tab" onclick="setTab(this)">90D</button>
      </div>
    </div>
    <div class="card-body">
      <div class="chart-wrap">
        <svg viewBox="0 0 600 200" preserveAspectRatio="none">
          <defs>
            <linearGradient id="og" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#f97316" stop-opacity="0.18"/>
              <stop offset="100%" stop-color="#f97316" stop-opacity="0"/>
            </linearGradient>
          </defs>
          <line x1="0" y1="40"  x2="600" y2="40"  stroke="#f0f0f0" stroke-width="1"/>
          <line x1="0" y1="80"  x2="600" y2="80"  stroke="#f0f0f0" stroke-width="1"/>
          <line x1="0" y1="120" x2="600" y2="120" stroke="#f0f0f0" stroke-width="1"/>
          <line x1="0" y1="160" x2="600" y2="160" stroke="#f0f0f0" stroke-width="1"/>
          <path d="M0,140 C40,130 80,110 120,100 C160,90 200,115 240,95 C280,75 320,60 360,70 C400,80 440,55 480,45 C520,35 560,50 600,40 L600,200 L0,200 Z" fill="url(#og)"/>
          <path d="M0,140 C40,130 80,110 120,100 C160,90 200,115 240,95 C280,75 320,60 360,70 C400,80 440,55 480,45 C520,35 560,50 600,40" fill="none" stroke="#f97316" stroke-width="2.5" stroke-linecap="round"/>
          <circle cx="120" cy="100" r="4" fill="#fff" stroke="#f97316" stroke-width="2.5"/>
          <circle cx="240" cy="95"  r="4" fill="#fff" stroke="#f97316" stroke-width="2.5"/>
          <circle cx="360" cy="70"  r="4" fill="#fff" stroke="#f97316" stroke-width="2.5"/>
          <circle cx="480" cy="45"  r="4" fill="#fff" stroke="#f97316" stroke-width="2.5"/>
          <circle cx="600" cy="40"  r="5" fill="#f97316" stroke="#fff" stroke-width="2"/>
        </svg>
      </div>
      <div style="display:flex;justify-content:space-between;margin-top:6px;">
        <span style="font-size:11px;color:var(--muted);">Jan 17</span>
        <span style="font-size:11px;color:var(--muted);">Jan 22</span>
        <span style="font-size:11px;color:var(--muted);">Jan 27</span>
        <span style="font-size:11px;color:var(--muted);">Feb 1</span>
        <span style="font-size:11px;color:var(--muted);">Feb 8</span>
        <span style="font-size:11px;color:var(--muted);">Feb 16</span>
      </div>
    </div>
  </div>

  <!-- Top Products -->
  <div class="card">
    <div class="card-head">
      <div><div class="card-title">Top Products</div><div class="card-sub">By revenue this month</div></div>
      <a href="{{ route('admin.products.index') }}" class="btn-ghost">See all</a>
    </div>
    @forelse($topProducts as $p)
    <div class="prod-item">
      <div class="prod-rank {{ ($p['rank']??0)==1?'gold':'' }}">{{ $p['rank'] }}</div>
      <div class="prod-img">{{ $p['emoji'] }}</div>
      <div class="prod-info">
        <div class="prod-name">{{ $p['name'] }}</div>
        <div class="prod-cat">{{ $p['cat'] }}</div>
      </div>
      <div style="text-align:right;">
        <div class="prod-amt">{{ $p['amt'] }}</div>
        <div class="prod-qty">{{ $p['qty'] }}</div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<!-- Bottom Row -->
<div class="bot-grid">

  <!-- Recent Orders -->
  <div class="card">
    <div class="card-head">
      <div><div class="card-title">Recent Orders</div><div class="card-sub">Latest transactions</div></div>
      <a href="{{ route('admin.orders.index') }}" class="btn-ghost">View all →</a>
    </div>
    <table>
      <thead><tr><th>Order</th><th>Customer</th><th>Amount</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($recentOrders as $o)
        <tr>
          <td><span class="oid">{{ $o['id'] }}</span></td>
          <td>{{ $o['customer'] }}</td>
          <td><span class="amt">{{ $o['amount'] }}</span></td>
          <td><span class="s-pill s-{{ $o['status'] }}"><span class="s-dot"></span>{{ ucfirst($o['status']) }}</span></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Right column -->
  <div style="display:flex;flex-direction:column;gap:16px;">

    <!-- Quick Actions -->
    <div class="card">
      <div class="card-head"><div class="card-title">Quick Actions</div></div>
      <div class="qa-grid">
        <a href="{{ route('admin.products.create') }}" class="qa-btn" style="text-decoration:none;">
          <div class="qa-icon" style="background:var(--orange-l)"><svg viewBox="0 0 24 24" style="stroke:var(--orange)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg></div>
          <span class="qa-label">Add Product</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="qa-btn" style="text-decoration:none;">
          <div class="qa-icon" style="background:#eff6ff"><svg viewBox="0 0 24 24" style="stroke:#3b82f6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
          <span class="qa-label">View Orders</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="qa-btn" style="text-decoration:none;">
          <div class="qa-icon" style="background:#f0fdf4"><svg viewBox="0 0 24 24" style="stroke:#22c55e"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
          <span class="qa-label">Manage Users</span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="qa-btn" style="text-decoration:none;">
          <div class="qa-icon" style="background:#faf5ff"><svg viewBox="0 0 24 24" style="stroke:#a855f7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
          <span class="qa-label">Reports</span>
        </a>
      </div>
    </div>

    <!-- Activity Feed -->
    <div class="card">
      <div class="card-head">
        <div class="card-title">Recent Activity</div>
        <button class="btn-ghost">View all</button>
      </div>
      <div>
        <div class="feed-item">
          <div class="feed-dot fd-orange"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
          <div><div class="feed-msg">New order <span>#00291</span> placed by Maria Santos</div><div class="feed-time">2 minutes ago</div></div>
        </div>
        <div class="feed-item">
          <div class="feed-dot fd-green"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
          <div><div class="feed-msg">Seller <span>TechHub PH</span> was approved</div><div class="feed-time">18 minutes ago</div></div>
        </div>
        <div class="feed-item">
          <div class="feed-dot fd-blue"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
          <div><div class="feed-msg">New user <span>Jenny Mendoza</span> registered</div><div class="feed-time">1 hour ago</div></div>
        </div>
        <div class="feed-item">
          <div class="feed-dot fd-red"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
          <div><div class="feed-msg">Order <span>#00287</span> was cancelled</div><div class="feed-time">2 hours ago</div></div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
function setTab(el) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
}
</script>
</x-admin-layout>