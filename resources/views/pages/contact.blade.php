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
    <h1 class="section-title">Kapcsolat - Budapest</h1>
    <p class="section-sub">Kérdése van? Keressen minket bizalommal.</p>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="admin-card h-100">
                <p><i class="bi bi-geo-alt text-primary me-2"></i><strong>Személyes átvétel:</strong><br>{{ $pickupAddress ?? 'Budapest XXIII. kerület, Soroksár' }}</p>
                <p><i class="bi bi-telephone text-primary me-2"></i><strong>Telefon:</strong><br>
                    <a href="tel:{{ preg_replace('/\s+/', '', $phoneDisplay ?? $shopPhoneDisplay) }}">{{ $phoneDisplay ?? $shopPhoneDisplay }}</a>
                </p>
                <p><i class="bi bi-clock text-primary me-2"></i><strong>Nyitvatartás:</strong><br>{{ $openingHours ?? 'előzetes telefonos egyeztetés alapján' }}</p>
                <a class="btn-primary-shop" href="tel:{{ preg_replace('/\s+/', '', $phoneDisplay ?? $shopPhoneDisplay) }}"><i class="bi bi-telephone-fill"></i> Hívás</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="sidebar-box h-100">
                <p class="mb-3"><i class="bi bi-truck text-primary me-1"></i> Kiszállítás Budapest teljes területén – {{ number_format($shippingFee ?? $shopShippingFee ?? 2500, 0, ',', '.') }} Ft / rendelés.</p>
                <a href="{{ route('shipping') }}" class="btn-outline-shop">Szállítás részletei</a>
            </div>
        </div>
    </div>
</div>
@endsection
