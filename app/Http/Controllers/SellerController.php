<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ReturnRequest;
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

        $salesOverview = [
            '7d' => $this->buildSalesSeries($user->id, 7),
            '30d' => $this->buildSalesSeries($user->id, 30),
            '90d' => $this->buildSalesSeries($user->id, 90),
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
            'salesOverview',
            'currentRole',
            'hasBuyerRole',
            'hasSellerRole'
        ));
    }

    /**
     * Build sales labels and totals for the selected day range.
     */
    private function buildSalesSeries(int $sellerId, int $days): array
    {
        $startDate = now()->subDays($days - 1)->startOfDay();
        $endDate = now()->endOfDay();

        $totalsByDate = Order::where('seller_id', $sellerId)
            ->whereIn('status', ['processing', 'shipped', 'delivered'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(fn ($order) => $order->created_at->toDateString())
            ->map(fn ($dayOrders) => round((float) $dayOrders->sum('total_amount'), 2));

        $labels = [];
        $values = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $labels[] = $days <= 7 ? $date->format('D') : $date->format('M d');
            $values[] = (float) ($totalsByDate->get($date->toDateString()) ?? 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
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
     * Printable receipt view for a seller-owned order.
     */
    public function printReceipt(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['user', 'seller', 'items', 'payment']);

        return view('seller.orders-receipt', compact('order'));
    }

    /**
     * Accept a pending order.
     */
    public function acceptOrder(Order $order)
    {
        return $this->transitionOrderStatus(
            $order,
            'pending',
            'processing',
            'Order accepted successfully.',
            'Seller accepted the order.'
        );
    }

    /**
     * Decline a pending order.
     */
    public function declineOrder(Order $order)
    {
        return $this->transitionOrderStatus(
            $order,
            'pending',
            'cancelled',
            'Order declined successfully.',
            'Seller declined the order.'
        );
    }

    /**
     * Mark a processing order as shipped.
     */
    public function shipOrder(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'processing') {
            return back()->with('error', 'Only processing orders can be marked as shipped.');
        }

        $fromStatus = $order->status;
        $trackingNumber = $order->tracking_number ?: ('TRK-' . now()->format('YmdHis') . '-' . $order->id);

        $order->update([
            'status' => 'shipped',
            'tracking_number' => $trackingNumber,
            'shipping_carrier' => $order->shipping_carrier ?: (Auth::user()->default_shipping_carrier ?: 'Standard Courier'),
            'shipped_at' => now(),
        ]);

        $order->statusHistories()->create([
            'from_status' => $fromStatus,
            'to_status' => 'shipped',
            'note' => "Seller marked the order as shipped. Tracking: {$trackingNumber}",
            'changed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Order marked as shipped.');
    }

    /**
     * Mark a shipped order as delivered.
     */
    public function deliverOrder(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'shipped') {
            return back()->with('error', 'Only shipped orders can be marked as delivered.');
        }

        $fromStatus = $order->status;
        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        $order->statusHistories()->create([
            'from_status' => $fromStatus,
            'to_status' => 'delivered',
            'note' => 'Seller marked the order as delivered.',
            'changed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Order marked as delivered.');
    }

    /**
     * Transition order status with ownership and state checks.
     */
    private function transitionOrderStatus(
        Order $order,
        string $expectedStatus,
        string $nextStatus,
        string $successMessage,
        string $note
    ) {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== $expectedStatus) {
            return back()->with('error', "Only {$expectedStatus} orders can be changed to {$nextStatus}.");
        }

        $fromStatus = $order->status;
        $order->update(['status' => $nextStatus]);

        $order->statusHistories()->create([
            'from_status' => $fromStatus,
            'to_status' => $nextStatus,
            'note' => $note,
            'changed_by' => Auth::id(),
        ]);

        return back()->with('success', $successMessage);
    }

    /**
     * Show the seller wallet/payments page.
     */
    public function wallet()
    {
        $user = Auth::user();
        $orders = Order::where('seller_id', $user->id)
            ->with('returnRequest')
            ->latest()
            ->get();
        $payments = Payment::whereHas('order', fn ($q) => $q->where('seller_id', $user->id))->latest()->get();
        $refundedReturns = ReturnRequest::where('seller_id', $user->id)->where('status', 'refunded')->get();

        $completedOrders = $orders->whereIn('status', ['delivered']);
        $pendingOrders = $orders->whereIn('status', ['pending', 'processing']);

        $totalEarnings = (float) $payments->where('status', 'captured')->sum('amount');
        $pendingAmount = (float) $pendingOrders->sum('total_amount');
        $refundedAmount = (float) $refundedReturns->sum(fn ($return) => (float) $return->order?->total_amount);
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
            $isRefund = optional($order->returnRequest)->status === 'refunded';

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
        $returnRequests = ReturnRequest::with(['order', 'buyer'])
            ->where('seller_id', $user->id)
            ->latest()
            ->take(20)
            ->get();

        $refundAmount = (float) $returnRequests
            ->where('status', 'refunded')
            ->sum(fn ($return) => (float) $return->order?->total_amount);

        return view('seller.returns', [
            'returnsStats' => [
                'totalReturns' => $returnRequests->count(),
                'pending' => $returnRequests->where('status', 'requested')->count(),
                'approved' => $returnRequests->where('status', 'approved')->count(),
                'refundedAmount' => $refundAmount,
            ],
            'returnRequests' => $returnRequests,
        ]);
    }

    /**
     * Approve a requested return.
     */
    public function approveReturn(ReturnRequest $returnRequest)
    {
        if ($returnRequest->seller_id !== Auth::id()) {
            abort(403);
        }

        if ($returnRequest->status !== 'requested') {
            return back()->with('error', 'Only requested returns can be approved.');
        }

        $returnRequest->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'seller_note' => 'Return approved by seller.',
        ]);

        return back()->with('success', 'Return request approved.');
    }

    /**
     * Reject a requested return.
     */
    public function rejectReturn(ReturnRequest $returnRequest)
    {
        if ($returnRequest->seller_id !== Auth::id()) {
            abort(403);
        }

        if ($returnRequest->status !== 'requested') {
            return back()->with('error', 'Only requested returns can be rejected.');
        }

        $returnRequest->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'seller_note' => 'Return rejected by seller.',
        ]);

        return back()->with('success', 'Return request rejected.');
    }

    /**
     * Mark an approved return as refunded.
     */
    public function refundReturn(ReturnRequest $returnRequest)
    {
        if ($returnRequest->seller_id !== Auth::id()) {
            abort(403);
        }

        if ($returnRequest->status !== 'approved') {
            return back()->with('error', 'Only approved returns can be refunded.');
        }

        $returnRequest->update([
            'status' => 'refunded',
            'refunded_at' => now(),
            'seller_note' => 'Return refunded.',
        ]);

        if ($returnRequest->order) {
            if ($returnRequest->order->payment && $returnRequest->order->payment->status !== 'refunded') {
                $meta = $returnRequest->order->payment->meta ?? [];
                $meta['refunded_at'] = now()->toDateTimeString();
                $meta['refund_source'] = 'seller_returns';

                $returnRequest->order->payment->update([
                    'status' => 'refunded',
                    'meta' => $meta,
                ]);
            }

            $returnRequest->order->statusHistories()->create([
                'from_status' => $returnRequest->order->status,
                'to_status' => $returnRequest->order->status,
                'note' => 'Order return refunded.',
                'changed_by' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Return marked as refunded.');
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
