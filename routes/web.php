<?php

use App\Http\Controllers\AdminSellerApplicationController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

// Public route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// --------------------
// Buyer Routes
// --------------------
Route::middleware(['auth', 'verified'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [BuyerController::class, 'orders'])->name('orders');
    Route::get('/wishlist', [BuyerController::class, 'wishlist'])->name('wishlist');
    Route::get('/cart', [BuyerController::class, 'cart'])->name('cart');
    Route::get('/settings', [BuyerController::class, 'settings'])->name('settings');
    
    // Seller Application Routes
    Route::get('/apply-seller', [BuyerController::class, 'applySeller'])->name('applySeller');
    Route::post('/submit-seller-application', [BuyerController::class, 'submitSellerApplication'])->name('submitSellerApplication');
});


// --------------------
// Seller Routes
// --------------------
Route::middleware(['auth', 'verified'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::get('/wallet', [SellerController::class, 'wallet'])->name('wallet');
    Route::get('/shipping', [SellerController::class, 'shipping'])->name('shipping');
    Route::get('/returns', [SellerController::class, 'returns'])->name('returns');
    Route::get('/settings', [SellerController::class, 'settings'])->name('settings');

    // Seller Product CRUD (only their own products)
    Route::resource('products', SellerProductController::class)->except(['show']);
});


// --------------------
// Admin Routes
// --------------------
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin Product CRUD
    Route::resource('products', AdminProductController::class)->except(['show']);

    // Admin Category CRUD
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Admin Order Management
    Route::resource('orders', AdminOrderController::class)->except(['create','store']);

    // Admin Seller Applications
    Route::get('seller-applications', [AdminSellerApplicationController::class, 'index'])->name('sellers.index');
    Route::get('seller-applications/{application}', [AdminSellerApplicationController::class, 'show'])->name('sellers.show');
    Route::post('seller-applications/{application}/approve', [AdminSellerApplicationController::class, 'approve'])->name('sellers.approve');
    Route::post('seller-applications/{application}/reject', [AdminSellerApplicationController::class, 'reject'])->name('sellers.reject');
    Route::delete('seller-applications/{application}', [AdminSellerApplicationController::class, 'destroy'])->name('sellers.destroy');

    // Users CRUD
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');

    // Contacts/Messages
    Route::get('/contacts', [AdminController::class, 'contactsIndex'])->name('contacts.index');

    // Pages
    Route::get('/pages', [AdminController::class, 'pagesIndex'])->name('pages.index');

    // Reports
    Route::get('/reports', [AdminController::class, 'reportsIndex'])->name('reports.index');

    // Logs
    Route::get('/logs', [AdminController::class, 'logsIndex'])->name('logs.index');
});


// --------------------
// Profile Routes
// --------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
