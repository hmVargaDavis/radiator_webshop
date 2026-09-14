<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Services\SeoService;

class PageController extends Controller
{
    public function shipping(SeoService $seo)
    {
        return view('pages.shipping', [
            'faqSchema' => $seo->faqSchema(),
            'shippingFee' => (int) (SiteSetting::getValue('shipping_fee') ?? config('shop.shipping_fee')),
            'pickupAddress' => SiteSetting::getValue('pickup_address') ?? config('shop.pickup_address'),
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'pickupAddress' => SiteSetting::getValue('pickup_address') ?? config('shop.pickup_address'),
            'phoneDisplay' => SiteSetting::getValue('phone_display') ?? config('shop.phone_display'),
            'openingHours' => SiteSetting::getValue('opening_hours') ?? 'előzetes telefonos egyeztetés alapján',
            'shippingFee' => (int) (SiteSetting::getValue('shipping_fee') ?? config('shop.shipping_fee')),
        ]);
    }

    public function package()
    {
        return view('pages.package', [
            'packageIntro' => SiteSetting::getValue('package_intro')
                ?? 'Minden radiátorhoz az alábbi alap szerelvényeket biztosítjuk a biztonságos felszereléshez.',
        ]);
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}
