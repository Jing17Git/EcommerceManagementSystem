<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\SellerApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * Show the buyer dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's order count
        $ordersCount = Order::where('user_id', $user->id)->count();
        
        // Get user's total spent
        $totalSpent = Order::where('user_id', $user->id)->where('status', '!=', 'cancelled')->sum('total_amount');
        
        // Get user's orders
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        
        // Get recent orders (latest 5)
        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Order status breakdown for buyer
        $orderStatuses = [
            'delivered' => $orders->where('status', 'delivered')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'pending' => $orders->where('status', 'pending')->count(),
            'shipped' => $orders->where('status', 'shipped')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];
        
        // Calculate this month's spending
        $thisMonthOrders = $orders->where('created_at', '>=', now()->startOfMonth());
        $thisMonthSpent = $thisMonthOrders->sum('total_amount');
        
        // Get wishlist count (products user has purchased or favorited - using orders as proxy)
        $wishlistCount = $orders->count();
        
        // Get pending orders count
        $pendingOrders = $orders->whereIn('status', ['pending', 'processing', 'shipped'])->count();
        
        // Get delivered orders count
        $deliveredOrders = $orders->where('status', 'delivered')->count();
        
        // Get cart count for real data visualization
        $cartCount = Cart::where('user_id', $user->id)->count();
        
        // Get all products for browsing stats
        $totalProducts = Product::where('is_active', true)->count();
        $categoriesCount = Category::count();
        
        // Get top categories by product count
        $topCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get();
        
        // Get recently viewed products (from recent orders as proxy)
        $recentlyViewedProducts = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        // Get recommended products (random active products)
        $recommendedProducts = Product::where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        // Calculate spending by month for chart (last 6 months)
        $monthlySpending = [];
        $monthlyLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthLabel = $month->format('M');
            $monthStart = $month->startOfMonth();
            $monthEnd = $month->endOfMonth();
            
            $spending = Order::where('user_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('total_amount');
            
            $monthlyLabels[] = $monthLabel;
            $monthlySpending[] = $spending;
        }
        
        // Store stats for sidebar
        $stats = [
            'ordersCount' => $ordersCount,
            'totalSpent' => $totalSpent,
            'thisMonthSpent' => $thisMonthSpent,
            'wishlistCount' => $wishlistCount,
            'pendingOrders' => $pendingOrders,
            'deliveredOrders' => $deliveredOrders,
            'totalProducts' => $totalProducts,
            'categoriesCount' => $categoriesCount,
            'cartCount' => $cartCount,
        ];
        
        // Check seller application status using new User model methods
        $isSeller = $user->isSeller();
        $hasPendingApplication = SellerApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();
        $hasApprovedApplication = SellerApplication::where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();
        $sellerApplication = SellerApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        // Get current role (for switching between buyer/seller)
        $currentRole = $user->getCurrentRoleDisplay();
        
        // Check if user has both buyer and seller roles (for switching) using new User model methods
        $hasBuyerRole = $user->isBuyer();
        $hasSellerRole = $user->isSeller();

        $notifications = $this->buildOrderNotifications($user->id, 8);
        $notificationCount = $notifications->count();
        
        return view('buyer.dashboard', compact(
            'stats',
            'recentOrders',
            'orderStatuses',
            'topCategories',
            'recentlyViewedProducts',
            'recommendedProducts',
            'monthlySpending',
            'monthlyLabels',
            'cartCount',
            'isSeller',
            'hasPendingApplication',
            'hasApprovedApplication',
            'sellerApplication',
            'currentRole',
            'hasBuyerRole',
            'hasSellerRole',
            'notifications',
            'notificationCount'
        ));
    }

    /**
     * Show the seller application form.
     */
    public function applySeller()
    {
        $user = Auth::user();
        
        // Check if user is already a seller
        if ($user->role === 'seller') {
            return redirect()->route('buyer.dashboard')->with('error', 'You are already a seller.');
        }
        
        // Check if user has a pending application
        $pendingApplication = SellerApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        
        if ($pendingApplication) {
            return redirect()->route('buyer.dashboard')->with('info', 'You already have a pending seller application.');
        }
        
        return view('buyer.apply-seller');
    }

    /**
     * Submit seller application.
     */
    public function submitSellerApplication(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is already a seller
        if ($user->role === 'seller') {
            return redirect()->route('buyer.dashboard')->with('error', 'You are already a seller.');
        }
        
        // Check if user has a pending application
        $pendingApplication = SellerApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        
        if ($pendingApplication) {
            return redirect()->route('buyer.dashboard')->with('info', 'You already have a pending seller application.');
        }
        
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'business_phone' => 'required|string|max:20',
            'business_address' => 'required|string|max:500',
        ]);
        
        SellerApplication::create([
            'user_id' => $user->id,
            'business_name' => $validated['business_name'],
            'business_email' => $validated['business_email'],
            'business_phone' => $validated['business_phone'],
            'business_address' => $validated['business_address'],
            'status' => 'pending',
        ]);
        
        return redirect()->route('buyer.dashboard')->with('success', 'Your seller application has been submitted successfully! Please wait for admin approval.');
    }

    /**
     * Show the buyer orders page.
     */
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('seller')
            ->latest()
            ->paginate(10);

        $notifications = $this->buildOrderNotifications(Auth::id(), 8);

        return view('buyer.orders', compact('orders', 'notifications'));
    }

    /**
     * Build buyer order notifications from order statuses.
     */
    private function buildOrderNotifications(int $userId, int $limit = 8)
    {
        return Order::where('user_id', $userId)
            ->with('seller')
            ->orderByDesc('updated_at')
            ->take($limit)
            ->get()
            ->map(function (Order $order) {
                $orderCode = $order->order_number ?? ('ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT));

                $message = match ($order->status) {
                    'processing' => "Your order {$orderCode} has been accepted and is now processing.",
                    'shipped' => "Your order {$orderCode} has been shipped.",
                    'delivered' => "Your order {$orderCode} has been delivered.",
                    'cancelled' => "Your order {$orderCode} was declined/cancelled by the seller.",
                    default => "Your order {$orderCode} has been placed and is pending confirmation.",
                };

                return [
                    'order' => $order,
                    'message' => $message,
                    'time' => $order->updated_at,
                    'is_update' => $order->updated_at->gt($order->created_at),
                ];
            });
    }

    /**
     * Show the buyer wishlist page.
     */
    public function wishlist()
    {
        return view('buyer.wishlist');
    }

    /**
     * Show the buyer cart/checkout page.
     */
    public function cart()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.category')
            ->latest()
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return (float) $item->product?->price * $item->quantity;
        });

        return view('buyer.cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ]);
    }

    /**
     * Add a product to cart.
     */
    public function addToCart(Product $product, Request $request)
    {
        if (!$product->is_active) {
            return back()->with('error', 'This product is not available.');
        }

        $requestedQty = (int) $request->input('quantity', 1);
        $quantity = max($requestedQty, 1);

        if ($product->stock < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $newQuantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
        if ($newQuantity > $product->stock) {
            return back()->with('error', 'Quantity exceeds available stock.');
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return back()->with('success', 'Product added to cart.');
    }

    /**
     * Update quantity of a cart item.
     */
    public function updateCartItem(Cart $cart, Request $request)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = $cart->product;
        if (!$product || $product->stock < (int) $validated['quantity']) {
            return back()->with('error', 'Not enough stock available for this update.');
        }

        $cart->update([
            'quantity' => (int) $validated['quantity'],
        ]);

        return back()->with('success', 'Cart quantity updated.');
    }

    /**
     * Remove item from cart.
     */
    public function removeCartItem(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Checkout all cart items and create orders.
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        try {
            DB::transaction(function () use ($cartItems, $validated, $userId) {
                foreach ($cartItems as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);

                    if (!$product || !$product->is_active || $product->stock < $item->quantity) {
                        throw new \RuntimeException("Product {$item->product_id} is unavailable or out of stock.");
                    }

                    $orderNumber = 'ORD-' . now()->format('YmdHis') . '-' . $item->id;
                    $total = round((float) $product->price * $item->quantity, 2);
                    $sellerId = $product->seller_id;
                    $seller = $sellerId ? User::find($sellerId) : null;
                    $status = ($seller && $seller->auto_accept_orders) ? 'processing' : 'pending';

                    Order::create([
                        'user_id' => $userId,
                        'seller_id' => $sellerId ?? $userId,
                        'order_number' => $orderNumber,
                        'total_amount' => $total,
                        'status' => $status,
                        'shipping_address' => $validated['shipping_address'],
                        'notes' => $validated['notes'] ?? null,
                    ]);

                    $product->decrement('stock', $item->quantity);
                }

                Cart::where('user_id', $userId)->delete();
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('buyer.orders')->with('success', 'Checkout successful. Your order has been placed.');
    }

    /**
     * Show the buyer profile/settings page.
     */
    public function settings()
    {
        return view('buyer.settings');
    }
}
