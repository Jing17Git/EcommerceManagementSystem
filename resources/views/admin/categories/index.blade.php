<x-admin-layout>
<x-slot name="header">Categories</x-slot>

<div class="ph">
  <div>
    <h1>Categories</h1>
    <p>Manage your store categories</p>
  </div>
  <a href="{{ route('admin.categories.create') }}" class="btn-primary">Add Category</a>
</div>

<div class="card">
  <div class="card-body">
    @if($categories->count())
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Slug</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          <td>{{ $category->name }}</td>
          <td>{{ $category->slug }}</td>
          <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
          <td>
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn-action btn-edit">Edit</a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this category?')">
              @csrf
              @method('DELETE')
              <button class="btn-action btn-delete">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $categories->links() }}
    @else
    <div class="empty-state">
      <div class="empty-icon">📂</div>
      <div class="empty-title">No Categories Yet</div>
      <div class="empty-desc">Categories will appear here once you add them.</div>
    </div>
    @endif
  </div>
</div>
</x-admin-layout>