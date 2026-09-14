@extends('layouts.admin')
@section('title', 'Keresés')

@section('content')
<div class="p-card mb-3">
    <form action="{{ route('admin.search') }}" method="get" class="d-flex gap-2">
        <input type="search" name="q" class="form-control form-control-lg" value="{{ $q }}" placeholder="Rendelésszám, név, e-mail, méret..." autofocus>
        <button class="polaris-btn polaris-btn-primary" type="submit">Keresés</button>
    </form>
</div>
@include('admin.partials.search-results')
@endsection
