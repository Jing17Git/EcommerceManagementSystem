<x-admin-layout>
<x-slot name="header">Seller Applications</x-slot>

<style>
  .sa-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
    overflow: hidden;
  }

  .sa-card-body {
    padding: 1.5rem;
  }

  /* ── Table ── */
  .sa-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .9rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }

  .sa-table thead {
    background: #f8f9fb;
    border-bottom: 2px solid #e5e7eb;
  }

  .sa-table th {
    padding: .75rem 1rem;
    text-align: left;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    font-size: .75rem;
    letter-spacing: .05em;
    white-space: nowrap;
  }

  .sa-table td {
    padding: .85rem 1rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
  }

  .sa-table tbody tr:last-child td {
    border-bottom: none;
  }

  .sa-table tbody tr:hover {
    background: #fafafa;
  }

  /* ── Status badges ── */
  .badge {
    display: inline-block;
    padding: .25em .75em;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 600;
    text-transform: capitalize;
  }
  .badge-pending  { background: #fef3c7; color: #92400e; }
  .badge-approved { background: #d1fae5; color: #065f46; }
  .badge-rejected { background: #fee2e2; color: #991b1b; }

  /* ── Action buttons ── */
  .actions { display: flex; flex-wrap: wrap; gap: .4rem; align-items: center; }

  .btn-action {
    display: inline-block;
    padding: .3rem .75rem;
    border-radius: 6px;
    font-size: .8rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    line-height: 1.6;
    transition: opacity .15s, transform .1s;
  }
  .btn-action:hover { opacity: .85; transform: translateY(-1px); }
  .btn-action:active { transform: translateY(0); }

  .btn-view    { background: #e0e7ff; color: #3730a3; }
  .btn-approve { background: #d1fae5; color: #065f46; }
  .btn-reject  { background: #fff7ed; color: #c2410c; }
  .btn-delete  { background: #fee2e2; color: #991b1b; }

  /* ── Pagination wrapper ── */
  .sa-pagination { margin-top: 1.25rem; }

  /* ── Empty state ── */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #9ca3af;
  }
  .empty-icon  { font-size: 3rem; margin-bottom: .75rem; }
  .empty-title { font-size: 1.15rem; font-weight: 700; color: #374151; margin-bottom: .4rem; }
  .empty-desc  { font-size: .9rem; }
</style>

<div class="sa-card">
  <div class="sa-card-body">

    @if($applications->count())

      <div style="overflow-x:auto;">
        <table class="sa-table">
          <thead>
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Business Name</th>
              <th>Status</th>
              <th>Submitted At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($applications as $app)
            <tr>
              <td>{{ $app->id }}</td>
              <td>{{ $app->user->name }}</td>
              <td>{{ $app->business_name }}</td>
              <td>
                <span class="badge badge-{{ $app->status }}">
                  {{ ucfirst($app->status) }}
                </span>
              </td>
              <td>{{ $app->created_at->format('Y-m-d') }}</td>
              <td>
                <div class="actions">

                  <a href="{{ route('admin.sellers.show', $app) }}" class="btn-action btn-view">View</a>

                  @if($app->status == 'pending')
                    <form action="{{ route('admin.sellers.approve', $app) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn-action btn-approve">Approve</button>
                    </form>

                    <form action="{{ route('admin.sellers.reject', $app) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn-action btn-reject">Reject</button>
                    </form>
                  @endif

                  <form action="{{ route('admin.sellers.destroy', $app) }}" method="POST"
                        onsubmit="return confirm('Delete this application?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">Delete</button>
                  </form>

                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="sa-pagination">
        {{ $applications->links() }}
      </div>

    @else

      <div class="empty-state">
        <div class="empty-icon">📝</div>
        <div class="empty-title">No Seller Applications Yet</div>
        <div class="empty-desc">Seller applications will appear here once users apply to become sellers.</div>
      </div>

    @endif

  </div>
</div>

</x-admin-layout>