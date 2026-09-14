@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name.' | Radiátor Outlet Budapest')
@section('meta_description', $product->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($product->ai_description ?: $product->short_description), 155))
@section('meta_keywords', $product->keywords ?: implode(', ', app(\App\Services\SeoService::class)->defaultKeywords($product)))
@section('og_image', $product->og_image_url)
@section('og_type', 'product')
@section('canonical', route('products.show', $product))
@section('product_json', route('products.json', $product))

@section('content')
<div class="container py-3">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="{{ route('home') }}"><span itemprop="name">Főoldal</span></a>
                <meta itemprop="position" content="1">
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="{{ route('products.index') }}"><span itemprop="name">Radiátorok és árak</span></a>
                <meta itemprop="position" content="2">
            </li>
            <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">{{ $product->size_label }}</span>
                <meta itemprop="position" content="3">
            </li>
        </ol>
    </nav>

    <article itemscope itemtype="https://schema.org/Product">
        <meta itemprop="sku" content="{{ $product->sku }}">
        <meta itemprop="mpn" content="{{ $product->sku }}">
        <link itemprop="image" href="{{ $product->image_url }}">

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="hero-media">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }} - 22K panelradiátor Budapest" width="800" height="600" itemprop="image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-kicker">Új 22K acéllemez panelradiátor · Budapest</div>
                <h1 class="section-title" itemprop="name">{{ $product->name }}</h1>
                <p class="text-muted" itemprop="description">{{ $product->short_description }}</p>
                <div class="product-price mb-3" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                    <meta itemprop="priceCurrency" content="HUF">
                    <meta itemprop="price" content="{{ $product->price }}">
                    <link itemprop="availability" href="{{ $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}">
                    <link itemprop="itemCondition" href="https://schema.org/NewCondition">
                    <meta itemprop="url" content="{{ route('products.show', $product) }}">
                    {{ $product->formatted_price }}/db
                </div>

                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><strong>Méret:</strong> {{ $product->size_label }}</li>
                    <li class="mb-2"><strong>Típus:</strong> Új 22K panelradiátor</li>
                    <li class="mb-2"><strong>Elérhetőség:</strong> {{ $product->in_stock ? 'Raktáron ('.$product->stock.' db), Budapest' : 'Jelenleg nem elérhető' }}</li>
                    <li class="mb-2"><strong>Személyes átvétel:</strong> {{ $pickupAddress }}</li>
                    <li class="mb-2"><strong>Budapesti kiszállítás:</strong> {{ number_format($shippingFee, 0, ',', '.') }} Ft / rendelés</li>
                    <li class="mb-2"><strong>Szolgáltatási terület:</strong> Budapest (vidéki kiszállítás nincs)</li>
                </ul>

                <form action="{{ route('cart.add') }}" method="post" data-add-to-cart class="d-flex flex-wrap gap-2 align-items-center mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @include('partials.qty')
                    <button type="submit" class="btn-primary-shop">
                        <i class="bi bi-cart3"></i> Kosárba
                    </button>
                </form>

                <div class="package-box">
                    <h2 class="h5 fw-bold">A csomag tartalmazza</h2>
                    <ul class="mb-0">
                        @foreach(preg_split("/\r\n|\n|\r/", $product->package_contents ?? '') as $line)
                            @if(trim($line) !== '')
                                <li>{{ trim($line) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="admin-card">
                    <h2 class="h4 fw-bold mb-3">Termékleírás</h2>
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar-box">
                    <h2 class="h5 fw-bold">Budapest GEO adatok</h2>
                    <p class="mb-2 small text-muted mb-0">Helyi kereséshez és AI/crawler olvasáshoz:</p>
                    <ul class="small mb-3">
                        <li>Város: Budapest</li>
                        <li>Átvétel: Soroksár (XXIII.)</li>
                        <li>Szállítás: Budapest összes kerülete</li>
                        <li>Szállítási díj: {{ number_format($shippingFee, 0, ',', '.') }} Ft</li>
                    </ul>
                    <a class="small" href="{{ route('products.json', $product) }}" rel="alternate" type="application/json">Termék JSON (AI) →</a>
                </div>
            </div>
        </div>
    </article>

    @if($related->count())
        <div class="mt-5">
            <h2 class="section-title h4">További méretek Budapesten</h2>
            <div class="row g-3">
                @foreach($related as $item)
                    <div class="col-6 col-md-3">
                        @include('partials.product-card', ['product' => $item])
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('head')
<script type="application/ld+json">
{!! app(\App\Services\SeoService::class)->encode($productSchema) !!}
</script>
<script type="application/ld+json">
{!! app(\App\Services\SeoService::class)->encode($breadcrumbSchema) !!}
</script>
<script type="application/ld+json" id="product-ai-json">
{!! app(\App\Services\SeoService::class)->encode($aiPayload) !!}
</script>
@endpush
@endsection
