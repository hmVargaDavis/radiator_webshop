<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $seoTitle = trim($__env->yieldContent('title')) ?: (\App\Models\SiteSetting::getValue('seo_title') ?? 'Radiátor Outlet Budapest | 22K panelradiátorok');
        $seoDesc = trim($__env->yieldContent('meta_description')) ?: (\App\Models\SiteSetting::getValue('seo_description') ?? 'Új 22K panelradiátorok Budapesten, raktárról. Kiszállítás Budapesten, átvétel Soroksáron.');
        $seoImage = trim($__env->yieldContent('og_image')) ?: asset('images/hero/hero-radiator.jpg');
        $seoType = trim($__env->yieldContent('og_type')) ?: 'website';
        $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
        $seoKeywords = trim($__env->yieldContent('meta_keywords')) ?: '22K radiátor Budapest, panelradiátor Budapest, lapradiátor raktárról, radiátor kiszállítás Budapest, radiátor Soroksár';
        $geo = app(\App\Services\SeoService::class)->geo();
    @endphp
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDesc }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="Radiátor Outlet Budapest">
    <meta name="robots" content="@yield('robots', 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1')">
    <meta name="googlebot" content="index,follow">
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="alternate" hreflang="hu" href="{{ $canonical }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    {{-- Open Graph --}}
    <meta property="og:locale" content="hu_HU">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:site_name" content="Radiátor Outlet Budapest">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:alt" content="{{ $seoTitle }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    {{-- GEO / local SEO --}}
    <meta name="geo.region" content="HU-BU">
    <meta name="geo.placename" content="Budapest, Soroksár">
    <meta name="geo.position" content="{{ $geo['latitude'] }};{{ $geo['longitude'] }}">
    <meta name="ICBM" content="{{ $geo['latitude'] }}, {{ $geo['longitude'] }}">
    <meta name="language" content="Hungarian">
    <meta name="content-language" content="hu">
    <meta name="coverage" content="Budapest">
    <meta name="distribution" content="local">
    <meta name="target" content="Budapest, Hungary">
    <meta name="rating" content="general">
    <meta name="revisit-after" content="7 days">
    <meta name="theme-color" content="#1f6fd6">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Radiátor Outlet">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=yes">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/icons/icon-192.png') }}">

    {{-- AI / machine discovery --}}
    <link rel="describedby" href="{{ url('/api/katalogus.json') }}" type="application/json" title="Termékkatalógus JSON">
    <link rel="alternate" type="application/json" href="{{ url('/api/katalogus.json') }}" title="AI product catalog">
    <link rel="help" href="{{ url('/llms.txt') }}" title="llms.txt">
    @hasSection('product_json')
        <link rel="alternate" type="application/json" href="@yield('product_json')" title="Product AI JSON">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/shop.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mobile-app.css') }}" rel="stylesheet">

    @stack('head')

    <script type="application/ld+json">
    {!! app(\App\Services\SeoService::class)->encode(app(\App\Services\SeoService::class)->organizationGraph()) !!}
    </script>
</head>
<body class="app-shell" itemscope itemtype="https://schema.org/WebPage">
@include('partials.header')

<main itemprop="mainContentOfPage" class="app-page-enter" id="appMain">
    @if(session('success'))
        <div class="container pt-3">
            <div class="alert alert-success alert-shop">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="container pt-3">
            <div class="alert alert-danger alert-shop">{{ session('error') }}</div>
        </div>
    @endif

    @yield('content')
</main>

@include('partials.footer')
@include('partials.bottom-nav')

<a class="mobile-call-fab" href="tel:{{ preg_replace('/\s+/', '', $shopPhoneDisplay ?? '06204662774') }}">
    <i class="fa-solid fa-phone"></i> Hívás
</a>

<div class="toast-container position-fixed p-3 app-toast-wrap" style="z-index:1080">
    <div id="cartToast" class="toast align-items-center text-bg-primary border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">Kosár frissítve.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/shop.js') }}"></script>
@stack('scripts')
</body>
</html>
