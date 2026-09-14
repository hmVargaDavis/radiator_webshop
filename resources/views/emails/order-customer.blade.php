<!DOCTYPE html>
<html lang="hu">
<head><meta charset="utf-8"><title>Rendelés visszaigazolás</title></head>
<body style="font-family:Arial,sans-serif;color:#1d2a3b;line-height:1.5">
<p>Tisztelt {{ $order->customer_name }}!</p>
<p>Köszönjük a rendelését. Megkaptuk, és hamarosan felvesszük Önnel a kapcsolatot.</p>
<p><strong>Rendelésszám:</strong> {{ $order->order_number }}</p>
<table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse;width:100%">
<thead><tr><th>Radiátor mérete</th><th>Darabszám</th><th>Egységár</th><th>Részösszeg</th></tr></thead>
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
<p>
Szállítási díj: {{ number_format($order->shipping_fee, 0, ',', '.') }} Ft<br>
<strong>Teljes végösszeg: {{ number_format($order->total, 0, ',', '.') }} Ft</strong>
</p>
<p>
Szállítási cím: {{ $order->shipping_address }}<br>
Telefon: {{ $order->customer_phone }}<br>
Megjegyzés: {{ $order->note ?: '-' }}
</p>
<p>Üdvözlettel,<br>Radiátor Outlet Budapest<br>{{ config('shop.phone_display') }}</p>
</body>
</html>
