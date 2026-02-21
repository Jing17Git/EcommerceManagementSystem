<x-admin-layout>
<x-slot name="header">Orders</x-slot>

<div class="ph">
  <div>
    <h1>Orders</h1>
    <p>Manage all customer orders</p>
  </div>
</div>

<div class="card">
  <div class="card-body">
    @if($orders->count())
    <table class="table">
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
          <td>{{ $order->order_number }}</td>
          <td>{{ $order->user->name }}</td>
          <td>${{ number_format($order->total_amount,2) }}</td>
          <td>{{ ucfirst($order->status) }}</td>
          <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
          <td>
            <a href="{{ route('admin.orders.edit',$order) }}" class="btn-action btn-edit">Edit</a>
            <form action="{{ route('admin.orders.destroy',$order) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this order?')">
              @csrf
              @method('DELETE')
              <button class="btn-action btn-delete">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $orders->links() }}
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