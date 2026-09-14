<div id="productListMobile">
@forelse($products as $product)
    <div class="product-list-row">
        <a href="{{ route('products.show', $product) }}">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        </a>
        <div>
            <a href="{{ route('products.show', $product) }}"><strong>{{ $product->size_label }}</strong></a>
            <div class="product-price mb-2">{{ $product->formatted_price }}/db</div>
        </div>
        <div class="row-actions">
            <form action="{{ route('cart.add') }}" method="post" data-add-to-cart class="d-flex flex-wrap gap-2 align-items-center">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                @include('partials.qty')
                <button class="btn-primary-shop" type="submit"><i class="bi bi-cart3"></i> Kosárba</button>
                <a href="{{ route('products.show', $product) }}" class="btn-outline-shop">Részletek</a>
            </form>
        </div>
    </div>
@empty
    <div class="admin-card text-center py-4">
        <p class="mb-0 text-muted">Nincs találat.</p>
    </div>
@endforelse
</div>
