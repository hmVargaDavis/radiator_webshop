@extends('layouts.app')
@section('title', 'A csomag tartalma | Radiátor Outlet Budapest')
@section('meta_description', 'Minden radiátorhoz: fali konzolok, szelepek, tömítő elemek, rögzítő csavarok. Radiátor Outlet Budapest.')
@section('canonical', route('package'))
@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Főoldal</a></li>
            <li class="breadcrumb-item active">Csomag tartalma</li>
        </ol>
    </nav>
    <div class="package-box">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="fa-solid fa-box-open fs-3 text-primary"></i>
            <h1 class="section-title mb-0 h3">A csomag tartalmazza</h1>
        </div>
        <p class="text-muted mb-4">{{ $packageIntro }}</p>
        <div class="row g-4">
            <div class="col-6 col-md-3"><div class="package-item"><div class="package-icon"><img src="{{ asset('images/package/bracket.jpg') }}" alt="Fali konzolok"></div><strong>Fali konzolok / rögzítők</strong></div></div>
            <div class="col-6 col-md-3"><div class="package-item"><div class="package-icon"><img src="{{ asset('images/package/valve.jpg') }}" alt="Szelepek"></div><strong>Szelepek / idomok</strong></div></div>
            <div class="col-6 col-md-3"><div class="package-item"><div class="package-icon"><img src="{{ asset('images/package/seal.jpg') }}" alt="Tömítők"></div><strong>Tömítő elemek</strong></div></div>
            <div class="col-6 col-md-3"><div class="package-item"><div class="package-icon"><img src="{{ asset('images/package/screws.jpg') }}" alt="Csavarok"></div><strong>Rögzítő csavarok</strong></div></div>
        </div>
        <p class="text-muted small mt-3">Továbbá: egyéb szükséges alap szerelvények a felszereléshez.</p>
        <a href="{{ route('products.index') }}" class="btn-primary-shop mt-3">Radiátorok megtekintése</a>
    </div>
</div>
@endsection
