<!-- BLADE FILE: resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name', 'Laravel') }} — Admin</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    *, *::before, *::after { box-sizing: border-box; }
    body { font-family: 'Inter', system-ui, sans-serif; background: #fafafa; }

    :root {
        --orange:       #f97316;
        --orange-dark:  #ea6c0a;
        --orange-light: #fff7ed;
        --border:       #f0f0f0;
        --txt:          #111827;
        --muted:        #9ca3af;
        --secondary:    #6b7280;
        --hover:        #fff7ed;
    }

    /* ── Sidebar ── */
    .sidebar {
        width: 228px; background: #fff;
        border-right: 1px solid var(--border);
        display: flex; flex-direction: column;
        height: 100vh; position: fixed;
        top: 0; left: 0; z-index: 50;
    }

    .brand {
        display: flex; align-items: center; gap: 11px;
        padding: 20px 18px 16px;
        border-bottom: 1px solid var(--border);
        flex-shrink: 0;
    }

    .brand-icon {
        width: 34px; height: 34px; border-radius: 10px;
        background: var(--orange); display: flex;
        align-items: center; justify-content: center;
        box-shadow: 0 2px 8px rgba(249,115,22,.3); flex-shrink: 0;
    }
    .brand-icon svg { width: 18px; height: 18px; stroke: #fff; fill: none; }
    .brand-name  { font-size: 14.5px; font-weight: 700; color: var(--txt); letter-spacing: -.02em; }
    .brand-sub   { font-size: 10.5px; color: var(--muted); font-weight: 500; }

    .sidebar-nav { flex: 1; overflow-y: auto; padding: 8px 0; scrollbar-width: none; }
    .sidebar-nav::-webkit-scrollbar { display: none; }

    .nav-label {
        font-size: 10px; font-weight: 700; letter-spacing: .09em;
        text-transform: uppercase; color: var(--muted);
        padding: 14px 20px 5px;
    }

    .nav-link {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 12px; margin: 1px 8px; border-radius: 8px;
        font-size: 13.5px; font-weight: 500; color: var(--secondary);
        text-decoration: none; transition: background .15s, color .15s;
        position: relative;
    }
    .nav-link:hover { background: var(--hover); color: var(--orange-dark); }
    .nav-link.active {
        background: var(--orange-light); color: var(--orange-dark); font-weight: 600;
    }
    .nav-link.active::before {
        content: ''; position: absolute; left: -8px; top: 50%; transform: translateY(-50%);
        width: 3px; height: 18px; background: var(--orange); border-radius: 0 3px 3px 0;
    }
    .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; stroke: currentColor; stroke-width: 1.75; fill: none; }
    .nav-badge {
        margin-left: auto; background: var(--orange); color: #fff;
        font-size: 10px; font-weight: 700; border-radius: 20px; padding: 1px 7px;
    }

    .sidebar-footer { border-top: 1px solid var(--border); padding: 10px; flex-shrink: 0; position: relative; }

    .user-row {
        display: flex; align-items: center; gap: 9px;
        padding: 8px 10px; border-radius: 9px; cursor: pointer;
        transition: background .15s;
    }
    .user-row:hover { background: var(--hover); }

    .user-avatar {
        width: 32px; height: 32px; border-radius: 9px;
        background: var(--orange); color: #fff; font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(249,115,22,.25);
    }
    .user-info { flex: 1; min-width: 0; }
    .u-name { font-size: 12.5px; font-weight: 600; color: var(--txt); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .u-role { font-size: 11px; color: var(--muted); }
    .chevron svg { width: 14px; height: 14px; stroke: var(--muted); stroke-width: 2; fill: none; }

    .dd-menu {
        position: absolute; bottom: calc(100% + 4px);
        left: 10px; right: 10px; background: #fff;
        border: 1px solid var(--border); border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,.10); padding: 6px;
        display: none; z-index: 100;
    }
    .dd-menu.open { display: block; }
    .dd-head { padding: 8px 10px 10px; border-bottom: 1px solid var(--border); margin-bottom: 4px; }
    .dd-head-name  { font-size: 12.5px; font-weight: 600; color: var(--txt); }
    .dd-head-email { font-size: 11px; color: var(--muted); margin-top: 1px; }
    .dd-item {
        display: flex; align-items: center; gap: 9px;
        padding: 7px 10px; border-radius: 7px; font-size: 13px;
        font-weight: 500; color: var(--secondary); text-decoration: none;
        cursor: pointer; border: none; background: none; width: 100%;
        text-align: left; transition: background .14s, color .14s; font-family: inherit;
    }
    .dd-item:hover { background: var(--hover); color: var(--orange-dark); }
    .dd-item.danger { color: #ef4444; }
    .dd-item.danger:hover { background: #fef2f2; }
    .dd-item svg { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2; fill: none; }

    /* ── Main Shell ── */
    .main-shell { margin-left: 228px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

    .topbar {
        height: 56px; background: #fff; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 28px; position: sticky; top: 0; z-index: 40;
    }
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-size: 13.5px; color: var(--muted);
    }
    .breadcrumb span { font-weight: 600; color: var(--txt); }
    .breadcrumb svg { width: 14px; height: 14px; stroke: var(--muted); stroke-width: 2; fill: none; }

    .tb-right { display: flex; align-items: center; gap: 8px; }

    .search-wrap { position: relative; display: flex; align-items: center; }
    .search-wrap svg { position: absolute; left: 10px; width: 14px; height: 14px; stroke: var(--muted); stroke-width: 2; fill: none; pointer-events: none; }
    .search-wrap input {
        background: #fafafa; border: 1px solid var(--border);
        border-radius: 9px; padding: 7px 14px 7px 32px;
        font-size: 13px; font-family: inherit; color: var(--txt);
        width: 210px; outline: none; transition: border .15s, background .15s;
    }
    .search-wrap input::placeholder { color: var(--muted); }
    .search-wrap input:focus { border-color: #fed7aa; background: #fff; }

    .tb-btn {
        width: 36px; height: 36px; border-radius: 9px; background: #fff;
        border: 1px solid var(--border); display: flex; align-items: center;
        justify-content: center; color: var(--muted); cursor: pointer;
        transition: all .15s; position: relative;
    }
    .tb-btn:hover { background: var(--hover); border-color: #fed7aa; color: var(--orange-dark); }
    .tb-btn svg { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2; fill: none; }
    .notif-dot { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: var(--orange); border-radius: 50%; border: 1.5px solid #fff; }

    .tb-avatar {
        width: 34px; height: 34px; border-radius: 9px; background: var(--orange);
        color: #fff; font-size: 11.5px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; box-shadow: 0 2px 6px rgba(249,115,22,.28);
    }

    .page-content { flex: 1; padding: 28px 32px; background: #fafafa; }
    </style>
</head>
<body style="display:flex; min-height:100vh;">

<!-- ════════════════════════════════ SIDEBAR ════════════════════════════════ -->
<aside class="sidebar">

    <div class="brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <div>
            <div class="brand-name">{{ config('app.name', 'ShopAdmin') }}</div>
            <div class="brand-sub">Management Console</div>
        </div>
    </div>

    <nav class="sidebar-nav">

        <div class="nav-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/></svg>
            Dashboard
        </a>

        <div class="nav-label">Catalog</div>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Products
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            Categories
        </a>

        <div class="nav-label">Sales</div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Orders
        </a>
        <a href="{{ route('admin.sellers.index') }}" class="nav-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Sellers
        </a>

        <div class="nav-label">People</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Users
        </a>
        <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Messages
        </a>

        <div class="nav-label">System</div>
        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Pages
        </a>
        <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Reports
        </a>
        <a href="{{ route('admin.logs.index') }}" class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Logs
        </a>

    </nav>

    <!-- Footer / User -->
    <div class="sidebar-footer" x-data="{ open: false }" style="position: relative;">
        <div class="user-row" @click="open = !open">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
            <div class="user-info">
                <div class="u-name">{{ Auth::user()->name }}</div>
                <div class="u-role">Administrator</div>
            </div>
            <div class="chevron">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4M8 15l4 4 4-4"/></svg>
            </div>
        </div>
        <div x-show="open" @click.away="open = false" class="dd-menu" style="display:none;">
            <div class="dd-head">
                <div class="dd-head-name">{{ Auth::user()->name }}</div>
                <div class="dd-head-email">{{ Auth::user()->email }}</div>
            </div>
            <a href="{{ route('profile.edit') }}" class="dd-item">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profile Settings
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dd-item danger" style="width:100%;">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign out
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- ════════════════════════════════ MAIN ════════════════════════════════ -->
<div class="main-shell">

    <header class="topbar">
        <div class="breadcrumb">
            Home
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span>{{ $header ?? 'Dashboard' }}</span>
        </div>
        <div class="tb-right">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Search…"/>
            </div>
            <button class="tb-btn">
                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="notif-dot"></span>
            </button>
            <div class="tb-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        </div>
    </header>

    <main class="page-content">
        {{ $slot }}
    </main>
</div>

</body>
</html>