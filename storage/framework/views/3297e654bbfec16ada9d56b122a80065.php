<footer class="site-footer" id="kapcsolat-footer">
    <div class="footer-strip">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <i class="fa-solid fa-truck me-2"></i>Budapest: <?php echo e(number_format($shopShippingFee ?? 2500, 0, ',', '.')); ?> Ft / rendelés
                </div>
                <div class="col-md-4">
                    <i class="fa-solid fa-location-dot me-2"></i><?php echo e(\App\Models\SiteSetting::getValue('pickup_address') ?? 'Budapest XXIII. kerület, Soroksár'); ?>

                </div>
                <div class="col-md-4">
                    <i class="fa-solid fa-phone me-2"></i>
                    <a href="tel:<?php echo e(preg_replace('/\s+/', '', $shopPhoneDisplay ?? '')); ?>"><?php echo e($shopPhoneDisplay); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container footer-main">
        <div class="row g-4">
            <div class="col-md-5">
                <div class="brand-lockup mb-2">
                    <span class="brand-mark">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
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
                </div>
                <p class="text-muted mb-0">Új 22K panelradiátorok raktárról, budapesti kiszállítással és személyes átvétellel Soroksáron.</p>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="fw-bold text-navy">Menü</h6>
                <div class="d-flex flex-column gap-1">
                    <a href="<?php echo e(route('home')); ?>">Főoldal</a>
                    <a href="<?php echo e(route('products.index')); ?>">Radiátorok</a>
                    <a href="<?php echo e(route('shipping')); ?>">Szállítás</a>
                    <a href="<?php echo e(route('package')); ?>">Csomag</a>
                    <a href="<?php echo e(route('reviews.index')); ?>">Vélemények</a>
                    <a href="<?php echo e(route('contact')); ?>">Kapcsolat</a>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <h6 class="fw-bold text-navy">Kapcsolat</h6>
                <p class="mb-1"><?php echo e(\App\Models\SiteSetting::getValue('pickup_address') ?? 'Budapest XXIII. kerület, Soroksár'); ?></p>
                <p class="mb-1"><a href="tel:<?php echo e(preg_replace('/\s+/', '', $shopPhoneDisplay ?? '')); ?>"><?php echo e($shopPhoneDisplay); ?></a></p>
                <p class="mb-0 text-muted"><?php echo e(\App\Models\SiteSetting::getValue('opening_hours') ?? 'előzetes telefonos egyeztetés alapján'); ?></p>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
            <span>© <?php echo e(date('Y')); ?> Radiátor Outlet Budapest. Minden jog fenntartva.</span>
            <a href="<?php echo e(route('privacy')); ?>">Adatkezelés</a>
        </div>
    </div>
</footer>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/partials/footer.blade.php ENDPATH**/ ?>