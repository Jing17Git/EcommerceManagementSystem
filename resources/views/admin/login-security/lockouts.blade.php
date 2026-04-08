<x-admin-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Login Lockouts</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.login-security.index') }}">Login Security</a></li>
            <li class="breadcrumb-item active">Lockouts</li>
        </ol>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-ban me-1"></i> Account Lockouts</span>
                <a href="{{ route('admin.login-security.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Attempts
                </a>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Note:</strong> Accounts are automatically locked after 5 failed login attempts within 15 minutes. 
                    Lockout duration is 5 minutes.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Identifier</th>
                                <th>Type</th>
                                <th>Failed Attempts</th>
                                <th>Status</th>
                                <th>Locked Until</th>
                                <th>Last Attempt</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lockouts as $lockout)
                                <tr class="{{ $lockout->isLocked() ? 'table-danger' : '' }}">
                                    <td>{{ $lockout->id }}</td>
                                    <td>
                                        @if($lockout->type === 'email')
                                            {{ $lockout->identifier }}
                                        @else
                                            <code>{{ $lockout->identifier }}</code>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $lockout->type === 'email' ? 'primary' : 'info' }}">
                                            {{ ucfirst($lockout->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $lockout->failed_attempts }}</span>
                                    </td>
                                    <td>
                                        @if($lockout->isLocked())
                                            <span class="badge bg-danger">
                                                <i class="fas fa-lock"></i> Locked
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fas fa-unlock"></i> Unlocked
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lockout->locked_until)
                                            {{ $lockout->locked_until->format('Y-m-d H:i:s') }}
                                            @if($lockout->isLocked())
                                                <br>
                                                <small class="text-danger">
                                                    ({{ ceil($lockout->getRemainingLockoutTime() / 60) }} min remaining)
                                                </small>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $lockout->last_attempt_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        @if($lockout->isLocked() || $lockout->failed_attempts > 0)
                                            <form action="{{ route('admin.login-security.unlock') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="identifier" value="{{ $lockout->identifier }}">
                                                <input type="hidden" name="type" value="{{ $lockout->type }}">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Unlock this account?')">
                                                    <i class="fas fa-unlock"></i> Unlock
                                                </button>
                                            </form>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No lockouts found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $lockouts->links() }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Lockout Policy
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>Maximum Failed Attempts:</strong> 5 attempts</li>
                    <li><strong>Time Window:</strong> 15 minutes</li>
                    <li><strong>Lockout Duration:</strong> 5 minutes</li>
                    <li><strong>Tracking:</strong> Both email and IP address</li>
                    <li><strong>Auto-Unlock:</strong> After lockout period expires</li>
                </ul>
            </div>
        </div>
    </div>
</x-admin-layout>
