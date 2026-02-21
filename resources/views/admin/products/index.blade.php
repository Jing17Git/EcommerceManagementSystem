<x-admin-layout>
<x-slot name="header">Products</x-slot>

<div class="ph">
  <div>
    <h1>Products</h1>
    <p>Manage your store products</p>
  </div>
  <a href="{{ route('admin.products.create') }}" class="btn-primary">Add Product</a>
</div>

<div class="card">
  <div class="card-body">
    @if($products->count() > 0)
    <table class="table">
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Status</th>
          <th width="150">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
        <tr>
          <td>
            <img src="{{ $product->imageUrl() }}" width="50" alt="Image">
          </td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->category?->name ?? '-' }}</td>
          <td>₱{{ number_format($product->price,2) }}</td>
          <td>{{ $product->stock }}</td>
          <td>
            @if($product->is_active)
              <span class="badge badge-success">Active</span>
            @else
              <span class="badge badge-danger">Inactive</span>
            @endif
          </td>
          <td>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn-action btn-edit">Edit</a>

            <form action="{{ route('admin.products.destroy', $product) }}"
                  method="POST" style="display:inline-block" 
                  onsubmit="return confirm('Delete this product?')">
              @csrf
              @method('DELETE')
              <button class="btn-action btn-delete">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{ $products->links() }}

    @else
    <div class="empty-state">
      <div class="empty-icon">📦</div>
      <div class="empty-title">No Products Yet</div>
      <div class="empty-desc">Products will appear here once you add them to your store.</div>
    </div>
    @endif
  </div>
</div>
</x-admin-layout>