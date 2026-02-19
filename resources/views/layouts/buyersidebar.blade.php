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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #FAFAFA;
            color: #1A1A1A;
        }

        .display-font {
            font-family: 'Playfair Display', serif;
        }

        /* Sidebar Styles */
        .sidebar-link {
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background: linear-gradient(to right, rgba(255, 107, 53, 0.1), transparent);
            border-left: 3px solid #FF6B35;
            padding-left: 1.25rem;
        }

        .sidebar-link.active {
            background: linear-gradient(to right, rgba(255, 107, 53, 0.15), transparent);
            border-left: 3px solid #FF6B35;
            padding-left: 1.25rem;
            color: #FF6B35;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease-out;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #F0F0F0;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12);
            border-color: #E5E5E5;
        }

        .product-image-container {
            position: relative;
            width: 100%;
            height: 180px;
            background: #F5F5F5;
            overflow: hidden;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.08);
        }

        .wishlist-icon {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .product-card:hover .wishlist-icon {
            opacity: 1;
        }

        .wishlist-icon:hover {
            background: #FEF2F2;
            color: #EF4444;
            transform: scale(1.1);
        }

        .wishlist-icon.active {
            background: #FEF2F2;
            color: #EF4444;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- Buyer Sidebar -->
<aside class="fixed left-0 top-0 h-screen w-72 bg-white border-r border-gray-200 flex flex-col shadow-sm z-50">
    
    <!-- Logo Section -->
    <div class="px-6 py-5 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                <i class="fas fa-store text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Support Local</h1>
                <p class="text-xs text-gray-500">Buyer Dashboard</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-3 py-4 overflow-y-auto">
        
        <!-- Main Navigation -->
        <div class="mb-6">
            <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</p>
            
            <a href="{{ route('buyer.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('buyer.orders') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('buyer.orders') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i>
                <span>My Orders</span>
                <span class="ml-auto bg-orange-100 text-orange-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $sidebarStats['ordersCount'] ?? 0 }}</span>
            </a>
            
            <a href="{{ route('buyer.wishlist') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('buyer.wishlist') ? 'active' : '' }}">
                <i class="fas fa-heart"></i>
                <span>Wishlist</span>
                <span class="ml-auto bg-red-100 text-red-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $sidebarStats['wishlistCount'] ?? 0 }}</span>
            </a>
            
            <a href="{{ route('buyer.cart') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('buyer.cart') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart</span>
                <span class="ml-auto bg-green-100 text-green-600 text-xs font-semibold px-2 py-0.5 rounded-full">2</span>
            </a>
        </div>

        <!-- Categories Section -->
        <div class="mb-6">
            <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Browse</p>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-gem"></i>
                <span>Jewelry</span>
            </a>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-couch"></i>
                <span>Home Decor</span>
            </a>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-paint-brush"></i>
                <span>Ceramics</span>
            </a>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-tshirt"></i>
                <span>Textiles</span>
            </a>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-palette"></i>
                <span>Art & Prints</span>
            </a>
        </div>

        <!-- Account Section -->
        <div class="mb-6">
            <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Account</p>
            
            <a href="{{ route('buyer.settings') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('buyer.settings') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Settings</span>
            </a>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-map-marker-alt"></i>
                <span>Addresses</span>
            </a>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-credit-card"></i>
                <span>Payment Methods</span>
            </a>
        </div>

        <!-- Support Section -->
        <div>
            <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Support</p>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-question-circle"></i>
                <span>Help Center</span>
            </a>
            
            <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-headset"></i>
                <span>Contact Us</span>
            </a>
        </div>
        
    </nav>

    <!-- User Profile Section -->
    <div class="px-3 py-4 border-t border-gray-200">
        <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Buyer' }}&background=FF6B35&color=fff&bold=true" 
                 alt="User Avatar" 
                 class="w-10 h-10 rounded-full ring-2 ring-orange-200">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? 'Buyer' }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'buyer@example.com' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-orange-500 transition">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>

</aside>

<!-- Main Content Area -->
<div class="ml-72 min-h-screen">
    {{ $slot }}
</div>

<script>
    // Active link handling
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('.sidebar-link');
        const currentPath = window.location.pathname;
        
        links.forEach(link => {
            // Set active class based on current path
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
            
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                links.forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');
            });
        });
    });

    // Wishlist toggle
    document.querySelectorAll('.wishlist-icon').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
        });
    });
</script>

</body>
</html>
