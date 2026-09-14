@extends('layouts.app')

@section('title', 'Kosár | Radiátor Outlet Budapest')

@section('content')
<div class="container py-4">
    <h1 class="section-title"><i class="fa-solid fa-cart-shopping me-2"></i>Kosár</h1>
    <div id="cartPageBody" data-cart-page-body>
        @include('partials.cart-page-body', ['cartData' => $cartData])
    </div>
</div>
@endsection
