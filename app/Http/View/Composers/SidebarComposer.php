<?php

namespace App\Http\View\Composers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            $sidebarStats = [
                'productsCount' => 0,
                'ordersCount' => 0,
                'pendingReturns' => 0,
                'wishlistCount' => 0,
                'totalSpent' => 0,
                'cartCount' => 0,
            ];
            $view->with('sidebarStats', $sidebarStats);
            return;
        }

        $user = Auth::user();
        
        $activeRole = $user->current_role ?? ($user->isSeller() ? 'seller' : 'buyer');

        // Check active role and provide appropriate stats
        if ($activeRole === 'seller' && $user->isSeller()) {
            // Seller stats
            $productsCount = Product::where('seller_id', $user->id)->count();
            $orders = Order::where('seller_id', $user->id)->orderBy('created_at', 'desc')->get();
            $ordersCount = $orders->count();
            $pendingReturns = $orders->where('status', 'cancelled')->count();
            
            $sidebarStats = [
                'productsCount' => $productsCount,
                'ordersCount' => $ordersCount,
                'pendingReturns' => $pendingReturns,
                'wishlistCount' => 0,
                'totalSpent' => 0,
                'cartCount' => 0,
            ];
        } else {
            // Buyer stats
            $buyerOrders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            $ordersCount = $buyerOrders->count();
            $totalSpent = $buyerOrders->where('status', '!=', 'cancelled')->sum('total_amount');
            
            // Wishlist count (using orders as proxy)
            $wishlistCount = $buyerOrders->count();
            $cartCount = Cart::where('user_id', $user->id)->sum('quantity');
            
            $sidebarStats = [
                'productsCount' => 0,
                'ordersCount' => $ordersCount,
                'pendingReturns' => 0,
                'wishlistCount' => $wishlistCount,
                'totalSpent' => $totalSpent,
                'cartCount' => $cartCount,
            ];
        }

        $view->with('sidebarStats', $sidebarStats);
    }
}
