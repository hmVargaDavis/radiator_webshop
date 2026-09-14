@extends('layouts.app')

@section('title', 'Radiátorok és árak Budapest | 22K panelradiátorok')
@section('meta_description', 'Új 22K panelradiátorok Budapesten, raktárról. Méretek 600×400-tól 600×1400 mm-ig. Szűrhető árlista, külön termékoldalak.')
@section('meta_keywords', 'radiátor árak Budapest, 22K panelradiátor, lapradiátor méretek')
@section('canonical', route('products.index'))

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Főoldal</a></li>
            <li class="breadcrumb-item active">Radiátorok és árak</li>
        </ol>
    </nav>

    <h1 class="section-title">Radiátorok és árak</h1>
    <p class="section-sub">Új 22K panelradiátorok raktárról. Kattintson a részletekre a külön termékoldalhoz. A mennyiség 1-50 között állítható.</p>

    <form id="productFilterForm" class="filter-bar admin-card mb-4" action="{{ route('products.index') }}" method="get" data-ajax-filter>
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Keresés</label>
                <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="pl. 600 × 800" autocomplete="off">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Szélesség</label>
                <select name="width" class="form-select">
                    <option value="">Összes</option>
                    @foreach($widths as $w)
                        <option value="{{ $w }}" @selected(($filters['width'] ?? '') == $w)>{{ $w }} mm</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Min. ár</label>
                <input type="number" name="min_price" class="form-control" min="0" step="100" value="{{ $filters['min_price'] ?? '' }}" placeholder="Ft">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Max. ár</label>
                <input type="number" name="max_price" class="form-control" min="0" step="100" value="{{ $filters['max_price'] ?? '' }}" placeholder="Ft">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold">Rendezés</label>
                <select name="sort" class="form-select">
                    <option value="size" @selected(($filters['sort'] ?? '') === 'size')>Méret szerint</option>
                    <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Ár növekvő</option>
                    <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Ár csökkenő</option>
                    <option value="name" @selected(($filters['sort'] ?? '') === 'name')>Név</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn-primary-shop w-100">OK</button>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
            <span class="small text-muted" data-filter-count>{{ $products->count() }} termék</span>
            <button type="button" class="btn btn-link btn-sm" id="resetFilters">Szűrők törlése</button>
        </div>
    </form>

    <div class="usp-strip mb-4">
        <div class="row g-3">
            <div class="col-md-4"><div class="usp-item"><i class="bi bi-shield-check"></i><span>Új 22K radiátorok azonnal elérhetők</span></div></div>
            <div class="col-md-4"><div class="usp-item"><i class="bi bi-lightning-charge"></i><span>Gyors ügyintézés, egyszerű rendelés</span></div></div>
            <div class="col-md-4"><div class="usp-item"><i class="bi bi-tag"></i><span>Kiváló ár-érték arány</span></div></div>
        </div>
    </div>

    <div class="position-relative" id="productsAjaxWrap">
        <div class="ajax-loading d-none" id="productsLoading"><div class="spinner-border text-primary" role="status"></div></div>
        <div class="d-md-none" data-products-mobile>
            @include('partials.product-list-mobile', ['products' => $products])
        </div>
        <div class="d-none d-md-block" data-products-desktop>
            @include('partials.product-grid', ['products' => $products])
        </div>
    </div>
</div>

@push('head')
<script type="application/ld+json">
{!! app(\App\Services\SeoService::class)->encode($itemListSchema) !!}
</script>
<script type="application/ld+json">
{!! app(\App\Services\SeoService::class)->encode($breadcrumbSchema) !!}
</script>
@endpush
@endsection
