<header class="site-header">
    <div class="container py-2 py-lg-3">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <button class="btn btn-link d-lg-none p-1 text-decoration-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-label="Menü">
                <i class="bi bi-list fs-2 text-primary"></i>
            </button>

            <a href="<?php echo e(route('home')); ?>" class="brand-lockup">
                <span class="brand-mark" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="5" width="3.2" height="14" rx="1" fill="currentColor"/>
                        <rect x="8" y="5" width="3.2" height="14" rx="1" fill="currentColor"/>
                        <rect x="13" y="5" width="3.2" height="14" rx="1" fill="currentColor"/>
                        <rect x="18" y="5" width="3.2" height="14" rx="1" fill="currentColor"/>
                    </svg>
                </span>
                <span>
                    <p class="brand-title">Radiátor Outlet Budapest</p>
                    <p class="brand-tag">Minőség. Jó árak. Budapesten.</p>
                </span>
            </a>

            <nav class="nav-main d-none d-lg-flex align-items-center gap-1 mx-auto">
                <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Főoldal</a>
                <a class="nav-link <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>" href="<?php echo e(route('products.index')); ?>">Radiátorok / Árak</a>
                <a class="nav-link <?php echo e(request()->routeIs('shipping') ? 'active' : ''); ?>" href="<?php echo e(route('shipping')); ?>">Szállítás</a>
                <a class="nav-link <?php echo e(request()->routeIs('reviews.*') ? 'active' : ''); ?>" href="<?php echo e(route('reviews.index')); ?>">Vélemények</a>
                <a class="nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>" href="<?php echo e(route('contact')); ?>">Kapcsolat</a>
            </nav>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <div class="header-phone d-none d-md-block">
                    <a href="tel:<?php echo e(preg_replace('/\s+/', '', $shopPhoneDisplay ?? '06 20 466 2774')); ?>"><?php echo e($shopPhoneDisplay ?? '06 20 466 2774'); ?></a>
                    <small>H-P: 8:00 - 17:00</small>
                </div>
                <a class="d-md-none text-primary fs-4" href="tel:<?php echo e(preg_replace('/\s+/', '', $shopPhoneDisplay ?? '06 20 466 2774')); ?>" aria-label="Hívás">
                    <i class="bi bi-telephone"></i>
                </a>
                <button type="button" class="btn-cart" id="openCartDrawer" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer" aria-controls="cartDrawer">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-label">Kosár</span>
                    <span class="cart-badge <?php echo e(($cartCount ?? 0) ? '' : 'd-none'); ?>" data-cart-count><?php echo e($cartCount ?? 0); ?></span>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menü</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" href="<?php echo e(route('home')); ?>">Főoldal</a>
            <a class="list-group-item list-group-item-action" href="<?php echo e(route('products.index')); ?>">Radiátorok / Árak</a>
            <a class="list-group-item list-group-item-action" href="<?php echo e(route('shipping')); ?>">Szállítás</a>
            <a class="list-group-item list-group-item-action" href="<?php echo e(route('package')); ?>">Csomag tartalma</a>
            <a class="list-group-item list-group-item-action" href="<?php echo e(route('reviews.index')); ?>">Vélemények</a>
            <a class="list-group-item list-group-item-action" href="<?php echo e(route('contact')); ?>">Kapcsolat</a>
            <a class="list-group-item list-group-item-action" href="<?php echo e(route('cart.index')); ?>">Kosár</a>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="cartDrawerLabel"><i class="bi bi-cart3 me-2"></i>Kosár</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0" id="cartDrawerBody" data-cart-drawer-body>
        <?php echo $__env->make('partials.cart-drawer', ['cartData' => $cartSummary ?? ['items' => [], 'count' => 0, 'subtotal' => 0, 'shipping_fee' => 0, 'total' => 0]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/partials/header.blade.php ENDPATH**/ ?>