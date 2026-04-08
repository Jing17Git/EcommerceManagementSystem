<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\AnomalyDetectionService;
use App\Models\UserActivity;

class DetectLoginAnomaly
{
    protected $anomalyService;

    public function __construct(AnomalyDetectionService $anomalyService)
    {
        $this->anomalyService = $anomalyService;
    }

    public function handle(Login $event): void
    {
        $user = $event->user;
        
        // Track login activity
        UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'login',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => [],
            'activity_at' => now()
        ]);

        // Detect anomalies
        $this->anomalyService->detectAnomalies($user->id, 'login', [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}
