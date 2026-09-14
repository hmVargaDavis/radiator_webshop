<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;

class SeoController extends Controller
{
    public function index(AnalyticsService $analytics)
    {
        return view('admin.seo.index', [
            'report' => $analytics->seoReport(),
        ]);
    }
}
