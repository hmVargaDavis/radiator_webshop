@if(($cartData['count'] ?? 0) < 1)
    <div class="p-4 text-center">
        <i class="bi bi-cart3 fs-1 text-muted"></i>
        <p class="mt-2 mb-3 text-muted">A kosár üres.</p>
        <a href="{{ route('products.index') }}" class="btn-primary-shop" data-bs-dismiss="offcanvas">Radiátorok megtekintése</a>
    </div>
@else
    <div class="p-3 d-flex flex-column gap-3" style="min-height:100%">
        @foreach($cartData['items'] as $row)
            <div class="d-flex gap-2 align-items-start border-bottom pb-3">
                <img src="{{ $row['product']->image_url }}" alt="" width="64" height="52" style="object-fit:cover;border-radius:8px">
                <div class="flex-grow-1">
                    <a href="{{ route('products.show', $row['product']) }}" class="fw-bold d-block">{{ $row['product']->size_label }}</a>
                    <div class="small text-muted">{{ number_format($row['unit_price'], 0, ',', '.') }} Ft/db</div>
                    <div class="d-flex align-items-center gap-2 mt-2">
                        <div class="qty-control qty-control-sm" data-ajax-qty data-product-id="{{ $row['product']->id }}">
                            <button type="button" data-qty-minus aria-label="Csökkentés">−</button>
                            <select data-qty-select data-value="{{ $row['quantity'] }}" aria-label="Darabszám"></select>
                            <button type="button" data-qty-plus aria-label="Növelés">+</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-ajax-remove="{{ $row['product']->id }}">Törlés</button>
                    </div>
                </div>
                <strong>{{ number_format($row['line_total'], 0, ',', '.') }} Ft</strong>
            </div>
        @endforeach

        <div class="mt-auto pt-2">
            <div class="d-flex justify-content-between mb-1"><span>Részösszeg</span><span>{{ number_format($cartData['subtotal'], 0, ',', '.') }} Ft</span></div>
            <div class="d-flex justify-content-between mb-1"><span>Szállítás</span><span>{{ number_format($cartData['shipping_fee'], 0, ',', '.') }} Ft</span></div>
            <div class="d-flex justify-content-between fw-bold fs-5 mb-3"><span>Végösszeg</span><span class="text-primary">{{ number_format($cartData['total'], 0, ',', '.') }} Ft</span></div>
            <a href="{{ route('cart.index') }}" class="btn-outline-shop w-100 mb-2 text-center">Kosár oldal</a>
            <a href="{{ route('checkout.show') }}" class="btn-primary-shop w-100">Megrendelés</a>
        </div>
    </div>
@endif
