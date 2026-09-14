@extends('layouts.admin')
@section('title', 'SEO')

@section('content')
@php $r = $report; $scoreClass = $r['score'] >= 80 ? 'good' : ($r['score'] >= 55 ? 'mid' : 'bad'); @endphp

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="p-card h-100 text-center">
            <div class="p-card-title justify-content-center"><span>Termék SEO átlag</span></div>
            <div class="seo-score {{ $scoreClass }} mx-auto mb-2">{{ $r['score'] }}</div>
            <p class="text-muted small mb-0">{{ $r['active_count'] }} aktív termék · {{ $r['with_ai'] }} AI leírással</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-card h-100 text-center">
            <div class="p-card-title justify-content-center"><span>Technikai checklist</span></div>
            <div class="seo-score good mx-auto mb-2">{{ $r['checklist_score'] }}</div>
            <p class="text-muted small mb-0">Sitemap, schema, PWA, robots</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-card h-100">
            <div class="p-card-title"><span>Gyors linkek</span></div>
            <div class="d-grid gap-2">
                <a class="polaris-btn polaris-btn-ghost" href="{{ url('/sitemap.xml') }}" target="_blank">sitemap.xml</a>
                <a class="polaris-btn polaris-btn-ghost" href="{{ url('/llms.txt') }}" target="_blank">llms.txt</a>
                <a class="polaris-btn polaris-btn-ghost" href="{{ url('/api/katalogus.json') }}" target="_blank">katalógus JSON</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-6">
        <div class="p-card">
            <div class="p-card-title">SEO / GEO checklist</div>
            @foreach($r['checklist'] as $item)
                <div class="check-row">
                    <span class="check-ico {{ $item['ok'] ? 'ok' : 'bad' }}"><i class="bi {{ $item['ok'] ? 'bi-check-lg' : 'bi-x-lg' }}"></i></span>
                    <div>
                        <strong>{{ $item['label'] }}</strong>
                        <div class="small text-muted">{{ $item['hint'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-6">
        <div class="p-card">
            <div class="p-card-title">Organikus / kereső forgalmú útvonalak</div>
            @forelse($r['top_organic_paths'] as $p)
                <div class="d-flex justify-content-between mb-2 gap-2">
                    <code class="small">{{ $p->path }}</code>
                    <strong>{{ $p->c }}</strong>
                </div>
            @empty
                <p class="text-muted small mb-0">Még nincs organikus forgalmi adat.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="p-card">
    <div class="p-card-title">
        <span>Termék SEO problémák</span>
        <a href="{{ route('admin.products.index') }}" data-spa-link>Termékek</a>
    </div>
    @forelse($r['issues'] as $issue)
        <div class="border rounded-3 p-3 mb-2">
            <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                <div>
                    <strong>{{ $issue['product']->name }}</strong>
                    <div class="small text-muted">{{ $issue['product']->size_label }}</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="p-badge {{ $issue['score'] >= 80 ? 'green' : ($issue['score'] >= 55 ? 'yellow' : 'red') }}">{{ $issue['score'] }}/100</span>
                    <a class="polaris-btn polaris-btn-ghost" href="{{ route('admin.products.edit', $issue['product']) }}" data-spa-link>Javítás</a>
                </div>
            </div>
            <ul class="mb-0 mt-2 small text-muted">
                @foreach($issue['issues'] as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
            </ul>
        </div>
    @empty
        <p class="text-muted mb-0">Minden termék SEO mezője rendben van.</p>
    @endforelse
</div>
@endsection
