<x-admin-layout>
<x-slot name="header">Create Page</x-slot>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.pages.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Content</label>
        <textarea name="content" class="form-control" rows="10"></textarea>
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
