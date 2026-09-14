

<?php $__env->startSection('title', 'Radiátorok és árak Budapest | 22K panelradiátorok'); ?>
<?php $__env->startSection('meta_description', 'Új 22K panelradiátorok Budapesten, raktárról. Méretek 600×400-tól 600×1400 mm-ig. Szűrhető árlista, külön termékoldalak.'); ?>
<?php $__env->startSection('meta_keywords', 'radiátor árak Budapest, 22K panelradiátor, lapradiátor méretek'); ?>
<?php $__env->startSection('canonical', route('products.index')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Főoldal</a></li>
            <li class="breadcrumb-item active">Radiátorok és árak</li>
        </ol>
    </nav>

    <h1 class="section-title">Radiátorok és árak</h1>
    <p class="section-sub">Új 22K panelradiátorok raktárról, minden méretben. A mennyiség 1 és 50 között állítható.</p>

    <form id="productFilterForm" class="filter-bar admin-card mb-4" action="<?php echo e(route('products.index')); ?>" method="get" data-ajax-filter>
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Keresés</label>
                <input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" class="form-control" placeholder="pl. 600 × 800" autocomplete="off">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Szélesség</label>
                <select name="width" class="form-select">
                    <option value="">Összes</option>
                    <?php $__currentLoopData = $widths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($w); ?>" <?php if(($filters['width'] ?? '') == $w): echo 'selected'; endif; ?>><?php echo e($w); ?> mm</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Min. ár</label>
                <input type="number" name="min_price" class="form-control" min="0" step="100" value="<?php echo e($filters['min_price'] ?? ''); ?>" placeholder="Ft">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Max. ár</label>
                <input type="number" name="max_price" class="form-control" min="0" step="100" value="<?php echo e($filters['max_price'] ?? ''); ?>" placeholder="Ft">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Rendezés</label>
                <select name="sort" class="form-select">
                    <option value="size" <?php if(($filters['sort'] ?? '') === 'size'): echo 'selected'; endif; ?>>Méret szerint</option>
                    <option value="price_asc" <?php if(($filters['sort'] ?? '') === 'price_asc'): echo 'selected'; endif; ?>>Ár növekvő</option>
                    <option value="price_desc" <?php if(($filters['sort'] ?? '') === 'price_desc'): echo 'selected'; endif; ?>>Ár csökkenő</option>
                    <option value="name" <?php if(($filters['sort'] ?? '') === 'name'): echo 'selected'; endif; ?>>Név</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn-primary-shop w-100">OK</button>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
            <span class="small text-muted" data-filter-count><?php echo e($products->count()); ?> termék</span>
            <button type="button" class="btn btn-link btn-sm" id="resetFilters">Szűrők törlése</button>
        </div>
    </form>

    <div class="usp-strip mb-4">
        <div class="row g-3">
            <div class="col-md-4"><div class="usp-item"><i class="fa-solid fa-shield-halved"></i><span>Új 22K radiátorok azonnal elérhetők</span></div></div>
            <div class="col-md-4"><div class="usp-item"><i class="fa-solid fa-bolt"></i><span>Gyors ügyintézés, egyszerű rendelés</span></div></div>
            <div class="col-md-4"><div class="usp-item"><i class="fa-solid fa-tags"></i><span>Kiváló ár-érték arány</span></div></div>
        </div>
    </div>

    <div class="position-relative" id="productsAjaxWrap">
        <div class="ajax-loading d-none" id="productsLoading"><div class="spinner-border text-primary" role="status"></div></div>
        <div class="d-md-none" data-products-mobile>
            <?php echo $__env->make('partials.product-list-mobile', ['products' => $products], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="d-none d-md-block" data-products-desktop>
            <?php echo $__env->make('partials.product-grid', ['products' => $products], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
</div>

<?php $__env->startPush('head'); ?>
<script type="application/ld+json">
<?php echo app(\App\Services\SeoService::class)->encode($itemListSchema); ?>

</script>
<script type="application/ld+json">
<?php echo app(\App\Services\SeoService::class)->encode($breadcrumbSchema); ?>

</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/products/index.blade.php ENDPATH**/ ?>