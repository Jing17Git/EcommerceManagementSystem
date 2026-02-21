<x-admin-layout>
<x-slot name="header">Edit Product</x-slot>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
          <option value="">-- None --</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Status</label>
        <select name="is_active" class="form-control">
          <option value="1" {{ $product->is_active ? 'selected' : '' }}>Active</option>
          <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Current Image</label><br>
        @if($product->image)
          <img src="{{ $product->imageUrl() }}" width="80" alt="Image">
        @else
          <span>No image</span>
        @endif
      </div>

      <div class="mb-3">
        <label>Change Image</label>
        <input type="file" name="image" class="form-control">
      </div>

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
</x-admin-layout>