
<?php $__env->startSection('title', 'Radiátor kiszállítás Budapest | 2.500 Ft / rendelés'); ?>
<?php $__env->startSection('meta_description', 'Kiszállítás Budapest teljes területén 2.500 Ft / rendelés. Vidéki kiszállítás jelenleg nincs. Radiátor Outlet Budapest, átvétel Soroksáron.'); ?>
<?php $__env->startSection('meta_keywords', 'radiátor szállítás Budapest, radiátor házhozszállítás, budapesti radiátor kiszállítás'); ?>
<?php $__env->startSection('canonical', route('shipping')); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Főoldal</a></li>
            <li class="breadcrumb-item active">Szállítás</li>
        </ol>
    </nav>
    <h1 class="section-title">Szállítás Budapesten</h1>
    <div class="shipping-banner d-inline-flex mb-3"><i class="fa-solid fa-truck"></i> Kiszállítás Budapest teljes területén – <?php echo e(number_format($shippingFee ?? $shopShippingFee ?? 2500, 0, ',', '.')); ?> Ft / rendelés.</div>
    <p class="fw-semibold text-danger">Vidéki kiszállítás jelenleg nincs.</p>
    <p class="text-muted">A szállítási díjat a kosár végösszegéhez automatikusan hozzáadjuk. Egy rendelésen belül több radiátor esetén is egyszer számítjuk fel. Budapest I-XXIII. kerületében elérhető.</p>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="admin-card h-100">
                <h2 class="h5 fw-bold">Budapesti kiszállítás</h2>
                <ul class="mb-0">
                    <li>Terület: Budapest teljes területe</li>
                    <li>Díj: <?php echo e(number_format($shippingFee ?? 2500, 0, ',', '.')); ?> Ft / rendelés</li>
                    <li>Vidék: jelenleg nem elérhető</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="sidebar-box h-100">
                <h2 class="h5 fw-bold">Személyes átvétel</h2>
                <p class="mb-2"><?php echo e($pickupAddress ?? 'Budapest XXIII. kerület, Soroksár'); ?></p>
                <a href="<?php echo e(route('contact')); ?>" class="btn-outline-shop">Kapcsolat oldal</a>
            </div>
        </div>
    </div>
    <a href="<?php echo e(route('products.index')); ?>" class="btn-primary-shop">Radiátorok megtekintése</a>
</div>
<?php $__env->startPush('head'); ?>
<script type="application/ld+json">
<?php echo app(\App\Services\SeoService::class)->encode($faqSchema ?? app(\App\Services\SeoService::class)->faqSchema()); ?>

</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/pages/shipping.blade.php ENDPATH**/ ?>