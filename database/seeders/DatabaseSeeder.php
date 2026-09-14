<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\SiteSetting;
use App\Services\SeoService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $seo = app(SeoService::class);

        $products = [
            ['width' => 400, 'price' => 6800, 'image' => 'images/products/radiator-1.jpg'],
            ['width' => 500, 'price' => 8000, 'image' => 'images/products/radiator-2.jpg'],
            ['width' => 600, 'price' => 9500, 'image' => 'images/products/radiator-3.jpg'],
            ['width' => 700, 'price' => 12000, 'image' => 'images/products/radiator-4.jpg'],
            ['width' => 800, 'price' => 20000, 'image' => 'images/products/radiator-5.jpg'],
            ['width' => 900, 'price' => 22000, 'image' => 'images/products/radiator-6.jpg'],
            ['width' => 1000, 'price' => 22000, 'image' => 'images/products/radiator-7.jpg'],
            ['width' => 1200, 'price' => 24000, 'image' => 'images/products/radiator-8.jpg'],
            ['width' => 1400, 'price' => 27500, 'image' => 'images/products/radiator-9.jpg'],
        ];

        foreach ($products as $i => $row) {
            $size = '600 × '.$row['width'].' mm';
            $priceFmt = number_format($row['price'], 0, ',', '.');
            $feeFmt = number_format($seo->shippingFee(), 0, ',', '.');

            $ai = "Termék: új 22K acéllemez panelradiátor (lapradiátor), méret {$size}. "
                ."Eladó: Radiátor Outlet Budapest. Ár: {$priceFmt} Ft/db, pénznem: HUF. Állapot: új, raktáron. "
                .'Felhasználás: lakások és családi házak fűtése, radiátorcsere Budapesten. '
                ."Szolgáltatási terület: kizárólag Budapest (I-XXIII. kerület). "
                ."Kiszállítás Budapest teljes területén: {$feeFmt} Ft / rendelés. Vidéki kiszállítás: nem elérhető. "
                .'Személyes átvétel: Budapest XXIII. kerület, Soroksár, előzetes telefonos egyeztetéssel. '
                .'Csomag tartalma: fali konzolok/rögzítők, szelepek/idomok, tömítő elemek, rögzítő csavarok, egyéb alap szerelvények. '
                .'Online bankkártyás fizetés jelenleg nincs; rendelés után telefonos/e-mailes visszaigazolás. '
                ."Kulcsszavak: 22K radiátor Budapest, panelradiátor {$size}, lapradiátor raktárról, radiátor kiszállítás Budapest.";

            Product::updateOrCreate(
                ['size_label' => $size],
                [
                    'name' => 'Új 22K lapradiátor - '.$size,
                    'slug' => '22k-lapradiator-600x'.$row['width'],
                    'sku' => 'RAD-600-'.$row['width'],
                    'height_mm' => 600,
                    'width_mm' => $row['width'],
                    'price' => $row['price'],
                    'image' => $row['image'],
                    'short_description' => 'Új, 22K kivitelű acéllemez panelradiátor raktárkészletről, Budapesten rendelhető.',
                    'description' => "Új 22K lapradiátor - {$size}\n\nÚj, 22K kivitelű acéllemez panelradiátor raktárkészletről. Megbízható fűtési teljesítmény lakásokhoz és családi házakhoz, Budapesten azonnal rendelhető méretben.\n\nA radiátor készre szerelhető állapotban kerül átadásra. A rendelés leadása után egyeztetjük az átvételt vagy a budapesti kiszállítást.\n\nKiszállítás: Budapest teljes területe, {$feeFmt} Ft / rendelés. Vidéki kiszállítás jelenleg nincs.\nSzemélyes átvétel: Budapest XXIII. kerület, Soroksár.",
                    'package_contents' => "fali konzolok / rögzítők\nszelepek / idomok\ntömítő elemek\nrögzítő csavarok\negyéb szükséges alap szerelvények",
                    'stock' => 40,
                    'is_active' => true,
                    'in_stock' => true,
                    'sort_order' => $i + 1,
                    'meta_title' => "22K radiátor {$size} Budapest | Radiátor Outlet",
                    'meta_description' => "Új 22K panelradiátor {$size} Budapesten, raktárról. Ár: {$priceFmt} Ft/db. Kiszállítás Budapesten {$feeFmt} Ft-ért, átvétel Soroksáron.",
                    'ai_description' => $ai,
                    'keywords' => implode(', ', [
                        '22K radiátor Budapest',
                        'panelradiátor '.$size,
                        'lapradiátor '.$row['width'].' mm',
                        'radiátor raktárról Budapest',
                        'radiátor kiszállítás Budapest',
                        'radiátor Soroksár',
                        'acéllemez radiátor Budapest',
                    ]),
                ]
            );
        }

        $reviews = [
            ['Nagy Tamás', 'Budapest', 5, 'Gyors és korrekt ügyintézés. A radiátorok tisztán, sérülésmentesen érkeztek, a konzolok és szelepek is megvoltak a csomagban.'],
            ['Kiss Andrea', 'Budapest XI.', 5, 'Átlátható árak, nincs rejtett költség. A 600x800-as méret pontosan megfelelt, a kiszállítás egyeztetett időpontban megérkezett.'],
            ['Szabó Péter', 'Budapest XXIII.', 5, 'Személyesen vettem át Soroksáron. Gyors volt, segítőkészek, a termék új és sértetlen.'],
            ['Tóth Eszter', 'Budapest XIV.', 5, 'Több méretet rendeltem egyszerre. Minden tétel stimmelt, a darabszám és az ár is pontosan úgy jött ki, ahogy a kosárban láttam.'],
            ['Horváth Gábor', 'Budapest III.', 4, 'Jó ár-érték arány. A radiátorok újak, a szerelvények is megvoltak. Egy kisebb idomcsere kellett a helyszínen, de ez nálunk a csatlakozás miatt volt.'],
            ['Varga Judit', 'Budapest XVIII.', 5, 'Telefonon is korrekt tájékoztatást kaptam. A rendelés másnapra összerakva állt, a budapesti szállítás gördülékeny volt.'],
            ['Farkas László', 'Budapest VIII.', 5, 'Nincs felesleges marketing szöveg, konkrét méretek és árak. Pontosan ezt kerestem panelradiátorhoz.'],
            ['Molnár Réka', 'Budapest II.', 5, 'A 600x1000-es radiátorok jól csomagolva érkeztek. Ajánlom, ha valaki gyorsan, raktárról szeretne rendelni Budapestre.'],
        ];

        foreach ($reviews as $r) {
            Review::updateOrCreate(
                ['author_name' => $r[0], 'content' => $r[3]],
                [
                    'author_city' => $r[1],
                    'rating' => $r[2],
                    'is_approved' => true,
                    'is_featured' => true,
                    'source' => 'placeholder',
                ]
            );
        }

        $settings = [
            'hero_title' => 'Minőségi radiátorok Budapesten, közvetlenül.',
            'hero_text' => 'Új 22K panelradiátorok raktárról, átlátható árakkal és egyszerű rendeléssel. Kiszállítás csak Budapesten.',
            'shipping_fee' => '2500',
            'pickup_address' => 'Budapest XXIII. kerület, Soroksár',
            'phone' => '06204662774',
            'phone_display' => '06 20 466 2774',
            'owner_email' => 'admin@radiatoroutlet.hu',
            'opening_hours' => 'előzetes telefonos egyeztetés alapján',
            'shipping_text' => 'Kiszállítás Budapest teljes területén - 2.500 Ft / rendelés. Vidéki kiszállítás jelenleg nincs.',
            'package_intro' => 'Minden radiátorhoz az alábbi alap szerelvényeket biztosítjuk a biztonságos felszereléshez.',
            'seo_title' => 'Radiátor Outlet Budapest | 22K panelradiátorok raktárról',
            'seo_description' => 'Új 22K acéllemez panelradiátorok Budapesten, raktárról. Átlátható árak, budapesti kiszállítás 2.500 Ft-ért, személyes átvétel Soroksáron (XXIII.).',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::setValue($key, $value);
        }
    }
}
