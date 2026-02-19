<x-admin-layout>
<x-slot name="header">Logs</x-slot>

<style>
:root {
  --orange: #f97316;
  --orange-d: #ea6c0a;
  --orange-l: #fff7ed;
  --border: #f0f0f0;
  --txt: #111827;
  --muted: #9ca3af;
  --sec: #6b7280;
}
.ph { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; }
.ph h1 { font-size: 20px; font-weight: 700; color: var(--txt); letter-spacing: -.03em; }
.ph p { font-size: 13px; color: var(--muted); margin-top: 3px; }
.card { background: #fff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
.card-body { padding: 20px; text-align: center; color: var(--muted); }
.empty-state { padding: 60px 20px; }
.empty-icon { font-size: 48px; margin-bottom: 16px; }
.empty-title { font-size: 16px; font-weight: 600; color: var(--txt); margin-bottom: 8px; }
.empty-desc { font-size: 13px; color: var(--muted); }
</style>

<div class="ph">
  <div>
    <h1>Logs</h1>
    <p>View system logs</p>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="empty-state">
      <div class="empty-icon">📋</div>
      <div class="empty-title">No Logs Available</div>
      <div class="empty-desc">System logs will appear here.</div>
    </div>
  </div>
</div>
</x-admin-layout>
