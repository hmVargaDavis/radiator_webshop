@extends('layouts.app')
@section('title', 'Adatkezelés | Radiátor Outlet Budapest')
@section('content')
<div class="container py-4" style="max-width:860px">
    <h1 class="section-title">Adatkezelési tájékoztató</h1>
    <p>A Radiátor Outlet Budapest a rendelés teljesítéséhez kezeli a megadott nevet, telefonszámot, e-mail címet és szállítási címet.</p>
    <p>Az adatokat kizárólag a rendelés feldolgozása, kapcsolattartás és visszaigazolás céljából használjuk. Harmadik félnek marketing célból nem adjuk át.</p>
    <p>Kapcsolat: <a href="tel:{{ preg_replace('/\s+/', '', $shopPhoneDisplay) }}">{{ $shopPhoneDisplay }}</a></p>
</div>
@endsection
