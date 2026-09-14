@extends('layouts.app')
@section('title', 'Kapcsolat | Radiátor Outlet Budapest - Soroksár')
@section('meta_description', 'Kapcsolat: Radiátor Outlet Budapest, személyes átvétel Soroksáron (XXIII.), telefon 06 20 466 2774.')
@section('canonical', route('contact'))
@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Főoldal</a></li>
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
                        <p class="mb-0 text-muted">{{ $pickupAddress ?? 'Budapest XXIII. kerület, Soroksár' }}</p>
                    </div>
                </div>
                <div class="contact-list-item">
                    <span class="contact-ico"><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <strong>Telefonszám</strong>
                        <p class="mb-0"><a href="tel:{{ preg_replace('/\s+/', '', $phoneDisplay ?? $shopPhoneDisplay) }}">{{ $phoneDisplay ?? $shopPhoneDisplay }}</a></p>
                    </div>
                </div>
                <div class="contact-list-item mb-3">
                    <span class="contact-ico"><i class="fa-solid fa-clock"></i></span>
                    <div>
                        <strong>Nyitvatartás</strong>
                        <p class="mb-0 text-muted">{{ $openingHours ?? 'előzetes telefonos egyeztetés alapján' }}</p>
                    </div>
                </div>
                <a class="btn-primary-shop w-100" href="tel:{{ preg_replace('/\s+/', '', $phoneDisplay ?? $shopPhoneDisplay) }}">
                    <i class="fa-solid fa-phone"></i> Hívás indítása: {{ $phoneDisplay ?? $shopPhoneDisplay }}
                </a>
            </div>
        </div>
        <div class="col-md-5">
            <div class="sidebar-box h-100">
                <p class="mb-2 fw-bold text-navy"><i class="fa-solid fa-truck text-primary me-1"></i> Kiszállítás csak Budapesten</p>
                <p class="mb-3 text-muted">A kiszállítás díja {{ number_format($shippingFee ?? $shopShippingFee ?? 2500, 0, ',', '.') }} Ft. Vidéki kiszállítás jelenleg nem elérhető.</p>
                <a href="{{ route('shipping') }}" class="btn-outline-shop">Szállítás részletei</a>
            </div>
        </div>
    </div>
</div>
@endsection
