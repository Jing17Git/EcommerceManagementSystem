<x-admin-layout>
    <div class="container-fluid px-4 py-4">
        <!-- Header Section -->
        <div class="mb-4">
            <h1 class="h3 mb-1 text-gray-800">
                <i class="fas fa-exclamation-triangle text-danger me-2"></i>Anomaly Details
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.anomaly-detection.index') }}">Anomaly Detection</a></li>
                    <li class="breadcrumb-item active">Details #{{ $anomaly->id }}</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Anomaly Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Anomaly Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Status Banner -->
                        @php
                            $statusConfig = [
                                'pending' => ['bg' => 'warning', 'icon' => 'fa-clock', 'text' => 'Pending Review'],
                                'reviewed' => ['bg' => 'info', 'icon' => 'fa-eye', 'text' => 'Reviewed'],
                                'resolved' => ['bg' => 'success', 'icon' => 'fa-check-circle', 'text' => 'Resolved'],
                                'false_positive' => ['bg' => 'secondary', 'icon' => 'fa-times-circle', 'text' => 'False Positive']
                            ];
                            $statusCfg = $statusConfig[$anomaly->status] ?? $statusConfig['pending'];
                            
                            $severityConfig = [
                                'critical' => ['bg' => 'danger', 'icon' => 'fa-fire'],
                                'high' => ['bg' => 'warning', 'icon' => 'fa-exclamation-triangle'],
                                'medium' => ['bg' => 'info', 'icon' => 'fa-info-circle'],
                                'low' => ['bg' => 'secondary', 'icon' => 'fa-circle']
                            ];
                            $severityCfg = $severityConfig[$anomaly->severity] ?? $severityConfig['low'];
                        @endphp
                        
                        <div class="alert alert-{{ $statusCfg['bg'] }} border-0 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas {{ $statusCfg['icon'] }} fa-2x me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Status: {{ $statusCfg['text'] }}</h6>
                                    <small>Anomaly ID: #{{ $anomaly->id }}</small>
                                </div>
                                <span class="badge bg-{{ $severityCfg['bg'] }} fs-6">
                                    <i class="fas {{ $severityCfg['icon'] }} me-1"></i>{{ ucfirst($anomaly->severity) }}
                                </span>
                            </div>
                        </div>

                        <!-- User Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted text-uppercase small mb-3">
                                    <i class="fas fa-user me-2"></i>User Information
                                </h6>
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-lg bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 60px; height: 60px;">
                                                <i class="fas fa-user fa-2x"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">{{ $anomaly->user->name }}</h5>
                                                <p class="mb-1 text-muted">
                                                    <i class="fas fa-envelope me-2"></i>{{ $anomaly->user->email }}
                                                </p>
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-user-tag me-1"></i>{{ ucfirst($anomaly->user->role) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Anomaly Details -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <div class="text-muted small mb-2">
                                            <i class="fas fa-tag me-2"></i>Anomaly Type
                                        </div>
                                        <h6 class="mb-0">
                                            <span class="badge bg-info-subtle text-info border border-info">
                                                {{ str_replace('_', ' ', ucwords($anomaly->anomaly_type)) }}
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <div class="text-muted small mb-2">
                                            <i class="fas fa-calendar-alt me-2"></i>Detected At
                                        </div>
                                        <h6 class="mb-0">{{ $anomaly->detected_at->format('M d, Y h:i A') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small mb-3">
                                <i class="fas fa-file-alt me-2"></i>Description
                            </h6>
                            <div class="alert alert-light border mb-0">
                                <p class="mb-0">{{ $anomaly->description }}</p>
                            </div>
                        </div>

                        <!-- Detection Data -->
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small mb-3">
                                <i class="fas fa-database me-2"></i>Detection Data
                            </h6>
                            <div class="card border-0 bg-dark text-light">
                                <div class="card-body">
                                    <pre class="mb-0 text-light" style="font-size: 0.85rem;"><code>{{ json_encode($anomaly->detection_data, JSON_PRETTY_PRINT) }}</code></pre>
                                </div>
                            </div>
                        </div>

                        <!-- Review Information -->
                        @if($anomaly->reviewed_at)
                            <div>
                                <h6 class="text-muted text-uppercase small mb-3">
                                    <i class="fas fa-clipboard-check me-2"></i>Review Information
                                </h6>
                                <div class="card border-0 bg-success bg-opacity-10 border-success">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Reviewed By</div>
                                                <div class="fw-semibold">
                                                    <i class="fas fa-user-check me-2 text-success"></i>{{ $anomaly->reviewer->name ?? 'N/A' }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-muted small mb-1">Reviewed At</div>
                                                <div class="fw-semibold">
                                                    <i class="fas fa-clock me-2 text-success"></i>{{ $anomaly->reviewed_at->format('M d, Y h:i A') }}
                                                </div>
                                            </div>
                                            @if($anomaly->review_notes)
                                                <div class="col-12">
                                                    <div class="text-muted small mb-1">Review Notes</div>
                                                    <div class="alert alert-success border-0 mb-0 mt-2">
                                                        {{ $anomaly->review_notes }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Review Form -->
                @if($anomaly->status === 'pending')
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-clipboard-check me-2 text-warning"></i>Review Anomaly
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.anomaly-detection.review', $anomaly->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-tasks me-2"></i>Status
                                    </label>
                                    <select name="status" class="form-select" required>
                                        <option value="">Select Status</option>
                                        <option value="reviewed">
                                            <i class="fas fa-eye"></i> Reviewed
                                        </option>
                                        <option value="resolved">
                                            <i class="fas fa-check-circle"></i> Resolved
                                        </option>
                                        <option value="false_positive">
                                            <i class="fas fa-times-circle"></i> False Positive
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-comment-alt me-2"></i>Review Notes
                                    </label>
                                    <textarea name="review_notes" class="form-control" rows="5" placeholder="Add your review notes here..."></textarea>
                                    <small class="text-muted">Optional: Add any relevant notes about this anomaly</small>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                    <i class="fas fa-check me-2"></i>Submit Review
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.anomaly-detection.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                        <a href="{{ route('admin.users.show', $anomaly->user_id) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-user me-2"></i>View User Profile
                        </a>
                    </div>
                </div>

                <!-- Anomaly Stats -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>Quick Stats
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <div class="text-muted small">Severity Level</div>
                                <span class="badge bg-{{ $severityCfg['bg'] }} mt-1">
                                    <i class="fas {{ $severityCfg['icon'] }} me-1"></i>{{ ucfirst($anomaly->severity) }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <div class="text-muted small">Current Status</div>
                                <span class="badge bg-{{ $statusCfg['bg'] }} mt-1">
                                    <i class="fas {{ $statusCfg['icon'] }} me-1"></i>{{ $statusCfg['text'] }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">Detection Time</div>
                                <div class="small mt-1">{{ $anomaly->detected_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .avatar-lg {
            font-size: 1rem;
        }
    </style>
</x-admin-layout>
