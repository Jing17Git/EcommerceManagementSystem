<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get user statistics
        $totalUsers = User::count();
        $totalBuyers = User::where('role', User::ROLE_BUYER)->count();
        $totalSellers = User::where('role', User::ROLE_SELLER)->count();
        $totalAdmins = User::where('role', User::ROLE_ADMINISTRATOR)->count();
        
        // Get new users in the last 30 days
        $newUsersLast30Days = User::where('created_at', '>=', now()->subDays(30))->count();
        
        // Get new users in the last 7 days
        $newUsersLast7Days = User::where('created_at', '>=', now()->subDays(7))->count();
        
        // Get users registered each month for the last 6 months (for chart)
        $monthlyUsers = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        // Format monthly data for the chart
        $months = [];
        $userCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M');
            $found = $monthlyUsers->firstWhere('month', (int)$month->format('n'));
            $userCounts[] = $found ? $found->count : 0;
        }
        
        // Get recent users
        $recentUsers = User::latest()->take(5)->get();
        
        // Calculate growth percentage (compared to 30 days before last 30 days)
        $previousMonthUsers = User::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $userGrowth = $previousMonthUsers > 0 
            ? round((($newUsersLast30Days - $previousMonthUsers) / $previousMonthUsers) * 100, 1)
            : 100;
        
        // Get real order statistics from database
        $totalRevenue = Order::sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Get top products by revenue
        $topProductsQuery = Product::with('category')
            ->where('is_active', true)
            ->get()
            ->map(function ($product, $index) {
                return [
                    'emoji' => '📦',
                    'name' => $product->name,
                    'cat' => $product->category ? $product->category->name : 'Uncategorized',
                    'amt' => '₱' . number_format($product->price, 0),
                    'qty' => $product->stock . ' in stock',
                    'rank' => $index + 1,
                ];
            })
            ->take(5);
        
        // If no products, use empty array
        $topProducts = $topProductsQuery->isNotEmpty() ? $topProductsQuery->toArray() : [];
        
        // Get recent orders with user data
        $recentOrdersQuery = Order::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->order_number,
                    'customer' => $order->user ? $order->user->name : 'Unknown',
                    'amount' => '₱' . number_format($order->total_amount, 0),
                    'status' => $order->status,
                ];
            });
        
        // If no orders, use empty array
        $recentOrders = $recentOrdersQuery->isNotEmpty() ? $recentOrdersQuery->toArray() : [];

        return view('admin.dashboard', [
            // User statistics
            'totalUsers' => $totalUsers,
            'totalBuyers' => $totalBuyers,
            'totalSellers' => $totalSellers,
            'totalAdmins' => $totalAdmins,
            'newUsersLast30Days' => $newUsersLast30Days,
            'newUsersLast7Days' => $newUsersLast7Days,
            'userGrowth' => $userGrowth,
            'monthlyUsers' => $monthlyUsers,
            'months' => $months,
            'userCounts' => $userCounts,
            'recentUsers' => $recentUsers,
            
            // Real order statistics from database
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            
            // For compatibility with existing dashboard
            'totalCustomers' => $totalUsers,
            
            // Top products from database
            'topProducts' => $topProducts,
            
            // Recent orders from database
            'recentOrders' => $recentOrders,
        ]);
    }

    /**
     * Display the products index page.
     */
    public function productsIndex()
    {
        return view('admin.products.index', [
            'title' => 'Products',
        ]);
    }

    /**
     * Display the categories index page.
     */
    public function categoriesIndex()
    {
        return view('admin.categories.index', [
            'title' => 'Categories',
        ]);
    }

    /**
     * Display the orders index page.
     */
    public function ordersIndex()
    {
        return view('admin.orders.index', [
            'title' => 'Orders',
        ]);
    }

    /**
     * Display the users index page.
     */
    public function usersIndex()
    {
        $users = User::latest()->paginate(20);
        
        return view('admin.users.index', [
            'title' => 'Users',
            'users' => $users,
        ]);
    }

    /**
     * Display the sellers index page.
     */
    public function sellersIndex()
    {
        $sellers = User::where('role', User::ROLE_SELLER)->latest()->paginate(20);
        
        return view('admin.sellers.index', [
            'title' => 'Sellers',
            'sellers' => $sellers,
        ]);
    }

    /**
     * Display the contacts index page.
     */
    public function contactsIndex()
    {
        return view('admin.contacts.index', [
            'title' => 'Messages',
        ]);
    }

    /**
     * Display the pages index page.
     */
    public function pagesIndex()
    {
        return view('admin.pages.index', [
            'title' => 'Pages',
        ]);
    }

    /**
     * Display the reports index page.
     */
    public function reportsIndex()
    {
        return view('admin.reports.index', [
            'title' => 'Reports',
        ]);
    }

    /**
     * Display the logs index page.
     */
    public function logsIndex()
    {
        return view('admin.logs.index', [
            'title' => 'Logs',
        ]);
    }
}
