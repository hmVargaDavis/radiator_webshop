<nav class="app-bottom-nav d-lg-none" id="appBottomNav" aria-label="Mobil navigáció">
    <a href="<?php echo e(route('home')); ?>" class="app-tab <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
        <i class="bi bi-house-door<?php echo e(request()->routeIs('home') ? '-fill' : ''); ?>"></i>
        <span>Főoldal</span>
    </a>
    <a href="<?php echo e(route('products.index')); ?>" class="app-tab <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">
        <i class="bi bi-grid<?php echo e(request()->routeIs('products.*') ? '-fill' : ''); ?>"></i>
        <span>Radiátorok</span>
    </a>
    <button type="button" class="app-tab app-tab-cart" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer" aria-controls="cartDrawer">
        <span class="app-tab-icon-wrap">
            <i class="bi bi-cart3"></i>
            <span class="cart-badge app-tab-badge <?php echo e(($cartCount ?? 0) ? '' : 'd-none'); ?>" data-cart-count><?php echo e($cartCount ?? 0); ?></span>
        </span>
        <span>Kosár</span>
    </button>
    <a href="<?php echo e(route('reviews.index')); ?>" class="app-tab <?php echo e(request()->routeIs('reviews.*') ? 'active' : ''); ?>">
        <i class="bi bi-star<?php echo e(request()->routeIs('reviews.*') ? '-fill' : ''); ?>"></i>
        <span>Vélemény</span>
    </a>
    <a href="<?php echo e(route('contact')); ?>" class="app-tab <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>">
        <i class="bi bi-telephone<?php echo e(request()->routeIs('contact') ? '-fill' : ''); ?>"></i>
        <span>Kapcsolat</span>
    </a>
</nav>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/partials/bottom-nav.blade.php ENDPATH**/ ?>