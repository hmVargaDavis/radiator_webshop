<footer class="site-footer" id="kapcsolat-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="brand-lockup mb-2">
                    <span class="brand-mark">
                        <i class="fa-solid fa-temperature-high"></i>
                    </span>
                    <span>
                        <p class="brand-title">Radiátor Outlet Budapest</p>
                        <p class="brand-tag">Minőség. Jó árak. Budapesten.</p>
                    </span>
                </div>
                <p class="text-muted mb-0">Új 22K panelradiátorok raktárról, budapesti kiszállítással és személyes átvétellel Soroksáron.</p>
            </div>
            <div class="col-6 col-md-2">
                <h6 class="fw-bold text-navy">Menü</h6>
                <div class="d-flex flex-column gap-1">
                    <a href="{{ route('home') }}">Főoldal</a>
                    <a href="{{ route('products.index') }}">Radiátorok</a>
                    <a href="{{ route('shipping') }}">Szállítás</a>
                    <a href="{{ route('package') }}">Csomag</a>
                    <a href="{{ route('reviews.index') }}">Vélemények</a>
                    <a href="{{ route('contact') }}">Kapcsolat</a>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="fw-bold">Szállítás</h6>
                <p class="mb-1"><i class="fa-solid fa-truck text-primary me-1"></i> Budapest: {{ number_format($shopShippingFee ?? 2500, 0, ',', '.') }} Ft / rendelés</p>
                <p class="mb-0 text-muted">Vidéki kiszállítás jelenleg nincs.</p>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold">Kapcsolat</h6>
                <p class="mb-1"><i class="fa-solid fa-location-dot text-primary me-1"></i> {{ \App\Models\SiteSetting::getValue('pickup_address') ?? 'Budapest XXIII. kerület, Soroksár' }}</p>
                <p class="mb-1"><i class="fa-solid fa-phone text-primary me-1"></i> <a href="tel:{{ preg_replace('/\s+/', '', $shopPhoneDisplay ?? '') }}">{{ $shopPhoneDisplay }}</a></p>
                <p class="mb-0 text-muted"><i class="fa-solid fa-clock text-primary me-1"></i> {{ \App\Models\SiteSetting::getValue('opening_hours') ?? 'előzetes telefonos egyeztetés alapján' }}</p>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
            <span>© {{ date('Y') }} Radiátor Outlet Budapest. Minden jog fenntartva.</span>
            <a href="{{ route('privacy') }}">Adatkezelés</a>
        </div>
    </div>
</footer>
