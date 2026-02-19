<x-admin-layout>
<x-slot name="header">Categories</x-slot>

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
.btn-primary {
  display: inline-flex; align-items: center; gap: 7px;
  background: var(--orange); color: #fff; border: none; border-radius: 9px;
  padding: 8px 16px; font-size: 13.5px; font-weight: 600; font-family: inherit;
  cursor: pointer; box-shadow: 0 2px 10px rgba(249,115,22,.28); transition: background .15s;
}
.btn-primary:hover { background: var(--orange-d); }
.btn-primary svg { width: 15px; height: 15px; stroke: #fff; stroke-width: 2.5; fill: none; }
.card { background: #fff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
.card-body { padding: 20px; text-align: center; color: var(--muted); }
.empty-state { padding: 60px 20px; }
.empty-icon { font-size: 48px; margin-bottom: 16px; }
.empty-title { font-size: 16px; font-weight: 600; color: var(--txt); margin-bottom: 8px; }
.empty-desc { font-size: 13px; color: var(--muted); }
</style>

<div class="ph">
  <div>
    <h1>Categories</h1>
    <p>Organize your products into categories</p>
  </div>
  <a href="{{ route('admin.categories.create') }}" class="btn-primary">
    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    Add Category
  </a>
</div>

<div class="card">
  <div class="card-body">
    <div class="empty-state">
      <div class="empty-icon">📂</div>
      <div class="empty-title">No Categories Yet</div>
      <div class="empty-desc">Categories will appear here once you create them.</div>
    </div>
  </div>
</div>
</x-admin-layout>
