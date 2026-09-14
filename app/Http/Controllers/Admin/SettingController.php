<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $keys = [
            'hero_title', 'hero_text', 'shipping_fee', 'pickup_address',
            'phone', 'phone_display', 'owner_email', 'opening_hours',
            'shipping_text', 'package_intro', 'seo_title', 'seo_description',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = SiteSetting::getValue($key);
        }

        $settings['shipping_fee'] ??= config('shop.shipping_fee');
        $settings['pickup_address'] ??= config('shop.pickup_address');
        $settings['phone'] ??= config('shop.phone');
        $settings['phone_display'] ??= config('shop.phone_display');
        $settings['owner_email'] ??= config('shop.owner_email');
        $settings['opening_hours'] ??= 'előzetes telefonos egyeztetés alapján';
        $settings['shipping_text'] ??= 'Kiszállítás Budapest teljes területén - 2.500 Ft / rendelés. Vidéki kiszállítás jelenleg nincs.';
        $settings['package_intro'] ??= 'Minden radiátorhoz az alábbi alap szerelvényeket biztosítjuk.';
        $settings['seo_title'] ??= 'Radiátor Outlet Budapest | 22K panelradiátorok raktárról';
        $settings['seo_description'] ??= 'Új 22K acéllemez panelradiátorok Budapesten, raktárról. Átlátható árak, budapesti kiszállítás 2.500 Ft-ért.';
        $settings['hero_title'] ??= 'Minőségi radiátorok Budapesten, közvetlenül.';
        $settings['hero_text'] ??= 'Új 22K panelradiátorok raktárról, átlátható árakkal és egyszerű rendeléssel.';

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_title' => 'required|string|max:200',
            'hero_text' => 'required|string|max:1000',
            'shipping_fee' => 'required|integer|min:0',
            'pickup_address' => 'required|string|max:200',
            'phone' => 'required|string|max:40',
            'phone_display' => 'required|string|max:40',
            'owner_email' => 'required|email',
            'opening_hours' => 'required|string|max:200',
            'shipping_text' => 'required|string|max:500',
            'package_intro' => 'required|string|max:500',
            'seo_title' => 'required|string|max:160',
            'seo_description' => 'required|string|max:320',
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::setValue($key, $value, 'content', $key);
        }

        return back()->with('success', 'Beállítások mentve.');
    }
}
