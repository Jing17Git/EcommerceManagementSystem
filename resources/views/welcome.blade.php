<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Local - Welcome</title>
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
            <p class="text-xs text-gray-500">Support Local Artisans</p>
        </div>
    </div>

    <nav class="hidden md:flex items-center gap-1">
        <a href="{{ route('welcome') }}" class="header-nav-link flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 rounded-lg {{ request()->routeIs('welcome') ? 'active' : '' }}">
            <i class="fas fa-home text-sm"></i><span>Home</span>
        </a>
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
        <a href="{{ route('about') }}" class="header-nav-link flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 rounded-lg">
            <i class="fas fa-info-circle text-sm"></i><span>About</span>
        </a>
       <a href="{{ route('contact') }}" class="header-nav-link flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 rounded-lg">
    <i class="fas fa-envelope text-sm"></i><span>Contact</span>
</a>
    </nav>

    <div class="flex items-center gap-3">
        <div class="relative hidden lg:block">
            <input type="text" placeholder="Search products..." class="w-64 pl-10 pr-4 py-2 text-sm bg-gray-100 border border-transparent rounded-lg focus:bg-white focus:border-orange-300 focus:outline-none transition">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-sign-in-alt mr-1"></i> Login
        </a>
        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 transition">
            <i class="fas fa-user-plus mr-1"></i> Register
        </a>
    </div>
</header>

<!-- Main Content -->
<main class="pt-16 min-h-screen">
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
<span class="trending-badge inline-flex items-center gap-2 bg-amber-400 text-gray-900 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider mb-4"><i class="fas fa-fire"></i> @if($index === 0)Trending Now @elseif($index === 1)Featured @else New Arrival @endif</span>
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

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 mb-10">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-8 mb-8 text-white">
                    <h2 class="display-font text-3xl font-bold mb-3">Welcome to Local Works!</h2>
                    <p class="text-white/90 text-lg mb-4">Discover unique handcrafted treasures from talented local artisans. Every purchase supports small businesses and keeps traditions alive.</p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2 bg-white/20 px-4 py-2 rounded-full">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm font-medium">100% Handmade</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/20 px-4 py-2 rounded-full">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm font-medium">Secure Payment</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/20 px-4 py-2 rounded-full">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm font-medium">Fast Shipping</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/20 px-4 py-2 rounded-full">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm font-medium">24/7 Support</span>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-5">Shop by Category</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <a href="#" class="category-card group bg-white rounded-2xl p-6 border border-gray-100 hover:border-orange-500 hover:shadow-lg transition-all duration-300 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-gem text-2xl text-orange-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Jewelry</h4>
                            <p class="text-xs text-gray-500">Handcrafted pieces</p>
                        </a>
                        <a href="#" class="category-card group bg-white rounded-2xl p-6 border border-gray-100 hover:border-orange-500 hover:shadow-lg transition-all duration-300 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-couch text-2xl text-blue-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Home Decor</h4>
                            <p class="text-xs text-gray-500">Unique decorations</p>
                        </a>
                        <a href="#" class="category-card group bg-white rounded-2xl p-6 border border-gray-100 hover:border-orange-500 hover:shadow-lg transition-all duration-300 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-paint-brush text-2xl text-purple-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Ceramics</h4>
                            <p class="text-xs text-gray-500">Pottery & crafts</p>
                        </a>
                        <a href="#" class="category-card group bg-white rounded-2xl p-6 border border-gray-100 hover:border-orange-500 hover:shadow-lg transition-all duration-300 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-tshirt text-2xl text-green-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Textiles</h4>
                            <p class="text-xs text-gray-500">Fabrics & clothing</p>
                        </a>
                        <a href="#" class="category-card group bg-white rounded-2xl p-6 border border-gray-100 hover:border-orange-500 hover:shadow-lg transition-all duration-300 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-red-100 to-rose-100 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-palette text-2xl text-red-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Art & Prints</h4>
                            <p class="text-xs text-gray-500">Original artwork</p>
                        </a>
                        <a href="#" class="category-card group bg-white rounded-2xl p-6 border border-gray-100 hover:border-orange-500 hover:shadow-lg transition-all duration-300 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-leaf text-2xl text-indigo-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Eco Products</h4>
                            <p class="text-xs text-gray-500">Sustainable items</p>
                        </a>
                    </div>
                </div>

                <!-- Why Choose Us -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-5">Why Choose Local Works?</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="feature-card bg-white rounded-xl p-5 border border-gray-100 hover:border-orange-500 hover:shadow-md transition-all">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-store text-orange-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Support Local</h4>
                                    <p class="text-sm text-gray-500">Every purchase directly supports local artisans and their families.</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card bg-white rounded-xl p-5 border border-gray-100 hover:border-orange-500 hover:shadow-md transition-all">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-medal text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Quality Guaranteed</h4>
                                    <p class="text-sm text-gray-500">Each item is carefully crafted with attention to detail.</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card bg-white rounded-xl p-5 border border-gray-100 hover:border-orange-500 hover:shadow-md transition-all">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-shipping-fast text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Fast Shipping</h4>
                                    <p class="text-sm text-gray-500">Quick delivery across the Philippines and beyond.</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature-card bg-white rounded-xl p-5 border border-gray-100 hover:border-orange-500 hover:shadow-md transition-all">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-headset text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">24/7 Support</h4>
                                    <p class="text-sm text-gray-500">We're here to help anytime you need assistance.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Products -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-5">Featured Products</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @forelse($featuredProducts as $product)
                        <div class="product-card">
                            <div class="product-image-container">
                                @if($product->image)
                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                                @else
                                <img src="https://via.placeholder.com/300x200?text=Product" alt="{{ $product->name }}">
                                @endif
                                <button class="wishlist-icon"><i class="far fa-heart"></i></button>
                            </div>
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 mb-1 truncate">{{ $product->name }}</h4>
                                <p class="text-sm text-gray-500 mb-2 truncate">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-orange-600">₱{{ number_format($product->price, 2) }}</span>
                                    <button class="px-3 py-1.5 bg-orange-500 text-white text-xs font-semibold rounded-lg hover:bg-orange-600 transition">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-8">
                            <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No featured products available yet</p>
                        </div>
                        @endforelse
                    </div>
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
                    <li><a href="{{ route('about') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">About Us</a></li>
<li><a href="{{ route('shop') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Shop Now</a></li>
<li><a href="{{ route('sell') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Sell on Local Works</a></li>
<li><a href="{{ route('blog') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Blog</a></li>
<li><a href="{{ route('careers') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Careers</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
<div class="col-span-1">
    <h4 class="font-semibold text-white mb-4">Customer Service</h4>
    <ul class="space-y-2">
        <li><a href="{{ route('help.center') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Help Center</a></li>
        <li><a href="{{ route('contact') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Contact Us</a></li>
        <li><a href="{{ route('shipping.info') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Shipping Info</a></li>
        <li><a href="{{ route('returns') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Returns & Refunds</a></li>
        <li><a href="{{ route('track.order') }}" class="text-sm text-gray-300 hover:text-orange-400 transition">Track Order</a></li>
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
               <a href="{{ route('privacy.policy') }}" class="text-sm text-gray-400 hover:text-orange-400 transition">Privacy Policy</a>
<a href="{{ route('terms.service') }}" class="text-sm text-gray-400 hover:text-orange-400 transition">Terms of Service</a>
<a href="{{ route('cookie.policy') }}" class="text-sm text-gray-400 hover:text-orange-400 transition">Cookie Policy</a>
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
</script>
</body>
</html>
