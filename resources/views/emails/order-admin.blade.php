<!DOCTYPE html>
<html lang="hu">
<head><meta charset="utf-8"><title>Új rendelés {{ $order->order_number }}</title></head>
<body style="font-family:Arial,sans-serif;color:#1d2a3b;line-height:1.5">
<h2>Új rendelés érkezett</h2>
<p><strong>Rendelésszám:</strong> {{ $order->order_number }}</p>
<p><strong>Név:</strong> {{ $order->customer_name }}<br>
<strong>Telefon:</strong> {{ $order->customer_phone }}<br>
<strong>E-mail:</strong> {{ $order->customer_email }}<br>
<strong>Szállítási cím:</strong> {{ $order->shipping_address }}<br>
<strong>Megjegyzés:</strong> {{ $order->note ?: '-' }}</p>
<table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse;width:100%">
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
<p>
Részösszeg: {{ number_format($order->subtotal, 0, ',', '.') }} Ft<br>
Szállítási díj: {{ number_format($order->shipping_fee, 0, ',', '.') }} Ft<br>
<strong>Végösszeg: {{ number_format($order->total, 0, ',', '.') }} Ft</strong>
</p>
</body>
</html>
