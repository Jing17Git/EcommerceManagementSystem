<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Local - Buyer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background-color: #FAFAFA; color: #1A1A1A; }
        .display-font { font-family: 'Playfair Display', serif; }
        .header-nav-link { transition: all 0.2s ease; position: relative; }
        .header-nav-link:hover { color: #FF6B35; }
        .header-nav-link.active { color: #FF6B35; }
        .header-nav-link.active::after { content: ''; position: absolute; bottom: -4px; left: 0; right: 0; height: 2px; background: #FF6B35; border-radius: 1px; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeInUp 0.5s ease-out; }
        .product-card { background: white; border-radius: 16px; overflow: hidden; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #F0F0F0; cursor: pointer; }
        .product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12); border-color: #E5E5E5; }
        .product-image-container { position: relative; width: 100%; height: 180px; background: #F5F5F5; overflow: hidden; }
        .product-image-container img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .product-card:hover .product-image-container img { transform: scale(1.08); }
        .wishlist-icon { position: absolute; top: 12px; right: 12px; width: 36px; height: 36px; border-radius: 50%; background: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; opacity: 0; }
        .product-card:hover .wishlist-icon { opacity: 1; }
        .wishlist-icon:hover { background: #FEF2F2; color: #EF4444; transform: scale(1.1); }
        .wishlist-icon.active { background: #FEF2F2; color: #EF4444; opacity: 1; }
        .dropdown-menu { opacity: 0; visibility: hidden; transform: translateY(10px); transition: all 0.2s ease; }
        .dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .hero-carousel { position: relative; }
        .carousel-slide { transition: opacity 0.7s ease-in-out; }
        .trending-badge { display: inline-flex; align-items: center; gap: 0.5rem; }
        .feature-card { transition: all 0.3s ease; }
        .feature-icon { display: flex; align-items: center; justify-content: center; }
        .category-tab { padding: 10px 24px; border-radius: 24px; border: 1.5px solid #E5E5E5; background: white; color: #6B7280; cursor: pointer; transition: all 0.2s ease; font-weight: 600; font-size: 14px; white-space: nowrap; }
        .category-tab:hover { border-color: #FF6B35; color: #FF6B35; }
        .category-tab.active { background: #FF6B35; color: white; border-color: #FF6B35; }
        .product-badge { position: absolute; top: 12px; left: 12px; background: #10B981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
    </style>
</head>
<body class="bg-gray-50">

<!-- Top Header -->
<header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-50 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
            <i class="fas fa-store text-white text-lg"></i>
        </div>
        <div>
            <h1 class="text-lg font-bold text-gray-900">Local Works</h1>
            <p class="text-xs text-gray-500">Buyer Dashboard</p>
        </div>
    </div>

    <nav class="hidden md:flex items-center gap-1">
        <a href="{{ route('buyer.dashboard') }}" class="header-nav-link flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 rounded-lg {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line text-sm"></i><span>Dashboard</span>
        </a>
        <a href="{{ route('buyer.orders') }}" class="header-nav-link flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 rounded-lg {{ request()->routeIs('buyer.orders') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag text-sm"></i><span>My Orders</span>
        </a>
        <a href="{{ route('buyer.cart') }}" class="header-nav-link flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 rounded-lg {{ request()->routeIs('buyer.cart') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart text-sm"></i><span>Cart</span><span class="bg-green-100 text-green-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $cartCount ?? 0 }}</span>
        </a>
        
        {{-- One-click switch to seller --}}
        @if(isset($hasSellerRole) && $hasSellerRole)
            <form method="POST" action="{{ route('buyer.switchAccount') }}">
                @csrf
                <input type="hidden" name="role" value="seller">
                <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-500 hover:bg-green-600 rounded-lg transition">
                    <i class="fas fa-store text-sm"></i><span>Seller Dashboard</span>
                </button>
            </form>
        @else
            {{-- Apply Seller Button - Only show if user hasn't applied yet --}}
            @if(!isset($hasPendingApplication) || !$hasPendingApplication)
                <a href="{{ route('buyer.applySeller') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                    <i class="fas fa-store-alt text-sm"></i><span>Apply Seller</span>
                </a>
            @else
                <div class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <i class="fas fa-clock text-sm"></i><span>Application Pending</span>
                </div>
            @endif
        @endif
        <div class="relative dropdown">
            <button class="header-nav-link flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 rounded-lg">
                <i class="fas fa-th-large text-sm"></i><span>Categories</span><i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div class="dropdown-menu absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2">
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-gem w-4"></i><span>Jewelry</span></a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-couch w-4"></i><span>Home Decor</span></a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-paint-brush w-4"></i><span>Ceramics</span></a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-tshirt w-4"></i><span>Textiles</span></a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-palette w-4"></i><span>Art & Prints</span></a>
            </div>
        </div>
        <div class="relative dropdown">
            <button class="header-nav-link flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 rounded-lg">
                <i class="fas fa-user-circle text-sm"></i><span>Account</span><i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div class="dropdown-menu absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2">
                <a href="{{ route('buyer.settings') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 {{ request()->routeIs('buyer.settings') ? 'text-orange-600' : '' }}"><i class="fas fa-user-cog w-4"></i><span>Settings</span></a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-map-marker-alt w-4"></i><span>Addresses</span></a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-credit-card w-4"></i><span>Payment Methods</span></a>
                <hr class="my-2 border-gray-200">
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-question-circle w-4"></i><span>Help Center</span></a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-headset w-4"></i><span>Contact Us</span></a>
            </div>
        </div>
    </nav>

    <div class="flex items-center gap-3">
        <div class="relative hidden lg:block">
            <input type="text" placeholder="Search products..." class="w-64 pl-10 pr-4 py-2 text-sm bg-gray-100 border border-transparent rounded-lg focus:bg-white focus:border-orange-300 focus:outline-none transition">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        <div class="relative dropdown">
            <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="far fa-bell text-lg"></i>
                @if(($notificationCount ?? 0) > 0)
                    <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-semibold flex items-center justify-center">
                        {{ min($notificationCount, 99) }}
                    </span>
                @endif
            </button>
            <div class="dropdown-menu absolute top-full right-0 mt-1 w-80 max-h-96 overflow-y-auto bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                <div class="px-4 py-2 border-b border-gray-200">
                    <p class="text-sm font-semibold text-gray-900">Order Notifications</p>
                </div>
                @forelse(($notifications ?? collect()) as $note)
                    <a href="{{ route('buyer.orders') }}" class="block px-4 py-3 hover:bg-orange-50 transition">
                        <p class="text-sm text-gray-800">{{ $note['message'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $note['time']->format('M d, Y h:i A') }}
                            @if($note['is_update'])
                                <span class="ml-2 text-blue-600">Updated</span>
                            @else
                                <span class="ml-2 text-amber-600">New</span>
                            @endif
                        </p>
                    </a>
                @empty
                    <div class="px-4 py-3 text-sm text-gray-500">No notifications yet.</div>
                @endforelse
                <div class="px-4 py-2 border-t border-gray-200">
                    <a href="{{ route('buyer.orders') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700">View all orders</a>
                </div>
            </div>
        </div>
        <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
            <i class="far fa-comment-dots text-lg"></i>
        </button>
        <div class="relative dropdown">
            <button class="flex items-center gap-2 p-1 rounded-lg hover:bg-gray-100 transition">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Buyer' }}&background=FF6B35&color=fff&bold=true" alt="User Avatar" class="w-8 h-8 rounded-full ring-2 ring-orange-200">
                <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Buyer' }}</span>
                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
            </button>
            <div class="dropdown-menu absolute top-full right-0 mt-1 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2">
                <div class="px-4 py-2 border-b border-gray-200 mb-2">
                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Buyer' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'buyer@example.com' }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600"><i class="fas fa-user-cog w-4"></i><span>Profile Settings</span></a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full"><i class="fas fa-sign-out-alt w-4"></i><span>Sign Out</span></button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="pt-16 min-h-screen">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif
    
    @if(session('info'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        </div>
    @endif

    <!-- Hero Carousel - Trending Header -->
    <div class="hero-carousel mb-10 animate-fade-in relative overflow-hidden rounded-2xl" style="height: 480px; margin-top: 2rem;">
        @php
            $featuredProducts = \App\Models\Product::where('is_active', true)->where('is_featured', true)->take(3)->get();
            if ($featuredProducts->isEmpty()) { $featuredProducts = \App\Models\Product::where('is_active', true)->take(3)->get(); }
        @endphp
        
        @forelse($featuredProducts as $index => $product)
        <div class="carousel-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" style="background: linear-gradient(135deg, {{ $index === 0 ? '#667eea 0%, #764ba2 100%' : ($index === 1 ? '#f093fb 0%, #f5576c 100%' : '#84fab0 0%, #8fd3f4 100%') }});">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30 flex items-center px-16">
                <div class="max-w-xl">
                    <span class="trending-badge inline-flex items-center gap-2 bg-amber-400 text-gray-900 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider mb-4"><i class="fas fa-fire"></i> {{ $index === 0 ? 'Trending Now' : ($index === 1 ? 'Featured' : 'New Arrival') }}</span>
                    <h2 class="display-font text-5xl text-white mb-4 leading-tight font-bold">Discover Unique Handcrafted Treasures</h2>
                    <p class="text-white/90 text-lg mb-2">Support local artisans and find one-of-a-kind pieces</p>
                    <p class="display-font text-6xl text-white font-bold mb-8">Shop Now</p>
                    <a href="#" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-gray-900 rounded-full font-semibold hover:bg-gray-50 transition shadow-lg">Browse Collection <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        @empty
        <div class="carousel-slide absolute inset-0 opacity-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30 flex items-center px-16">
                <div class="max-w-xl">
                    <span class="trending-badge inline-flex items-center gap-2 bg-amber-400 text-gray-900 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider mb-4"><i class="fas fa-fire"></i>Welcome</span>
                    <h2 class="display-font text-5xl text-white mb-4 leading-tight font-bold">Support Local Artisans</h2>
                    <p class="text-white/90 text-lg mb-2">Discover unique handcrafted items</p>
                    <p class="display-font text-6xl text-white font-bold mb-8">Explore</p>
                    <a href="#" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-gray-900 rounded-full font-semibold hover:bg-gray-50 transition shadow-lg">Browse Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        @endforelse

        <button class="carousel-nav-btn absolute top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/95 border-none cursor-pointer flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg z-10 left-6" onclick="changeSlide(-1)"><i class="fas fa-chevron-left text-gray-700"></i></button>
        <button class="carousel-nav-btn absolute top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/95 border-none cursor-pointer flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg z-10 right-6" onclick="changeSlide(1)"><i class="fas fa-chevron-right text-gray-700"></i></button>

        <div class="carousel-indicators absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            @for($i = 0; $i < max(1, $featuredProducts->count()); $i++)
            <span class="indicator w-2 h-2 rounded-full bg-white/50 cursor-pointer transition-all duration-300 {{ $i === 0 ? 'bg-white w-6 rounded' : '' }}" onclick="goToSlide({{ $i }})"></span>
            @endfor
        </div>

        <div class="slide-counter absolute top-6 right-6 bg-black/60 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold z-10">
            <span id="currentSlide">1</span> / <span id="totalSlides">{{ max(1, $featuredProducts->count()) }}</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="max-w-7xl mx-auto px-6 mb-10">
        <div class="grid grid-cols-4 gap-5">
            <div class="feature-card bg-white rounded-2xl p-6 flex items-center gap-4 border border-gray-100 hover:border-orange-500 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center text-2xl flex-shrink-0" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"><i class="fas fa-shopping-bag text-white"></i></div>
                <div><p class="text-xs text-gray-500">Total Orders</p><p class="font-bold text-2xl text-gray-900">{{ $stats['ordersCount'] ?? 0 }}</p></div>
            </div>
            <div class="feature-card bg-white rounded-2xl p-6 flex items-center gap-4 border border-gray-100 hover:border-orange-500 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center text-2xl flex-shrink-0" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);"><i class="fas fa-peso-sign text-white"></i></div>
                <div><p class="text-xs text-gray-500">Total Spent</p><p class="font-bold text-2xl text-gray-900">₱{{ number_format($stats['totalSpent'] ?? 0, 2) }}</p></div>
            </div>
            <div class="feature-card bg-white rounded-2xl p-6 flex items-center gap-4 border border-gray-100 hover:border-orange-500 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center text-2xl flex-shrink-0" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);"><i class="fas fa-clock text-white"></i></div>
                <div><p class="text-xs text-gray-500">Pending Orders</p><p class="font-bold text-2xl text-gray-900">{{ $stats['pendingOrders'] ?? 0 }}</p></div>
            </div>
            <div class="feature-card bg-white rounded-2xl p-6 flex items-center gap-4 border border-gray-100 hover:border-orange-500 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center text-2xl flex-shrink-0" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);"><i class="fas fa-check-circle text-white"></i></div>
                <div><p class="text-xs text-gray-500">Delivered</p><p class="font-bold text-2xl text-gray-900">{{ $stats['deliveredOrders'] ?? 0 }}</p></div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-6 mb-10">
        <div class="grid grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="col-span-2">
                <!-- Categories -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-5">Shop by Category</h3>
                    <div class="flex gap-3 overflow-x-auto pb-2">
                        <a href="{{ route('shop') }}" class="category-tab active">All Items</a>
                        @forelse($topCategories as $category)
                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="category-tab">{{ $category->name }}</a>
                        @empty
                        <a href="{{ route('shop') }}" class="category-tab">Jewelry</a>
                        <a href="{{ route('shop') }}" class="category-tab">Home Decor</a>
                        <a href="{{ route('shop') }}" class="category-tab">Ceramics</a>
                        <a href="{{ route('shop') }}" class="category-tab">Textiles</a>
                        @endforelse
                    </div>
                </div>

                <!-- Recommended Products -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-2xl font-bold text-gray-900">Recommended for You</h3>
                        <a href="{{ route('shop') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700">View Shop</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @forelse($recommendedProducts as $product)
                            <div class="product-card">
                                <div class="product-image-container">
                                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-gray-500 mb-1">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                                    <h4 class="font-semibold text-gray-900 mb-2 truncate">{{ $product->name }}</h4>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-orange-600">PHP {{ number_format((float)$product->price, 2) }}</span>
                                        <form method="POST" action="{{ route('buyer.cart.add', $product) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-orange-500 text-white text-xs font-semibold rounded-lg hover:bg-orange-600 transition">
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="md:col-span-2 bg-white border border-gray-100 rounded-xl p-6 text-center text-gray-500">
                                No products available yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recently Added Products -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-5">Recently Added</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @forelse($recentlyViewedProducts as $product)
                            <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-4">
                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-xl">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-500">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                                    <p class="font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                    <p class="text-sm font-bold text-orange-600 mt-1">PHP {{ number_format((float)$product->price, 2) }}</p>
                                </div>
                                <form method="POST" action="{{ route('buyer.cart.add', $product) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-orange-100 text-orange-700 text-xs font-semibold rounded-lg hover:bg-orange-200 transition">
                                        Add
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="md:col-span-2 bg-white border border-gray-100 rounded-xl p-6 text-center text-gray-500">
                                No recent products found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-span-1">
                <!-- Spending Chart -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Monthly Spending</h3>
                    <div class="h-64">
                        <canvas id="spendingChart"></canvas>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Order Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-500"></span><span class="text-sm text-gray-600">Delivered</span></div>
                            <span class="font-semibold text-gray-900">{{ $orderStatuses['delivered'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-500"></span><span class="text-sm text-gray-600">Processing</span></div>
                            <span class="font-semibold text-gray-900">{{ $orderStatuses['processing'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-yellow-500"></span><span class="text-sm text-gray-600">Pending</span></div>
                            <span class="font-semibold text-gray-900">{{ $orderStatuses['pending'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-purple-500"></span><span class="text-sm text-gray-600">Shipped</span></div>
                            <span class="font-semibold text-gray-900">{{ $orderStatuses['shipped'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span><span class="text-sm text-gray-600">Cancelled</span></div>
                            <span class="font-semibold text-gray-900">{{ $orderStatuses['cancelled'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Recent Orders</h3>
                    <div class="space-y-3">
                        @forelse($recentOrders as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Order #{{ $order->id }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($order->status == 'delivered') bg-green-100 text-green-700
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-700
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                    @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-sm text-center py-4">No orders yet</p>
                        @endforelse
                    </div>
                    <a href="{{ route('buyer.orders') }}" class="block text-center text-orange-600 font-semibold text-sm mt-4 hover:text-orange-700">View All Orders</a>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-[#1a1a2e] mt-auto">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">Local Works</h1>
                        <p class="text-xs text-gray-400">Support Local Artisans</p>
                    </div>
                </div>
                <p class="text-sm text-gray-300 mb-4">Discover unique handcrafted treasures from local artisans. Every purchase supports small businesses and keeps traditions alive.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-orange-500 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-orange-500 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-orange-500 transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-orange-500 transition"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-span-1">
                <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">About Us</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Shop Now</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Sell on Local Works</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Blog</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Careers</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="col-span-1">
                <h4 class="font-semibold text-white mb-4">Customer Service</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Help Center</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Contact Us</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Shipping Info</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Returns & Refunds</a></li>
                    <li><a href="#" class="text-sm text-gray-300 hover:text-orange-400 transition">Track Order</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-span-1">
                <h4 class="font-semibold text-white mb-4">Contact Us</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-orange-500 mt-1"></i>
                        <span class="text-sm text-gray-300">123 Artisan Street, Manila, Philippines 1001</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-orange-500"></i>
                        <span class="text-sm text-gray-300">+63 912 345 6789</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-orange-500"></i>
                        <span class="text-sm text-gray-300">support@localworks.ph</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-clock text-orange-500"></i>
                        <span class="text-sm text-gray-300">Mon - Sat: 9AM - 7PM</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-700 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Local Works. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="text-sm text-gray-400 hover:text-orange-400 transition">Privacy Policy</a>
                <a href="#" class="text-sm text-gray-400 hover:text-orange-400 transition">Terms of Service</a>
                <a href="#" class="text-sm text-gray-400 hover:text-orange-400 transition">Cookie Policy</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-lock text-green-400 text-sm"></i>
                <span class="text-sm text-gray-400">Secure Payments</span>
                <div class="flex gap-1 ml-2">
                    <i class="fab fa-cc-visa text-xl text-white"></i>
                    <i class="fab fa-cc-mastercard text-xl text-white"></i>
                    <i class="fab fa-cc-paypal text-xl text-white"></i>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    // Carousel
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const indicators = document.querySelectorAll('.indicator');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
        });
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('bg-white', i === index);
            indicator.classList.toggle('w-6', i === index);
            indicator.classList.toggle('rounded', i === index);
            indicator.classList.toggle('bg-white/50', i !== index);
            indicator.classList.toggle('w-2', i !== index);
        });
        document.getElementById('currentSlide').textContent = index + 1;
        currentSlide = index;
    }

    function changeSlide(direction) {
        let newIndex = currentSlide + direction;
        if (newIndex < 0) newIndex = totalSlides - 1;
        if (newIndex >= totalSlides) newIndex = 0;
        showSlide(newIndex);
    }

    function goToSlide(index) { showSlide(index); }

    setInterval(() => { if (totalSlides > 1) { changeSlide(1); } }, 5000);

    // Chart
    const ctx = document.getElementById('spendingChart').getContext('2d');
    const spendingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {{ json_encode($monthlyLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) }},
            datasets: [{
                label: 'Spending (₱)',
                data: {{ json_encode($monthlySpending ?? [0, 0, 0, 0, 0, 0]) }},
                backgroundColor: 'rgba(255, 107, 53, 0.8)',
                borderColor: 'rgba(255, 107, 53, 1)',
                borderWidth: 1,
                borderRadius: 8,
                barThickness: 30,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { callback: function(value) { return '₱' + value.toLocaleString(); } } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
</body>
</html>
