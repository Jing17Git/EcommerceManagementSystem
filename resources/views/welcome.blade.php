<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopHinoba-an - Shop Everything</title>
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
            --gray-soft: #F7F8FA;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background: var(--gray-soft); color: #1A1A1A; }
        .sora { font-family: 'Sora', sans-serif; }

        /* ── HEADER ── */
        .top-bar { background: var(--orange); color: white; font-size: 12px; padding: 6px 24px; display: flex; justify-content: space-between; align-items: center; }
        .main-header { background: white; border-bottom: 1px solid #F0F0F0; position: sticky; top: 0; z-index: 100; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .header-inner { max-width: 1280px; margin: 0 auto; padding: 12px 24px; display: flex; align-items: center; gap: 20px; }
        .logo-wrap { display: flex; align-items: center; gap-x: 10px; gap: 10px; flex-shrink: 0; }
        .logo-icon { width: 40px; height: 40px; background: linear-gradient(135deg, var(--orange), var(--orange-dark)); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(255,107,53,0.35); }
        .search-bar { flex: 1; max-width: 520px; position: relative; }
        .search-bar input { width: 100%; padding: 10px 50px 10px 18px; border: 2px solid #F0F0F0; border-radius: 50px; font-size: 14px; font-family: 'Outfit', sans-serif; background: var(--gray-soft); transition: all .25s; outline: none; }
        .search-bar input:focus { border-color: var(--orange); background: white; box-shadow: 0 0 0 4px rgba(255,107,53,0.08); }
        .search-bar button { position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: var(--orange); color: white; border: none; padding: 7px 16px; border-radius: 50px; cursor: pointer; font-size: 13px; font-weight: 600; transition: background .2s; }
        .search-bar button:hover { background: var(--orange-dark); }
        .header-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .icon-btn { position: relative; width: 40px; height: 40px; border-radius: 10px; background: var(--gray-soft); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #555; transition: all .2s; font-size: 16px; }
        .icon-btn:hover { background: var(--orange-light); color: var(--orange); }
        .badge { position: absolute; top: -4px; right: -4px; min-width: 18px; height: 18px; background: #EF4444; color: white; border-radius: 50px; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; padding: 0 4px; border: 2px solid white; }

        /* ── NAV BAR ── */
        .nav-bar { background: white; border-bottom: 1px solid #F0F0F0; }
        .nav-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; gap: 0; }
        .nav-item { display: flex; align-items: center; gap: 6px; padding: 12px 16px; font-size: 13px; font-weight: 600; color: #555; text-decoration: none; border-bottom: 2px solid transparent; transition: all .2s; white-space: nowrap; cursor: pointer; border: none; background: none; }
        .nav-item:hover, .nav-item.active { color: var(--orange); border-bottom-color: var(--orange); }
        .nav-item i { font-size: 12px; }
        .dropdown-wrap { position: relative; }
        .dropdown-wrap:hover .dd-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .dd-menu { position: absolute; top: 100%; left: 0; min-width: 200px; background: white; border-radius: 14px; border: 1px solid #F0F0F0; box-shadow: 0 16px 40px rgba(0,0,0,0.12); padding: 8px; opacity: 0; visibility: hidden; transform: translateY(8px); transition: all .2s; z-index: 200; }
        .dd-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 8px; font-size: 13px; color: #444; text-decoration: none; transition: all .15s; }
        .dd-item:hover { background: var(--orange-light); color: var(--orange); }

        /* ── HERO ── */
        .hero-section { max-width: 1280px; margin: 0 auto; padding: 24px; display: grid; grid-template-columns: 1fr 300px; gap: 16px; }
        .hero-main { position: relative; border-radius: 20px; overflow: hidden; height: 380px; }
        .hero-slide { position: absolute; inset: 0; transition: opacity .6s ease; }
        .hero-slide.active { opacity: 1; z-index: 2; }
        .hero-slide.inactive { opacity: 0; z-index: 1; }
        .hero-content { position: absolute; inset: 0; display: flex; align-items: center; padding: 48px; z-index: 5; }
        .hero-dots { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 10; }
        .hero-dot { width: 8px; height: 8px; border-radius: 50px; background: rgba(255,255,255,0.4); cursor: pointer; transition: all .3s; border: none; }
        .hero-dot.active { width: 24px; background: white; }
        .hero-nav { position: absolute; top: 50%; transform: translateY(-50%); width: 38px; height: 38px; border-radius: 50%; background: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 10; transition: all .2s; color: #333; }
        .hero-nav:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.2); transform: translateY(-50%) scale(1.1); }
        .hero-nav.prev { left: 16px; }
        .hero-nav.next { right: 16px; }
        .hero-side { display: flex; flex-direction: column; gap: 16px; }
        .hero-banner { border-radius: 16px; overflow: hidden; height: 180px; position: relative; flex: 1; }

        /* ── CATEGORY ICONS ── */
        .cat-section { max-width: 1280px; margin: 0 auto; padding: 0 24px 24px; }
        .cat-grid { background: white; border-radius: 20px; padding: 24px; display: grid; grid-template-columns: repeat(10, 1fr); gap: 8px; }
        .cat-item { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 12px 6px; border-radius: 12px; cursor: pointer; transition: all .2s; text-decoration: none; }
        .cat-item:hover { background: var(--orange-light); }
        .cat-item:hover .cat-icon { transform: translateY(-3px); }
        .cat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; transition: transform .2s; }
        .cat-item span { font-size: 11px; font-weight: 600; color: #444; text-align: center; line-height: 1.3; }

        /* ── FLASH SALE ── */
        .section-wrap { max-width: 1280px; margin: 0 auto; padding: 0 24px 24px; }
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .section-title { display: flex; align-items: center; gap: 10px; }
        .section-title h2 { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 800; color: #1A1A1A; }
        .flash-badge { background: var(--orange); color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
        .countdown { display: flex; align-items: center; gap: 4px; background: #1A1A2E; color: white; padding: 6px 12px; border-radius: 8px; font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; }
        .countdown span.sep { opacity: .6; }
        .view-all { font-size: 13px; font-weight: 600; color: var(--orange); text-decoration: none; display: flex; align-items: center; gap: 4px; }
        .view-all:hover { color: var(--orange-dark); }

        /* ── PRODUCT CARDS ── */
        .products-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; }
        .product-card { background: white; border-radius: 16px; overflow: hidden; transition: all .3s cubic-bezier(.4,0,.2,1); border: 1px solid #F0F0F0; cursor: pointer; position: relative; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); border-color: #E5E5E5; }
        .product-img { width: 100%; height: 170px; object-fit: cover; background: #F5F5F5; display: block; }
        .product-img-wrap { position: relative; overflow: hidden; }
        .product-img-wrap img { width: 100%; height: 170px; object-fit: cover; transition: transform .5s ease; }
        .product-card:hover .product-img-wrap img { transform: scale(1.07); }
        .product-badge-sale { position: absolute; top: 10px; left: 10px; background: #EF4444; color: white; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 6px; z-index: 2; }
        .product-badge-new { position: absolute; top: 10px; left: 10px; background: #10B981; color: white; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 6px; z-index: 2; }
        .wishlist-btn { position: absolute; top: 10px; right: 10px; width: 32px; height: 32px; border-radius: 50%; background: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; opacity: 0; transition: all .25s; box-shadow: 0 2px 8px rgba(0,0,0,0.12); font-size: 14px; color: #888; }
        .product-card:hover .wishlist-btn { opacity: 1; }
        .wishlist-btn:hover { color: #EF4444; transform: scale(1.1); }
        .product-info { padding: 12px; }
        .product-name { font-size: 13px; font-weight: 600; color: #1A1A1A; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; }
        .product-price-row { display: flex; align-items: center; justify-content: space-between; margin-top: 6px; }
        .price-current { font-size: 16px; font-weight: 800; color: var(--orange); font-family: 'Sora', sans-serif; }
        .price-original { font-size: 11px; color: #AAA; text-decoration: line-through; margin-left: 4px; }
        .product-rating { display: flex; align-items: center; gap: 3px; font-size: 11px; color: #888; margin-top: 4px; }
        .product-rating i { color: #F59E0B; font-size: 10px; }
        .add-cart-btn { width: 30px; height: 30px; border-radius: 8px; background: var(--orange); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; transition: all .2s; flex-shrink: 0; }
        .add-cart-btn:hover { background: var(--orange-dark); transform: scale(1.1); }

        /* ── PROMO BANNERS ── */
        .promo-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .promo-card { border-radius: 16px; overflow: hidden; height: 140px; position: relative; cursor: pointer; }
        .promo-card:hover img { transform: scale(1.05); }
        .promo-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
        .promo-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0,0,0,.55) 0%, transparent 60%); display: flex; align-items: flex-end; padding: 16px; }

        /* ── BRAND TRUST ── */
        .trust-bar { background: white; border-radius: 20px; padding: 20px 28px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; }
        .trust-item { display: flex; align-items: center; gap: 12px; padding: 0 20px; }
        .trust-item:not(:last-child) { border-right: 1px solid #F0F0F0; }
        .trust-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }

        /* ── FOOTER ── */
        footer { background: #1A1A2E; margin-top: 32px; }
        .footer-inner { max-width: 1280px; margin: 0 auto; padding: 48px 24px 24px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.08); padding-top: 24px; display: flex; justify-content: space-between; align-items: center; }

        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp .5s ease both; }
        .fade-up-1 { animation-delay: .1s; }
        .fade-up-2 { animation-delay: .2s; }
        .fade-up-3 { animation-delay: .3s; }
        .fade-up-4 { animation-delay: .4s; }
    </style>
</head>
<body>

<!-- Top promotional bar -->
<div class="top-bar">
    <span><i class="fas fa-tag mr-1"></i> Welcome to ShopHinoba-an! Free shipping on orders ₱499+</span>
    <div style="display:flex;gap:20px;align-items:center;">
        <a href="{{ route('login') }}" style="color:white;text-decoration:none;font-weight:600;">Login</a>
        <span style="opacity:.4;">|</span>
        <a href="{{ route('register') }}" style="color:white;text-decoration:none;font-weight:600;">Register</a>
        <span style="opacity:.4;">|</span>
        <span><i class="fas fa-map-marker-alt mr-1"></i>Hinoba-an, Neg. Occ.</span>
    </div>
</div>

<!-- Main Header -->
<header class="main-header">
    <div class="header-inner">
        <div class="logo-wrap">
            <div class="logo-icon"><i class="fas fa-store text-white" style="font-size:18px;"></i></div>
            <div>
                <div class="sora" style="font-size:18px;font-weight:800;color:#1A1A1A;line-height:1.1;">ShopHinoba-an</div>
                <div style="font-size:10px;color:var(--orange);font-weight:600;letter-spacing:.5px;">SHOP EVERYTHING</div>
            </div>
        </div>

        <div class="search-bar">
            <input type="text" placeholder="Search products, brands, categories...">
            <button><i class="fas fa-search"></i></button>
        </div>

        <div class="header-actions">
            <button class="icon-btn"><i class="far fa-heart"></i></button>
            <a href="{{ route('login') }}" style="text-decoration:none;">
                <button class="icon-btn" style="position:relative;">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge">0</span>
                </button>
            </a>
            <a href="{{ route('login') }}" style="text-decoration:none;">
                <button style="display:flex;align-items:center;gap:8px;padding:8px 16px;background:var(--orange);color:white;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;transition:background .2s;" onmouseover="this.style.background='#E85A22'" onmouseout="this.style.background='var(--orange)'">
                    <i class="fas fa-user"></i> Login
                </button>
            </a>
            <a href="{{ route('register') }}" style="text-decoration:none;">
                <button style="display:flex;align-items:center;gap:8px;padding:8px 16px;background:white;color:var(--orange);border:2px solid var(--orange);border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;transition:all .2s;" onmouseover="this.style.background='var(--orange-light)'" onmouseout="this.style.background='white'">
                    Register
                </button>
            </a>
        </div>
    </div>
</header>

<!-- Category Nav Bar -->
<div class="nav-bar">
    <div class="nav-inner">
        <div class="dropdown-wrap">
            <button class="nav-item active"><i class="fas fa-th"></i> All Categories <i class="fas fa-chevron-down" style="font-size:10px;"></i></button>
            <div class="dd-menu">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $cat)
                    <a href="#" class="dd-item"><i class="fas fa-folder" style="color:var(--orange);width:16px;"></i> {{ $cat->name }}</a>
                    @endforeach
                @else
                    <a href="#" class="dd-item"><i class="fas fa-mobile-alt" style="color:var(--orange);width:16px;"></i> Electronics</a>
                    <a href="#" class="dd-item"><i class="fas fa-tshirt" style="color:var(--orange);width:16px;"></i> Fashion</a>
                    <a href="#" class="dd-item"><i class="fas fa-apple-alt" style="color:var(--orange);width:16px;"></i> Food & Grocery</a>
                    <a href="#" class="dd-item"><i class="fas fa-home" style="color:var(--orange);width:16px;"></i> Home & Living</a>
                    <a href="#" class="dd-item"><i class="fas fa-dumbbell" style="color:var(--orange);width:16px;"></i> Sports</a>
                @endif
            </div>
        </div>
        <a href="#" class="nav-item"><i class="fas fa-bolt" style="color:var(--orange);"></i> Flash Sale</a>
        <a href="#" class="nav-item"><i class="fas fa-star" style="color:#F59E0B;"></i> Top Deals</a>
        <a href="#" class="nav-item"><i class="fas fa-fire" style="color:#EF4444;"></i> Trending</a>
        <a href="#" class="nav-item"><i class="fas fa-tag"></i> New Arrivals</a>
        <a href="#" class="nav-item"><i class="fas fa-store-alt" style="color:var(--orange);"></i> Local Sellers</a>
        <a href="#" class="nav-item"><i class="fas fa-info-circle"></i> About</a>
        <a href="#" class="nav-item"><i class="fas fa-headset"></i> Help</a>
    </div>
</div>

<!-- Hero + Side Banners -->
<div class="hero-section fade-up">
    <div class="hero-main">
        <!-- Slide 1 -->
        <div class="hero-slide active" style="background:linear-gradient(135deg,#1A1A2E 0%,#16213E 50%,#0F3460 100%);">
            <div class="hero-content">
                <div>
                    <span style="display:inline-flex;align-items:center;gap:6px;background:var(--orange);color:white;padding:5px 14px;border-radius:50px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:16px;">
                        <i class="fas fa-bolt"></i> Flash Sale — Today Only
                    </span>
                    <h1 class="sora" style="font-size:44px;font-weight:800;color:white;line-height:1.1;margin-bottom:12px;">Up to <span style="color:var(--orange);">70% OFF</span><br>Electronics</h1>
                    <p style="color:rgba(255,255,255,.7);font-size:15px;margin-bottom:24px;">Phones, laptops, gadgets & more.<br>Limited stocks — grab yours now!</p>
                    <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:8px;background:var(--orange);color:white;padding:13px 28px;border-radius:50px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s;box-shadow:0 8px 24px rgba(255,107,53,.4);">
                        Shop Now <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div style="position:absolute;right:60px;top:50%;transform:translateY(-50%);font-size:140px;opacity:.08;color:white;"><i class="fas fa-mobile-alt"></i></div>
        </div>
        <!-- Slide 2 -->
        <div class="hero-slide inactive" style="background:linear-gradient(135deg,#134E4A 0%,#065F46 50%,#064E3B 100%);">
            <div class="hero-content">
                <div>
                    <span style="display:inline-flex;align-items:center;gap:6px;background:#F59E0B;color:#1A1A1A;padding:5px 14px;border-radius:50px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:16px;">
                        <i class="fas fa-leaf"></i> Fresh & Local
                    </span>
                    <h1 class="sora" style="font-size:44px;font-weight:800;color:white;line-height:1.1;margin-bottom:12px;">Fresh Food &<br><span style="color:#6EE7B7;">Groceries</span></h1>
                    <p style="color:rgba(255,255,255,.7);font-size:15px;margin-bottom:24px;">Straight from Hinoba-an farms<br>to your table. Same-day delivery!</p>
                    <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:8px;background:#10B981;color:white;padding:13px 28px;border-radius:50px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s;box-shadow:0 8px 24px rgba(16,185,129,.4);">
                        Order Fresh <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div style="position:absolute;right:60px;top:50%;transform:translateY(-50%);font-size:140px;opacity:.08;color:white;"><i class="fas fa-apple-alt"></i></div>
        </div>
        <!-- Slide 3 -->
        <div class="hero-slide inactive" style="background:linear-gradient(135deg,#4C1D95 0%,#5B21B6 50%,#6D28D9 100%);">
            <div class="hero-content">
                <div>
                    <span style="display:inline-flex;align-items:center;gap:6px;background:#F472B6;color:white;padding:5px 14px;border-radius:50px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:16px;">
                        <i class="fas fa-star"></i> New Season
                    </span>
                    <h1 class="sora" style="font-size:44px;font-weight:800;color:white;line-height:1.1;margin-bottom:12px;">Fashion &<br><span style="color:#F9A8D4;">Style 2025</span></h1>
                    <p style="color:rgba(255,255,255,.7);font-size:15px;margin-bottom:24px;">Trendy clothes, shoes & accessories.<br>New arrivals every week!</p>
                    <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:8px;background:#EC4899;color:white;padding:13px 28px;border-radius:50px;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s;box-shadow:0 8px 24px rgba(236,72,153,.4);">
                        Explore Fashion <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div style="position:absolute;right:60px;top:50%;transform:translateY(-50%);font-size:140px;opacity:.08;color:white;"><i class="fas fa-tshirt"></i></div>
        </div>

        <button class="hero-nav prev" onclick="prevSlide()"><i class="fas fa-chevron-left"></i></button>
        <button class="hero-nav next" onclick="nextSlide()"><i class="fas fa-chevron-right"></i></button>
        <div class="hero-dots">
            <button class="hero-dot active" onclick="goSlide(0)"></button>
            <button class="hero-dot" onclick="goSlide(1)"></button>
            <button class="hero-dot" onclick="goSlide(2)"></button>
        </div>
    </div>

    <!-- Side banners -->
    <div class="hero-side">
        <div class="hero-banner" style="background:linear-gradient(135deg,#FF6B35,#E85A22);">
            <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:center;padding:20px;z-index:2;">
                <span style="font-size:11px;color:rgba(255,255,255,.8);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Limited Offer</span>
                <div class="sora" style="font-size:22px;font-weight:800;color:white;line-height:1.2;">Vouchers<br>Up to ₱200 OFF</div>
                <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:5px;margin-top:12px;background:white;color:var(--orange);padding:7px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;width:fit-content;">Claim Now <i class="fas fa-arrow-right"></i></a>
            </div>
            <div style="position:absolute;right:-10px;bottom:-10px;font-size:80px;opacity:.15;color:white;"><i class="fas fa-ticket-alt"></i></div>
        </div>
        <div class="hero-banner" style="background:linear-gradient(135deg,#1A1A2E,#0F3460);">
            <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:center;padding:20px;z-index:2;">
                <span style="font-size:11px;color:rgba(255,255,255,.6);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">New Sellers</span>
                <div class="sora" style="font-size:20px;font-weight:800;color:white;line-height:1.2;">Sell on<br>ShopHinoba-an</div>
                <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:5px;margin-top:12px;background:var(--orange);color:white;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;width:fit-content;">Start Selling <i class="fas fa-arrow-right"></i></a>
            </div>
            <div style="position:absolute;right:-10px;bottom:-10px;font-size:80px;opacity:.1;color:white;"><i class="fas fa-store"></i></div>
        </div>
    </div>
</div>

<!-- Category Icons -->
<div class="cat-section fade-up fade-up-1">
    <div class="cat-grid">
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#EFF6FF;"><i class="fas fa-mobile-alt" style="color:#3B82F6;"></i></div>
            <span>Electronics</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#FFF7ED;"><i class="fas fa-apple-alt" style="color:#F97316;"></i></div>
            <span>Food & Grocery</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#FDF4FF;"><i class="fas fa-tshirt" style="color:#A855F7;"></i></div>
            <span>Fashion</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#F0FDF4;"><i class="fas fa-home" style="color:#22C55E;"></i></div>
            <span>Home & Living</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#FFF1F2;"><i class="fas fa-heartbeat" style="color:#F43F5E;"></i></div>
            <span>Health & Beauty</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#FFFBEB;"><i class="fas fa-dumbbell" style="color:#EAB308;"></i></div>
            <span>Sports</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#EFF6FF;"><i class="fas fa-baby-carriage" style="color:#60A5FA;"></i></div>
            <span>Babies & Kids</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#F0FDF4;"><i class="fas fa-paw" style="color:#16A34A;"></i></div>
            <span>Pet Supplies</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#FFF7ED;"><i class="fas fa-car" style="color:#EA580C;"></i></div>
            <span>Automotive</span>
        </a>
        <a href="#" class="cat-item">
            <div class="cat-icon" style="background:#FDF4FF;"><i class="fas fa-ellipsis-h" style="color:#9333EA;"></i></div>
            <span>See All</span>
        </a>
    </div>
</div>

<!-- Trust Bar -->
<div class="section-wrap fade-up fade-up-2">
    <div class="trust-bar">
        <div class="trust-item">
            <div class="trust-icon" style="background:#FFF7ED;"><i class="fas fa-shipping-fast" style="color:var(--orange);"></i></div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#1A1A1A;">Free Shipping</div>
                <div style="font-size:11px;color:#888;">On orders over ₱499</div>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon" style="background:#F0FDF4;"><i class="fas fa-shield-alt" style="color:#22C55E;"></i></div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#1A1A1A;">Buyer Protection</div>
                <div style="font-size:11px;color:#888;">100% secure payments</div>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon" style="background:#EFF6FF;"><i class="fas fa-undo-alt" style="color:#3B82F6;"></i></div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#1A1A1A;">Easy Returns</div>
                <div style="font-size:11px;color:#888;">7-day return policy</div>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon" style="background:#FFF1F2;"><i class="fas fa-headset" style="color:#F43F5E;"></i></div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#1A1A1A;">24/7 Support</div>
                <div style="font-size:11px;color:#888;">Always here to help</div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section with Real Data -->
<div class="section-wrap">
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm fade-up">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-box text-blue-500 text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 font-medium">Total Products</div>
                    <div class="text-2xl font-bold text-gray-900 sora">{{ $totalProducts ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm fade-up" style="animation-delay:0.1s;">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-tags text-purple-500 text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 font-medium">Categories</div>
                    <div class="text-2xl font-bold text-gray-900 sora">{{ $totalCategories ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm fade-up" style="animation-delay:0.2s;">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-green-500 text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 font-medium">Total Orders</div>
                    <div class="text-2xl font-bold text-gray-900 sora">{{ $totalOrders ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm fade-up" style="animation-delay:0.3s;">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
                    <i class="fas fa-store text-orange-500 text-xl"></i>
                </div>
                <div>
                    <div class="text-xs text-gray-500 font-medium">Active Sellers</div>
                    <div class="text-2xl font-bold text-gray-900 sora">{{ $totalSellers ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="section-wrap">
    <div class="grid grid-cols-3 gap-5">
        <!-- Monthly Sales Chart -->
        <div class="col-span-2 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 sora">Monthly Sales</h3>
                    <p class="text-sm text-gray-500">Revenue trend for the last 6 months</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full">₱{{ number_format(array_sum(array_column($monthlySales ?? [['revenue'=>0]],'revenue')), 0) }}</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <!-- Category Distribution Chart -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="mb-5">
                <h3 class="text-lg font-bold text-gray-900 sora">Categories</h3>
                <p class="text-sm text-gray-500">Product distribution</p>
            </div>
            <div class="h-56 flex items-center justify-center">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Activity -->
@if(isset($recentOrders) && $recentOrders->count() > 0)
<div class="section-wrap">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-lg font-bold text-gray-900 sora">Recent Orders</h3>
                <p class="text-sm text-gray-500">Latest order activity</p>
            </div>
        </div>
        <div class="space-y-3">
            @foreach($recentOrders as $order)
            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-orange-500"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm">Order #{{ $order->order_number ?? $order->id }}</div>
                        <div class="text-xs text-gray-500">{{ $order->user->name ?? 'Guest' }} · {{ $order->created_at->format('M d, h:i A') }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-gray-900">₱{{ number_format($order->total_amount, 0) }}</div>
                    <span class="text-xs px-2 py-0.5 rounded-full 
                        @if($order->status == 'delivered') bg-green-100 text-green-700
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-700
                        @else bg-yellow-100 text-yellow-700 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Flash Sale -->
<div class="section-wrap fade-up fade-up-3">
    <div class="section-header">
        <div class="section-title">
            <i class="fas fa-bolt" style="color:var(--orange);font-size:22px;"></i>
            <h2>Flash Sale</h2>
            <span class="flash-badge">HOT</span>
            <div class="countdown">
                <span id="h">02</span><span class="sep">:</span><span id="m">34</span><span class="sep">:</span><span id="s">17</span>
            </div>
        </div>
        <a href="{{ route('login') }}" class="view-all">View All <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="products-grid">
        @forelse(($featuredProducts ?? collect())->take(5) as $product)
        <div class="product-card">
            <div class="product-img-wrap">
                <img src="{{ $product->imageUrl() ?? 'https://picsum.photos/seed/'.$product->id.'/300/200' }}" alt="{{ $product->name }}">
                <span class="product-badge-sale">-20%</span>
                <button class="wishlist-btn"><i class="far fa-heart"></i></button>
            </div>
            <div class="product-info">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span>4.5 (128)</span></div>
                <div class="product-price-row">
                    <div><span class="price-current">₱{{ number_format($product->price, 0) }}</span></div>
                    <a href="{{ route('login') }}"><button class="add-cart-btn"><i class="fas fa-plus"></i></button></a>
                </div>
            </div>
        </div>
        @empty
        @for($i = 1; $i <= 5; $i++)
        <div class="product-card">
            <div class="product-img-wrap">
                <img src="https://picsum.photos/seed/prod{{ $i }}/300/200" alt="Product {{ $i }}">
                <span class="product-badge-sale">-{{ $i * 10 }}%</span>
                <button class="wishlist-btn"><i class="far fa-heart"></i></button>
            </div>
            <div class="product-info">
                <div class="product-name">Sample Product {{ $i }} - Great Deal Available</div>
                <div class="product-rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span>4.{{ $i }} ({{ $i * 42 }})</span></div>
                <div class="product-price-row">
                    <div><span class="price-current">₱{{ $i * 299 }}</span> <span class="price-original">₱{{ $i * 399 }}</span></div>
                    <a href="{{ route('login') }}"><button class="add-cart-btn"><i class="fas fa-plus"></i></button></a>
                </div>
            </div>
        </div>
        @endfor
        @endforelse
    </div>
</div>

<!-- Promo Banners -->
<div class="section-wrap fade-up fade-up-4">
    <div class="promo-grid">
        <div class="promo-card" style="background:linear-gradient(135deg,#FF6B35,#C9461A);">
            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:24px;z-index:2;">
                <div>
                    <div style="font-size:11px;color:rgba(255,255,255,.8);font-weight:600;text-transform:uppercase;margin-bottom:6px;">Electronics Week</div>
                    <div class="sora" style="font-size:24px;font-weight:800;color:white;line-height:1.2;">Up to 50% OFF<br>Gadgets</div>
                    <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:5px;margin-top:12px;background:white;color:var(--orange);padding:7px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">Shop Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div style="position:absolute;right:0;top:50%;transform:translateY(-50%);font-size:100px;opacity:.15;color:white;"><i class="fas fa-laptop"></i></div>
        </div>
        <div class="promo-card" style="background:linear-gradient(135deg,#065F46,#134E4A);">
            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:24px;z-index:2;">
                <div>
                    <div style="font-size:11px;color:rgba(255,255,255,.8);font-weight:600;text-transform:uppercase;margin-bottom:6px;">Fresh Daily</div>
                    <div class="sora" style="font-size:24px;font-weight:800;color:white;line-height:1.2;">Local Food &<br>Produce</div>
                    <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:5px;margin-top:12px;background:#10B981;color:white;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">Order Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div style="position:absolute;right:0;top:50%;transform:translateY(-50%);font-size:100px;opacity:.15;color:white;"><i class="fas fa-seedling"></i></div>
        </div>
        <div class="promo-card" style="background:linear-gradient(135deg,#4C1D95,#6D28D9);">
            <div style="position:absolute;inset:0;display:flex;align-items:center;padding:24px;z-index:2;">
                <div>
                    <div style="font-size:11px;color:rgba(255,255,255,.8);font-weight:600;text-transform:uppercase;margin-bottom:6px;">New Collection</div>
                    <div class="sora" style="font-size:24px;font-weight:800;color:white;line-height:1.2;">Fashion &<br>Lifestyle</div>
                    <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:5px;margin-top:12px;background:#8B5CF6;color:white;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">Browse <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div style="position:absolute;right:0;top:50%;transform:translateY(-50%);font-size:100px;opacity:.15;color:white;"><i class="fas fa-tshirt"></i></div>
        </div>
    </div>
</div>

<!-- Featured Products -->
<div class="section-wrap">
    <div class="section-header">
        <div class="section-title">
            <i class="fas fa-star" style="color:#F59E0B;font-size:22px;"></i>
            <h2>Top Picks For You</h2>
        </div>
        <a href="{{ route('login') }}" class="view-all">See All Products <i class="fas fa-chevron-right"></i></a>
    </div>
    <div class="products-grid">
        @forelse(($featuredProducts ?? collect())->take(10) as $product)
        <div class="product-card">
            <div class="product-img-wrap">
                <img src="{{ $product->imageUrl() ?? 'https://picsum.photos/seed/'.$product->id.'a/300/200' }}" alt="{{ $product->name }}">
                <span class="product-badge-new">NEW</span>
                <button class="wishlist-btn"><i class="far fa-heart"></i></button>
            </div>
            <div class="product-info">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>{{ $product->category->name ?? 'General' }}</span></div>
                <div class="product-price-row">
                    <span class="price-current">₱{{ number_format($product->price, 0) }}</span>
                    <a href="{{ route('login') }}"><button class="add-cart-btn"><i class="fas fa-plus"></i></button></a>
                </div>
            </div>
        </div>
        @empty
        @for($i = 1; $i <= 10; $i++)
        <div class="product-card">
            <div class="product-img-wrap">
                <img src="https://picsum.photos/seed/feat{{ $i }}/300/200" alt="Product">
                <button class="wishlist-btn"><i class="far fa-heart"></i></button>
            </div>
            <div class="product-info">
                <div class="product-name">Featured Item {{ $i }} — Best Value Pick</div>
                <div class="product-rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>4.0 ({{ $i * 30 }})</span></div>
                <div class="product-price-row">
                    <span class="price-current">₱{{ $i * 199 }}</span>
                    <a href="{{ route('login') }}"><button class="add-cart-btn"><i class="fas fa-plus"></i></button></a>
                </div>
            </div>
        </div>
        @endfor
        @endforelse
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                    <div class="logo-icon"><i class="fas fa-store text-white" style="font-size:16px;"></i></div>
                    <div class="sora" style="font-size:18px;font-weight:800;color:white;">ShopHinoba-an</div>
                </div>
                <p style="font-size:13px;color:rgba(255,255,255,.55);line-height:1.7;margin-bottom:16px;">Your one-stop marketplace for everything — from electronics and fashion to food and essentials. Shop local, support Hinoba-an!</p>
                <div style="display:flex;gap:8px;">
                    <a href="#" style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.6);text-decoration:none;transition:all .2s;" onmouseover="this.style.background='var(--orange)';this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,.08)';this.style.color='rgba(255,255,255,.6)'"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.6);text-decoration:none;transition:all .2s;" onmouseover="this.style.background='var(--orange)';this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,.08)';this.style.color='rgba(255,255,255,.6)'"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.6);text-decoration:none;transition:all .2s;" onmouseover="this.style.background='var(--orange)';this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,.08)';this.style.color='rgba(255,255,255,.6)'"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div>
                <h4 style="font-size:13px;font-weight:700;color:white;margin-bottom:14px;text-transform:uppercase;letter-spacing:.5px;">Shop</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:8px;">
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">All Products</a></li>
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Flash Sales</a></li>
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">New Arrivals</a></li>
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Best Sellers</a></li>
                    <li><a href="{{ route('register') }}" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Sell With Us</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-size:13px;font-weight:700;color:white;margin-bottom:14px;text-transform:uppercase;letter-spacing:.5px;">Support</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:8px;">
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Help Center</a></li>
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Track Order</a></li>
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Returns & Refunds</a></li>
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Shipping Info</a></li>
                    <li><a href="#" style="font-size:13px;color:rgba(255,255,255,.55);text-decoration:none;transition:color .2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,.55)'">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-size:13px;font-weight:700;color:white;margin-bottom:14px;text-transform:uppercase;letter-spacing:.5px;">Contact</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:10px;">
                    <li style="display:flex;align-items:flex-start;gap:8px;"><i class="fas fa-map-marker-alt" style="color:var(--orange);margin-top:2px;width:14px;"></i><span style="font-size:13px;color:rgba(255,255,255,.55);">Municipality of Hinobaan, Negros Occidental 6113</span></li>
                    <li style="display:flex;align-items:center;gap:8px;"><i class="fas fa-phone" style="color:var(--orange);width:14px;"></i><span style="font-size:13px;color:rgba(255,255,255,.55);">+63 912 345 6789</span></li>
                    <li style="display:flex;align-items:center;gap:8px;"><i class="fas fa-envelope" style="color:var(--orange);width:14px;"></i><span style="font-size:13px;color:rgba(255,255,255,.55);">hello@shophinobaan.ph</span></li>
                    <li style="display:flex;align-items:center;gap:8px;"><i class="fas fa-clock" style="color:var(--orange);width:14px;"></i><span style="font-size:13px;color:rgba(255,255,255,.55);">Mon-Sat: 9AM - 7PM</span></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p style="font-size:12px;color:rgba(255,255,255,.35);">&copy; {{ date('Y') }} ShopHinoba-an. All rights reserved.</p>
            <div style="display:flex;align-items:center;gap:16px;">
                <a href="#" style="font-size:12px;color:rgba(255,255,255,.35);text-decoration:none;">Privacy Policy</a>
                <a href="#" style="font-size:12px;color:rgba(255,255,255,.35);text-decoration:none;">Terms of Service</a>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <i class="fas fa-lock" style="color:#22C55E;font-size:12px;"></i>
                <span style="font-size:12px;color:rgba(255,255,255,.35);">Secure Payments</span>
                <i class="fab fa-cc-visa" style="color:rgba(255,255,255,.4);font-size:20px;margin-left:6px;"></i>
                <i class="fab fa-cc-mastercard" style="color:rgba(255,255,255,.4);font-size:20px;"></i>
                <i class="fab fa-cc-paypal" style="color:rgba(255,255,255,.4);font-size:20px;"></i>
                <i class="fab fa-gcash" style="color:rgba(255,255,255,.4);font-size:16px;"></i>
            </div>
        </div>
    </div>
</footer>

<script>
    // Hero carousel
    let current = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    function goSlide(n) {
        slides[current].classList.replace('active','inactive');
        dots[current].classList.remove('active');
        current = n;
        slides[current].classList.replace('inactive','active');
        dots[current].classList.add('active');
    }
    function nextSlide() { goSlide((current + 1) % slides.length); }
    function prevSlide() { goSlide((current - 1 + slides.length) % slides.length); }
    setInterval(nextSlide, 5000);

    // Countdown timer
    let totalSecs = 2 * 3600 + 34 * 60 + 17;
    setInterval(() => {
        if (totalSecs <= 0) return;
        totalSecs--;
        const h = String(Math.floor(totalSecs / 3600)).padStart(2,'0');
        const m = String(Math.floor((totalSecs % 3600) / 60)).padStart(2,'0');
        const s = String(totalSecs % 60).padStart(2,'0');
        document.getElementById('h').textContent = h;
        document.getElementById('m').textContent = m;
        document.getElementById('s').textContent = s;
    }, 1000);

    // Monthly Sales Chart
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyLabels ?? ['Jan','Feb','Mar','Apr','May','Jun']) !!},
                datasets: [{
                    label: 'Revenue (₱)',
                    data: {!! json_encode(array_column($monthlySales ?? [['revenue'=>0]],'revenue')) !!},
                    backgroundColor: 'rgba(255, 107, 53, 0.85)',
                    borderColor: 'rgba(255, 107, 53, 1)',
                    borderWidth: 0,
                    borderRadius: 8,
                    barThickness: 32,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            },
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }

    // Category Distribution Chart (Doughnut)
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoryDistribution->pluck('name') ?? ['Electronics','Fashion','Food','Home','Sports']) !!},
                datasets: [{
                    data: {!! json_encode($categoryDistribution->pluck('products_count') ?? [10,8,6,4,2]) !!},
                    backgroundColor: [
                        '#FF6B35',
                        '#3B82F6',
                        '#10B981',
                        '#8B5CF6',
                        '#F59E0B',
                        '#EC4899'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: { size: 10 }
                        }
                    }
                }
            }
        });
    }
</script>
</body>
</html>
