<x-admin-layout>
    <div class="container-fluid px-4 py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">
                    <i class="fas fa-shield-alt text-primary me-2"></i>Anomaly Detection
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Anomaly Detection</li>
                    </ol>
                </nav>
            </div>
            <form action="{{ route('admin.anomaly-detection.learn-baselines') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success shadow-sm">
                    <i class="fas fa-brain me-2"></i>Learn Baselines
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-gradient rounded-3 p-3">
                                    <i class="fas fa-exclamation-triangle fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small text-uppercase mb-1">Total Anomalies</div>
                                <div class="h3 mb-0 fw-bold">{{ $stats['total'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-gradient rounded-3 p-3">
                                    <i class="fas fa-clock fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small text-uppercase mb-1">Pending Review</div>
                                <div class="h3 mb-0 fw-bold">{{ $stats['pending'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-danger bg-gradient rounded-3 p-3">
                                    <i class="fas fa-fire fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small text-uppercase mb-1">Critical Pending</div>
                                <div class="h3 mb-0 fw-bold">{{ $stats['critical'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>Detected Anomalies
                </h5>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Status</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="all">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="false_positive" {{ request('status') === 'false_positive' ? 'selected' : '' }}>False Positive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Severity</label>
                        <select name="severity" class="form-select" onchange="this.form.submit()">
                            <option value="all">All Severity</option>
                            <option value="critical" {{ request('severity') === 'critical' ? 'selected' : '' }}>Critical</option>
                            <option value="high" {{ request('severity') === 'high' ? 'selected' : '' }}>High</option>
                            <option value="medium" {{ request('severity') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="low" {{ request('severity') === 'low' ? 'selected' : '' }}>Low</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Type</label>
                        <select name="type" class="form-select" onchange="this.form.submit()">
                            <option value="all">All Types</option>
                            <option value="suspicious_login" {{ request('type') === 'suspicious_login' ? 'selected' : '' }}>Suspicious Login</option>
                            <option value="unusual_shopping" {{ request('type') === 'unusual_shopping' ? 'selected' : '' }}>Unusual Shopping</option>
                            <option value="abnormal_seller_activity" {{ request('type') === 'abnormal_seller_activity' ? 'selected' : '' }}>Abnormal Seller Activity</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">&nbsp;</label>
                        <a href="{{ route('admin.anomaly-detection.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-redo me-1"></i>Reset
                        </a>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 60px;">ID</th>
                                <th>User</th>
                                <th>Type</th>
                                <th class="text-center">Severity</th>
                                <th>Description</th>
                                <th>Detected At</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anomalies as $anomaly)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">#{{ $anomaly->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $anomaly->user->name }}</div>
                                                <small class="text-muted">{{ $anomaly->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info border border-info">
                                            <i class="fas fa-tag me-1"></i>{{ str_replace('_', ' ', ucwords($anomaly->anomaly_type)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $severityConfig = [
                                                'critical' => ['bg' => 'danger', 'icon' => 'fa-fire'],
                                                'high' => ['bg' => 'warning', 'icon' => 'fa-exclamation-triangle'],
                                                'medium' => ['bg' => 'info', 'icon' => 'fa-info-circle'],
                                                'low' => ['bg' => 'secondary', 'icon' => 'fa-circle']
                                            ];
                                            $config = $severityConfig[$anomaly->severity] ?? $severityConfig['low'];
                                        @endphp
                                        <span class="badge bg-{{ $config['bg'] }}">
                                            <i class="fas {{ $config['icon'] }} me-1"></i>{{ ucfirst($anomaly->severity) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 300px;" title="{{ $anomaly->description }}">
                                            {{ Str::limit($anomaly->description, 60) }}
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="fas fa-calendar-alt me-1 text-muted"></i>{{ $anomaly->detected_at->format('M d, Y') }}<br>
                                            <i class="fas fa-clock me-1 text-muted"></i>{{ $anomaly->detected_at->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['bg' => 'warning', 'icon' => 'fa-clock'],
                                                'reviewed' => ['bg' => 'info', 'icon' => 'fa-eye'],
                                                'resolved' => ['bg' => 'success', 'icon' => 'fa-check-circle'],
                                                'false_positive' => ['bg' => 'secondary', 'icon' => 'fa-times-circle']
                                            ];
                                            $statusCfg = $statusConfig[$anomaly->status] ?? $statusConfig['pending'];
                                        @endphp
                                        <span class="badge bg-{{ $statusCfg['bg'] }}">
                                            <i class="fas {{ $statusCfg['icon'] }} me-1"></i>{{ ucfirst(str_replace('_', ' ', $anomaly->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.anomaly-detection.show', $anomaly->id) }}" class="btn btn-sm btn-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-shield-alt fa-3x mb-3 opacity-25"></i>
                                            <p class="mb-0">No anomalies detected</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($anomalies->hasPages())
                    <div class="mt-4">
                        {{ $anomalies->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .avatar-sm {
            font-size: 0.75rem;
        }
        .table > :not(caption) > * > * {
            padding: 0.75rem 0.5rem;
        }
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }
    </style>
</x-admin-layout>
