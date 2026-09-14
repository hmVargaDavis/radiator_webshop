

<?php $__env->startSection('title', \App\Models\SiteSetting::getValue('seo_title') ?? 'Radiátor Outlet Budapest | 22K panelradiátorok raktárról'); ?>
<?php $__env->startSection('meta_description', \App\Models\SiteSetting::getValue('seo_description') ?? 'Új 22K acéllemez panelradiátorok Budapesten, raktárról.'); ?>
<?php $__env->startSection('meta_keywords', '22K radiátor Budapest, panelradiátor Budapest, radiátor kiszállítás Budapest'); ?>
<?php $__env->startSection('canonical', url('/')); ?>

<?php $__env->startSection('content'); ?>
<section class="hero">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="hero-kicker">Új 22K radiátorok raktárról</div>
                <h1><?php echo e($heroTitle); ?></h1>
                <p class="hero-lead"><?php echo e($heroText); ?></p>

                <a href="<?php echo e(route('shipping')); ?>" class="shipping-banner d-none d-lg-inline-flex">
                    <i class="fa-solid fa-truck"></i>
                    Kiszállítás Budapest teljes területén – <?php echo e(number_format($shippingFee, 0, ',', '.')); ?> Ft →
                </a>

                <div class="usp-strip d-none d-lg-block">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="usp-item"><i class="fa-solid fa-shield-halved"></i><span>Új 22K radiátorok</span></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="usp-item"><i class="fa-solid fa-bolt"></i><span>Gyors ügyintézés</span></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="usp-item"><i class="fa-solid fa-tags"></i><span>Átlátható árak</span></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="usp-item"><i class="fa-solid fa-truck"></i><span>Csak Budapest</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="hero-media">
                    <img src="<?php echo e(asset('images/hero/hero-radiator.jpg')); ?>" alt="Fehér panelradiátor modern lakásban" width="800" height="560">
                    <div class="hero-caption">Meleg otthonokért Budapesten</div>
                </div>
            </div>
        </div>
    </div>
</section>

<a href="<?php echo e(route('shipping')); ?>" class="shipping-banner shipping-banner-full d-lg-none">
    <i class="fa-solid fa-truck"></i>
    Kiszállítás Budapest teljes területén – <?php echo e(number_format($shippingFee, 0, ',', '.')); ?> Ft →
</a>

<div class="container d-lg-none mb-4">
    <div class="usp-strip">
        <div class="row g-3">
            <div class="col-6">
                <div class="usp-item"><i class="fa-solid fa-shield-halved"></i><span>Új 22K radiátorok azonnal elérhetők</span></div>
            </div>
            <div class="col-6">
                <div class="usp-item"><i class="fa-solid fa-bolt"></i><span>Gyors ügyintézés</span></div>
            </div>
            <div class="col-6">
                <div class="usp-item"><i class="fa-solid fa-tags"></i><span>Kiváló ár-érték arány</span></div>
            </div>
            <div class="col-6">
                <div class="usp-item"><i class="fa-solid fa-truck"></i><span>Csak Budapesten szállítunk</span></div>
            </div>
        </div>
    </div>
</div>

<section class="section pt-2" id="radiatorok">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
            <div>
                <h2 class="section-title">Radiátorok és árak</h2>
                <p class="section-sub mb-0"><?php echo e($productCount); ?> méret raktárról. Minden terméknek külön oldala van.</p>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="section-link">Összes termék →</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-9">
                <div class="row g-3 home-product-grid">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-md-4 home-product-col">
                            <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-center mt-4 d-lg-none">
                    <a href="<?php echo e(route('products.index')); ?>" class="btn-primary-shop">Teljes árlista</a>
                </div>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                <aside class="order-aside sticky-top" style="top:5.5rem">
                    <h3>Rendelésre kész?</h3>
                    <a href="<?php echo e(route('cart.index')); ?>" class="btn-primary-shop w-100 mb-3">Kosár megtekintése →</a>
                    <ol class="order-steps">
                        <li>Válassza ki a radiátor méretét és darabszámát.</li>
                        <li>Adja meg a budapesti szállítási adatokat.</li>
                        <li>Visszaigazoljuk a rendelést telefonon vagy e-mailben.</li>
                    </ol>
                </aside>
            </div>
        </div>
    </div>
</section>

<section class="section pt-0" id="csomag">
    <div class="container">
        <div class="package-box">
            <div class="row g-3 align-items-center">
                <div class="col-lg-4">
                    <div class="d-flex align-items-start gap-3">
                        <i class="fa-solid fa-box-open fa-2x text-primary mt-1"></i>
                        <div>
                            <h2 class="section-title h4 mb-2">A csomagolás tartalma</h2>
                            <p class="text-muted mb-0">Minden radiátorhoz biztosítjuk az alap szerelvényeket a biztonságos felszereléshez.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="package-item">
                                <div class="package-icon"><img src="<?php echo e(asset('images/package/bracket.jpg')); ?>" alt="Fali konzolok"></div>
                                <strong class="small">Fali konzolok / rögzítők</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="package-item">
                                <div class="package-icon"><img src="<?php echo e(asset('images/package/valve.jpg')); ?>" alt="Szelepek"></div>
                                <strong class="small">Szelepek / idomok</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="package-item">
                                <div class="package-icon"><img src="<?php echo e(asset('images/package/seal.jpg')); ?>" alt="Tömítők"></div>
                                <strong class="small">Tömítő elemek</strong>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="package-item">
                                <div class="package-icon"><img src="<?php echo e(asset('images/package/screws.jpg')); ?>" alt="Csavarok"></div>
                                <strong class="small">Rögzítő csavarok</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:var(--bg-soft)" id="velemenyek">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
            <div>
                <h2 class="section-title">Vásárlói vélemények</h2>
                <p class="section-sub mb-0">
                    <?php if(($reviewStats['count'] ?? 0) > 0): ?>
                        Átlag <?php echo e($reviewStats['average']); ?>/5 · <?php echo e($reviewStats['count']); ?> értékelés
                    <?php endif; ?>
                </p>
            </div>
            <a href="<?php echo e(route('reviews.index')); ?>" class="section-link">Összes vélemény →</a>
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