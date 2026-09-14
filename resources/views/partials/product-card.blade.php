<div class="product-card">
    <a href="{{ route('products.show', $product) }}" class="product-card-img">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" width="400" height="300">
    </a>
    <a href="{{ route('products.show', $product) }}">
        <h3 class="product-size">{{ $product->size_label }}</h3>
    </a>
    <div class="product-price">{{ $product->formatted_price }}/db</div>

    <form action="{{ route('cart.add') }}" method="post" data-add-to-cart class="mt-auto">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
            @include('partials.qty')
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn-primary-shop">
                <i class="fa-solid fa-cart-shopping"></i> Kosárba
            </button>
            <a href="{{ route('products.show', $product) }}" class="btn-outline-shop text-center">Részletek</a>
        </div>
    </form>
</div>
