<x-admin-layout>
<x-slot name="header">Edit Category</x-slot>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $category->description }}</textarea>
      </div>

      <div class="mb-3">
        <label>Status</label>
        <select name="is_active" class="form-control">
          <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
          <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
</x-admin-layout>