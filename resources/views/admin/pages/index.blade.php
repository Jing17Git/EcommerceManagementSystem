<x-admin-layout>
<x-slot name="header">Pages</x-slot>

<style>
  /* ── Page header ── */
  .cat-ph {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
  }
  .cat-ph h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 .2rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .cat-ph p {
    font-size: .9rem;
    color: #6b7280;
    margin: 0;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }

  /* ── Add button ── */
  .btn-primary {
    display: inline-block;
    padding: .55rem 1.25rem;
    background: #4f46e5;
    color: #fff;
    font-size: .875rem;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    font-family: 'Segoe UI', system-ui, sans-serif;
    transition: background .15s, transform .1s;
    white-space: nowrap;
  }
  .btn-primary:hover  { background: #4338ca; transform: translateY(-1px); }
  .btn-primary:active { transform: translateY(0); }

  /* ── Card ── */
  .cat-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
    overflow: hidden;
  }
  .cat-card-body { padding: 1.5rem; }

  /* ── Table ── */
  .cat-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .9rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .cat-table thead {
    background: #f8f9fb;
    border-bottom: 2px solid #e5e7eb;
  }
  .cat-table th {
    padding: .75rem 1rem;
    text-align: left;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    font-size: .72rem;
    letter-spacing: .05em;
    white-space: nowrap;
  }
  .cat-table td {
    padding: .85rem 1rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
  }
  .cat-table tbody tr:last-child td { border-bottom: none; }
  .cat-table tbody tr:hover { background: #fafafa; }

  /* ── Slug pill ── */
  .slug-pill {
    font-family: 'Courier New', monospace;
    font-size: .82rem;
    background: #f3f4f6;
    color: #6b7280;
    padding: .2em .6em;
    border-radius: 5px;
  }

  /* ── Status badges ── */
  .badge {
    display: inline-block;
    padding: .25em .75em;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 600;
  }
  .badge-active   { background: #d1fae5; color: #065f46; }
  .badge-inactive { background: #f3f4f6; color: #6b7280; }

  /* ── Action buttons ── */
  .cat-actions {
    display: flex;
    gap: .4rem;
    align-items: center;
    flex-wrap: wrap;
  }
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
    font-family: 'Segoe UI', system-ui, sans-serif;
    transition: opacity .15s, transform .1s;
  }
  .btn-action:hover  { opacity: .85; transform: translateY(-1px); }
  .btn-action:active { transform: translateY(0); }
  .btn-edit   { background: #e0e7ff; color: #3730a3; }
  .btn-delete { background: #fee2e2; color: #991b1b; }

  /* ── Pagination ── */
  .cat-pagination { margin-top: 1.25rem; }

  /* ── Empty state ── */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #9ca3af;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .empty-icon  { font-size: 3rem; margin-bottom: .75rem; }
  .empty-title { font-size: 1.15rem; font-weight: 700; color: #374151; margin-bottom: .4rem; }
  .empty-desc  { font-size: .9rem; }
</style>

{{-- Page Header --}}
<div class="cat-ph">
  <div>
    <h1>Pages</h1>
    <p>Manage static pages</p>
  </div>
  <a href="{{ route('admin.pages.create') }}" class="btn-primary">+ Add Page</a>
</div>

{{-- Main Card --}}
<div class="cat-card">
  <div class="cat-card-body">

    @if($pages->count())

      <div style="overflow-x:auto;">
        <table class="cat-table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Slug</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pages as $page)
            <tr>
              <td><strong>{{ $page->title }}</strong></td>
              <td><span class="slug-pill">{{ $page->slug }}</span></td>
              <td>
                @if($page->is_active)
                  <span class="badge badge-active">Active</span>
                @else
                  <span class="badge badge-inactive">Inactive</span>
                @endif
              </td>
              <td>
                <div class="cat-actions">
                  <a href="{{ route('admin.pages.edit', $page) }}" class="btn-action btn-edit">Edit</a>
                  <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                        onsubmit="return confirm('Delete this page?')">
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

      <div class="cat-pagination">
        {{ $pages->links() }}
      </div>

    @else

      <div class="empty-state">
        <div class="empty-icon">📄</div>
        <div class="empty-title">No Custom Pages</div>
        <div class="empty-desc">Static pages will appear here once you create them.</div>
      </div>

    @endif

  </div>
</div>

</x-admin-layout>
