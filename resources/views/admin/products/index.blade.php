@extends('layouts.admin')
@section('title', 'Termékek')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
    <p class="text-muted mb-0">Készlet, árak, SEO mezők</p>
    <a href="{{ route('admin.products.create') }}" class="polaris-btn polaris-btn-primary" data-spa-link><i class="bi bi-plus-lg"></i> Termék hozzáadása</a>
</div>
<div class="p-card">
    <div class="table-responsive">
        <table class="p-table p-table-mobile align-middle">
            <thead><tr><th>Termék</th><th>Ár</th><th>Készlet</th><th>Státusz</th><th></th></tr></thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <img src="{{ $product->image_url }}" width="48" height="40" style="object-fit:cover;border-radius:8px" alt="">
                            <div>
                                <strong>{{ $product->size_label }}</strong>
                                <div class="small text-muted">{{ $product->sku }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->formatted_price }}</td>
                    <td><span class="p-badge {{ $product->stock <= 5 ? 'yellow' : 'green' }}">{{ $product->stock }} db</span></td>
                    <td><span class="p-badge {{ $product->is_active ? 'green' : 'red' }}">{{ $product->is_active ? 'Aktív' : 'Inaktív' }}</span></td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin.products.edit', $product) }}" class="polaris-btn polaris-btn-ghost" data-spa-link>Szerkesztés</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="post" class="d-inline" onsubmit="return confirm('Biztosan törli?')">
                            @csrf @method('DELETE')
                            <button class="polaris-btn polaris-btn-ghost" type="submit">Törlés</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
