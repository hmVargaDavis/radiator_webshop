<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Review;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;

class SeoService
{
    public function businessName(): string
    {
        return 'Radiátor Outlet Budapest';
    }

    public function phoneE164(): string
    {
        $raw = SiteSetting::getValue('phone') ?? config('shop.phone');
        $digits = preg_replace('/\D+/', '', (string) $raw);

        if (str_starts_with($digits, '36')) {
            return '+'.$digits;
        }
        if (str_starts_with($digits, '06')) {
            return '+36'.substr($digits, 2);
        }

        return '+36204662774';
    }

    public function pickupAddress(): string
    {
        return (string) (SiteSetting::getValue('pickup_address') ?? config('shop.pickup_address'));
    }

    public function shippingFee(): int
    {
        return (int) (SiteSetting::getValue('shipping_fee') ?? config('shop.shipping_fee', 2500));
    }

    public function openingHoursText(): string
    {
        return (string) (SiteSetting::getValue('opening_hours') ?? 'előzetes telefonos egyeztetés alapján');
    }

    /** Soroksár / Budapest XXIII. körülbelüli koordináta */
    public function geo(): array
    {
        return [
            'latitude' => 47.3975,
            'longitude' => 19.1352,
        ];
    }

    public function budapestDistricts(): array
    {
        return [
            'Budapest I. kerület', 'Budapest II. kerület', 'Budapest III. kerület',
            'Budapest IV. kerület', 'Budapest V. kerület', 'Budapest VI. kerület',
            'Budapest VII. kerület', 'Budapest VIII. kerület', 'Budapest IX. kerület',
            'Budapest X. kerület', 'Budapest XI. kerület', 'Budapest XII. kerület',
            'Budapest XIII. kerület', 'Budapest XIV. kerület', 'Budapest XV. kerület',
            'Budapest XVI. kerület', 'Budapest XVII. kerület', 'Budapest XVIII. kerület',
            'Budapest XIX. kerület', 'Budapest XX. kerület', 'Budapest XXI. kerület',
            'Budapest XXII. kerület', 'Budapest XXIII. kerület', 'Soroksár',
        ];
    }

    public function reviewStats(): array
    {
        $query = Review::approved();
        $count = (clone $query)->count();
        $avg = $count ? round((float) (clone $query)->avg('rating'), 1) : 0;

        return [
            'count' => $count,
            'average' => $avg,
        ];
    }

    public function organizationGraph(): array
    {
        $geo = $this->geo();
        $stats = $this->reviewStats();
        $shipping = $this->shippingFee();

        $areaServed = array_map(fn ($name) => [
            '@type' => 'AdministrativeArea',
            'name' => $name,
        ], $this->budapestDistricts());

        $graph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => ['LocalBusiness', 'HomeAndConstructionBusiness', 'Store'],
                    '@id' => url('/').'#business',
                    'name' => $this->businessName(),
                    'alternateName' => ['Radiator Outlet Budapest', '22K radiátor Budapest'],
                    'url' => url('/'),
                    'image' => asset('images/hero/hero-radiator.jpg'),
                    'logo' => asset('images/hero/hero-radiator.jpg'),
                    'description' => SiteSetting::getValue('seo_description')
                        ?? 'Új 22K acéllemez panelradiátorok Budapesten, raktárról. Kiszállítás Budapest teljes területén, személyes átvétel Soroksáron.',
                    'telephone' => $this->phoneE164(),
                    'email' => SiteSetting::getValue('owner_email') ?? config('shop.owner_email'),
                    'priceRange' => 'Ft',
                    'currenciesAccepted' => 'HUF',
                    'paymentAccepted' => 'Cash, Bank Transfer',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'Soroksár',
                        'addressLocality' => 'Budapest',
                        'addressRegion' => 'Budapest',
                        'postalCode' => '1237',
                        'addressCountry' => 'HU',
                    ],
                    'geo' => [
                        '@type' => 'GeoCoordinates',
                        'latitude' => $geo['latitude'],
                        'longitude' => $geo['longitude'],
                    ],
                    'hasMap' => 'https://www.google.com/maps/search/?api=1&query='.$geo['latitude'].','.$geo['longitude'],
                    'areaServed' => array_merge([
                        [
                            '@type' => 'City',
                            'name' => 'Budapest',
                            'sameAs' => 'https://www.wikidata.org/wiki/Q1781',
                        ],
                    ], $areaServed),
                    'openingHoursSpecification' => [
                        [
                            '@type' => 'OpeningHoursSpecification',
                            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                            'opens' => '08:00',
                            'closes' => '17:00',
                            'description' => $this->openingHoursText(),
                        ],
                    ],
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'telephone' => $this->phoneE164(),
                        'contactType' => 'customer service',
                        'areaServed' => 'Budapest',
                        'availableLanguage' => ['Hungarian'],
                    ],
                    'makesOffer' => [
                        '@type' => 'Offer',
                        'name' => 'Budapesti radiátor kiszállítás',
                        'price' => $shipping,
                        'priceCurrency' => 'HUF',
                        'description' => 'Kiszállítás Budapest teljes területén '.$shipping.' Ft / rendelés. Vidéki kiszállítás nincs.',
                        'areaServed' => [
                            '@type' => 'City',
                            'name' => 'Budapest',
                        ],
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/').'#website',
                    'url' => url('/'),
                    'name' => $this->businessName(),
                    'inLanguage' => 'hu-HU',
                    'publisher' => ['@id' => url('/').'#business'],
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => url('/radiatorok').'?q={search_term_string}',
                        'query-input' => 'required name=search_term_string',
                    ],
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => url()->current().'#webpage',
                    'url' => url()->current(),
                    'name' => SiteSetting::getValue('seo_title') ?? $this->businessName(),
                    'isPartOf' => ['@id' => url('/').'#website'],
                    'about' => ['@id' => url('/').'#business'],
                    'inLanguage' => 'hu-HU',
                ],
            ],
        ];

        if ($stats['count'] > 0) {
            $graph['@graph'][0]['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $stats['average'],
                'reviewCount' => $stats['count'],
                'bestRating' => 5,
                'worstRating' => 1,
            ];
        }

        return $graph;
    }

    public function faqSchema(): array
    {
        $fee = number_format($this->shippingFee(), 0, ',', '.');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'Szállítanak radiátort Budapesten?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => "Igen. Kiszállítás Budapest teljes területén elérhető, {$fee} Ft / rendelés. Vidéki kiszállítás jelenleg nincs.",
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Hol vehető át személyesen a radiátor?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Személyes átvétel: '.$this->pickupAddress().'. Időpont előzetes telefonos egyeztetés alapján.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Milyen radiátorok rendelhetők?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Új 22K acéllemez panelradiátorok több méretben (600 × 400 mm-től 600 × 1400 mm-ig), raktárkészletről, Budapesten.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Mit tartalmaz a csomag?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Fali konzolok / rögzítők, szelepek / idomok, tömítő elemek, rögzítő csavarok és egyéb szükséges alap szerelvények.',
                    ],
                ],
            ],
        ];
    }

    public function breadcrumb(array $items): array
    {
        $list = [];
        foreach (array_values($items) as $i => $item) {
            $list[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $list,
        ];
    }

    public function productJsonLd(Product $product): array
    {
        $stats = $this->reviewStats();
        $url = route('products.show', $product);
        $shipping = $this->shippingFee();

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            '@id' => $url.'#product',
            'name' => $product->name,
            'sku' => $product->sku,
            'mpn' => $product->sku,
            'productID' => (string) $product->id,
            'category' => 'Panelradiátor / 22K lapradiátor',
            'image' => [$product->image_url],
            'description' => $product->ai_description ?: $product->description ?: $product->short_description,
            'url' => $url,
            'brand' => [
                '@type' => 'Brand',
                'name' => $this->businessName(),
            ],
            'manufacturer' => [
                '@type' => 'Organization',
                'name' => $this->businessName(),
            ],
            'material' => 'Acéllemez',
            'color' => 'Fehér',
            'additionalProperty' => [
                ['@type' => 'PropertyValue', 'name' => 'Típus', 'value' => '22K panelradiátor'],
                ['@type' => 'PropertyValue', 'name' => 'Magasság', 'value' => $product->height_mm.' mm'],
                ['@type' => 'PropertyValue', 'name' => 'Szélesség', 'value' => $product->width_mm.' mm'],
                ['@type' => 'PropertyValue', 'name' => 'Méret', 'value' => $product->size_label],
                ['@type' => 'PropertyValue', 'name' => 'Kiszállítási terület', 'value' => 'Budapest'],
                ['@type' => 'PropertyValue', 'name' => 'Személyes átvétel', 'value' => $this->pickupAddress()],
            ],
            'offers' => [
                '@type' => 'Offer',
                '@id' => $url.'#offer',
                'url' => $url,
                'priceCurrency' => 'HUF',
                'price' => $product->price,
                'priceValidUntil' => now()->addYear()->toDateString(),
                'availability' => $product->in_stock
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'itemCondition' => 'https://schema.org/NewCondition',
                'seller' => ['@id' => url('/').'#business'],
                'areaServed' => [
                    '@type' => 'City',
                    'name' => 'Budapest',
                    'sameAs' => 'https://www.wikidata.org/wiki/Q1781',
                ],
                'shippingDetails' => [
                    '@type' => 'OfferShippingDetails',
                    'shippingRate' => [
                        '@type' => 'MonetaryAmount',
                        'value' => $shipping,
                        'currency' => 'HUF',
                    ],
                    'shippingDestination' => [
                        '@type' => 'DefinedRegion',
                        'addressCountry' => 'HU',
                        'addressRegion' => 'Budapest',
                    ],
                    'deliveryTime' => [
                        '@type' => 'ShippingDeliveryTime',
                        'handlingTime' => [
                            '@type' => 'QuantitativeValue',
                            'minValue' => 0,
                            'maxValue' => 2,
                            'unitCode' => 'DAY',
                        ],
                        'transitTime' => [
                            '@type' => 'QuantitativeValue',
                            'minValue' => 1,
                            'maxValue' => 3,
                            'unitCode' => 'DAY',
                        ],
                    ],
                ],
                'hasMerchantReturnPolicy' => [
                    '@type' => 'MerchantReturnPolicy',
                    'applicableCountry' => 'HU',
                    'returnPolicyCategory' => 'https://schema.org/MerchantReturnNotPermitted',
                    'merchantReturnDays' => 0,
                    'description' => 'Egyedi méretű, raktárról kiadott fűtési termék. Részletek telefonon egyeztethetők.',
                ],
            ],
            'isRelatedTo' => [
                '@type' => 'Thing',
                'name' => 'Fűtés Budapest, panelradiátor csere, lakásfűtés',
            ],
        ];

        if ($stats['count'] > 0) {
            $data['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $stats['average'],
                'reviewCount' => $stats['count'],
                'bestRating' => 5,
                'worstRating' => 1,
            ];
        }

        return $data;
    }

    /**
     * AI / gépi olvasásra optimalizált termék JSON (nem csak schema.org).
     */
    public function productAiPayload(Product $product): array
    {
        $shipping = $this->shippingFee();
        $package = array_values(array_filter(array_map(
            'trim',
            preg_split("/\r\n|\n|\r/", (string) $product->package_contents) ?: []
        )));

        return [
            'document_type' => 'product_ai_description',
            'language' => 'hu-HU',
            'locale' => 'Budapest, Hungary',
            'business' => [
                'name' => $this->businessName(),
                'phone' => $this->phoneE164(),
                'pickup_address' => $this->pickupAddress(),
                'service_area' => 'Budapest only',
                'service_area_hu' => 'Csak Budapest',
                'shipping_fee_huf' => $shipping,
                'rural_delivery' => false,
                'url' => url('/'),
            ],
            'product' => [
                'id' => $product->id,
                'sku' => $product->sku,
                'slug' => $product->slug,
                'name' => $product->name,
                'type' => '22K steel panel radiator',
                'type_hu' => 'Új 22K acéllemez panelradiátor',
                'condition' => 'new',
                'size_label' => $product->size_label,
                'height_mm' => $product->height_mm,
                'width_mm' => $product->width_mm,
                'price_huf' => $product->price,
                'price_formatted' => $product->formatted_price.'/db',
                'currency' => 'HUF',
                'in_stock' => (bool) $product->in_stock,
                'stock_qty' => $product->stock,
                'image_url' => $product->image_url,
                'product_url' => route('products.show', $product),
                'json_url' => route('products.json', $product),
                'short_description' => $product->short_description,
                'description' => $product->description,
                'ai_description' => $product->ai_description ?: $this->defaultAiDescription($product),
                'package_contents' => $package,
                'keywords' => $product->keywords
                    ? array_values(array_filter(array_map('trim', explode(',', $product->keywords))))
                    : $this->defaultKeywords($product),
                'geo_relevance' => [
                    'primary_city' => 'Budapest',
                    'pickup' => $this->pickupAddress(),
                    'delivery' => 'Budapest teljes területe',
                    'delivery_fee_huf' => $shipping,
                    'no_countryside_delivery' => true,
                    'districts_served' => $this->budapestDistricts(),
                ],
                'use_cases_hu' => [
                    'Lakás radiátorcsere Budapesten',
                    'Panelradiátor pótlás raktárról',
                    'Új 22K lapradiátor gyors átvétellel Soroksáron',
                ],
                'schema_org' => $this->productJsonLd($product),
            ],
            'generated_at' => now()->toIso8601String(),
        ];
    }

    public function catalogAiPayload(?Collection $products = null): array
    {
        $products ??= Product::active()->get();

        return [
            'document_type' => 'product_catalog_ai',
            'language' => 'hu-HU',
            'business' => $this->businessName(),
            'service_area' => 'Budapest',
            'shipping_fee_huf' => $this->shippingFee(),
            'product_count' => $products->count(),
            'products' => $products->map(fn (Product $p) => [
                'name' => $p->name,
                'size' => $p->size_label,
                'price_huf' => $p->price,
                'url' => route('products.show', $p),
                'json_url' => route('products.json', $p),
                'in_stock' => (bool) $p->in_stock,
                'summary' => $p->ai_description ?: $p->short_description,
            ])->values()->all(),
            'faq' => $this->faqSchema()['mainEntity'],
            'generated_at' => now()->toIso8601String(),
        ];
    }

    public function itemListSchema(Collection $products): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => '22K panelradiátorok Budapest - árak és méretek',
            'url' => route('products.index'),
            'isPartOf' => ['@id' => url('/').'#website'],
            'about' => [
                '@type' => 'Thing',
                'name' => 'Panelradiátor vásárlás Budapesten',
            ],
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => $products->values()->map(function (Product $product, int $index) {
                    return [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'url' => route('products.show', $product),
                        'name' => $product->name,
                        'item' => $this->productJsonLd($product),
                    ];
                })->all(),
            ],
        ];
    }

    public function defaultAiDescription(Product $product): string
    {
        $fee = number_format($this->shippingFee(), 0, ',', '.');
        $price = number_format($product->price, 0, ',', '.');

        return "A(z) {$product->name} új, 22K kivitelű acéllemez panelradiátor, amely Budapesten raktárkészletről rendelhető. "
            ."Pontos méret: {$product->size_label}. Egységár: {$price} Ft/db. "
            .'A csomag tartalmazza a fali konzolokat, szelepeket/idomokat, tömítő elemeket, rögzítő csavarokat és az alap szerelvényeket. '
            ."Személyes átvétel: {$this->pickupAddress()}. "
            ."Kiszállítás Budapest teljes területén {$fee} Ft / rendelés. Vidéki kiszállítás nincs. "
            .'A termék lakások és családi házak fűtéséhez, radiátorcseréhez ajánlott Budapesten.';
    }

    public function defaultKeywords(Product $product): array
    {
        return [
            '22K radiátor Budapest',
            'panelradiátor '.$product->size_label,
            'lapradiátor Budapest',
            'radiátor raktárról Budapest',
            'radiátor kiszállítás Budapest',
            'radiátor Soroksár',
            'acéllemez radiátor '.$product->width_mm.' mm',
            'fűtés Budapest',
        ];
    }

    public function encode(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
