@extends('layouts.admin')
@section('title', 'Beállítások')
@section('content')
<h1 class="h3 fw-bold mb-3">Szövegek és beállítások</h1>
<form method="post" action="{{ route('admin.settings.update') }}" class="admin-card">
@csrf
<div class="row g-3">
@foreach([
'hero_title' => 'Főoldal cím',
'hero_text' => 'Főoldal szöveg',
'shipping_fee' => 'Szállítási díj (Ft)',
'pickup_address' => 'Átvételi cím',
'phone' => 'Telefon (híváshoz)',
'phone_display' => 'Telefon megjelenítés',
'owner_email' => 'Rendelési értesítő e-mail',
'opening_hours' => 'Nyitvatartás',
'shipping_text' => 'Szállítási szöveg',
'package_intro' => 'Csomag bevezető',
'seo_title' => 'SEO cím',
'seo_description' => 'SEO leírás',
] as $key => $label)
<div class="col-12 {{ in_array($key, ['shipping_fee','phone','phone_display']) ? 'col-md-4' : '' }}">
<label class="form-label">{{ $label }}</label>
@if(in_array($key, ['hero_text','shipping_text','package_intro','seo_description']))
<textarea name="{{ $key }}" class="form-control" rows="3" required>{{ old($key, $settings[$key]) }}</textarea>
@else
<input type="{{ $key === 'shipping_fee' ? 'number' : ($key === 'owner_email' ? 'email' : 'text') }}" name="{{ $key }}" class="form-control" required value="{{ old($key, $settings[$key]) }}">
@endif
</div>
@endforeach
</div>
<button class="btn-primary-shop mt-4" type="submit">Mentés</button>
</form>
@endsection
