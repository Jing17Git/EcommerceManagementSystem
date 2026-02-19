<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Buyer Routes
Route::middleware(['auth', 'verified'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [BuyerController::class, 'orders'])->name('orders');
    Route::get('/wishlist', [BuyerController::class, 'wishlist'])->name('wishlist');
    Route::get('/cart', [BuyerController::class, 'cart'])->name('cart');
    Route::get('/settings', [BuyerController::class, 'settings'])->name('settings');
});

// Seller Routes
Route::middleware(['auth', 'verified'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [SellerController::class, 'products'])->name('products');
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::get('/wallet', [SellerController::class, 'wallet'])->name('wallet');
    Route::get('/shipping', [SellerController::class, 'shipping'])->name('shipping');
    Route::get('/returns', [SellerController::class, 'returns'])->name('returns');
    Route::get('/settings', [SellerController::class, 'settings'])->name('settings');
});

// Admin Routes - All routes use the AdminController
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products
    Route::get('/products', [AdminController::class, 'productsIndex'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'productsIndex'])->name('products.create');
    
    // Categories
    Route::get('/categories', [AdminController::class, 'categoriesIndex'])->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'categoriesIndex'])->name('categories.create');
    
    // Orders
    Route::get('/orders', [AdminController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/create', [AdminController::class, 'ordersIndex'])->name('orders.create');
    
    // Sellers
    Route::get('/sellers', [AdminController::class, 'sellersIndex'])->name('sellers.index');
    Route::get('/sellers/create', [AdminController::class, 'sellersIndex'])->name('sellers.create');
    
    // Users
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'usersIndex'])->name('users.create');
    
    // Contacts/Messages
    Route::get('/contacts', [AdminController::class, 'contactsIndex'])->name('contacts.index');
    Route::get('/contacts/create', [AdminController::class, 'contactsIndex'])->name('contacts.create');
    
    // Pages
    Route::get('/pages', [AdminController::class, 'pagesIndex'])->name('pages.index');
    Route::get('/pages/create', [AdminController::class, 'pagesIndex'])->name('pages.create');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reportsIndex'])->name('reports.index');
    
    // Logs
    Route::get('/logs', [AdminController::class, 'logsIndex'])->name('logs.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
