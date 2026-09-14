<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\CartService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, SeoService $seo)
    {
        $products = $this->filtered($request);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'ok' => true,
                'count' => $products->count(),
                'html' => view('partials.product-grid', ['products' => $products])->render(),
                'list_html' => view('partials.product-list-mobile', ['products' => $products])->render(),
            ]);
        }

        return view('products.index', [
            'products' => $products,
            'shippingFee' => (int) (SiteSetting::getValue('shipping_fee') ?? config('shop.shipping_fee')),
            'itemListSchema' => $seo->itemListSchema($products),
            'breadcrumbSchema' => $seo->breadcrumb([
                ['name' => 'Főoldal', 'url' => url('/')],
                ['name' => 'Radiátorok és árak', 'url' => route('products.index')],
            ]),
            'filters' => [
                'q' => $request->string('q')->toString(),
                'sort' => $request->string('sort', 'size')->toString(),
                'min_price' => $request->input('min_price'),
                'max_price' => $request->input('max_price'),
                'width' => $request->input('width'),
            ],
            'widths' => Product::active()->pluck('width_mm')->unique()->sort()->values(),
        ]);
    }

    public function show(Product $product, CartService $cart, SeoService $seo)
    {
        abort_unless($product->is_active, 404);

        $related = Product::active()->where('id', '!=', $product->id)->take(4)->get();

        return view('products.show', [
            'product' => $product,
            'related' => $related,
            'cartData' => $cart->detailed(),
            'shippingFee' => (int) (SiteSetting::getValue('shipping_fee') ?? config('shop.shipping_fee')),
            'pickupAddress' => SiteSetting::getValue('pickup_address') ?? config('shop.pickup_address'),
            'productSchema' => $seo->productJsonLd($product),
            'breadcrumbSchema' => $seo->breadcrumb([
                ['name' => 'Főoldal', 'url' => url('/')],
                ['name' => 'Radiátorok', 'url' => route('products.index')],
                ['name' => $product->size_label, 'url' => route('products.show', $product)],
            ]),
            'aiPayload' => $seo->productAiPayload($product),
        ]);
    }

    public function json(Product $product, SeoService $seo)
    {
        abort_unless($product->is_active, 404);

        return response()
            ->json($seo->productAiPayload($product), 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            ->header('Content-Type', 'application/json; charset=UTF-8')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('X-Robots-Tag', 'index, follow');
    }

    public function catalogJson(SeoService $seo)
    {
        return response()
            ->json($seo->catalogAiPayload(), 200, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            ->header('Content-Type', 'application/json; charset=UTF-8')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('X-Robots-Tag', 'index, follow');
    }

    private function filtered(Request $request)
    {
        $query = Product::active();

        if ($q = trim((string) $request->input('q'))) {
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('size_label', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('width')) {
            $query->where('width_mm', (int) $request->input('width'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->input('max_price'));
        }

        $sort = $request->string('sort', 'size')->toString();
        match ($sort) {
            'price_asc' => $query->reorder()->orderBy('price')->orderBy('width_mm'),
            'price_desc' => $query->reorder()->orderByDesc('price')->orderBy('width_mm'),
            'name' => $query->reorder()->orderBy('name'),
            default => $query->reorder()->orderBy('sort_order')->orderBy('width_mm'),
        };

        return $query->get();
    }
}
