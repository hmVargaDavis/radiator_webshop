<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $results = [
            'products' => collect(),
            'orders' => collect(),
            'reviews' => collect(),
        ];

        if (mb_strlen($q) >= 2) {
            $results['products'] = Product::query()
                ->where(function ($b) use ($q) {
                    $b->where('name', 'like', "%{$q}%")
                        ->orWhere('size_label', 'like', "%{$q}%")
                        ->orWhere('sku', 'like', "%{$q}%");
                })
                ->limit(8)
                ->get();

            $results['orders'] = Order::query()
                ->where(function ($b) use ($q) {
                    $b->where('order_number', 'like', "%{$q}%")
                        ->orWhere('customer_name', 'like', "%{$q}%")
                        ->orWhere('customer_email', 'like', "%{$q}%")
                        ->orWhere('customer_phone', 'like', "%{$q}%");
                })
                ->latest()
                ->limit(8)
                ->get();

            $results['reviews'] = Review::query()
                ->where(function ($b) use ($q) {
                    $b->where('author_name', 'like', "%{$q}%")
                        ->orWhere('content', 'like', "%{$q}%");
                })
                ->latest()
                ->limit(8)
                ->get();
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'q' => $q,
                'html' => view('admin.partials.search-results', compact('q', 'results'))->render(),
            ]);
        }

        return view('admin.search', compact('q', 'results'));
    }
}
