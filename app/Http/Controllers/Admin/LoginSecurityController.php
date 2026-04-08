<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginAttempt;
use App\Models\LoginLockout;
use App\Services\LoginSecurityService;

class LoginSecurityController extends Controller
{
    protected $loginSecurity;

    public function __construct(LoginSecurityService $loginSecurity)
    {
        $this->loginSecurity = $loginSecurity;
    }

    public function index(Request $request)
    {
        $query = LoginAttempt::orderBy('attempted_at', 'desc');

        if ($request->has('email') && $request->email) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->has('ip') && $request->ip) {
            $query->where('ip_address', $request->ip);
        }

        if ($request->has('status')) {
            if ($request->status === 'success') {
                $query->where('successful', true);
            } elseif ($request->status === 'failed') {
                $query->where('successful', false);
            }
        }

        $attempts = $query->paginate(50);

        $stats = [
            'total_attempts' => LoginAttempt::count(),
            'failed_attempts' => LoginAttempt::where('successful', false)->count(),
            'successful_attempts' => LoginAttempt::where('successful', true)->count(),
            'active_lockouts' => LoginLockout::where('locked_until', '>', now())->count(),
            'recent_failed' => LoginAttempt::where('successful', false)
                ->where('attempted_at', '>=', now()->subHour())
                ->count(),
        ];

        return view('admin.login-security.index', compact('attempts', 'stats'));
    }

    public function lockouts()
    {
        $lockouts = LoginLockout::orderBy('last_attempt_at', 'desc')->paginate(20);
        
        return view('admin.login-security.lockouts', compact('lockouts'));
    }

    public function unlock(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'type' => 'required|in:email,ip'
        ]);

        $lockout = LoginLockout::where('identifier', $request->identifier)
            ->where('type', $request->type)
            ->first();

        if ($lockout) {
            $lockout->update([
                'locked_until' => null,
                'failed_attempts' => 0
            ]);
        }

        return back()->with('success', 'Lockout removed successfully.');
    }

    public function cleanup()
    {
        $this->loginSecurity->cleanupOldAttempts();
        
        return back()->with('success', 'Old login attempts cleaned up successfully.');
    }
}
