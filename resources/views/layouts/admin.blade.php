<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#008060">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>@yield('title', 'Admin') | Radiátor Outlet</title>
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('head')
</head>
<body class="polaris-app" data-admin-spa="1">
@php
    $adminNav = [
        ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'label' => 'Kezdőlap', 'icon' => 'fa-solid fa-house'],
        ['route' => 'admin.orders.index', 'match' => 'admin.orders.*', 'label' => 'Rendelések', 'icon' => 'fa-solid fa-bag-shopping'],
        ['route' => 'admin.products.index', 'match' => 'admin.products.*', 'label' => 'Termékek', 'icon' => 'fa-solid fa-box-open'],
        ['route' => 'admin.analytics', 'match' => 'admin.analytics', 'label' => 'Analitika', 'icon' => 'fa-solid fa-chart-line'],
        ['route' => 'admin.seo', 'match' => 'admin.seo', 'label' => 'SEO', 'icon' => 'fa-solid fa-magnifying-glass'],
        ['route' => 'admin.reviews.index', 'match' => 'admin.reviews.*', 'label' => 'Vélemények', 'icon' => 'fa-solid fa-comments'],
        ['route' => 'admin.settings.edit', 'match' => 'admin.settings.*', 'label' => 'Beállítások', 'icon' => 'fa-solid fa-gear'],
    ];
@endphp

<div class="polaris-shell">
    <aside class="polaris-sidebar d-none d-lg-flex">
        <div class="polaris-brand">
            <span class="polaris-logo"><i class="fa-solid fa-temperature-high"></i></span>
            <div>
                <strong>Radiátor Outlet</strong>
                <small>Admin</small>
            </div>
        </div>
        <nav class="polaris-nav">
            @foreach($adminNav as $item)
                <a href="{{ route($item['route']) }}" class="polaris-nav-link {{ request()->routeIs($item['match']) ? 'active' : '' }}" data-spa-link>
                    <i class="{{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
        <div class="polaris-side-foot">
            <a href="{{ url('/') }}" class="polaris-nav-link" target="_blank" rel="noopener"><i class="fa-solid fa-arrow-up-right-from-square"></i><span>Webshop megnyitása</span></a>
            <form method="post" action="{{ route('admin.logout') }}">@csrf
                <button class="polaris-nav-link w-100 border-0" type="submit"><i class="fa-solid fa-right-from-bracket"></i><span>Kijelentkezés</span></button>
            </form>
        </div>
    </aside>

    <div class="polaris-main">
        <header class="polaris-topbar">
            <div class="polaris-top-left">
                <div class="polaris-page-title" data-spa-title>@yield('title', 'Kezdőlap')</div>
            </div>
            <form class="polaris-search" action="{{ route('admin.search') }}" method="get" id="adminSearchForm" data-spa-ignore="0">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="q" id="adminSearchInput" placeholder="Keresés: rendelés, termék, vevő..." value="{{ request('q') }}" autocomplete="off">
            </form>
            <div class="polaris-top-actions">
                <a href="{{ route('admin.products.create') }}" class="polaris-btn polaris-btn-primary d-none d-md-inline-flex" data-spa-link>
                    <i class="fa-solid fa-plus"></i> Termék
                </a>
                <a href="{{ url('/') }}" class="polaris-btn polaris-btn-ghost d-lg-none" target="_blank">Shop</a>
            </div>
        </header>

        <div id="adminSpaStatus" class="polaris-loading d-none">Betöltés...</div>
        <div class="polaris-content" id="adminSpaContent" data-spa-content>
            @if(session('success'))
                <div class="polaris-banner success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="polaris-banner danger">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </div>
</div>

<nav class="polaris-tabbar d-lg-none" aria-label="Admin mobil">
    <a href="{{ route('admin.dashboard') }}" class="polaris-tab {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-spa-link>
        <i class="fa-solid fa-house"></i><span>Kezdőlap</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="polaris-tab {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" data-spa-link>
        <i class="fa-solid fa-bag-shopping"></i><span>Rendelés</span>
    </a>
    <a href="{{ route('admin.products.index') }}" class="polaris-tab {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" data-spa-link>
        <i class="fa-solid fa-box-open"></i><span>Termék</span>
    </a>
    <a href="{{ route('admin.analytics') }}" class="polaris-tab {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" data-spa-link>
        <i class="fa-solid fa-chart-line"></i><span>Analitika</span>
    </a>
    <a href="{{ route('admin.seo') }}" class="polaris-tab {{ request()->routeIs('admin.seo') ? 'active' : '' }}" data-spa-link>
        <i class="fa-solid fa-magnifying-glass"></i><span>SEO</span>
    </a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/admin-spa.js') }}"></script>
@stack('scripts')
</body>
</html>
