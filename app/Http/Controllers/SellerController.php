<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    /**
     * Show the seller dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get products count for this seller
        $productsCount = Product::where('user_id', $user->id)->count();
        
        // Get all orders (for now - in a multi-seller system, we'd need order_items table)
        $orders = Order::orderBy('created_at', 'desc')->get();
        $ordersCount = $orders->count();
        
        // Calculate revenue (sum of all order amounts)
        $revenue = $orders->sum('total_amount');
        
        // Get recent orders (latest 5)
        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
        
        // Order status breakdown
        $orderStatuses = [
            'delivered' => $orders->where('status', 'delivered')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'pending' => $orders->where('status', 'pending')->count(),
            'shipped' => $orders->where('status', 'shipped')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];
        
        // Get top products (seller's products with stock > 0, ordered by created_at)
        $topProducts = Product::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Calculate this month's stats
        $thisMonthOrders = $orders->where('created_at', '>=', now()->startOfMonth());
        $thisMonthRevenue = $thisMonthOrders->sum('total_amount');
        
        // Pending returns count (orders with status 'cancelled' or we could add a returns table)
        $pendingReturns = $orders->where('status', 'cancelled')->count();
        
        // Store stats for sidebar
        $stats = [
            'productsCount' => $productsCount,
            'ordersCount' => $ordersCount,
            'revenue' => $revenue,
            'thisMonthRevenue' => $thisMonthRevenue,
            'pendingReturns' => $pendingReturns,
        ];

        // Get current role (for switching between buyer/seller)
        $currentRole = $user->getCurrentRoleDisplay();
        
        // Check if user has both buyer and seller roles (for switching)
        // Using the new hasAnyRole method from User model
        $hasBuyerRole = $user->isBuyer();
        $hasSellerRole = $user->isSeller();
        
        return view('seller.dashboard', compact(
            'stats',
            'recentOrders',
            'orderStatuses',
            'topProducts',
            'currentRole',
            'hasBuyerRole',
            'hasSellerRole'
        ));
    }

    /**
     * Show the seller products page.
     */
    public function products()
    {
        return view('seller.products');
    }

    /**
     * Show the seller orders page.
     */
    public function orders()
    {
        return view('seller.orders');
    }

    /**
     * Show the seller wallet/payments page.
     */
    public function wallet()
    {
        return view('seller.wallet');
    }

    /**
     * Show the seller shipping page.
     */
    public function shipping()
    {
        return view('seller.shipping');
    }

    /**
     * Show the seller returns/refunds page.
     */
    public function returns()
    {
        return view('seller.returns');
    }

    /**
     * Show the seller settings page.
     */
    public function settings()
    {
        return view('seller.settings');
    }
}
