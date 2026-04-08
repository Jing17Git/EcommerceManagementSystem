<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserActivity;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check()) {
            $activityType = $this->determineActivityType($request);
            
            if ($activityType) {
                UserActivity::create([
                    'user_id' => auth()->id(),
                    'activity_type' => $activityType,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'metadata' => $this->extractMetadata($request),
                    'activity_at' => now()
                ]);
            }
        }

        return $response;
    }

    private function determineActivityType(Request $request)
    {
        $route = $request->route();
        if (!$route) return null;

        $routeName = $route->getName();
        $method = $request->method();

        // Login/Logout
        if ($routeName === 'login' && $method === 'POST') return 'login';
        if ($routeName === 'logout') return 'logout';

        // Shopping activities
        if (str_contains($routeName, 'product') && $method === 'GET') return 'view_product';
        if (str_contains($routeName, 'cart.add')) return 'add_to_cart';
        if (str_contains($routeName, 'order') && $method === 'POST') return 'purchase';

        // Seller activities
        if (str_contains($routeName, 'product.store')) return 'add_product';
        if (str_contains($routeName, 'product.update')) return 'update_product';
        if (str_contains($routeName, 'product.destroy')) return 'delete_product';

        return null;
    }

    private function extractMetadata(Request $request)
    {
        $metadata = [];

        if ($request->has('product_id')) {
            $metadata['product_id'] = $request->input('product_id');
        }

        if ($request->has('amount') || $request->has('total')) {
            $metadata['amount'] = $request->input('amount') ?? $request->input('total');
        }

        return $metadata;
    }
}
