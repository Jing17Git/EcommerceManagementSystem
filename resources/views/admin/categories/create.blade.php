<x-admin-layout>
<x-slot name="header">Add Category</x-slot>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.categories.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="mb-3">
        <label>Status</label>
        <select name="is_active" class="form-control">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>

      <button class="btn btn-primary">Save</button>
    </form>
  </div>
</div>
</x-admin-layout>