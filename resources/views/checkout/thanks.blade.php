@extends('layouts.app')

@section('title', 'Rendelés megérkezett | Radiátor Outlet Budapest')

@section('content')
<div class="container py-5">
    <div class="admin-card text-center mx-auto" style="max-width:680px">
        <i class="bi bi-check-circle-fill text-success fs-1"></i>
        <h1 class="section-title mt-2">Köszönjük a rendelését!</h1>
        <p class="text-muted">Rendelésszám: <strong>{{ $order->order_number }}</strong></p>
        <p>A rendelést megkaptuk. Hamarosan felvesszük Önnel a kapcsolatot a megadott telefonszámon vagy e-mailben. Visszaigazoló e-mailt is küldtünk a(z) <strong>{{ $order->customer_email }}</strong> címre.</p>
        <p class="fw-bold mb-4">Végösszeg: {{ number_format($order->total, 0, ',', '.') }} Ft</p>
        <a href="{{ route('home') }}" class="btn-primary-shop">Vissza a főoldalra</a>
    </div>
</div>
@endsection
