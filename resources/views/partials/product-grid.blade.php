<div class="row g-3 g-md-4" id="productGrid">
    @forelse($products as $product)
        <div class="col-6 col-md-4 col-xl-3 product-grid-item" data-product-id="{{ $product->id }}">
            @include('partials.product-card', ['product' => $product])
        </div>
    @empty
        <div class="col-12">
            <div class="admin-card text-center py-5">
                <p class="mb-0 text-muted">Nincs találat a szűrésre. Próbáljon másik méretet vagy árintervallumot.</p>
            </div>
        </div>
    @endforelse
</div>
