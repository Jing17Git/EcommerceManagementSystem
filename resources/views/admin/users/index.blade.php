<x-admin-layout>
<x-slot name="header">Users</x-slot>

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
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
.stat-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 20px; }
.stat-label { font-size: 12.5px; font-weight: 500; color: var(--muted); margin-bottom: 8px; }
.stat-val { font-size: 24px; font-weight: 700; color: var(--txt); letter-spacing: -.04em; }
.card { background: #fff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
.card-head { padding: 18px 20px; border-bottom: 1px solid var(--border); }
.card-title { font-size: 14px; font-weight: 600; color: var(--txt); }
table { width: 100%; border-collapse: collapse; }
th { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--muted); padding: 12px 16px; text-align: left; background: #fafafa; border-bottom: 1px solid var(--border); }
td { font-size: 13px; color: var(--sec); padding: 12px 16px; border-bottom: 1px solid var(--border); }
tr:last-child td { border-bottom: none; }
tr:hover td { background: #fffaf7; }
.user-cell { display: flex; align-items: center; gap: 10px; }
.user-avatar { width: 32px; height: 32px; border-radius: 8px; background: var(--orange); color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
.user-name { font-weight: 500; color: var(--txt); }
.user-email { font-size: 12px; color: var(--muted); }
.role-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; }
.role-admin { background: #fef2f2; color: #dc2626; }
.role-buyer { background: #eff6ff; color: #2563eb; }
.role-seller { background: #f0fdf4; color: #16a34a; }
</style>

<div class="ph">
  <div>
    <h1>Users</h1>
    <p>Manage registered users</p>
  </div>
</div>

<!-- User Stats -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-label">Total Users</div>
    <div class="stat-val">{{ number_format($users->total() ?? 0) }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Buyers</div>
    <div class="stat-val">{{ number_format($users->where('role', 'buyer')->count() ?? 0) }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Sellers</div>
    <div class="stat-val">{{ number_format($users->where('role', 'seller')->count() ?? 0) }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Administrators</div>
    <div class="stat-val">{{ number_format($users->where('role', 'administrator')->count() ?? 0) }}</div>
  </div>
</div>

<!-- Users Table -->
<div class="card">
  <div class="card-head">
    <div class="card-title">All Users</div>
  </div>
  <table>
    <thead>
      <tr>
        <th>User</th>
        <th>Role</th>
        <th>Joined</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
      <tr>
        <td>
          <div class="user-cell">
            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
            <div>
              <div class="user-name">{{ $user->name }}</div>
              <div class="user-email">{{ $user->email }}</div>
            </div>
          </div>
        </td>
        <td>
          <span class="role-badge role-{{ $user->role }}">{{ $user->role }}</span>
        </td>
        <td>{{ $user->created_at->format('M d, Y') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="3" style="text-align: center; padding: 40px; color: var(--muted);">No users found</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px;">
  {{ $users->links() }}
</div>
</x-admin-layout>
