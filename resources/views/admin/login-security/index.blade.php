<x-admin-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Login Security</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Login Security</li>
        </ol>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <h4>{{ $stats['total_attempts'] }}</h4>
                        <div>Total Attempts</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <h4>{{ $stats['failed_attempts'] }}</h4>
                        <div>Failed Attempts</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <h4>{{ $stats['successful_attempts'] }}</h4>
                        <div>Successful Logins</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <h4>{{ $stats['active_lockouts'] }}</h4>
                        <div>Active Lockouts</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-lock me-1"></i> Login Attempts</span>
                <div>
                    <a href="{{ route('admin.login-security.lockouts') }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-ban"></i> View Lockouts
                    </a>
                    <form action="{{ route('admin.login-security.cleanup') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Clean up old login attempts?')">
                            <i class="fas fa-trash"></i> Cleanup
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3 mb-3">
                    <div class="col-md-3">
                        <input type="text" name="email" class="form-control" placeholder="Search by email" value="{{ request('email') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="ip" class="form-control" placeholder="Search by IP" value="{{ request('ip') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Successful</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.login-security.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Recent Activity:</strong> {{ $stats['recent_failed'] }} failed attempts in the last hour
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>IP Address</th>
                                <th>Status</th>
                                <th>Failure Reason</th>
                                <th>Attempted At</th>
                                <th>User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attempts as $attempt)
                                <tr class="{{ $attempt->successful ? '' : 'table-danger' }}">
                                    <td>{{ $attempt->id }}</td>
                                    <td>{{ $attempt->email }}</td>
                                    <td>
                                        <code>{{ $attempt->ip_address }}</code>
                                    </td>
                                    <td>
                                        @if($attempt->successful)
                                            <span class="badge bg-success">Success</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $attempt->failure_reason ?? '-' }}</td>
                                    <td>{{ $attempt->attempted_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($attempt->user_agent, 50) }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No login attempts found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $attempts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
