<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request, AnalyticsService $analytics)
    {
        $range = $request->string('range', '30d')->toString();

        return view('admin.analytics.index', [
            'data' => $analytics->analytics($range),
        ]);
    }
}
