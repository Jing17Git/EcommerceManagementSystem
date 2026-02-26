<?php
use App\Models\Page;
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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


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
        Route::get('/wishlist', [BuyerController::class, 'wishlist'])->name('wishlist');
        Route::get('/cart', [BuyerController::class, 'cart'])->name('cart');
        Route::get('/settings', [BuyerController::class, 'settings'])->name('settings');

        // Seller Application
        Route::get('/apply-seller', [BuyerController::class, 'applySeller'])->name('applySeller');
        Route::post('/submit-seller-application', [BuyerController::class, 'submitSellerApplication'])->name('submitSellerApplication');

        // Switch Account
        Route::post('/switch-account', [SwitchAccountController::class, 'switch'])->name('switchAccount');
    });


/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
        Route::get('/wallet', [SellerController::class, 'wallet'])->name('wallet');
        Route::get('/shipping', [SellerController::class, 'shipping'])->name('shipping');
        Route::get('/returns', [SellerController::class, 'returns'])->name('returns');
        Route::get('/settings', [SellerController::class, 'settings'])->name('settings');

        // Seller Products
        Route::resource('products', SellerProductController::class)->except(['show']);

        // Switch Account
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

        // Products
        Route::resource('products', AdminProductController::class)->except(['show']);

        // Categories
        Route::resource('categories', AdminCategoryController::class)->except(['show']);

        // Orders
        Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);

        // Seller Applications
        Route::get('seller-applications', [AdminSellerApplicationController::class, 'index'])->name('sellers.index');
        Route::get('seller-applications/{application}', [AdminSellerApplicationController::class, 'show'])->name('sellers.show');
        Route::post('seller-applications/{application}/approve', [AdminSellerApplicationController::class, 'approve'])->name('sellers.approve');
        Route::post('seller-applications/{application}/reject', [AdminSellerApplicationController::class, 'reject'])->name('sellers.reject');
        Route::delete('seller-applications/{application}', [AdminSellerApplicationController::class, 'destroy'])->name('sellers.destroy');

        // Users
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');

        // Contacts
        Route::get('/contacts', [AdminController::class, 'contactsIndex'])->name('contacts.index');

        // Pages
Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
        // Reports
        Route::get('/reports', [AdminController::class, 'reportsIndex'])->name('reports.index');

        // Logs
        Route::get('/logs', [AdminController::class, 'logsIndex'])->name('logs.index');
    });


/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Customer Public Pages
|--------------------------------------------------------------------------
| Using folder/index.blade.php structure
*/

Route::prefix('/')
    ->group(function () {

        Route::get('/help-center', fn() => view('customer.help center.index'))->name('help.center');
        Route::get('/contact', fn() => view('customer.contact.index'))->name('contact');
        Route::post('/contact', function (\Illuminate\Http\Request $request) {

            $request->validate([
                'name'    => 'required|string|max:100',
                'email'   => 'required|email',
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

});
        Route::get('/terms-of-service', fn() => view('customer.terms of service.index'))->name('terms.service');
        Route::get('/cookie-policy', fn() => view('customer.cookie policy.index'))->name('cookie.policy');

        Route::get('/shop', fn() => view('customer.shop.index'))->name('shop');
        Route::get('/sell', fn() => view('customer.sell.index'))->name('sell');
        Route::get('/blog', fn() => view('customer.blog.index'))->name('blog');
        Route::get('/careers', fn() => view('customer.careers.index'))->name('careers');
       

require __DIR__.'/auth.php';
 Route::get('/page{slug}', function ($slug) {
    $page = Page::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

    return view('customer.page.index', compact('page'));
    });

