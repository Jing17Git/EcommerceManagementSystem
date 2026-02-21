<x-admin-layout>
<x-slot name="header">Orders</x-slot>

<style>
  /* ── Page header ── */
  .ord-ph {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
  }
  .ord-ph h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 .2rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .ord-ph p {
    font-size: .9rem;
    color: #6b7280;
    margin: 0;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }

  /* ── Card ── */
  .ord-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
    overflow: hidden;
  }
  .ord-card-body {
    padding: 1.5rem;
  }

  /* ── Table ── */
  .ord-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .9rem;
    font-family: 'Segoe UI', system-ui, sans-serif;
  }
  .ord-table thead {
    background: #f8f9fb;
    border-bottom: 2px solid #e5e7eb;
  }
  .ord-table th {
    padding: .75rem 1rem;
    text-align: left;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    font-size: .72rem;
    letter-spacing: .05em;
    white-space: nowrap;
  }
  .ord-table td {
    padding: .85rem 1rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
  }
  .ord-table tbody tr:last-child td {
    border-bottom: none;
  }
  .ord-table tbody tr:hover {
    background: #fafafa;
  }

  /* ── Order number pill ── */
  .order-num {
    font-family: 'Courier New', monospace;
    font-size: .82rem;
    font-weight: 700;
    background: #f3f4f6;
    color: #374151;
    padding: .2em .6em;
    border-radius: 5px;
    letter-spacing: .03em;
  }

  /* ── Amount ── */
  .amount {
    font-weight: 700;
    color: #111827;
  }

  /* ── Status badges ── */
  .badge {
    display: inline-block;
    padding: .25em .75em;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 600;
    text-transform: capitalize;
  }
  .badge-pending    { background: #fef3c7; color: #92400e; }
  .badge-processing { background: #dbeafe; color: #1e40af; }
  .badge-shipped    { background: #e0e7ff; color: #3730a3; }
  .badge-delivered  { background: #d1fae5; color: #065f46; }
  .badge-cancelled  { background: #fee2e2; color: #991b1b; }
  .badge-refunded   { background: #f3f4f6; color: #4b5563; }

  /* ── Actions ── */
  .ord-actions {
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
    transition: opacity .15s, transform .1s;
  }
  .btn-action:hover  { opacity: .85; transform: translateY(-1px); }
  .btn-action:active { transform: translateY(0); }
  .btn-edit   { background: #e0e7ff; color: #3730a3; }
  .btn-delete { background: #fee2e2; color: #991b1b; }

  /* ── Pagination ── */
  .ord-pagination { margin-top: 1.25rem; }

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
<div class="ord-ph">
  <div>
    <h1>Orders</h1>
    <p>Manage all customer orders</p>
  </div>
</div>

{{-- Main Card --}}
<div class="ord-card">
  <div class="ord-card-body">

    @if($orders->count())

      <div style="overflow-x:auto;">
        <table class="ord-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Order Number</th>
              <th>Buyer</th>
              <th>Total</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>{{ $order->id }}</td>
              <td><span class="order-num">{{ $order->order_number }}</span></td>
              <td>{{ $order->user->name }}</td>
              <td><span class="amount">${{ number_format($order->total_amount, 2) }}</span></td>
              <td>
                <span class="badge badge-{{ $order->status }}">
                  {{ ucfirst($order->status) }}
                </span>
              </td>
              <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
              <td>
                <div class="ord-actions">
                  <a href="{{ route('admin.orders.edit', $order) }}" class="btn-action btn-edit">Edit</a>
                  <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                        onsubmit="return confirm('Delete this order?')">
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

      <div class="ord-pagination">
        {{ $orders->links() }}
      </div>

    @else

      <div class="empty-state">
        <div class="empty-icon">🛒</div>
        <div class="empty-title">No Orders Yet</div>
        <div class="empty-desc">Orders will appear here once customers place them.</div>
      </div>

    @endif

  </div>
</div>

</x-admin-layout>