<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\LoginSecurityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected $loginSecurity;

    public function __construct(LoginSecurityService $loginSecurity)
    {
        $this->loginSecurity = $loginSecurity;
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Check if account is locked
        $lockInfo = $this->loginSecurity->isLocked($request->email);
        
        if ($lockInfo['locked']) {
            $message = $this->loginSecurity->getLockoutMessage($lockInfo);
            $remainingSeconds = $lockInfo['remaining_seconds'];
            return back()->withErrors([
                'email' => $message . '|REMAINING:' . $remainingSeconds
            ])->withInput($request->only('email'));
        }

        try {
            $request->authenticate();
            
            // Record successful login
            $this->loginSecurity->recordAttempt($request->email, true);
            
            $request->session()->regenerate();

            // Redirect based on user role
            if (Auth::user()->isAdministrator()) {
                return redirect()->intended(route('admin.dashboard', absolute: false));
            }

            if (Auth::user()->isSeller()) {
                return redirect()->intended(route('seller.dashboard', absolute: false));
            }

            if (Auth::user()->isBuyer()) {
                return redirect()->intended(route('buyer.dashboard', absolute: false));
            }

            return redirect()->intended(route('dashboard', absolute: false));
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Record failed login attempt
            $this->loginSecurity->recordAttempt($request->email, false, 'Invalid credentials');
            
            // Get remaining attempts
            $remaining = $this->loginSecurity->getRemainingAttempts($request->email);
            
            if ($remaining > 0 && $remaining <= 3) {
                $message = "Invalid credentials. You have {$remaining} attempt(s) remaining before temporary lockout.";
            } else {
                $message = "These credentials do not match our records.";
            }
            
            return back()->withErrors([
                'email' => $message
            ])->withInput($request->only('email'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('status', 'You have been logged out successfully.');
    }
}
