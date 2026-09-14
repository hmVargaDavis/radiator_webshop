@extends('layouts.admin')
@section('title', 'Rendelések')
@section('content')
<div class="p-card">
    <div class="table-responsive">
        <table class="p-table p-table-mobile">
            <thead><tr><th>Szám</th><th>Dátum</th><th>Vásárló</th><th>Összeg</th><th>Státusz</th><th></th></tr></thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->created_at->format('Y.m.d H:i') }}</td>
                    <td>{{ $order->customer_name }}<div class="small text-muted">{{ $order->customer_phone }}</div></td>
                    <td>{{ number_format($order->total, 0, ',', '.') }} Ft</td>
                    <td><span class="p-badge">{{ $order->status }}</span></td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="polaris-btn polaris-btn-ghost" data-spa-link>Megnyitás</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted">Nincs rendelés.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
