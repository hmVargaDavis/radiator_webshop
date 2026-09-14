<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $started = microtime(true);
        $response = $next($request);

        if ($this->shouldTrack($request, $response)) {
            try {
                $ua = (string) $request->userAgent();
                $referrer = (string) $request->headers->get('referer', '');
                $host = null;
                if ($referrer !== '') {
                    $host = parse_url($referrer, PHP_URL_HOST);
                }

                PageView::create([
                    'path' => '/'.ltrim($request->path(), '/'),
                    'full_url' => Str::limit($request->fullUrl(), 980),
                    'method' => $request->method(),
                    'referrer' => $referrer ? Str::limit($referrer, 980) : null,
                    'referrer_host' => $host ? Str::limit($host, 250) : null,
                    'utm_source' => $request->query('utm_source'),
                    'utm_medium' => $request->query('utm_medium'),
                    'utm_campaign' => $request->query('utm_campaign'),
                    'ip_hash' => hash('sha256', ($request->ip() ?? '0').'|'.config('app.key')),
                    'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                    'user_agent' => Str::limit($ua, 490),
                    'device' => $this->device($ua),
                    'browser' => $this->browser($ua),
                    'country' => null,
                    'is_bot' => $this->isBot($ua),
                    'response_time_ms' => (int) ((microtime(true) - $started) * 1000),
                ]);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (!$request->isMethod('GET')) {
            return false;
        }
        if ($response->getStatusCode() >= 400) {
            return false;
        }
        if ($request->ajax() && $request->expectsJson()) {
            return false;
        }
        if ($request->is('admin*') || $request->is('api/*') || $request->is('up')) {
            return false;
        }
        if ($request->is('*.js') || $request->is('*.css') || $request->is('*.xml') || $request->is('*.txt') || $request->is('*.json') || $request->is('sw.js') || $request->is('manifest.webmanifest')) {
            return false;
        }
        if ($request->is('livewire/*') || $request->is('_debugbar*')) {
            return false;
        }

        return true;
    }

    private function isBot(string $ua): bool
    {
        return (bool) preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|bingpreview|yandex|baidu|duckduck|semrush|ahrefs|mt-google|python-requests|curl|wget/i', $ua);
    }

    private function device(string $ua): string
    {
        if (preg_match('/iPad|Tablet|Android(?!.*Mobile)/i', $ua)) {
            return 'tablet';
        }
        if (preg_match('/Mobile|Android|iPhone|iPod|webOS|BlackBerry|IEMobile/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }

    private function browser(string $ua): string
    {
        return match (true) {
            str_contains($ua, 'Edg/') => 'Edge',
            str_contains($ua, 'OPR/') || str_contains($ua, 'Opera') => 'Opera',
            str_contains($ua, 'Firefox/') => 'Firefox',
            str_contains($ua, 'Chrome/') && ! str_contains($ua, 'Edg/') => 'Chrome',
            str_contains($ua, 'Safari/') && ! str_contains($ua, 'Chrome/') => 'Safari',
            default => 'Egyéb',
        };
    }
}
