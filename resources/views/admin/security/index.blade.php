<x-admin-layout>
<x-slot name="header">Security Center</x-slot>

<style>
:root {
  --orange:#f97316; --orange-d:#ea6c0a; --orange-l:#fff7ed;
  --border:#f0f0f0; --txt:#111827; --muted:#9ca3af; --sec:#6b7280;
}

.sec-header {
  display:flex; align-items:center; justify-content:space-between;
  margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid var(--border);
}
.sec-header h1 {
  font-size:24px; font-weight:700; color:var(--txt);
  display:flex; align-items:center; gap:12px;
}
.sec-header h1 svg { width:28px; height:28px; stroke:var(--orange); stroke-width:2; fill:none; }
.sec-header p { font-size:13px; color:var(--muted); margin-top:4px; }

.sec-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }

.sec-card {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  padding:20px; transition:all .2s; cursor:pointer; position:relative;
  overflow:hidden;
}
.sec-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.08); transform:translateY(-2px); }
.sec-card::before {
  content:''; position:absolute; top:0; left:0; right:0;
  height:4px; background:var(--accent); opacity:0; transition:opacity .2s;
}
.sec-card:hover::before { opacity:1; }

.sc-top { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:16px; }
.sc-icon {
  width:48px; height:48px; border-radius:12px;
  display:flex; align-items:center; justify-content:center;
  background:var(--bg);
}
.sc-icon svg { width:24px; height:24px; stroke:var(--accent); stroke-width:2; fill:none; }
.sc-badge {
  font-size:11px; font-weight:600; padding:4px 10px;
  border-radius:20px; background:var(--badge-bg); color:var(--badge-color);
}

.sc-title { font-size:16px; font-weight:600; color:var(--txt); margin-bottom:6px; }
.sc-desc { font-size:13px; color:var(--muted); line-height:1.5; margin-bottom:16px; }

.sc-stats { display:flex; gap:16px; margin-bottom:16px; }
.sc-stat { flex:1; }
.sc-stat-val { font-size:20px; font-weight:700; color:var(--txt); }
.sc-stat-label { font-size:11px; color:var(--muted); margin-top:2px; }

.sc-footer {
  display:flex; align-items:center; justify-content:space-between;
  padding-top:12px; border-top:1px solid var(--border);
}
.sc-link {
  font-size:13px; font-weight:500; color:var(--orange);
  text-decoration:none; display:flex; align-items:center; gap:4px;
  transition:gap .2s;
}
.sc-link:hover { gap:8px; }
.sc-link svg { width:14px; height:14px; stroke:currentColor; stroke-width:2; fill:none; }

.sc-status {
  display:flex; align-items:center; gap:6px;
  font-size:12px; font-weight:500;
}
.sc-status-dot {
  width:8px; height:8px; border-radius:50%;
  background:currentColor; animation:pulse 2s infinite;
}
@keyframes pulse {
  0%, 100% { opacity:1; }
  50% { opacity:.5; }
}

.sec-card.cookie { --accent:#3b82f6; --bg:#eff6ff; --badge-bg:#dbeafe; --badge-color:#1e40af; }
.cookie .sc-status { color:#22c55e; }

.sec-card.anomaly { --accent:#f59e0b; --bg:#fef3c7; --badge-bg:#fde68a; --badge-color:#92400e; }
.anomaly .sc-status { color:#f59e0b; }

.sec-card.login { --accent:#ef4444; --bg:#fee2e2; --badge-bg:#fecaca; --badge-color:#991b1b; }
.login .sc-status { color:#ef4444; }

.activity-section {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  padding:24px; margin-bottom:24px;
}
.activity-header {
  display:flex; align-items:center; justify-content:space-between;
  margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid var(--border);
}
.activity-header h2 { font-size:16px; font-weight:600; color:var(--txt); }
.activity-filter { display:flex; gap:8px; }
.filter-btn {
  font-size:12px; font-weight:500; padding:6px 12px;
  border-radius:8px; border:1px solid var(--border);
  background:#fff; color:var(--sec); cursor:pointer;
  transition:all .15s; font-family:inherit;
}
.filter-btn.active { background:var(--orange-l); color:var(--orange-d); border-color:var(--orange); }
.filter-btn:hover:not(.active) { background:#fafafa; }

.activity-list { display:flex; flex-direction:column; gap:12px; }
.activity-item {
  display:flex; gap:12px; padding:12px; border-radius:10px;
  border:1px solid var(--border); transition:all .15s;
}
.activity-item:hover { background:#fafafa; }

.act-icon {
  width:40px; height:40px; border-radius:10px;
  display:flex; align-items:center; justify-content:center;
  flex-shrink:0;
}
.act-icon svg { width:18px; height:18px; stroke-width:2; fill:none; }
.act-icon.blue { background:#eff6ff; } .act-icon.blue svg { stroke:#3b82f6; }
.act-icon.orange { background:#fff7ed; } .act-icon.orange svg { stroke:#f97316; }
.act-icon.red { background:#fee2e2; } .act-icon.red svg { stroke:#ef4444; }
.act-icon.green { background:#f0fdf4; } .act-icon.green svg { stroke:#22c55e; }

.act-content { flex:1; min-width:0; }
.act-title { font-size:13.5px; font-weight:500; color:var(--txt); margin-bottom:2px; }
.act-desc { font-size:12px; color:var(--muted); }
.act-time {
  font-size:11px; color:var(--muted); white-space:nowrap;
  display:flex; align-items:center; gap:4px;
}
.act-time svg { width:12px; height:12px; stroke:currentColor; stroke-width:2; fill:none; }

.quick-actions {
  display:grid; grid-template-columns:repeat(4,1fr); gap:12px;
  background:#fff; border:1px solid var(--border); border-radius:14px;
  padding:20px;
}
.qa-btn {
  display:flex; flex-direction:column; align-items:center; gap:10px;
  padding:16px; border-radius:12px; border:1.5px solid var(--border);
  background:#fff; cursor:pointer; transition:all .15s;
  text-decoration:none; font-family:inherit;
}
.qa-btn:hover { border-color:var(--orange); background:var(--orange-l); }
.qa-icon {
  width:44px; height:44px; border-radius:11px;
  display:flex; align-items:center; justify-content:center;
}
.qa-icon svg { width:20px; height:20px; stroke-width:2; fill:none; }
.qa-label { font-size:12.5px; font-weight:500; color:var(--sec); text-align:center; }
</style>

<div class="sec-header">
  <div>
    <h1>
      <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
      Security Center
    </h1>
    <p>Monitor and manage all security features from one place</p>
  </div>
</div>

<div class="sec-grid">
  
  <div class="sec-card cookie" onclick="window.location='{{ route('admin.cookie-consent.edit') }}'">
    <div class="sc-top">
      <div class="sc-icon">
        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <span class="sc-badge">{{ $cookieConsent->is_enabled ? 'Active' : 'Inactive' }}</span>
    </div>
    <div class="sc-title">Cookie Consent</div>
    <div class="sc-desc">Manage cookie consent popup settings and user preferences for GDPR compliance</div>
    <div class="sc-stats">
      <div class="sc-stat">
        <div class="sc-stat-val">{{ $cookieStats['accepted'] ?? 0 }}</div>
        <div class="sc-stat-label">Accepted</div>
      </div>
      <div class="sc-stat">
        <div class="sc-stat-val">{{ $cookieStats['declined'] ?? 0 }}</div>
        <div class="sc-stat-label">Declined</div>
      </div>
    </div>
    <div class="sc-footer">
      <div class="sc-status">
        <span class="sc-status-dot"></span>
        {{ $cookieConsent->is_enabled ? 'Enabled' : 'Disabled' }}
      </div>
      <a href="{{ route('admin.cookie-consent.edit') }}" class="sc-link">
        Configure
        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>

  <div class="sec-card anomaly" onclick="window.location='{{ route('admin.anomaly-detection.index') }}'">
    <div class="sc-top">
      <div class="sc-icon">
        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
      </div>
      <span class="sc-badge">{{ $anomalyStats['pending'] }} Pending</span>
    </div>
    <div class="sc-title">Anomaly Detection</div>
    <div class="sc-desc">AI-powered detection of suspicious activities and unusual behavior patterns</div>
    <div class="sc-stats">
      <div class="sc-stat">
        <div class="sc-stat-val">{{ $anomalyStats['total'] }}</div>
        <div class="sc-stat-label">Total Detected</div>
      </div>
      <div class="sc-stat">
        <div class="sc-stat-val">{{ $anomalyStats['critical'] }}</div>
        <div class="sc-stat-label">Critical</div>
      </div>
    </div>
    <div class="sc-footer">
      <div class="sc-status">
        <span class="sc-status-dot"></span>
        Monitoring
      </div>
      <a href="{{ route('admin.anomaly-detection.index') }}" class="sc-link">
        View Details
        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>

  <div class="sec-card login" onclick="window.location='{{ route('admin.login-security.index') }}'">
    <div class="sc-top">
      <div class="sc-icon">
        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
      </div>
      <span class="sc-badge">{{ $loginStats['active_lockouts'] }} Locked</span>
    </div>
    <div class="sc-title">Login Security</div>
    <div class="sc-desc">Track login attempts, failed authentications, and account lockouts</div>
    <div class="sc-stats">
      <div class="sc-stat">
        <div class="sc-stat-val">{{ $loginStats['failed_attempts'] }}</div>
        <div class="sc-stat-label">Failed Today</div>
      </div>
      <div class="sc-stat">
        <div class="sc-stat-val">{{ $loginStats['successful_attempts'] }}</div>
        <div class="sc-stat-label">Successful</div>
      </div>
    </div>
    <div class="sc-footer">
      <div class="sc-status">
        <span class="sc-status-dot"></span>
        {{ $loginStats['recent_failed'] }} Recent Fails
      </div>
      <a href="{{ route('admin.login-security.index') }}" class="sc-link">
        View Logs
        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>

</div>

<div class="activity-section">
  <div class="activity-header">
    <h2>Recent Security Events</h2>
    <div class="activity-filter">
      <button class="filter-btn active">All</button>
      <button class="filter-btn">Critical</button>
      <button class="filter-btn">Today</button>
    </div>
  </div>
  <div class="activity-list">
    @forelse($recentActivity as $activity)
    <div class="activity-item">
      <div class="act-icon {{ $activity['color'] }}">
        {!! $activity['icon'] !!}
      </div>
      <div class="act-content">
        <div class="act-title">{{ $activity['title'] }}</div>
        <div class="act-desc">{{ $activity['description'] }}</div>
      </div>
      <div class="act-time">
        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ $activity['time'] }}
      </div>
    </div>
    @empty
    <div style="text-align:center; padding:40px; color:var(--muted);">
      <svg viewBox="0 0 24 24" style="width:48px; height:48px; stroke:currentColor; stroke-width:1.5; fill:none; margin:0 auto 12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
      <p>No recent security events</p>
    </div>
    @endforelse
  </div>
</div>

<div class="quick-actions">
  <a href="{{ route('admin.cookie-consent.edit') }}" class="qa-btn">
    <div class="qa-icon" style="background:#eff6ff;">
      <svg viewBox="0 0 24 24" style="stroke:#3b82f6;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </div>
    <span class="qa-label">Cookie Settings</span>
  </a>
  
  <form action="{{ route('admin.anomaly-detection.learn-baselines') }}" method="POST" style="margin:0;">
    @csrf
    <button type="submit" class="qa-btn" style="width:100%;">
      <div class="qa-icon" style="background:#fef3c7;">
        <svg viewBox="0 0 24 24" style="stroke:#f59e0b;"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
      </div>
      <span class="qa-label">Learn Baselines</span>
    </button>
  </form>
  
  <a href="{{ route('admin.login-security.lockouts') }}" class="qa-btn">
    <div class="qa-icon" style="background:#fee2e2;">
      <svg viewBox="0 0 24 24" style="stroke:#ef4444;"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
    </div>
    <span class="qa-label">View Lockouts</span>
  </a>
  
  <form action="{{ route('admin.login-security.cleanup') }}" method="POST" style="margin:0;">
    @csrf
    <button type="submit" class="qa-btn" style="width:100%;" onclick="return confirm('Clean up old login attempts?')">
      <div class="qa-icon" style="background:#f0fdf4;">
        <svg viewBox="0 0 24 24" style="stroke:#22c55e;"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
      </div>
      <span class="qa-label">Cleanup Logs</span>
    </button>
  </form>
</div>

<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  });
});
</script>

</x-admin-layout>
