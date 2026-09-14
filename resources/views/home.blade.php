@extends('layouts.app')

@section('title', \App\Models\SiteSetting::getValue('seo_title') ?? 'Radiátor Outlet Budapest | 22K panelradiátorok raktárról')
@section('meta_description', \App\Models\SiteSetting::getValue('seo_description') ?? 'Új 22K acéllemez panelradiátorok Budapesten, raktárról.')
@section('meta_keywords', '22K radiátor Budapest, panelradiátor Budapest, radiátor kiszállítás Budapest')
@section('canonical', url('/'))

@section('content')
<section class="hero">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="hero-kicker">Új 22K radiátorok raktárról</div>
                <h1>{{ $heroTitle }}</h1>
                <p class="hero-lead">{{ $heroText }}</p>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('products.index') }}" class="btn-primary-shop">Radiátorok / Árak</a>
                    <a href="{{ route('shipping') }}" class="btn-outline-shop">Szállítás részletei</a>
                </div>
                <a href="{{ route('shipping') }}" class="shipping-banner">
                    <i class="bi bi-truck"></i>
                    Kiszállítás Budapest teljes területén – {{ number_format($shippingFee, 0, ',', '.') }} Ft →
                </a>
                <div class="usp-strip">
                    <div class="row g-3">
                        <div class="col-6 col-md-3"><div class="usp-item"><i class="bi bi-shield-check"></i><span>Új 22K radiátorok</span></div></div>
                        <div class="col-6 col-md-3"><div class="usp-item"><i class="bi bi-lightning-charge"></i><span>Gyors ügyintézés</span></div></div>
                        <div class="col-6 col-md-3"><div class="usp-item"><i class="bi bi-tag"></i><span>Átlátható árak</span></div></div>
                        <div class="col-6 col-md-3"><div class="usp-item"><i class="bi bi-truck"></i><span>Csak Budapest</span></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-media">
                    <img src="{{ asset('images/hero/hero-radiator.jpg') }}" alt="Fehér panelradiátor modern lakásban" width="800" height="560">
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
                <p class="section-sub mb-0">{{ $productCount }} méret raktárról. Minden terméknek külön oldala van.</p>
            </div>
            <a href="{{ route('products.index') }}">Összes radiátor →</a>
        </div>
        <div class="row g-3 g-md-4">
            @foreach($products as $product)
                <div class="col-6 col-md-4">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn-primary-shop">Teljes árlista megnyitása</a>
        </div>
    </div>
</section>

<section class="section pt-0">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('shipping') }}" class="admin-card d-block h-100 text-decoration-none">
                    <i class="bi bi-truck fs-3 text-primary"></i>
                    <h3 class="h5 fw-bold mt-2 text-dark">Szállítás</h3>
                    <p class="text-muted mb-0">Budapest: {{ number_format($shippingFee, 0, ',', '.') }} Ft / rendelés</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('package') }}" class="admin-card d-block h-100 text-decoration-none">
                    <i class="bi bi-box-seam fs-3 text-primary"></i>
                    <h3 class="h5 fw-bold mt-2 text-dark">Csomag tartalma</h3>
                    <p class="text-muted mb-0">Konzolok, szelepek, tömítők, csavarok</p>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('contact') }}" class="admin-card d-block h-100 text-decoration-none">
                    <i class="bi bi-geo-alt fs-3 text-primary"></i>
                    <h3 class="h5 fw-bold mt-2 text-dark">Kapcsolat / átvétel</h3>
                    <p class="text-muted mb-0">{{ $pickupAddress }}</p>
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
                    @if(($reviewStats['count'] ?? 0) > 0)
                        Átlag {{ $reviewStats['average'] }}/5, {{ $reviewStats['count'] }} értékelés
                    @endif
                </p>
            </div>
            <a href="{{ route('reviews.index') }}">Összes vélemény →</a>
        </div>
        <div class="row g-3">
            @foreach($reviews as $review)
                <div class="col-md-6 col-lg-3">
                    <article class="review-card">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                        <p class="review-text">„{{ \Illuminate\Support\Str::limit($review->content, 120) }}”</p>
                        <div class="review-author">
                            {{ $review->author_name }}@if($review->author_city), {{ $review->author_city }}@endif
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('head')
<script type="application/ld+json">
{!! app(\App\Services\SeoService::class)->encode($faqSchema) !!}
</script>
<script type="application/ld+json">
{!! app(\App\Services\SeoService::class)->encode($itemListSchema) !!}
</script>
@endpush
@endsection
