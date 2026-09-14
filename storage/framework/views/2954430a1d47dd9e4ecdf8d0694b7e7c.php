

<?php $__env->startSection('title', \App\Models\SiteSetting::getValue('seo_title') ?? 'Radiátor Outlet Budapest | 22K panelradiátorok raktárról'); ?>
<?php $__env->startSection('meta_description', \App\Models\SiteSetting::getValue('seo_description') ?? 'Új 22K acéllemez panelradiátorok Budapesten, raktárról.'); ?>
<?php $__env->startSection('meta_keywords', '22K radiátor Budapest, panelradiátor Budapest, radiátor kiszállítás Budapest'); ?>
<?php $__env->startSection('canonical', url('/')); ?>

<?php $__env->startSection('content'); ?>
<section class="hero">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="hero-kicker">Új 22K radiátorok raktárról</div>
                <h1><?php echo e($heroTitle); ?></h1>
                <p class="hero-lead"><?php echo e($heroText); ?></p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="<?php echo e(route('products.index')); ?>" class="btn-primary-shop">Radiátorok / Árak</a>
                    <a href="<?php echo e(route('shipping')); ?>" class="btn-outline-shop">Szállítás részletei</a>
                </div>
                <a href="<?php echo e(route('shipping')); ?>" class="shipping-banner">
                    <i class="fa-solid fa-truck"></i>
                    Kiszállítás Budapest teljes területén – <?php echo e(number_format($shippingFee, 0, ',', '.')); ?> Ft →
                </a>
                <div class="usp-strip">
                    <div class="row g-3">
                        <div class="col-6 col-md-3"><div class="usp-item"><i class="fa-solid fa-shield-halved"></i><span>Új 22K radiátorok</span></div></div>
                        <div class="col-6 col-md-3"><div class="usp-item"><i class="fa-solid fa-bolt"></i><span>Gyors ügyintézés</span></div></div>
                        <div class="col-6 col-md-3"><div class="usp-item"><i class="fa-solid fa-tags"></i><span>Átlátható árak</span></div></div>
                        <div class="col-6 col-md-3"><div class="usp-item"><i class="fa-solid fa-truck"></i><span>Csak Budapest</span></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-media">
                    <img src="<?php echo e(asset('images/hero/hero-radiator.jpg')); ?>" alt="Fehér panelradiátor modern lakásban" width="800" height="560">
                    <div class="hero-caption">Meleg otthonokért Budapesten</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
            <div>
                <h2 class="section-title">Kiemelt radiátorok</h2>
                <p class="section-sub mb-0"><?php echo e($productCount); ?> méret raktárról. Minden terméknek külön oldala van.</p>
            </div>
            <a href="<?php echo e(route('products.index')); ?>">Összes radiátor →</a>
        </div>
        <div class="row g-3 g-md-4">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-4">
                    <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo e(route('products.index')); ?>" class="btn-primary-shop">Teljes árlista megnyitása</a>
        </div>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4">
                <a href="<?php echo e(route('shipping')); ?>" class="admin-card d-block h-100 text-decoration-none">
                    <i class="fa-solid fa-truck fs-3 text-primary"></i>
                    <h3 class="h5 fw-bold mt-2 text-dark">Szállítás</h3>
                    <p class="text-muted mb-0">Budapest: <?php echo e(number_format($shippingFee, 0, ',', '.')); ?> Ft / rendelés</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo e(route('package')); ?>" class="admin-card d-block h-100 text-decoration-none">
                    <i class="fa-solid fa-box-open fs-3 text-primary"></i>
                    <h3 class="h5 fw-bold mt-2 text-dark">Csomag tartalma</h3>
                    <p class="text-muted mb-0">Konzolok, szelepek, tömítők, csavarok</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo e(route('contact')); ?>" class="admin-card d-block h-100 text-decoration-none">
                    <i class="fa-solid fa-location-dot fs-3 text-primary"></i>
                    <h3 class="h5 fw-bold mt-2 text-dark">Kapcsolat / átvétel</h3>
                    <p class="text-muted mb-0"><?php echo e($pickupAddress); ?></p>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:var(--bg-soft)">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
            <div>
                <h2 class="section-title">Vélemények</h2>
                <p class="section-sub mb-0">
                    <?php if(($reviewStats['count'] ?? 0) > 0): ?>
                        Átlag <?php echo e($reviewStats['average']); ?>/5, <?php echo e($reviewStats['count']); ?> értékelés
                    <?php endif; ?>
                </p>
            </div>
            <a href="<?php echo e(route('reviews.index')); ?>">Összes vélemény →</a>
        </div>
        <div class="row g-3">
            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-3">
                    <article class="review-card">
                        <div class="stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="<?php echo e($i <= $review->rating ? 'fa-solid' : 'fa-regular'); ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="review-text">„<?php echo e(\Illuminate\Support\Str::limit($review->content, 120)); ?>”</p>
                        <div class="review-author">
                            <?php echo e($review->author_name); ?><?php if($review->author_city): ?>, <?php echo e($review->author_city); ?><?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->startPush('head'); ?>
<script type="application/ld+json">
<?php echo app(\App\Services\SeoService::class)->encode($faqSchema); ?>

</script>
<script type="application/ld+json">
<?php echo app(\App\Services\SeoService::class)->encode($itemListSchema); ?>

</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/home.blade.php ENDPATH**/ ?>