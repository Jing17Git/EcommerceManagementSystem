@php
    $pendingAnomalies = \App\Models\AnomalyDetection::where('status', 'pending')->count();
    $criticalAnomalies = \App\Models\AnomalyDetection::where('severity', 'critical')->where('status', 'pending')->count();
    $recentAnomalies = \App\Models\AnomalyDetection::with('user')
        ->where('status', 'pending')
        ->orderBy('detected_at', 'desc')
        ->take(5)
        ->get();
@endphp

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-shield-alt me-1"></i> Security Alerts</span>
        <a href="{{ route('admin.anomaly-detection.index') }}" class="btn btn-sm btn-outline-primary">
            View All
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="alert alert-warning mb-0">
                    <h4 class="mb-0">{{ $pendingAnomalies }}</h4>
                    <small>Pending Reviews</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-danger mb-0">
                    <h4 class="mb-0">{{ $criticalAnomalies }}</h4>
                    <small>Critical Alerts</small>
                </div>
            </div>
        </div>

        @if($recentAnomalies->count() > 0)
            <h6 class="mb-2">Recent Anomalies</h6>
            <div class="list-group">
                @foreach($recentAnomalies as $anomaly)
                    <a href="{{ route('admin.anomaly-detection.show', $anomaly->id) }}" 
                       class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $anomaly->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($anomaly->description, 50) }}</small>
                            </div>
                            <span class="badge bg-{{ $anomaly->severity === 'critical' ? 'danger' : ($anomaly->severity === 'high' ? 'warning' : 'info') }}">
                                {{ ucfirst($anomaly->severity) }}
                            </span>
                        </div>
                        <small class="text-muted">{{ $anomaly->detected_at->diffForHumans() }}</small>
                    </a>
                @endforeach
            </div>
        @else
            <div class="alert alert-success mb-0">
                <i class="fas fa-check-circle"></i> No pending anomalies. System is secure!
            </div>
        @endif
    </div>
</div>
