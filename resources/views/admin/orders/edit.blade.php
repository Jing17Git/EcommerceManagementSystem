<x-admin-layout>
<x-slot name="header">Edit Order</x-slot>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
          <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
          <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
          <option value="shipped" {{ $order->status=='shipped'?'selected':'' }}>Shipped</option>
          <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Delivered</option>
          <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Notes</label>
        <textarea name="notes" class="form-control">{{ $order->notes }}</textarea>
      </div>

      <button class="btn btn-primary">Update Order</button>
    </form>
  </div>
</div>
</x-admin-layout>