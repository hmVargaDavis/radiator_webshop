@extends('layouts.admin')
@section('title', 'Rendelés '.$order->order_number)
@section('content')
<h1 class="h3 fw-bold mb-3">Rendelés {{ $order->order_number }}</h1>
<div class="row g-3">
<div class="col-lg-5">
<div class="admin-card">
<p><strong>Név:</strong> {{ $order->customer_name }}</p>
<p><strong>Telefon:</strong> {{ $order->customer_phone }}</p>
<p><strong>E-mail:</strong> {{ $order->customer_email }}</p>
<p><strong>Cím:</strong> {{ $order->shipping_address }}</p>
<p><strong>Megjegyzés:</strong> {{ $order->note ?: '-' }}</p>
<form method="post" action="{{ route('admin.orders.status', $order) }}" class="mt-3">
@csrf
<label class="form-label">Státusz</label>
<select name="status" class="form-select mb-2">
@foreach(['new','processing','shipped','completed','cancelled'] as $st)
<option value="{{ $st }}" @selected($order->status===$st)>{{ $st }}</option>
@endforeach
</select>
<button class="btn-primary-shop" type="submit">Státusz mentése</button>
</form>
</div>
</div>
<div class="col-lg-7">
<div class="admin-card table-responsive">
<table class="table">
<thead><tr><th>Méret</th><th>Db</th><th>Egységár</th><th>Részösszeg</th></tr></thead>
<tbody>
@foreach($order->items as $item)
<tr>
<td>{{ $item->size_label }}</td>
<td>{{ $item->quantity }}</td>
<td>{{ number_format($item->unit_price, 0, ',', '.') }} Ft</td>
<td>{{ number_format($item->line_total, 0, ',', '.') }} Ft</td>
</tr>
@endforeach
</tbody>
</table>
<p class="mb-1">Részösszeg: {{ number_format($order->subtotal, 0, ',', '.') }} Ft</p>
<p class="mb-1">Szállítás: {{ number_format($order->shipping_fee, 0, ',', '.') }} Ft</p>
<p class="fw-bold">Végösszeg: {{ number_format($order->total, 0, ',', '.') }} Ft</p>
</div>
</div>
</div>
@endsection
