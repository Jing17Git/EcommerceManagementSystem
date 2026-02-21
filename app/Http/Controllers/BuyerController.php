<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\SellerApplication;
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
            'hasSellerRole'
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
        return view('buyer.orders');
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
        return view('buyer.cart');
    }

    /**
     * Show the buyer profile/settings page.
     */
    public function settings()
    {
        return view('buyer.settings');
    }
}
