@extends('layouts.admin')
@section('title', 'Analitika')

@section('content')
@php $d = $data; @endphp
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <p class="text-muted mb-0">Látogatottság, források, eszközök, UTM kampányok</p>
    <div class="p-range">
        @foreach(['today'=>'Ma','7d'=>'7 nap','30d'=>'30 nap','90d'=>'90 nap'] as $k=>$label)
            <a href="{{ route('admin.analytics', ['range'=>$k]) }}" class="{{ $d['range']===$k ? 'active' : '' }}" data-spa-link>{{ $label }}</a>
        @endforeach
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3"><div class="p-kpi"><div class="label">Megtekintések</div><div class="value">{{ number_format($d['summary']['views'],0,',','.') }}</div></div></div>
    <div class="col-6 col-md-3"><div class="p-kpi"><div class="label">Látogatók</div><div class="value">{{ number_format($d['summary']['visitors'],0,',','.') }}</div></div></div>
    <div class="col-6 col-md-3"><div class="p-kpi"><div class="label">1 oldalas session</div><div class="value">{{ number_format($d['summary']['bounce_like'],0,',','.') }}</div></div></div>
    <div class="col-6 col-md-3"><div class="p-kpi"><div class="label">Átlag válaszidő</div><div class="value">{{ $d['summary']['avg_ms'] }} ms</div></div></div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-8">
        <div class="p-card"><div class="p-card-title">Napi forgalom</div><canvas id="trafficChart" height="120"></canvas></div>
    </div>
    <div class="col-lg-4">
        <div class="p-card"><div class="p-card-title">Óránkénti aktivitás</div><canvas id="hourlyChart" height="180"></canvas></div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-6">
        <div class="p-card">
            <div class="p-card-title">Forgalmi források (referrer)</div>
            <table class="p-table p-table-mobile">
                <thead><tr><th>Host</th><th>Típus</th><th>Views</th><th>Users</th></tr></thead>
                <tbody>
                @forelse($d['referrers'] as $r)
                    <tr>
                        <td><strong>{{ $r->referrer_host }}</strong></td>
                        <td><span class="p-badge blue">{{ $r->source_type }}</span></td>
                        <td>{{ $r->views }}</td>
                        <td>{{ $r->visitors }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted">Még nincs külső forrás. Ha Google-ból / Facebookról jönnek, itt fog megjelenni.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="p-card">
            <div class="p-card-title">UTM források</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <h3 class="h6">utm_source</h3>
                    @forelse($d['utm_sources'] as $u)
                        <div class="d-flex justify-content-between small mb-1"><span>{{ $u->name }}</span><strong>{{ $u->c }}</strong></div>
                    @empty
                        <p class="small text-muted">Nincs UTM adat.</p>
                    @endforelse
                </div>
                <div class="col-md-4">
                    <h3 class="h6">utm_medium</h3>
                    @forelse($d['utm_mediums'] as $u)
                        <div class="d-flex justify-content-between small mb-1"><span>{{ $u->name }}</span><strong>{{ $u->c }}</strong></div>
                    @empty
                        <p class="small text-muted">-</p>
                    @endforelse
                </div>
                <div class="col-md-4">
                    <h3 class="h6">utm_campaign</h3>
                    @forelse($d['utm_campaigns'] as $u)
                        <div class="d-flex justify-content-between small mb-1"><span>{{ $u->name }}</span><strong>{{ $u->c }}</strong></div>
                    @empty
                        <p class="small text-muted">-</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="p-card">
            <div class="p-card-title">Böngészők</div>
            @foreach($d['browsers'] as $b)
                <div class="d-flex justify-content-between mb-2"><span>{{ $b->name }}</span><strong>{{ $b->c }}</strong></div>
            @endforeach
            @if($d['browsers']->isEmpty())<p class="text-muted small mb-0">Nincs adat.</p>@endif
        </div>
    </div>
    <div class="col-lg-4">
        <div class="p-card">
            <div class="p-card-title">Belépő oldalak</div>
            @foreach($d['entry_paths'] as $p)
                <div class="d-flex justify-content-between mb-2 gap-2"><code class="small">{{ $p->path }}</code><strong>{{ $p->c }}</strong></div>
            @endforeach
            @if($d['entry_paths']->isEmpty())<p class="text-muted small mb-0">Nincs adat.</p>@endif
        </div>
    </div>
    <div class="col-lg-4">
        <div class="p-card">
            <div class="p-card-title">Top oldalak</div>
            @foreach($d['top_pages']->take(10) as $p)
                <div class="d-flex justify-content-between mb-2 gap-2"><code class="small">{{ $p->path }}</code><strong>{{ $p->views }}</strong></div>
            @endforeach
            @if($d['top_pages']->isEmpty())<p class="text-muted small mb-0">Nincs adat.</p>@endif
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
  if (!window.Chart) return;
  const traffic = @json($d['traffic_chart']);
  const hourly = @json($d['hourly']);
  const t = document.getElementById('trafficChart');
  if (t) new Chart(t, {
    type: 'bar',
    data: {
      labels: traffic.labels,
      datasets: [
        { label: 'Views', data: traffic.series.views, backgroundColor: 'rgba(0,128,96,.35)' },
        { label: 'Látogatók', data: traffic.series.visitors, backgroundColor: 'rgba(44,110,203,.45)' }
      ]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } }
  });
  const h = document.getElementById('hourlyChart');
  if (h) new Chart(h, {
    type: 'line',
    data: { labels: hourly.labels, datasets: [{ label: 'Views', data: hourly.data, borderColor: '#008060', tension: .3, fill: false }] },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });
})();
</script>
@endpush
@endsection
