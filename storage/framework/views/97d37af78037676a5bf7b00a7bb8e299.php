<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php
        $seoTitle = trim($__env->yieldContent('title')) ?: (\App\Models\SiteSetting::getValue('seo_title') ?? 'Radiátor Outlet Budapest | 22K panelradiátorok');
        $seoDesc = trim($__env->yieldContent('meta_description')) ?: (\App\Models\SiteSetting::getValue('seo_description') ?? 'Új 22K panelradiátorok Budapesten, raktárról. Kiszállítás Budapesten, átvétel Soroksáron.');
        $seoImage = trim($__env->yieldContent('og_image')) ?: asset('images/hero/hero-radiator.jpg');
        $seoType = trim($__env->yieldContent('og_type')) ?: 'website';
        $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
        $seoKeywords = trim($__env->yieldContent('meta_keywords')) ?: '22K radiátor Budapest, panelradiátor Budapest, lapradiátor raktárról, radiátor kiszállítás Budapest, radiátor Soroksár';
        $geo = app(\App\Services\SeoService::class)->geo();
    ?>
    <title><?php echo e($seoTitle); ?></title>
    <meta name="description" content="<?php echo e($seoDesc); ?>">
    <meta name="keywords" content="<?php echo e($seoKeywords); ?>">
    <meta name="author" content="Radiátor Outlet Budapest">
    <meta name="robots" content="<?php echo $__env->yieldContent('robots', 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1'); ?>">
    <meta name="googlebot" content="index,follow">
    <link rel="canonical" href="<?php echo e($canonical); ?>">
    <link rel="alternate" hreflang="hu" href="<?php echo e($canonical); ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo e(url('/')); ?>">

    
    <meta property="og:locale" content="hu_HU">
    <meta property="og:type" content="<?php echo e($seoType); ?>">
    <meta property="og:title" content="<?php echo e($seoTitle); ?>">
    <meta property="og:description" content="<?php echo e($seoDesc); ?>">
    <meta property="og:url" content="<?php echo e($canonical); ?>">
    <meta property="og:site_name" content="Radiátor Outlet Budapest">
    <meta property="og:image" content="<?php echo e($seoImage); ?>">
    <meta property="og:image:alt" content="<?php echo e($seoTitle); ?>">

    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($seoTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($seoDesc); ?>">
    <meta name="twitter:image" content="<?php echo e($seoImage); ?>">

    
    <meta name="geo.region" content="HU-BU">
    <meta name="geo.placename" content="Budapest, Soroksár">
    <meta name="geo.position" content="<?php echo e($geo['latitude']); ?>;<?php echo e($geo['longitude']); ?>">
    <meta name="ICBM" content="<?php echo e($geo['latitude']); ?>, <?php echo e($geo['longitude']); ?>">
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
    <link rel="manifest" href="<?php echo e(asset('manifest.webmanifest')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/icons/apple-touch-icon.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo e(asset('images/icons/icon-192.png')); ?>">

    
    <link rel="describedby" href="<?php echo e(url('/api/katalogus.json')); ?>" type="application/json" title="Termékkatalógus JSON">
    <link rel="alternate" type="application/json" href="<?php echo e(url('/api/katalogus.json')); ?>" title="AI product catalog">
    <link rel="help" href="<?php echo e(url('/llms.txt')); ?>" title="llms.txt">
    <?php if (! empty(trim($__env->yieldContent('product_json')))): ?>
        <link rel="alternate" type="application/json" href="<?php echo $__env->yieldContent('product_json'); ?>" title="Product AI JSON">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/shop.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/mobile-app.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldPushContent('head'); ?>

    <script type="application/ld+json">
    <?php echo app(\App\Services\SeoService::class)->encode(app(\App\Services\SeoService::class)->organizationGraph()); ?>

    </script>
</head>
<body class="app-shell" itemscope itemtype="https://schema.org/WebPage">
<?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main itemprop="mainContentOfPage" class="app-page-enter" id="appMain">
    <?php if(session('success')): ?>
        <div class="container pt-3">
            <div class="alert alert-success alert-shop"><?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="container pt-3">
            <div class="alert alert-danger alert-shop"><?php echo e(session('error')); ?></div>
        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</main>

<?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.bottom-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<a class="mobile-call-fab" href="tel:<?php echo e(preg_replace('/\s+/', '', $shopPhoneDisplay ?? '06204662774')); ?>">
    <i class="bi bi-telephone-fill"></i> Hívás
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
<script src="<?php echo e(asset('js/shop.js')); ?>"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/layouts/app.blade.php ENDPATH**/ ?>