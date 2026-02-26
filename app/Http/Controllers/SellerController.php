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
        $productsCount = Product::where('seller_id', $user->id)->count();
        
        // Get seller-owned orders
        $orders = Order::where('seller_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        $ordersCount = $orders->count();
        
        // Calculate revenue (sum of all order amounts)
        $revenue = $orders->sum('total_amount');
        
        // Get recent orders (latest 5)
        $recentOrders = Order::where('seller_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Order status breakdown
        $orderStatuses = [
            'delivered' => $orders->where('status', 'delivered')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'pending' => $orders->where('status', 'pending')->count(),
            'shipped' => $orders->where('status', 'shipped')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];
        
        // Get top products (seller's products with stock > 0, ordered by created_at)
        $topProducts = Product::where('seller_id', $user->id)
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
        $user = Auth::user();
        $orders = Order::where('seller_id', $user->id)
            ->with('user')
            ->latest()
            ->paginate(10);

        $orderStatuses = [
            'pending' => Order::where('seller_id', $user->id)->where('status', 'pending')->count(),
            'processing' => Order::where('seller_id', $user->id)->where('status', 'processing')->count(),
            'shipped' => Order::where('seller_id', $user->id)->where('status', 'shipped')->count(),
            'delivered' => Order::where('seller_id', $user->id)->where('status', 'delivered')->count(),
            'cancelled' => Order::where('seller_id', $user->id)->where('status', 'cancelled')->count(),
        ];

        $totalOrders = array_sum($orderStatuses);

        return view('seller.orders', compact('orders', 'orderStatuses', 'totalOrders'));
    }

    /**
     * Show the seller wallet/payments page.
     */
    public function wallet()
    {
        $user = Auth::user();
        $orders = Order::where('seller_id', $user->id)->latest()->get();

        $completedOrders = $orders->whereIn('status', ['shipped', 'delivered']);
        $pendingOrders = $orders->whereIn('status', ['pending', 'processing']);
        $cancelledOrders = $orders->where('status', 'cancelled');

        $totalEarnings = (float) $completedOrders->sum('total_amount');
        $pendingAmount = (float) $pendingOrders->sum('total_amount');
        $refundedAmount = (float) $cancelledOrders->sum('total_amount');
        $availableBalance = max($totalEarnings - $refundedAmount, 0);

        $monthlyEarnings = collect(range(5, 0))
            ->map(function ($monthsAgo) use ($completedOrders) {
                $month = now()->subMonths($monthsAgo);
                $monthTotal = (float) $completedOrders
                    ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                    ->sum('total_amount');

                return [
                    'label' => $month->format('M'),
                    'amount' => round($monthTotal, 2),
                ];
            })
            ->push([
                'label' => now()->format('M'),
                'amount' => round((float) $completedOrders
                    ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                    ->sum('total_amount'), 2),
            ]);

        $recentTransactions = $orders->take(10)->map(function ($order) {
            $isRefund = $order->status === 'cancelled';

            return [
                'id' => $order->order_number ?? ('ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT)),
                'type' => $isRefund ? 'Refund' : 'Order Payment',
                'amount' => (float) $order->total_amount,
                'status' => $order->status,
                'date' => $order->created_at,
            ];
        });

        return view('seller.wallet', [
            'walletStats' => [
                'availableBalance' => $availableBalance,
                'thisMonthEarnings' => (float) $monthlyEarnings->last()['amount'],
                'pendingAmount' => $pendingAmount,
                'refundedAmount' => $refundedAmount,
                'totalEarnings' => $totalEarnings,
            ],
            'monthlyEarnings' => $monthlyEarnings,
            'recentTransactions' => $recentTransactions,
        ]);
    }

    /**
     * Show the seller shipping page.
     */
    public function shipping()
    {
        $user = Auth::user();
        $orders = Order::where('seller_id', $user->id)->latest()->get();

        $totalShipments = $orders->whereNotIn('status', ['cancelled'])->count();
        $inTransit = $orders->whereIn('status', ['processing', 'shipped'])->count();
        $delivered = $orders->where('status', 'delivered')->count();
        $failed = $orders->where('status', 'cancelled')->count();

        $activeShipments = $orders
            ->whereIn('status', ['processing', 'shipped'])
            ->take(10);

        return view('seller.shipping', [
            'shippingStats' => [
                'totalShipments' => $totalShipments,
                'inTransit' => $inTransit,
                'delivered' => $delivered,
                'failed' => $failed,
            ],
            'activeShipments' => $activeShipments,
        ]);
    }

    /**
     * Show the seller returns/refunds page.
     */
    public function returns()
    {
        $user = Auth::user();
        $returnOrders = Order::where('seller_id', $user->id)
            ->where('status', 'cancelled')
            ->latest()
            ->take(20)
            ->get();

        $refundAmount = (float) $returnOrders->sum('total_amount');

        return view('seller.returns', [
            'returnsStats' => [
                'totalReturns' => $returnOrders->count(),
                'pending' => 0,
                'approved' => $returnOrders->count(),
                'refundedAmount' => $refundAmount,
            ],
            'returnRequests' => $returnOrders,
        ]);
    }

    /**
     * Show the seller settings page.
     */
    public function settings()
    {
        $user = Auth::user();
        return view('seller.settings', compact('user'));
    }

    /**
     * Update seller settings.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            // Store Profile Fields
            'store_name' => 'nullable|string|max:255',
            'store_email' => 'nullable|email|max:255',
            'store_description' => 'nullable|string',
            'store_phone' => 'nullable|string|max:50',
            'store_address' => 'nullable|string',
            'store_logo' => 'nullable|string',
            // Business Settings
            'auto_accept_orders' => 'required|boolean',
            'low_stock_alerts' => 'required|boolean',
            'email_notifications' => 'required|boolean',
            // Shipping Preferences
            'default_shipping_carrier' => 'nullable|in:J&T Express,LBC Padala,Flash Express',
            'processing_time' => 'nullable|in:Same Day,1-2 Business Days,3-5 Business Days,5-7 Business Days',
            'free_shipping_threshold' => 'nullable|in:0,500,1000,1500,2000',
        ]);

        $user->update($validated);

        return redirect()->route('seller.settings')->with('success', 'Settings updated successfully!');
    }
}
