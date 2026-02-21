<x-admin-layout>
<x-slot name="header">Seller Applications</x-slot>

<div class="card">
  <div class="card-body">
    @if($applications->count())
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Business Name</th>
          <th>Status</th>
          <th>Submitted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($applications as $app)
        <tr>
          <td>{{ $app->id }}</td>
          <td>{{ $app->user->name }}</td>
          <td>{{ $app->business_name }}</td>
          <td>{{ ucfirst($app->status) }}</td>
          <td>{{ $app->created_at->format('Y-m-d') }}</td>
          <td>
            <a href="{{ route('admin.sellers.show', $app) }}" class="btn-action btn-view">View</a>
            @if($app->status == 'pending')
              <form action="{{ route('admin.sellers.approve', $app) }}" method="POST" style="display:inline-block">
                @csrf
                <button class="btn-action btn-approve">Approve</button>
              </form>
              <form action="{{ route('admin.sellers.reject', $app) }}" method="POST" style="display:inline-block">
                @csrf
                <button class="btn-action btn-reject">Reject</button>
              </form>
            @endif
            <form action="{{ route('admin.sellers.destroy', $app) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this application?')">
              @csrf
              @method('DELETE')
              <button class="btn-action btn-delete">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $applications->links() }}
    @else
    <div class="empty-state">
      <div class="empty-icon">📝</div>
      <div class="empty-title">No Seller Applications Yet</div>
      <div class="empty-desc">Seller applications will appear here once users apply to become sellers.</div>
    </div>
    @endif
  </div>
</div>
</x-admin-layout>