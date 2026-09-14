<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, AnalyticsService $analytics)
    {
        $range = $request->string('range', '30d')->toString();
        $data = $analytics->dashboard($range);

        return view('admin.dashboard', [
            'data' => $data,
            'activities' => AdminActivity::latest()->take(8)->get(),
            'lowStock' => Product::where('is_active', true)->where('stock', '<=', 5)->orderBy('stock')->take(5)->get(),
        ]);
    }
}
