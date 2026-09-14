
<?php $__env->startSection('title', 'Kapcsolat | Radiátor Outlet Budapest - Soroksár'); ?>
<?php $__env->startSection('meta_description', 'Kapcsolat: Radiátor Outlet Budapest, személyes átvétel Soroksáron (XXIII.), telefon 06 20 466 2774.'); ?>
<?php $__env->startSection('canonical', route('contact')); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Főoldal</a></li>
            <li class="breadcrumb-item active">Kapcsolat</li>
        </ol>
    </nav>
    <h1 class="section-title">Kapcsolat</h1>
    <p class="section-sub">Kérdése van? Keressen minket bizalommal.</p>
    <div class="row g-4">
        <div class="col-md-7">
            <div class="admin-card h-100">
                <div class="contact-list-item">
                    <span class="contact-ico"><i class="fa-solid fa-location-dot"></i></span>
                    <div>
                        <strong>Személyes átvétel</strong>
                        <p class="mb-0 text-muted"><?php echo e($pickupAddress ?? 'Budapest XXIII. kerület, Soroksár'); ?></p>
                    </div>
                </div>
                <div class="contact-list-item">
                    <span class="contact-ico"><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <strong>Telefonszám</strong>
                        <p class="mb-0"><a href="tel:<?php echo e(preg_replace('/\s+/', '', $phoneDisplay ?? $shopPhoneDisplay)); ?>"><?php echo e($phoneDisplay ?? $shopPhoneDisplay); ?></a></p>
                    </div>
                </div>
                <div class="contact-list-item mb-3">
                    <span class="contact-ico"><i class="fa-solid fa-clock"></i></span>
                    <div>
                        <strong>Nyitvatartás</strong>
                        <p class="mb-0 text-muted"><?php echo e($openingHours ?? 'előzetes telefonos egyeztetés alapján'); ?></p>
                    </div>
                </div>
                <a class="btn-primary-shop w-100" href="tel:<?php echo e(preg_replace('/\s+/', '', $phoneDisplay ?? $shopPhoneDisplay)); ?>">
                    <i class="fa-solid fa-phone"></i> Hívás indítása: <?php echo e($phoneDisplay ?? $shopPhoneDisplay); ?>

                </a>
            </div>
        </div>
        <div class="col-md-5">
            <div class="sidebar-box h-100">
                <p class="mb-2 fw-bold text-navy"><i class="fa-solid fa-truck text-primary me-1"></i> Kiszállítás csak Budapesten</p>
                <p class="mb-3 text-muted">A kiszállítás díja <?php echo e(number_format($shippingFee ?? $shopShippingFee ?? 2500, 0, ',', '.')); ?> Ft. Vidéki kiszállítás jelenleg nem elérhető.</p>
                <a href="<?php echo e(route('shipping')); ?>" class="btn-outline-shop">Szállítás részletei</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/pages/contact.blade.php ENDPATH**/ ?>