<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\SiteSetting;
use App\Services\CartService;
use App\Services\SeoService;

class HomeController extends Controller
{
    public function index(CartService $cart, SeoService $seo)
    {
        $products = Product::active()->take(6)->get();
        $reviews = Review::featured()->take(4)->get();

        return view('home', [
            'products' => $products,
            'reviews' => $reviews,
            'cartData' => $cart->detailed(),
            'shippingFee' => (int) (SiteSetting::getValue('shipping_fee') ?? config('shop.shipping_fee')),
            'pickupAddress' => SiteSetting::getValue('pickup_address') ?? config('shop.pickup_address'),
            'phoneDisplay' => SiteSetting::getValue('phone_display') ?? config('shop.phone_display'),
            'phone' => SiteSetting::getValue('phone') ?? config('shop.phone'),
            'heroTitle' => SiteSetting::getValue('hero_title') ?? 'Minőségi radiátorok Budapesten, közvetlenül.',
            'heroText' => SiteSetting::getValue('hero_text') ?? 'Új 22K panelradiátorok raktárról, átlátható árakkal és egyszerű rendeléssel. Kiszállítás csak Budapesten.',
            'faqSchema' => $seo->faqSchema(),
            'itemListSchema' => $seo->itemListSchema($products),
            'reviewStats' => $seo->reviewStats(),
            'productCount' => Product::active()->count(),
        ]);
    }
}
