<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        View::composer(['layouts.app', 'partials.*', 'home', 'products.*', 'cart.*', 'checkout.*', 'pages.*', 'reviews.*'], function ($view) {
            try {
                $cart = app(CartService::class);
                $view->with('cartCount', $cart->count());
                $view->with('cartSummary', $cart->detailed());
                $view->with('shopPhone', \App\Models\SiteSetting::getValue('phone') ?? config('shop.phone'));
                $view->with('shopPhoneDisplay', \App\Models\SiteSetting::getValue('phone_display') ?? config('shop.phone_display'));
                $view->with('shopShippingFee', (int) (\App\Models\SiteSetting::getValue('shipping_fee') ?? config('shop.shipping_fee')));
            } catch (\Throwable $e) {
                $view->with('cartCount', 0);
                $view->with('cartSummary', ['items' => [], 'subtotal' => 0, 'shipping_fee' => 2500, 'total' => 0, 'count' => 0]);
                $view->with('shopPhone', config('shop.phone'));
                $view->with('shopPhoneDisplay', config('shop.phone_display'));
                $view->with('shopShippingFee', (int) config('shop.shipping_fee'));
            }
        });
    }
}
