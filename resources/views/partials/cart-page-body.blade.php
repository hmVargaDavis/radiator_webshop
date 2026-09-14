@if(($cartData['count'] ?? 0) < 1)
    <div class="admin-card">
        <p class="mb-3">A kosár jelenleg üres.</p>
        <a href="{{ route('products.index') }}" class="btn-primary-shop">Radiátorok megtekintése</a>
    </div>
@else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="table-responsive admin-card">
                <table class="table cart-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Radiátor</th>
                            <th>Egységár</th>
                            <th>Darabszám</th>
                            <th>Részösszeg</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($cartData['items'] as $row)
                        <tr>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="{{ $row['product']->image_url }}" alt="" width="64" height="48" style="object-fit:cover;border-radius:6px">
                                    <div>
                                        <a href="{{ route('products.show', $row['product']) }}"><strong>{{ $row['product']->size_label }}</strong></a>
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($row['unit_price'], 0, ',', '.') }} Ft</td>
                            <td style="min-width:160px">
                                <div class="qty-control" data-ajax-qty data-product-id="{{ $row['product']->id }}">
                                    <button type="button" data-qty-minus>−</button>
                                    <select data-qty-select data-value="{{ $row['quantity'] }}"></select>
                                    <button type="button" data-qty-plus>+</button>
                                </div>
                            </td>
                            <td class="fw-bold">{{ number_format($row['line_total'], 0, ',', '.') }} Ft</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-ajax-remove="{{ $row['product']->id }}">Törlés</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="sidebar-box">
                <h2 class="h5 fw-bold">Összesítés</h2>
                <div class="d-flex justify-content-between mb-2">
                    <span>Részösszeg</span>
                    <strong data-cart-subtotal>{{ number_format($cartData['subtotal'], 0, ',', '.') }} Ft</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Szállítási díj (Budapest)</span>
                    <strong data-cart-shipping>{{ number_format($cartData['shipping_fee'], 0, ',', '.') }} Ft</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold">Végösszeg</span>
                    <strong class="fs-5 text-primary" data-cart-total>{{ number_format($cartData['total'], 0, ',', '.') }} Ft</strong>
                </div>
                <p class="small text-muted">Vidéki kiszállítás jelenleg nincs. A szállítási díj rendelésenként egyszer kerül felszámításra.</p>
                <a href="{{ route('checkout.show') }}" class="btn-primary-shop w-100">Megrendelés</a>
            </div>
        </div>
    </div>
@endif
