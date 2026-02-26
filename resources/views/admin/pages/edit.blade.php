<x-admin-layout>
<x-slot name="header">Edit Page</x-slot>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" value="{{ $page->title }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Content</label>
        <textarea name="content" class="form-control" rows="10">{{ $page->content }}</textarea>
      </div>

      <div class="mb-3">
        <label>Status</label>
        <select name="is_active" class="form-control">
          <option value="1" {{ $page->is_active ? 'selected' : '' }}>Active</option>
          <option value="0" {{ !$page->is_active ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
</x-admin-layout>
