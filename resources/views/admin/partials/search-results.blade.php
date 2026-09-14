@if(mb_strlen($q) < 2)
    <div class="p-card"><p class="text-muted mb-0">Írjon be legalább 2 karaktert.</p></div>
@else
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="p-card h-100">
                <div class="p-card-title">Termékek</div>
                @forelse($results['products'] as $p)
                    <a class="d-block mb-2" href="{{ route('admin.products.edit', $p) }}" data-spa-link>
                        <strong>{{ $p->size_label }}</strong>
                        <div class="small text-muted">{{ number_format($p->price, 0, ',', '.') }} Ft</div>
                    </a>
                @empty
                    <p class="text-muted small mb-0">Nincs találat.</p>
                @endforelse
            </div>
        </div>
        <div class="col-lg-4">
            <div class="p-card h-100">
                <div class="p-card-title">Rendelések</div>
                @forelse($results['orders'] as $o)
                    <a class="d-block mb-2" href="{{ route('admin.orders.show', $o) }}" data-spa-link>
                        <strong>{{ $o->order_number }}</strong>
                        <div class="small text-muted">{{ $o->customer_name }} · {{ number_format($o->total, 0, ',', '.') }} Ft</div>
                    </a>
                @empty
                    <p class="text-muted small mb-0">Nincs találat.</p>
                @endforelse
            </div>
        </div>
        <div class="col-lg-4">
            <div class="p-card h-100">
                <div class="p-card-title">Vélemények</div>
                @forelse($results['reviews'] as $rev)
                    <a class="d-block mb-2" href="{{ route('admin.reviews.edit', $rev) }}" data-spa-link>
                        <strong>{{ $rev->author_name }}</strong>
                        <div class="small text-muted">{{ \Illuminate\Support\Str::limit($rev->content, 70) }}</div>
                    </a>
                @empty
                    <p class="text-muted small mb-0">Nincs találat.</p>
                @endforelse
            </div>
        </div>
    </div>
@endif
