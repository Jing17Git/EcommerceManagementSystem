<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar-link {
            transition: all 0.2s ease;
        }
        
        .sidebar-link:hover {
            background: linear-gradient(to right, rgba(249, 115, 22, 0.1), transparent);
            border-left: 3px solid #f97316;
            padding-left: 1.25rem;
        }
        
        .sidebar-link.active {
            background: linear-gradient(to right, rgba(249, 115, 22, 0.15), transparent);
            border-left: 3px solid #f97316;
            padding-left: 1.25rem;
            color: #f97316;
        }
        
        .sidebar-link i {
            width: 20px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- Seller Sidebar -->
<aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-gray-200 flex flex-col shadow-sm z-50">
    
    <!-- Logo Section -->
    <div class="px-6 py-5 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center shadow-md">
                <i class="fas fa-store text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900">SellerHub</h1>
                <p class="text-xs text-gray-500">Seller Portal</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-3 py-4 overflow-y-auto">
        
        <!-- Main Navigation -->
        <div class="mb-6">
            <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</p>
            
            <a href="{{ route('seller.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('seller.products') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('seller.products') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Products</span>
                <span class="ml-auto bg-orange-100 text-orange-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $sidebarStats['productsCount'] }}</span>
            </a>
            
            <a href="{{ route('seller.orders') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('seller.orders') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
                <span class="ml-auto bg-red-100 text-red-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $sidebarStats['ordersCount'] }}</span>
            </a>
            
            <a href="{{ route('seller.wallet') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('seller.wallet') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i>
                <span>Wallet / Payments</span>
            </a>
            
            <a href="{{ route('seller.shipping') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('seller.shipping') ? 'active' : '' }}">
                <i class="fas fa-truck"></i>
                <span>Shipping</span>
            </a>
            
            <a href="{{ route('seller.returns') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('seller.returns') ? 'active' : '' }}">
                <i class="fas fa-undo"></i>
                <span>Returns / Refunds</span>
                <span class="ml-auto bg-yellow-100 text-yellow-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $sidebarStats['pendingReturns'] }}</span>
            </a>
            
            <a href="{{ route('seller.settings') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 mb-1 {{ request()->routeIs('seller.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </div>
        
    </nav>

    <!-- User Profile Section -->
    <div class="px-3 py-4 border-t border-gray-200">
        <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
            <img src="https://ui-avatars.com/api/?name=John+Seller&background=f97316&color=fff&bold=true" 
                 alt="Seller Avatar" 
                 class="w-10 h-10 rounded-full ring-2 ring-orange-100">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">John's Store</p>
                <p class="text-xs text-gray-500 truncate">seller@example.com</p>
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
<div class="ml-64 min-h-screen">
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
</script>

</body>
</html>
