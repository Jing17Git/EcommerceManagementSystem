<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Http\Controllers\AdminSellerApplicationController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SwitchAccountController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    // Get active categories with product counts
    $categories = \App\Models\Category::where('is_active', true)
        ->withCount('products')
        ->orderBy('products_count', 'desc')
        ->get();

    // Get featured products
    $featuredProducts = Product::with('category')
        ->where('is_active', true)
        ->where('stock', '>', 0)
        ->latest()
        ->take(9)
        ->get();

    // Get statistics for visualization
    $totalProducts = Product::where('is_active', true)->count();
    $totalCategories = Category::where('is_active', true)->count();
    $totalOrders = \App\Models\Order::count();
    $totalSellers = \App\Models\User::where('role', 'seller')->count();
    $totalRevenue = \App\Models\Order::where('status', '!=', 'cancelled')->sum('total_amount');

    // Get category distribution for pie chart
    $categoryDistribution = Category::where('is_active', true)
        ->withCount(['products' => function ($query) {
            $query->where('is_active', true);
        }])
        ->whereHas('products', function ($query) {
            $query->where('is_active', true);
        })
        ->orderBy('products_count', 'desc')
        ->take(6)
        ->get();

    // Get monthly sales data for chart (last 6 months)
    $monthlySales = [];
    $monthlyLabels = [];
    for ($i = 5; $i >= 0; $i--) {
        $month = now()->subMonths($i);
        $monthLabel = $month->format('M');
        $monthStart = $month->startOfMonth();
        $monthEnd = $month->endOfMonth();
        
        $sales = \App\Models\Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('total_amount');
        
        $orderCount = \App\Models\Order::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        
        $monthlyLabels[] = $monthLabel;
        $monthlySales[] = [
            'revenue' => $sales,
            'orders' => $orderCount
        ];
    }

    // Get recent orders for activity feed
    $recentOrders = \App\Models\Order::with('user')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // Get top selling products (based on order items)
    $topSellingProducts = \App\Models\Product::with('category')
        ->where('is_active', true)
        ->where('stock', '>', 0)
        ->withCount(['orderItems' => function ($query) {
            $query->whereHas('order', function ($q) {
                $q->where('status', '!=', 'cancelled');
            });
        }])
        ->orderBy('order_items_count', 'desc')
        ->take(5)
        ->get();

    return view('welcome', compact(
        'categories',
        'featuredProducts',
        'totalProducts',
        'totalCategories',
        'totalOrders',
        'totalSellers',
        'totalRevenue',
        'categoryDistribution',
        'monthlySales',
        'monthlyLabels',
        'recentOrders',
        'topSellingProducts'
    ));

})->name('welcome');

Route::get('/product-images/{path}', [ProductImageController::class, 'show'])
    ->where('path', '.*')
    ->name('product.image');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Buyer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->prefix('buyer')
    ->name('buyer.')
    ->group(function () {

        Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [BuyerController::class, 'orders'])->name('orders');
        Route::post('/orders/{order}/return-request', [BuyerController::class, 'requestReturn'])->name('orders.returnRequest');
        Route::get('/wishlist', [BuyerController::class, 'wishlist'])->name('wishlist');
        Route::get('/cart', [BuyerController::class, 'cart'])->name('cart');
        Route::post('/cart/add/{product}', [BuyerController::class, 'addToCart'])->name('cart.add');
        Route::patch('/cart/{cart}', [BuyerController::class, 'updateCartItem'])->name('cart.update');
        Route::delete('/cart/{cart}', [BuyerController::class, 'removeCartItem'])->name('cart.remove');
        Route::post('/cart/checkout', [BuyerController::class, 'checkout'])->name('cart.checkout');
        Route::get('/settings', [BuyerController::class, 'settings'])->name('settings');

        Route::get('/apply-seller', [BuyerController::class, 'applySeller'])->name('applySeller');
        Route::post('/submit-seller-application', [BuyerController::class, 'submitSellerApplication'])->name('submitSellerApplication');

        Route::post('/switch-account', [SwitchAccountController::class, 'switch'])->name('switchAccount');
    });


/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');

        Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}/receipt', [SellerController::class, 'printReceipt'])->name('orders.receipt');

        Route::patch('/orders/{order}/accept', [SellerController::class, 'acceptOrder'])->name('orders.accept');
        Route::patch('/orders/{order}/decline', [SellerController::class, 'declineOrder'])->name('orders.decline');
        Route::patch('/orders/{order}/ship', [SellerController::class, 'shipOrder'])->name('orders.ship');
        Route::patch('/orders/{order}/deliver', [SellerController::class, 'deliverOrder'])->name('orders.deliver');

        Route::get('/wallet', [SellerController::class, 'wallet'])->name('wallet');
        Route::get('/shipping', [SellerController::class, 'shipping'])->name('shipping');

        Route::get('/returns', [SellerController::class, 'returns'])->name('returns');
        Route::patch('/returns/{returnRequest}/approve', [SellerController::class, 'approveReturn'])->name('returns.approve');
        Route::patch('/returns/{returnRequest}/reject', [SellerController::class, 'rejectReturn'])->name('returns.reject');
        Route::patch('/returns/{returnRequest}/refund', [SellerController::class, 'refundReturn'])->name('returns.refund');

        Route::get('/settings', [SellerController::class, 'settings'])->name('settings');
        Route::put('/settings', [SellerController::class, 'updateSettings'])->name('settings.update');

        Route::resource('products', SellerProductController::class)->except(['show']);

        Route::post('/switch-account', [SwitchAccountController::class, 'switch'])->name('switchAccount');
    });


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);

        Route::get('seller-applications', [AdminSellerApplicationController::class, 'index'])->name('sellers.index');
        Route::get('seller-applications/{application}', [AdminSellerApplicationController::class, 'show'])->name('sellers.show');
        Route::post('seller-applications/{application}/approve', [AdminSellerApplicationController::class, 'approve'])->name('sellers.approve');
        Route::post('seller-applications/{application}/reject', [AdminSellerApplicationController::class, 'reject'])->name('sellers.reject');
        Route::delete('seller-applications/{application}', [AdminSellerApplicationController::class, 'destroy'])->name('sellers.destroy');

        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::get('/contacts', [AdminController::class, 'contactsIndex'])->name('contacts.index');

        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

        Route::get('/reports', [AdminController::class, 'reportsIndex'])->name('reports.index');
        Route::get('/logs', [AdminController::class, 'logsIndex'])->name('logs.index');
    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('/')->group(function () {

    Route::get('/help-center', fn() => view('customer.help center.index'))->name('help.center');
    Route::get('/contact', fn() => view('customer.contact.index'))->name('contact');

    Route::post('/contact', function (\Illuminate\Http\Request $request) {

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'nullable|string',
            'message' => 'required|string|min:10',
        ]);

        return back()->with('success', "Thanks {$request->name}! We'll get back to you within 24 hours.");
    })->name('contact.send');

    Route::get('/shipping-info', fn() => view('customer.shipping info.index'))->name('shipping.info');
    Route::get('/returns', fn() => view('customer.returns.index'))->name('returns');
    Route::get('/track-order', fn() => view('customer.track order.index'))->name('track.order');

    Route::get('/about', fn() => view('customer.about.index'))->name('about');
    Route::get('/privacy-policy', fn() => view('customer.privacy.index'))->name('privacy.policy');
    Route::get('/terms-of-service', fn() => view('customer.terms of service.index'))->name('terms.service');
    Route::get('/cookie-policy', fn() => view('customer.cookie policy.index'))->name('cookie.policy');

});

require __DIR__.'/auth.php';

Route::get('/page/{slug}', function ($slug) {

    $page = Page::where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();

    return view('customer.page.index', compact('page'));

})->name('page.show');