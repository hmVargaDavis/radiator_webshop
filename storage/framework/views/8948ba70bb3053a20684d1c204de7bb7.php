<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, maximum-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#008060">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> | Radiátor Outlet</title>
    <link rel="manifest" href="<?php echo e(asset('manifest.webmanifest')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/icons/apple-touch-icon.png')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/admin.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body class="polaris-app" data-admin-spa="1">
<?php
    $adminNav = [
        ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'label' => 'Kezdőlap', 'icon' => 'house'],
        ['route' => 'admin.orders.index', 'match' => 'admin.orders.*', 'label' => 'Rendelések', 'icon' => 'bag-check'],
        ['route' => 'admin.products.index', 'match' => 'admin.products.*', 'label' => 'Termékek', 'icon' => 'box-seam'],
        ['route' => 'admin.analytics', 'match' => 'admin.analytics', 'label' => 'Analitika', 'icon' => 'graph-up-arrow'],
        ['route' => 'admin.seo', 'match' => 'admin.seo', 'label' => 'SEO', 'icon' => 'search'],
        ['route' => 'admin.reviews.index', 'match' => 'admin.reviews.*', 'label' => 'Vélemények', 'icon' => 'chat-square-quote'],
        ['route' => 'admin.settings.edit', 'match' => 'admin.settings.*', 'label' => 'Beállítások', 'icon' => 'gear'],
    ];
?>

<div class="polaris-shell">
    <aside class="polaris-sidebar d-none d-lg-flex">
        <div class="polaris-brand">
            <span class="polaris-logo">R</span>
            <div>
                <strong>Radiátor Outlet</strong>
                <small>Admin</small>
            </div>
        </div>
        <nav class="polaris-nav">
            <?php $__currentLoopData = $adminNav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route($item['route'])); ?>" class="polaris-nav-link <?php echo e(request()->routeIs($item['match']) ? 'active' : ''); ?>" data-spa-link>
                    <i class="bi bi-<?php echo e($item['icon']); ?>"></i>
                    <span><?php echo e($item['label']); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
        <div class="polaris-side-foot">
            <a href="<?php echo e(url('/')); ?>" class="polaris-nav-link" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right"></i><span>Webshop megnyitása</span></a>
            <form method="post" action="<?php echo e(route('admin.logout')); ?>"><?php echo csrf_field(); ?>
                <button class="polaris-nav-link w-100 border-0" type="submit"><i class="bi bi-box-arrow-right"></i><span>Kijelentkezés</span></button>
            </form>
        </div>
    </aside>

    <div class="polaris-main">
        <header class="polaris-topbar">
            <div class="polaris-top-left">
                <div class="polaris-page-title" data-spa-title><?php echo $__env->yieldContent('title', 'Kezdőlap'); ?></div>
            </div>
            <form class="polaris-search" action="<?php echo e(route('admin.search')); ?>" method="get" id="adminSearchForm" data-spa-ignore="0">
                <i class="bi bi-search"></i>
                <input type="search" name="q" id="adminSearchInput" placeholder="Keresés: rendelés, termék, vevő..." value="<?php echo e(request('q')); ?>" autocomplete="off">
            </form>
            <div class="polaris-top-actions">
                <a href="<?php echo e(route('admin.products.create')); ?>" class="polaris-btn polaris-btn-primary d-none d-md-inline-flex" data-spa-link>
                    <i class="bi bi-plus-lg"></i> Termék
                </a>
                <a href="<?php echo e(url('/')); ?>" class="polaris-btn polaris-btn-ghost d-lg-none" target="_blank">Shop</a>
            </div>
        </header>

        <div id="adminSpaStatus" class="polaris-loading d-none">Betöltés...</div>
        <div class="polaris-content" id="adminSpaContent" data-spa-content>
            <?php if(session('success')): ?>
                <div class="polaris-banner success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="polaris-banner danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<nav class="polaris-tabbar d-lg-none" aria-label="Admin mobil">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="polaris-tab <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" data-spa-link>
        <i class="bi bi-house"></i><span>Kezdőlap</span>
    </a>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="polaris-tab <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" data-spa-link>
        <i class="bi bi-bag-check"></i><span>Rendelés</span>
    </a>
    <a href="<?php echo e(route('admin.products.index')); ?>" class="polaris-tab <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>" data-spa-link>
        <i class="bi bi-box-seam"></i><span>Termék</span>
    </a>
    <a href="<?php echo e(route('admin.analytics')); ?>" class="polaris-tab <?php echo e(request()->routeIs('admin.analytics') ? 'active' : ''); ?>" data-spa-link>
        <i class="bi bi-graph-up"></i><span>Analitika</span>
    </a>
    <a href="<?php echo e(route('admin.seo')); ?>" class="polaris-tab <?php echo e(request()->routeIs('admin.seo') ? 'active' : ''); ?>" data-spa-link>
        <i class="bi bi-search"></i><span>SEO</span>
    </a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="<?php echo e(asset('js/admin-spa.js')); ?>"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/layouts/admin.blade.php ENDPATH**/ ?>