<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopHinoba-an — My Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --orange: #FF6B35;
            --orange-dark: #E85A22;
            --orange-light: #FFF3EE;
            --dark: #1A1A2E;
            --soft: #F7F8FA;
        }
        * { margin:0;padding:0;box-sizing:border-box; }
        body { font-family:'Outfit',sans-serif; background:var(--soft); color:#1A1A1A; }
        .sora { font-family:'Sora',sans-serif; }

        /* HEADER */
        .main-header { background:white; border-bottom:1px solid #F0F0F0; position:sticky; top:0; z-index:100; box-shadow:0 2px 12px rgba(0,0,0,.06); }
        .header-inner { max-width:1280px; margin:0 auto; padding:10px 24px; display:flex; align-items:center; gap:16px; }
        .logo-icon { width:38px;height:38px;background:linear-gradient(135deg,var(--orange),var(--orange-dark));border-radius:10px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(255,107,53,.3); }
        .search-bar { flex:1;max-width:480px;position:relative; }
        .search-bar input { width:100%;padding:9px 46px 9px 16px;border:2px solid #F0F0F0;border-radius:50px;font-size:13px;font-family:'Outfit',sans-serif;background:var(--soft);transition:all .25s;outline:none; }
        .search-bar input:focus { border-color:var(--orange);background:white; }
        .search-bar button { position:absolute;right:4px;top:50%;transform:translateY(-50%);background:var(--orange);color:white;border:none;padding:6px 14px;border-radius:50px;cursor:pointer;font-size:12px;font-weight:700; }
        .nav-links { display:flex;align-items:center;gap:2px; }
        .nav-link { display:flex;align-items:center;gap:5px;padding:8px 12px;font-size:13px;font-weight:600;color:#555;text-decoration:none;border-radius:8px;transition:all .2s;position:relative;white-space:nowrap; }
        .nav-link:hover,.nav-link.active { color:var(--orange);background:var(--orange-light); }
        .nav-link .cnt { font-size:10px;background:var(--orange);color:white;padding:1px 5px;border-radius:10px; }
        .icon-btn { width:38px;height:38px;border-radius:10px;background:var(--soft);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#555;transition:all .2s;font-size:15px;position:relative;flex-shrink:0; }
        .icon-btn:hover { background:var(--orange-light);color:var(--orange); }
        .notif-badge { position:absolute;top:-3px;right:-3px;min-width:16px;height:16px;background:#EF4444;color:white;border-radius:50px;font-size:9px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 3px;border:2px solid white; }
        .avatar-btn { display:flex;align-items:center;gap:8px;padding:5px 10px 5px 5px;border-radius:10px;background:var(--soft);border:none;cursor:pointer;transition:all .2s; }
        .avatar-btn:hover { background:var(--orange-light); }
        .avatar { width:32px;height:32px;border-radius:50%;ring:2px solid rgba(255,107,53,.3);object-fit:cover; }
        .dropdown { position:relative; }
        .dropdown:hover .dd { opacity:1;visibility:visible;transform:translateY(0); }
        .dd { position:absolute;top:calc(100% + 8px);right:0;min-width:200px;background:white;border-radius:14px;border:1px solid #F0F0F0;box-shadow:0 16px 40px rgba(0,0,0,.12);padding:8px;opacity:0;visibility:hidden;transform:translateY(8px);transition:all .2s;z-index:300; }
        .dd-item { display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;font-size:13px;color:#444;text-decoration:none;cursor:pointer;border:none;background:none;width:100%;transition:all .15s; }
        .dd-item:hover { background:var(--orange-light);color:var(--orange); }
        .dd-item.danger:hover { background:#FEF2F2;color:#EF4444; }
        .dd-sep { height:1px;background:#F0F0F0;margin:4px 0; }

        /* HERO CAROUSEL */
        .hero-carousel { max-width:1280px;margin:0 auto;padding:20px 24px 0; }
        .carousel-wrap { position:relative;border-radius:20px;overflow:hidden;height:260px; }
        .c-slide { position:absolute;inset:0;opacity:0;transition:opacity .6s; }
        .c-slide.on { opacity:1;z-index:2; }
        .c-nav { position:absolute;top:50%;transform:translateY(-50%);width:34px;height:34px;border-radius:50%;background:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:10;box-shadow:0 4px 12px rgba(0,0,0,.15);color:#333;transition:all .2s;font-size:12px; }
        .c-nav:hover { transform:translateY(-50%) scale(1.1); }
        .c-dots { position:absolute;bottom:14px;left:50%;transform:translateX(-50%);display:flex;gap:5px;z-index:10; }
        .c-dot { width:6px;height:6px;border-radius:50px;background:rgba(255,255,255,.4);border:none;cursor:pointer;transition:all .3s; }
        .c-dot.on { width:20px;background:white; }

        /* STAT CARDS */
        .stats-section { max-width:1280px;margin:0 auto;padding:20px 24px 0; }
        .stats-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:14px; }
        .stat-card { background:white;border-radius:16px;padding:20px;border:1px solid #F0F0F0;transition:all .3s;cursor:default;display:flex;align-items:center;gap:14px; }
        .stat-card:hover { transform:translateY(-3px);box-shadow:0 12px 32px rgba(0,0,0,.08);border-color:#E5E5E5; }
        .stat-icon { width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0; }
        .stat-label { font-size:12px;color:#888;font-weight:500;margin-bottom:3px; }
        .stat-value { font-size:24px;font-weight:800;color:#1A1A1A;font-family:'Sora',sans-serif;line-height:1; }
        .stat-sub { font-size:11px;color:#10B981;font-weight:600;margin-top:3px; }
        .stat-sub.down { color:#EF4444; }

        /* MAIN GRID */
        .main-grid { max-width:1280px;margin:0 auto;padding:20px 24px; display:grid;grid-template-columns:1fr 340px;gap:20px; }

        /* CATEGORY TABS */
        .cat-tabs { display:flex;gap:8px;overflow-x:auto;padding-bottom:4px;margin-bottom:16px; }
        .cat-tabs::-webkit-scrollbar { height:0; }
        .cat-tab { padding:8px 18px;border-radius:50px;border:1.5px solid #E5E5E5;background:white;color:#555;font-size:12px;font-weight:700;cursor:pointer;white-space:nowrap;transition:all .2s;flex-shrink:0; }
        .cat-tab:hover { border-color:var(--orange);color:var(--orange); }
        .cat-tab.active { background:var(--orange);color:white;border-color:var(--orange); }

        /* PRODUCTS */
        .products-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:14px; }
        .product-card { background:white;border-radius:14px;overflow:hidden;transition:all .3s cubic-bezier(.4,0,.2,1);border:1px solid #F0F0F0;cursor:pointer; }
        .product-card:hover { transform:translateY(-4px);box-shadow:0 12px 32px rgba(0,0,0,.1);border-color:#E5E5E5; }
        .product-img-wrap { position:relative;height:150px;overflow:hidden;background:#F5F5F5; }
        .product-img-wrap img { width:100%;height:100%;object-fit:cover;transition:transform .5s ease; }
        .product-card:hover .product-img-wrap img { transform:scale(1.08); }
        .sale-badge { position:absolute;top:8px;left:8px;background:#EF4444;color:white;font-size:9px;font-weight:700;padding:2px 7px;border-radius:5px; }
        .wl-btn { position:absolute;top:8px;right:8px;width:28px;height:28px;border-radius:50%;background:white;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;opacity:0;transition:all .25s;font-size:12px;color:#888;box-shadow:0 2px 6px rgba(0,0,0,.1); }
        .product-card:hover .wl-btn { opacity:1; }
        .wl-btn:hover { color:#EF4444; }
        .p-info { padding:10px; }
        .p-name { font-size:12px;font-weight:600;color:#1A1A1A;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.4;margin-bottom:4px; }
        .p-price { font-size:15px;font-weight:800;color:var(--orange);font-family:'Sora',sans-serif; }
        .p-row { display:flex;align-items:center;justify-content:space-between;margin-top:4px; }
        .p-sold { font-size:10px;color:#AAA; }
        .add-btn { width:26px;height:26px;border-radius:7px;background:var(--orange);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:white;font-size:11px;transition:all .2s; }
        .add-btn:hover { background:var(--orange-dark);transform:scale(1.1); }

        /* RIGHT PANEL */
        .right-panel { display:flex;flex-direction:column;gap:16px; }
        .panel-card { background:white;border-radius:16px;padding:20px;border:1px solid #F0F0F0; }
        .panel-title { font-size:15px;font-weight:800;color:#1A1A1A;margin-bottom:14px;display:flex;align-items:center;gap:8px; }

        /* ORDER STATUS */
        .order-status-grid { display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:16px; }
        .os-item { display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px 6px;border-radius:12px;cursor:pointer;transition:all .2s;border:1.5px solid #F0F0F0;background:var(--soft); }
        .os-item:hover { border-color:var(--orange);background:var(--orange-light); }
        .os-icon { width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px; }
        .os-label { font-size:10px;font-weight:700;color:#555;text-align:center;line-height:1.3; }
        .os-count { font-size:10px;font-weight:800;color:var(--orange); }

        /* RECENT ORDERS */
        .order-item { display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid #F7F8FA; }
        .order-item:last-child { border-bottom:none;padding-bottom:0; }
        .order-thumb { width:44px;height:44px;border-radius:10px;object-fit:cover;flex-shrink:0;background:#F5F5F5; }
        .order-info { flex:1;min-width:0; }
        .order-name { font-size:12px;font-weight:600;color:#1A1A1A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
        .order-meta { font-size:11px;color:#AAA;margin-top:1px; }
        .order-price { font-size:13px;font-weight:800;color:#1A1A1A;font-family:'Sora',sans-serif;flex-shrink:0; }
        .status-pill { font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;flex-shrink:0; }
        .status-delivered { background:#D1FAE5;color:#065F46; }
        .status-processing { background:#DBEAFE;color:#1E40AF; }
        .status-pending { background:#FEF3C7;color:#92400E; }
        .status-shipped { background:#EDE9FE;color:#5B21B6; }
        .status-cancelled { background:#FEE2E2;color:#991B1B; }

        /* SPENDING CHART */
        .chart-wrap { height:180px;position:relative; }

        /* VOUCHER CARD */
        .voucher-card { background:linear-gradient(135deg,var(--orange),var(--orange-dark));border-radius:16px;padding:16px 20px;color:white;display:flex;align-items:center;justify-content:space-between;cursor:pointer;transition:all .2s; }
        .voucher-card:hover { transform:translateY(-2px);box-shadow:0 8px 24px rgba(255,107,53,.35); }

        @keyframes fadeUp { from{opacity:0;transform:translateY(12px);}to{opacity:1;transform:translateY(0);} }
        .fu { animation:fadeUp .5s ease both; }
        .fu1 { animation-delay:.05s; }
        .fu2 { animation-delay:.1s; }
        .fu3 { animation-delay:.15s; }
        .fu4 { animation-delay:.2s; }
    </style>
</head>
<body>

<!-- Header -->
<header class="main-header">
    <div class="header-inner">
        <!-- Logo -->
        <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
            <div class="logo-icon"><i class="fas fa-store text-white" style="font-size:16px;"></i></div>
            <div class="sora" style="font-size:16px;font-weight:800;color:#1A1A1A;">ShopHinoba-an</div>
        </div>

        <!-- Search -->
        <div class="search-bar">
            <input type="text" placeholder="Search for products, brands...">
            <button><i class="fas fa-search"></i></button>
        </div>

        <!-- Nav links -->
        <div class="nav-links">
            <a href="{{ route('buyer.dashboard') }}" class="nav-link active"><i class="fas fa-home"></i> Home</a>
            <a href="{{ route('buyer.orders') }}" class="nav-link"><i class="fas fa-box"></i> Orders</a>
            <a href="{{ route('buyer.cart') }}" class="nav-link">
                <i class="fas fa-shopping-cart"></i> Cart
                @if(($cartCount ?? 0) > 0)<span class="cnt">{{ $cartCount }}</span>@endif
            </a>
            @if(isset($hasSellerRole) && $hasSellerRole)
            <form method="POST" action="{{ route('buyer.switchAccount') }}" style="display:contents;">
                @csrf<input type="hidden" name="role" value="seller">
                <button type="submit" style="display:flex;align-items:center;gap:5px;padding:8px 12px;background:#10B981;color:white;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;transition:background .2s;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10B981'">
                    <i class="fas fa-store"></i> Seller Mode
                </button>
            </form>
            @elseif(!isset($hasPendingApplication) || !$hasPendingApplication)
            <a href="{{ route('buyer.applySeller') }}" style="display:flex;align-items:center;gap:5px;padding:8px 12px;background:var(--orange);color:white;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;transition:background .2s;" onmouseover="this.style.background='var(--orange-dark)'" onmouseout="this.style.background='var(--orange)'">
                <i class="fas fa-store-alt"></i> Sell Now
            </a>
            @else
            <div style="display:flex;align-items:center;gap:5px;padding:8px 12px;background:#FEF3C7;color:#92400E;border-radius:8px;font-size:12px;font-weight:700;">
                <i class="fas fa-clock"></i> Pending
            </div>
            @endif
        </div>

        <!-- Icons -->
        <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
            <button class="icon-btn"><i class="far fa-heart"></i></button>

            <!-- Notifications -->
            <div class="dropdown">
                <button class="icon-btn">
                    <i class="far fa-bell"></i>
                    @if(($notificationCount ?? 0) > 0)<span class="notif-badge">{{ min($notificationCount,9) }}</span>@endif
                </button>
                <div class="dd" style="width:300px;">
                    <div style="padding:8px 12px 8px;font-size:13px;font-weight:700;color:#1A1A1A;border-bottom:1px solid #F0F0F0;margin-bottom:4px;">Notifications</div>
                    @forelse(($notifications ?? collect()) as $note)
                    <a href="{{ route('buyer.orders') }}" class="dd-item">
                        <div style="width:8px;height:8px;border-radius:50%;background:var(--orange);flex-shrink:0;"></div>
                        <div><div style="font-size:12px;font-weight:600;color:#1A1A1A;">{{ $note['message'] }}</div><div style="font-size:11px;color:#AAA;">{{ $note['time']->format('M d, h:i A') }}</div></div>
                    </a>
                    @empty
                    <div style="padding:16px;text-align:center;font-size:12px;color:#AAA;">No notifications yet</div>
                    @endforelse
                </div>
            </div>

            <!-- User menu -->
            <div class="dropdown">
                <button class="avatar-btn">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Buyer') }}&background=FF6B35&color=fff&bold=true" class="avatar" alt="">
                    <span style="font-size:13px;font-weight:600;color:#1A1A1A;">{{ Auth::user()->name ?? 'Buyer' }}</span>
                    <i class="fas fa-chevron-down" style="font-size:10px;color:#AAA;"></i>
                </button>
                <div class="dd">
                    <div style="padding:10px 12px;border-bottom:1px solid #F0F0F0;margin-bottom:4px;">
                        <div style="font-size:13px;font-weight:700;color:#1A1A1A;">{{ Auth::user()->name ?? 'Buyer' }}</div>
                        <div style="font-size:11px;color:#AAA;">{{ Auth::user()->email ?? 'buyer@example.com' }}</div>
                    </div>
                    <a href="{{ route('buyer.settings') }}" class="dd-item"><i class="fas fa-user-cog" style="width:16px;color:var(--orange);"></i> My Profile</a>
                    <a href="{{ route('buyer.orders') }}" class="dd-item"><i class="fas fa-box" style="width:16px;color:var(--orange);"></i> My Orders</a>
                    <a href="{{ route('buyer.cart') }}" class="dd-item"><i class="fas fa-shopping-cart" style="width:16px;color:var(--orange);"></i> My Cart</a>
                    <div class="dd-sep"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dd-item danger" style="width:100%;"><i class="fas fa-sign-out-alt" style="width:16px;"></i> Sign Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Hero Carousel -->
<div class="hero-carousel fu">
    <div class="carousel-wrap">
        <div class="c-slide on" style="background:linear-gradient(135deg,#1A1A2E,#0F3460);">
            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:40px 56px;z-index:5;">
                <div>
                    <span style="display:inline-flex;align-items:center;gap:5px;background:var(--orange);color:white;padding:4px 12px;border-radius:50px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:12px;"><i class="fas fa-bolt"></i> Flash Sale Ends In 02:34:17</span>
                    <h1 class="sora" style="font-size:36px;font-weight:800;color:white;line-height:1.15;margin-bottom:8px;">Up to <span style="color:var(--orange);">70% OFF</span> Electronics</h1>
                    <p style="color:rgba(255,255,255,.65);font-size:14px;margin-bottom:20px;">Phones, laptops, TVs & more. Limited stocks!</p>
                    <a href="{{ route('shop') ?? '#' }}" style="display:inline-flex;align-items:center;gap:6px;background:var(--orange);color:white;padding:10px 22px;border-radius:50px;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 6px 20px rgba(255,107,53,.4);">Shop Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div style="position:absolute;right:60px;top:50%;transform:translateY(-50%);font-size:130px;opacity:.07;color:white;"><i class="fas fa-laptop"></i></div>
        </div>
        <div class="c-slide" style="background:linear-gradient(135deg,#064E3B,#065F46);">
            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:40px 56px;z-index:5;">
                <div>
                    <span style="display:inline-flex;align-items:center;gap:5px;background:#F59E0B;color:#1A1A1A;padding:4px 12px;border-radius:50px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:12px;"><i class="fas fa-leaf"></i> Fresh & Local</span>
                    <h1 class="sora" style="font-size:36px;font-weight:800;color:white;line-height:1.15;margin-bottom:8px;">Fresh <span style="color:#6EE7B7;">Food & Grocery</span></h1>
                    <p style="color:rgba(255,255,255,.65);font-size:14px;margin-bottom:20px;">Farm-fresh from Hinoba-an. Same-day delivery!</p>
                    <a href="#" style="display:inline-flex;align-items:center;gap:6px;background:#10B981;color:white;padding:10px 22px;border-radius:50px;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 6px 20px rgba(16,185,129,.4);">Order Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div style="position:absolute;right:60px;top:50%;transform:translateY(-50%);font-size:130px;opacity:.07;color:white;"><i class="fas fa-apple-alt"></i></div>
        </div>
        <div class="c-slide" style="background:linear-gradient(135deg,#4C1D95,#6D28D9);">
            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:40px 56px;z-index:5;">
                <div>
                    <span style="display:inline-flex;align-items:center;gap:5px;background:#F472B6;color:white;padding:4px 12px;border-radius:50px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:12px;"><i class="fas fa-star"></i> New Season</span>
                    <h1 class="sora" style="font-size:36px;font-weight:800;color:white;line-height:1.15;margin-bottom:8px;"><span style="color:#F9A8D4;">Fashion</span> & Lifestyle</h1>
                    <p style="color:rgba(255,255,255,.65);font-size:14px;margin-bottom:20px;">Trendy clothes, shoes & accessories. New arrivals!</p>
                    <a href="#" style="display:inline-flex;align-items:center;gap:6px;background:#EC4899;color:white;padding:10px 22px;border-radius:50px;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 6px 20px rgba(236,72,153,.4);">Explore <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div style="position:absolute;right:60px;top:50%;transform:translateY(-50%);font-size:130px;opacity:.07;color:white;"><i class="fas fa-tshirt"></i></div>
        </div>
        <button class="c-nav" style="left:14px;" onclick="cPrev()"><i class="fas fa-chevron-left"></i></button>
        <button class="c-nav" style="right:14px;" onclick="cNext()"><i class="fas fa-chevron-right"></i></button>
        <div class="c-dots">
            <button class="c-dot on" onclick="cGo(0)"></button>
            <button class="c-dot" onclick="cGo(1)"></button>
            <button class="c-dot" onclick="cGo(2)"></button>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="stats-section fu fu1">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#DBEAFE,#BFDBFE);"><i class="fas fa-shopping-bag" style="color:#3B82F6;"></i></div>
            <div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ $stats['ordersCount'] ?? 0 }}</div>
                <div class="stat-sub">All time</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#D1FAE5,#A7F3D0);"><i class="fas fa-peso-sign" style="color:#059669;"></i></div>
            <div>
                <div class="stat-label">Total Spent</div>
                <div class="stat-value" style="font-size:18px;">₱{{ number_format($stats['totalSpent'] ?? 0, 0) }}</div>
                <div class="stat-sub">Lifetime value</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#FEF3C7,#FDE68A);"><i class="fas fa-clock" style="color:#D97706;"></i></div>
            <div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value">{{ $stats['pendingOrders'] ?? 0 }}</div>
                @if(($stats['pendingOrders'] ?? 0) > 0)<div class="stat-sub down">Needs attention</div>@else<div class="stat-sub">All clear!</div>@endif
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#FCE7F3,#FBCFE8);"><i class="fas fa-check-circle" style="color:#DB2777;"></i></div>
            <div>
                <div class="stat-label">Delivered</div>
                <div class="stat-value">{{ $stats['deliveredOrders'] ?? 0 }}</div>
                <div class="stat-sub">Successfully received</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="main-grid">

    <!-- LEFT: Products -->
    <div>
        <!-- Order Status Quick Nav -->
        <div class="panel-card fu fu2" style="margin-bottom:16px;">
            <div class="panel-title"><i class="fas fa-box-open" style="color:var(--orange);"></i> My Orders</div>
            <div class="order-status-grid">
                <a href="{{ route('buyer.orders') }}" class="os-item" style="text-decoration:none;">
                    <div class="os-icon" style="background:#FEF3C7;"><i class="fas fa-wallet" style="color:#D97706;font-size:14px;"></i></div>
                    <div class="os-label">To Pay</div>
                    <div class="os-count">{{ $orderStatuses['pending'] ?? 0 }}</div>
                </a>
                <a href="{{ route('buyer.orders') }}" class="os-item" style="text-decoration:none;">
                    <div class="os-icon" style="background:#DBEAFE;"><i class="fas fa-box" style="color:#3B82F6;font-size:14px;"></i></div>
                    <div class="os-label">To Ship</div>
                    <div class="os-count">{{ $orderStatuses['processing'] ?? 0 }}</div>
                </a>
                <a href="{{ route('buyer.orders') }}" class="os-item" style="text-decoration:none;">
                    <div class="os-icon" style="background:#EDE9FE;"><i class="fas fa-truck" style="color:#7C3AED;font-size:14px;"></i></div>
                    <div class="os-label">Shipped</div>
                    <div class="os-count">{{ $orderStatuses['shipped'] ?? 0 }}</div>
                </a>
                <a href="{{ route('buyer.orders') }}" class="os-item" style="text-decoration:none;">
                    <div class="os-icon" style="background:#D1FAE5;"><i class="fas fa-check-circle" style="color:#059669;font-size:14px;"></i></div>
                    <div class="os-label">Delivered</div>
                    <div class="os-count">{{ $orderStatuses['delivered'] ?? 0 }}</div>
                </a>
                <a href="{{ route('buyer.orders') }}" class="os-item" style="text-decoration:none;">
                    <div class="os-icon" style="background:#FEE2E2;"><i class="fas fa-star" style="color:#EF4444;font-size:14px;"></i></div>
                    <div class="os-label">To Review</div>
                    <div class="os-count">0</div>
                </a>
            </div>
        </div>

        <!-- Category Tabs + Products -->
        <div class="panel-card fu fu3">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <div class="panel-title" style="margin-bottom:0;"><i class="fas fa-fire" style="color:var(--orange);"></i> Recommended For You</div>
                <a href="#" style="font-size:12px;font-weight:600;color:var(--orange);text-decoration:none;">See All <i class="fas fa-chevron-right" style="font-size:10px;"></i></a>
            </div>
            <div class="cat-tabs">
                <button class="cat-tab active" onclick="setTab(this)">All</button>
                @forelse(($topCategories ?? collect()) as $cat)
                <button class="cat-tab" onclick="setTab(this)">{{ $cat->name }}</button>
                @empty
                <button class="cat-tab" onclick="setTab(this)">Electronics</button>
                <button class="cat-tab" onclick="setTab(this)">Food</button>
                <button class="cat-tab" onclick="setTab(this)">Fashion</button>
                <button class="cat-tab" onclick="setTab(this)">Home</button>
                <button class="cat-tab" onclick="setTab(this)">Sports</button>
                @endforelse
            </div>
            <div class="products-grid">
                @forelse(($recommendedProducts ?? collect())->take(6) as $product)
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                        <button class="wl-btn"><i class="far fa-heart"></i></button>
                    </div>
                    <div class="p-info">
                        <div class="p-name">{{ $product->name }}</div>
                        <div class="p-row">
                            <span class="p-price">₱{{ number_format($product->price, 0) }}</span>
                            <form method="POST" action="{{ route('buyer.cart.add', $product) }}" style="display:contents;">
                                @csrf
                                <button type="submit" class="add-btn"><i class="fas fa-plus"></i></button>
                            </form>
                        </div>
                        <div class="p-sold">{{ $product->category?->name ?? 'General' }}</div>
                    </div>
                </div>
                @empty
                @for($i = 1; $i <= 6; $i++)
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img src="https://picsum.photos/seed/dash{{ $i }}/280/200" alt="Product">
                        <span class="sale-badge">-{{ $i*8 }}%</span>
                        <button class="wl-btn"><i class="far fa-heart"></i></button>
                    </div>
                    <div class="p-info">
                        <div class="p-name">Great Product {{ $i }} — Best Value</div>
                        <div class="p-row">
                            <span class="p-price">₱{{ $i * 249 }}</span>
                            <button class="add-btn"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="p-sold">{{ $i*120 }} sold</div>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>

            <!-- Recently Added -->
            <div style="margin-top:20px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                    <div class="panel-title" style="margin-bottom:0;"><i class="fas fa-clock" style="color:#3B82F6;"></i> Recently Added</div>
                    <a href="#" style="font-size:12px;font-weight:600;color:var(--orange);text-decoration:none;">See All <i class="fas fa-chevron-right" style="font-size:10px;"></i></a>
                </div>
                <div class="products-grid">
                    @forelse(($recentlyViewedProducts ?? collect())->take(3) as $product)
                    <div class="product-card">
                        <div class="product-img-wrap">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                            <button class="wl-btn"><i class="far fa-heart"></i></button>
                        </div>
                        <div class="p-info">
                            <div class="p-name">{{ $product->name }}</div>
                            <div class="p-row">
                                <span class="p-price">₱{{ number_format($product->price, 0) }}</span>
                                <form method="POST" action="{{ route('buyer.cart.add', $product) }}" style="display:contents;">
                                    @csrf
                                    <button type="submit" class="add-btn"><i class="fas fa-plus"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    @for($i = 1; $i <= 3; $i++)
                    <div class="product-card">
                        <div class="product-img-wrap">
                            <img src="https://picsum.photos/seed/new{{ $i }}/280/200" alt="">
                            <span class="sale-badge" style="background:#10B981;">NEW</span>
                        </div>
                        <div class="p-info">
                            <div class="p-name">New Arrival {{ $i }}</div>
                            <div class="p-row"><span class="p-price">₱{{ $i * 349 }}</span><button class="add-btn"><i class="fas fa-plus"></i></button></div>
                        </div>
                    </div>
                    @endfor
                    @endforelse
                </div>
            </div>
        </div>
    </div>

<!-- RIGHT PANEL -->
    <div class="right-panel">

        <!-- Voucher Card -->
        <div class="voucher-card fu fu1">
            <div>
                <div style="font-size:11px;color:rgba(255,255,255,.75);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Available Vouchers</div>
                <div class="sora" style="font-size:20px;font-weight:800;">3 Vouchers</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Save up to ₱200 on next order</div>
            </div>
            <div>
                <div style="width:52px;height:52px;background:rgba(255,255,255,.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;"><i class="fas fa-ticket-alt"></i></div>
            </div>
        </div>

        <!-- Monthly Spending Chart -->
        <div class="panel-card fu fu2">
            <div class="panel-title"><i class="fas fa-chart-bar" style="color:var(--orange);"></i> Monthly Spending</div>
            <div class="chart-wrap">
                <canvas id="spendChart"></canvas>
            </div>
        </div>

        <!-- Order Status Chart -->
        <div class="panel-card fu fu2">
            <div class="panel-title"><i class="fas fa-chart-pie" style="color:var(--orange);"></i> Order Status</div>
            <div class="chart-wrap" style="height:200px;">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>

        <!-- Weekly Spending Chart -->
        <div class="panel-card fu fu2">
            <div class="panel-title"><i class="fas fa-calendar-week" style="color:#3B82F6;"></i> Weekly Spending</div>
            <div class="chart-wrap">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="panel-card fu fu3">
            <div class="panel-title"><i class="fas fa-shopping-bag" style="color:var(--orange);"></i> Recent Orders</div>
            @forelse(($recentOrders ?? collect())->take(5) as $order)
            <div class="order-item">
                <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,var(--orange-light),#FFF);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">
                    <i class="fas fa-box" style="color:var(--orange);"></i>
                </div>
                <div class="order-info">
                    <div class="order-name">Order #{{ $order->id }}</div>
                    <div class="order-meta">{{ $order->created_at->format('M d, Y') }} · {{ $order->orderItems->count() ?? 0 }} item(s)</div>
                </div>
                <div style="text-align:right;flex-shrink:0;">
                    <div class="order-price">₱{{ number_format($order->total_amount, 0) }}</div>
                    <span class="status-pill status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:24px 0;">
                <i class="fas fa-box-open" style="font-size:32px;color:#E5E5E5;margin-bottom:8px;display:block;"></i>
                <p style="font-size:13px;color:#AAA;">No orders yet</p>
                <a href="#" style="display:inline-flex;align-items:center;gap:5px;margin-top:10px;background:var(--orange);color:white;padding:8px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">Start Shopping</a>
            </div>
            @endforelse
            <a href="{{ route('buyer.orders') }}" style="display:block;text-align:center;margin-top:12px;font-size:13px;font-weight:700;color:var(--orange);text-decoration:none;padding:8px;border-radius:8px;transition:background .2s;" onmouseover="this.style.background='var(--orange-light)'" onmouseout="this.style.background='transparent'">View All Orders <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
        </div>

        <!-- Quick Links -->
        <div class="panel-card fu fu4">
            <div class="panel-title"><i class="fas fa-bolt" style="color:var(--orange);"></i> Quick Links</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                <a href="{{ route('buyer.settings') }}" style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px;border-radius:12px;border:1.5px solid #F0F0F0;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='var(--orange)';this.style.background='var(--orange-light)'" onmouseout="this.style.borderColor='#F0F0F0';this.style.background='white'">
                    <i class="fas fa-user-cog" style="font-size:18px;color:var(--orange);"></i>
                    <span style="font-size:11px;font-weight:700;color:#444;">My Profile</span>
                </a>
                <a href="{{ route('buyer.cart') }}" style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px;border-radius:12px;border:1.5px solid #F0F0F0;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='var(--orange)';this.style.background='var(--orange-light)'" onmouseout="this.style.borderColor='#F0F0F0';this.style.background='white'">
                    <i class="fas fa-shopping-cart" style="font-size:18px;color:#3B82F6;"></i>
                    <span style="font-size:11px;font-weight:700;color:#444;">My Cart</span>
                </a>
                <a href="#" style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px;border-radius:12px;border:1.5px solid #F0F0F0;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='var(--orange)';this.style.background='var(--orange-light)'" onmouseout="this.style.borderColor='#F0F0F0';this.style.background='white'">
                    <i class="fas fa-heart" style="font-size:18px;color:#EF4444;"></i>
                    <span style="font-size:11px;font-weight:700;color:#444;">Wishlist</span>
                </a>
                <a href="#" style="display:flex;flex-direction:column;align-items:center;gap:6px;padding:12px;border-radius:12px;border:1.5px solid #F0F0F0;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='var(--orange)';this.style.background='var(--orange-light)'" onmouseout="this.style.borderColor='#F0F0F0';this.style.background='white'">
                    <i class="fas fa-headset" style="font-size:18px;color:#10B981;"></i>
                    <span style="font-size:11px;font-weight:700;color:#444;">Support</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer style="background:#1A1A2E;margin-top:16px;">
    <div style="max-width:1280px;margin:0 auto;padding:32px 24px;">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:32px;margin-bottom:28px;">
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                    <div class="logo-icon"><i class="fas fa-store text-white" style="font-size:14px;"></i></div>
                    <div class="sora" style="font-size:16px;font-weight:800;color:white;">ShopHinoba-an</div>
                </div>
                <p style="font-size:12px;color:rgba(255,255,255,.45);line-height:1.7;">Your one-stop marketplace — shop electronics, food, fashion & more. Shop local, support Hinoba-an!</p>
            </div>
            <div>
                <h4 style="font-size:12px;font-weight:700;color:white;margin-bottom:12px;text-transform:uppercase;letter-spacing:.5px;">Shop</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:7px;">
                    <li><a href="#" style="font-size:12px;color:rgba(255,255,255,.45);text-decoration:none;">All Products</a></li>
                    <li><a href="#" style="font-size:12px;color:rgba(255,255,255,.45);text-decoration:none;">Flash Sales</a></li>
                    <li><a href="#" style="font-size:12px;color:rgba(255,255,255,.45);text-decoration:none;">New Arrivals</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-size:12px;font-weight:700;color:white;margin-bottom:12px;text-transform:uppercase;letter-spacing:.5px;">Support</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:7px;">
                    <li><a href="#" style="font-size:12px;color:rgba(255,255,255,.45);text-decoration:none;">Help Center</a></li>
                    <li><a href="#" style="font-size:12px;color:rgba(255,255,255,.45);text-decoration:none;">Track Order</a></li>
                    <li><a href="#" style="font-size:12px;color:rgba(255,255,255,.45);text-decoration:none;">Returns</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-size:12px;font-weight:700;color:white;margin-bottom:12px;text-transform:uppercase;letter-spacing:.5px;">Contact</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:7px;">
                    <li style="display:flex;gap:6px;"><i class="fas fa-map-marker-alt" style="color:var(--orange);width:12px;font-size:11px;margin-top:2px;"></i><span style="font-size:12px;color:rgba(255,255,255,.45);">Hinobaan, Negros Occ.</span></li>
                    <li style="display:flex;gap:6px;"><i class="fas fa-phone" style="color:var(--orange);width:12px;font-size:11px;"></i><span style="font-size:12px;color:rgba(255,255,255,.45);">+63 912 345 6789</span></li>
                </ul>
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:20px;display:flex;justify-content:space-between;align-items:center;">
            <p style="font-size:11px;color:rgba(255,255,255,.3);">&copy; {{ date('Y') }} ShopHinoba-an. All rights reserved.</p>
            <div style="display:flex;align-items:center;gap:8px;">
                <i class="fas fa-lock" style="color:#22C55E;font-size:11px;"></i>
                <span style="font-size:11px;color:rgba(255,255,255,.3);">Secure Payments</span>
                <i class="fab fa-cc-visa" style="color:rgba(255,255,255,.35);font-size:18px;margin-left:4px;"></i>
                <i class="fab fa-cc-mastercard" style="color:rgba(255,255,255,.35);font-size:18px;"></i>
                <i class="fab fa-cc-paypal" style="color:rgba(255,255,255,.35);font-size:18px;"></i>
            </div>
        </div>
    </div>
</footer>

<script>
    // Carousel
    let ci = 0;
    const cSlides = document.querySelectorAll('.c-slide');
    const cDots = document.querySelectorAll('.c-dot');
    function cGo(n) {
        cSlides[ci].classList.remove('on');
        cDots[ci].classList.remove('on');
        ci = n;
        cSlides[ci].classList.add('on');
        cDots[ci].classList.add('on');
    }
    function cNext() { cGo((ci+1) % cSlides.length); }
    function cPrev() { cGo((ci-1+cSlides.length) % cSlides.length); }
    setInterval(cNext, 5000);

    // Tab switcher
    function setTab(el) {
        document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    // Monthly Spending Chart
    const ctx = document.getElementById('spendChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels ?? ['Jan','Feb','Mar','Apr','May','Jun','Jul']) !!},
            datasets: [{
                label: '₱ Spent',
                data: {!! json_encode($monthlySpending ?? [0,0,0,0,0,0,0]) !!},
                backgroundColor: 'rgba(255,107,53,0.85)',
                borderColor: 'rgba(255,107,53,1)',
                borderWidth: 0,
                borderRadius: 8,
                barThickness: 24,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { callback: v => '₱'+v.toLocaleString(), font: { size: 10 } } },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });

    // Order Status Doughnut Chart
    const statusCtx = document.getElementById('orderStatusChart');
    if (statusCtx) {
        const statusCounts = {!! json_encode($orderStatusCounts ?? ['delivered'=>0,'processing'=>0,'pending'=>0,'shipped'=>0,'cancelled'=>0]) !!};
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Delivered', 'Processing', 'Pending', 'Shipped', 'Cancelled'],
                datasets: [{
                    data: [statusCounts.delivered || 0, statusCounts.processing || 0, statusCounts.pending || 0, statusCounts.shipped || 0, statusCounts.cancelled || 0],
                    backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#8B5CF6', '#EF4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true, font: { size: 9 } }
                    }
                }
            }
        });
    }

    // Weekly Spending Chart
    const weeklyCtx = document.getElementById('weeklyChart');
    if (weeklyCtx) {
        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($weeklyLabels ?? ['Week 1','Week 2','Week 3','Week 4']) !!},
                datasets: [{
                    label: '₱ Spent',
                    data: {!! json_encode($weeklySpending ?? [0,0,0,0]) !!},
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3B82F6',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { callback: v => '₱'+v.toLocaleString(), font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                }
            }
        });
    }
</script>
</body>
</html>
