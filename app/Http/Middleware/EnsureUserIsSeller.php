<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isSeller()) {
            return redirect('/dashboard')->with('error', 'You do not have permission to access seller pages.');
        }

        if (!is_null($user->current_role) && $user->current_role !== User::ROLE_SELLER) {
            return redirect()->route('buyer.dashboard')->with('error', 'Switch to seller account first.');
        }

        return $next($request);
    }
}
