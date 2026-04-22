<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CookieConsent;
use App\Models\AnomalyDetection;
use App\Models\LoginAttempt;
use App\Models\LoginLockout;
use Illuminate\Support\Facades\DB;

class SecurityCenterController extends Controller
{
    public function index()
    {
        $cookieConsent = CookieConsent::first() ?? new CookieConsent(['is_enabled' => false]);
        
        $cookieStats = [
            'accepted' => DB::table('cookie_consent')->where('consent_given', true)->count(),
            'declined' => DB::table('cookie_consent')->where('consent_given', false)->count(),
        ];

        $anomalyStats = [
            'total' => AnomalyDetection::count(),
            'pending' => AnomalyDetection::where('status', 'pending')->count(),
            'critical' => AnomalyDetection::where('severity', 'critical')->where('status', 'pending')->count(),
        ];

        $today = now()->startOfDay();
        $loginStats = [
            'total_attempts' => LoginAttempt::count(),
            'failed_attempts' => LoginAttempt::where('successful', false)->whereDate('attempted_at', $today)->count(),
            'successful_attempts' => LoginAttempt::where('successful', true)->whereDate('attempted_at', $today)->count(),
            'active_lockouts' => LoginLockout::where('locked_until', '>', now())->count(),
            'recent_failed' => LoginAttempt::where('successful', false)->where('attempted_at', '>=', now()->subHour())->count(),
        ];

        $recentActivity = $this->getRecentActivity();

        return view('admin.security.index', compact(
            'cookieConsent',
            'cookieStats',
            'anomalyStats',
            'loginStats',
            'recentActivity'
        ));
    }

    private function getRecentActivity()
    {
        $activities = [];

        $recentAnomalies = AnomalyDetection::with('user')
            ->where('detected_at', '>=', now()->subDay())
            ->orderBy('detected_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($recentAnomalies as $anomaly) {
            $activities[] = [
                'title' => ucfirst(str_replace('_', ' ', $anomaly->anomaly_type)),
                'description' => 'Detected for ' . $anomaly->user->name . ' - ' . $anomaly->severity . ' severity',
                'time' => $anomaly->detected_at->diffForHumans(),
                'color' => $anomaly->severity === 'critical' ? 'red' : 'orange',
                'icon' => '<svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
            ];
        }

        $recentLockouts = LoginLockout::where('locked_at', '>=', now()->subDay())
            ->orderBy('locked_at', 'desc')
            ->limit(2)
            ->get();

        foreach ($recentLockouts as $lockout) {
            $activities[] = [
                'title' => 'Account Locked',
                'description' => 'Email: ' . $lockout->email . ' - ' . $lockout->reason,
                'time' => $lockout->locked_at->diffForHumans(),
                'color' => 'red',
                'icon' => '<svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>',
            ];
        }

        $recentFailedLogins = LoginAttempt::where('successful', false)
            ->where('attempted_at', '>=', now()->subHours(6))
            ->orderBy('attempted_at', 'desc')
            ->limit(2)
            ->get();

        foreach ($recentFailedLogins as $attempt) {
            $activities[] = [
                'title' => 'Failed Login Attempt',
                'description' => $attempt->email . ' from ' . $attempt->ip_address,
                'time' => $attempt->attempted_at->diffForHumans(),
                'color' => 'orange',
                'icon' => '<svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
            ];
        }

        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }
}
