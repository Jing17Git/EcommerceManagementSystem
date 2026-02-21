<x-admin-layout>
<x-slot name="header">Add Product</x-slot>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
          <option value="">-- None --</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control">
      </div>

      <button class="btn btn-primary">Save</button>
    </form>
  </div>
</div>
</x-admin-layout>