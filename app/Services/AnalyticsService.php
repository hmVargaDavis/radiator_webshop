<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PageView;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function range(?string $range = '30d'): array
    {
        $to = now();
        $from = match ($range) {
            '7d' => now()->subDays(6)->startOfDay(),
            '90d' => now()->subDays(89)->startOfDay(),
            'today' => now()->startOfDay(),
            default => now()->subDays(29)->startOfDay(),
        };

        return [$from, $to];
    }

    public function dashboard(string $range = '30d'): array
    {
        [$from, $to] = $this->range($range);

        $orders = Order::whereBetween('created_at', [$from, $to]);
        $views = PageView::human()->between($from, $to);

        $orderCount = (clone $orders)->count();
        $revenue = (int) (clone $orders)->sum('total');
        $visitors = (clone $views)->distinct('session_id')->count('session_id');
        $pageViews = (clone $views)->count();

        $prevFrom = (clone $from)->subDays(max(1, $from->diffInDays($to)));
        $prevTo = (clone $from)->subSecond();
        $prevRevenue = (int) Order::whereBetween('created_at', [$prevFrom, $prevTo])->sum('total');
        $prevVisitors = PageView::human()->between($prevFrom, $prevTo)->distinct('session_id')->count('session_id');

        return [
            'range' => $range,
            'from' => $from,
            'to' => $to,
            'orders' => $orderCount,
            'revenue' => $revenue,
            'avg_order' => $orderCount ? (int) round($revenue / $orderCount) : 0,
            'visitors' => $visitors,
            'page_views' => $pageViews,
            'conversion' => $visitors > 0 ? round(($orderCount / $visitors) * 100, 2) : 0,
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'products' => Product::where('is_active', true)->count(),
            'new_orders_today' => Order::whereDate('created_at', today())->count(),
            'revenue_change' => $this->pctChange($revenue, $prevRevenue),
            'visitor_change' => $this->pctChange($visitors, $prevVisitors),
            'sales_chart' => $this->dailySales($from, $to),
            'traffic_chart' => $this->dailyTraffic($from, $to),
            'top_pages' => $this->topPages($from, $to, 8),
            'top_referrers' => $this->topReferrers($from, $to, 8),
            'devices' => $this->devices($from, $to),
            'recent_orders' => Order::latest()->take(6)->get(),
        ];
    }

    public function analytics(string $range = '30d'): array
    {
        [$from, $to] = $this->range($range);
        $base = PageView::human()->between($from, $to);

        return [
            'range' => $range,
            'from' => $from,
            'to' => $to,
            'summary' => [
                'views' => (clone $base)->count(),
                'visitors' => (clone $base)->distinct('session_id')->count('session_id'),
                'bounce_like' => $this->singlePageSessions($from, $to),
                'avg_ms' => (int) round((clone $base)->avg('response_time_ms') ?? 0),
            ],
            'traffic_chart' => $this->dailyTraffic($from, $to),
            'referrers' => $this->topReferrers($from, $to, 20),
            'utm_sources' => $this->groupCount($from, $to, 'utm_source'),
            'utm_mediums' => $this->groupCount($from, $to, 'utm_medium'),
            'utm_campaigns' => $this->groupCount($from, $to, 'utm_campaign'),
            'devices' => $this->devices($from, $to),
            'browsers' => $this->groupCount($from, $to, 'browser'),
            'top_pages' => $this->topPages($from, $to, 25),
            'entry_paths' => $this->entryPaths($from, $to),
            'hourly' => $this->hourly($from, $to),
        ];
    }

    public function seoReport(): array
    {
        $products = Product::orderBy('sort_order')->get();
        $issues = [];
        $scoreParts = [];

        foreach ($products as $p) {
            $local = 100;
            $itemIssues = [];
            if (! $p->meta_title) {
                $itemIssues[] = 'Hiányzik a SEO cím';
                $local -= 20;
            } elseif (mb_strlen($p->meta_title) < 20 || mb_strlen($p->meta_title) > 65) {
                $itemIssues[] = 'SEO cím hossza nem ideális (20-65 karakter)';
                $local -= 10;
            }
            if (! $p->meta_description) {
                $itemIssues[] = 'Hiányzik a meta leírás';
                $local -= 20;
            } elseif (mb_strlen($p->meta_description) < 70 || mb_strlen($p->meta_description) > 160) {
                $itemIssues[] = 'Meta leírás hossza nem ideális (70-160)';
                $local -= 10;
            }
            if (! $p->ai_description) {
                $itemIssues[] = 'Hiányzik az AI leírás';
                $local -= 15;
            }
            if (! $p->keywords) {
                $itemIssues[] = 'Nincsenek kulcsszavak';
                $local -= 10;
            }
            if (! $p->image) {
                $itemIssues[] = 'Nincs termékfotó';
                $local -= 15;
            }
            if (! $p->is_active) {
                $itemIssues[] = 'Inaktív termék';
            }
            $scoreParts[] = max(0, $local);
            if ($itemIssues) {
                $issues[] = [
                    'product' => $p,
                    'score' => max(0, $local),
                    'issues' => $itemIssues,
                ];
            }
        }

        $avg = $scoreParts ? (int) round(array_sum($scoreParts) / count($scoreParts)) : 0;

        $checklist = [
            ['label' => 'Sitemap elérhető', 'ok' => true, 'hint' => url('/sitemap.xml')],
            ['label' => 'llms.txt elérhető', 'ok' => true, 'hint' => url('/llms.txt')],
            ['label' => 'Katalógus JSON', 'ok' => true, 'hint' => url('/api/katalogus.json')],
            ['label' => 'robots.txt', 'ok' => true, 'hint' => url('/robots.txt')],
            ['label' => 'LocalBusiness schema', 'ok' => true, 'hint' => 'Minden oldalon'],
            ['label' => 'Product schema', 'ok' => $products->where('is_active', true)->count() > 0, 'hint' => 'Termékoldalakon'],
            ['label' => 'PWA manifest', 'ok' => file_exists(public_path('manifest.webmanifest')), 'hint' => 'Telepíthető mobilapp élmény'],
            ['label' => 'Összes aktív terméknek van SEO címe', 'ok' => $products->where('is_active', true)->whereNull('meta_title')->count() === 0, 'hint' => 'Admin > Termékek'],
            ['label' => 'Összes aktív terméknek van meta leírása', 'ok' => $products->where('is_active', true)->filter(fn ($p) => blank($p->meta_description))->count() === 0, 'hint' => 'Admin > Termékek'],
        ];

        $passed = collect($checklist)->where('ok', true)->count();

        return [
            'score' => $avg,
            'checklist_score' => $checklist ? (int) round(($passed / count($checklist)) * 100) : 0,
            'checklist' => $checklist,
            'issues' => $issues,
            'product_count' => $products->count(),
            'active_count' => $products->where('is_active', true)->count(),
            'with_ai' => $products->whereNotNull('ai_description')->count(),
            'top_organic_paths' => PageView::human()
                ->where(function ($q) {
                    $q->whereNull('referrer_host')
                        ->orWhere('referrer_host', 'like', '%google%')
                        ->orWhere('referrer_host', 'like', '%bing%')
                        ->orWhere('utm_medium', 'organic');
                })
                ->select('path', DB::raw('count(*) as c'))
                ->groupBy('path')
                ->orderByDesc('c')
                ->limit(10)
                ->get(),
        ];
    }

    private function pctChange(int|float $current, int|float $previous): float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function dailySales(Carbon $from, Carbon $to): array
    {
        $driver = config('database.default');
        $dateExpr = $driver === 'mysql' ? 'DATE(created_at)' : "strftime('%Y-%m-%d', created_at)";

        $rows = Order::whereBetween('created_at', [$from, $to])
            ->select(DB::raw("$dateExpr as d"), DB::raw('sum(total) as revenue'), DB::raw('count(*) as orders'))
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->keyBy('d');

        return $this->fillDays($from, $to, $rows, ['revenue', 'orders']);
    }

    private function dailyTraffic(Carbon $from, Carbon $to): array
    {
        $driver = config('database.default');
        $dateExpr = $driver === 'mysql' ? 'DATE(created_at)' : "strftime('%Y-%m-%d', created_at)";

        $rows = PageView::human()->between($from, $to)
            ->select(DB::raw("$dateExpr as d"), DB::raw('count(*) as views'), DB::raw('count(distinct session_id) as visitors'))
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->keyBy('d');

        return $this->fillDays($from, $to, $rows, ['views', 'visitors']);
    }

    private function fillDays(Carbon $from, Carbon $to, $rows, array $fields): array
    {
        $labels = [];
        $series = [];
        foreach ($fields as $f) {
            $series[$f] = [];
        }

        for ($d = $from->copy(); $d <= $to; $d->addDay()) {
            $key = $d->toDateString();
            $labels[] = $d->format('m.d.');
            $row = $rows[$key] ?? null;
            foreach ($fields as $f) {
                $series[$f][] = $row ? (int) $row->{$f} : 0;
            }
        }

        return ['labels' => $labels, 'series' => $series];
    }

    private function topPages(Carbon $from, Carbon $to, int $limit = 10)
    {
        return PageView::human()->between($from, $to)
            ->select('path', DB::raw('count(*) as views'), DB::raw('count(distinct session_id) as visitors'))
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit($limit)
            ->get();
    }

    private function topReferrers(Carbon $from, Carbon $to, int $limit = 10)
    {
        return PageView::human()->between($from, $to)
            ->whereNotNull('referrer_host')
            ->where('referrer_host', '!=', '')
            ->select('referrer_host', DB::raw('count(*) as views'), DB::raw('count(distinct session_id) as visitors'))
            ->groupBy('referrer_host')
            ->orderByDesc('views')
            ->limit($limit)
            ->get()
            ->map(function ($row) {
                $host = strtolower($row->referrer_host);
                $row->source_type = match (true) {
                    str_contains($host, 'google') => 'Kereső (Google)',
                    str_contains($host, 'bing') => 'Kereső (Bing)',
                    str_contains($host, 'facebook') || str_contains($host, 'instagram') => 'Közösségi',
                    str_contains($host, 'youtube') => 'Videó',
                    default => 'Hivatkozás',
                };

                return $row;
            });
    }

    private function devices(Carbon $from, Carbon $to)
    {
        return PageView::human()->between($from, $to)
            ->select('device', DB::raw('count(*) as c'))
            ->groupBy('device')
            ->orderByDesc('c')
            ->get();
    }

    private function groupCount(Carbon $from, Carbon $to, string $column)
    {
        return PageView::human()->between($from, $to)
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->select($column.' as name', DB::raw('count(*) as c'))
            ->groupBy($column)
            ->orderByDesc('c')
            ->limit(15)
            ->get();
    }

    private function entryPaths(Carbon $from, Carbon $to)
    {
        // approximation: first path per session in range
        $driver = config('database.default');
        if ($driver === 'sqlite') {
            return PageView::human()->between($from, $to)
                ->whereIn('id', function ($q) use ($from, $to) {
                    $q->selectRaw('min(id)')
                        ->from('page_views')
                        ->where('is_bot', 0)
                        ->whereBetween('created_at', [$from, $to])
                        ->groupBy('session_id');
                })
                ->select('path', DB::raw('count(*) as c'))
                ->groupBy('path')
                ->orderByDesc('c')
                ->limit(12)
                ->get();
        }

        return $this->topPages($from, $to, 12);
    }

    private function hourly(Carbon $from, Carbon $to)
    {
        $driver = config('database.default');
        $hourExpr = $driver === 'mysql' ? 'HOUR(created_at)' : "cast(strftime('%H', created_at) as integer)";

        $rows = PageView::human()->between($from, $to)
            ->select(DB::raw("$hourExpr as h"), DB::raw('count(*) as c'))
            ->groupBy('h')
            ->orderBy('h')
            ->get()
            ->keyBy('h');

        $labels = [];
        $data = [];
        for ($i = 0; $i < 24; $i++) {
            $labels[] = sprintf('%02d:00', $i);
            $data[] = isset($rows[$i]) ? (int) $rows[$i]->c : 0;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function singlePageSessions(Carbon $from, Carbon $to): int
    {
        $rows = PageView::human()->between($from, $to)
            ->select('session_id', DB::raw('count(*) as c'))
            ->groupBy('session_id')
            ->having('c', '=', 1)
            ->get();

        return $rows->count();
    }
}
