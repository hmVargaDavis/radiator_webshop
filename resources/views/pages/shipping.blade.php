@extends('layouts.app')
@section('title', 'Radiátor kiszállítás Budapest | 2.500 Ft / rendelés')
@section('meta_description', 'Kiszállítás Budapest teljes területén 2.500 Ft / rendelés. Vidéki kiszállítás jelenleg nincs. Radiátor Outlet Budapest, átvétel Soroksáron.')
@section('meta_keywords', 'radiátor szállítás Budapest, radiátor házhozszállítás, budapesti radiátor kiszállítás')
@section('canonical', route('shipping'))
@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Főoldal</a></li>
            <li class="breadcrumb-item active">Szállítás</li>
        </ol>
    </nav>
    <h1 class="section-title">Szállítás Budapesten</h1>
    <div class="shipping-banner d-inline-flex mb-3"><i class="fa-solid fa-truck"></i> Kiszállítás Budapest teljes területén – {{ number_format($shippingFee ?? $shopShippingFee ?? 2500, 0, ',', '.') }} Ft / rendelés.</div>
    <p class="fw-semibold text-danger">Vidéki kiszállítás jelenleg nincs.</p>
    <p class="text-muted">A szállítási díjat a kosár végösszegéhez automatikusan hozzáadjuk. Egy rendelésen belül több radiátor esetén is egyszer számítjuk fel. Budapest I-XXIII. kerületében elérhető.</p>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="admin-card h-100">
                <h2 class="h5 fw-bold">Budapesti kiszállítás</h2>
                <ul class="mb-0">
                    <li>Terület: Budapest teljes területe</li>
                    <li>Díj: {{ number_format($shippingFee ?? 2500, 0, ',', '.') }} Ft / rendelés</li>
                    <li>Vidék: jelenleg nem elérhető</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="sidebar-box h-100">
                <h2 class="h5 fw-bold">Személyes átvétel</h2>
                <p class="mb-2">{{ $pickupAddress ?? 'Budapest XXIII. kerület, Soroksár' }}</p>
                <a href="{{ route('contact') }}" class="btn-outline-shop">Kapcsolat oldal</a>
            </div>
        </div>
    </div>
    <a href="{{ route('products.index') }}" class="btn-primary-shop">Radiátorok megtekintése</a>
</div>
@push('head')
<script type="application/ld+json">
{!! app(\App\Services\SeoService::class)->encode($faqSchema ?? app(\App\Services\SeoService::class)->faqSchema()) !!}
</script>
@endpush
@endsection
