@extends('layouts.admin')
@section('title', 'Kezdőlap')

@section('content')
@php $d = $data; @endphp
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <div class="text-muted small">Üzleti áttekintés · Budapest webshop</div>
    </div>
    <div class="p-range">
        <a href="{{ route('admin.dashboard', ['range' => 'today']) }}" class="{{ ($d['range'] ?? '') === 'today' ? 'active' : '' }}" data-spa-link>Ma</a>
        <a href="{{ route('admin.dashboard', ['range' => '7d']) }}" class="{{ ($d['range'] ?? '') === '7d' ? 'active' : '' }}" data-spa-link>7 nap</a>
        <a href="{{ route('admin.dashboard', ['range' => '30d']) }}" class="{{ ($d['range'] ?? '') === '30d' ? 'active' : '' }}" data-spa-link>30 nap</a>
        <a href="{{ route('admin.dashboard', ['range' => '90d']) }}" class="{{ ($d['range'] ?? '') === '90d' ? 'active' : '' }}" data-spa-link>90 nap</a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-lg-3">
        <div class="p-kpi">
            <div class="label">Bevétel</div>
            <div class="value">{{ number_format($d['revenue'], 0, ',', '.') }} Ft</div>
            <div class="delta {{ $d['revenue_change'] >= 0 ? 'up' : 'down' }}">
                {{ $d['revenue_change'] >= 0 ? '+' : '' }}{{ $d['revenue_change'] }}% az előző időszakhoz
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="p-kpi">
            <div class="label">Rendelések</div>
            <div class="value">{{ $d['orders'] }}</div>
            <div class="delta">Átlag kosár: {{ number_format($d['avg_order'], 0, ',', '.') }} Ft</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="p-kpi">
            <div class="label">Látogatók</div>
            <div class="value">{{ number_format($d['visitors'], 0, ',', '.') }}</div>
            <div class="delta {{ $d['visitor_change'] >= 0 ? 'up' : 'down' }}">
                {{ $d['visitor_change'] >= 0 ? '+' : '' }}{{ $d['visitor_change'] }}% · {{ number_format($d['page_views'], 0, ',', '.') }} megtekintés
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="p-kpi">
            <div class="label">Konverzió</div>
            <div class="value">{{ number_format($d['conversion'], 2, ',', '.') }}%</div>
            <div class="delta">Ma új rendelés: {{ $d['new_orders_today'] }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-8">
        <div class="p-card h-100">
            <div class="p-card-title">
                <span>Forgalom és bevétel</span>
                <a href="{{ route('admin.analytics', ['range' => $d['range']]) }}" class="small" data-spa-link>Részletes analitika</a>
            </div>
            <canvas id="dashComboChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="p-card h-100">
            <div class="p-card-title"><span>Eszközök</span></div>
            <canvas id="dashDeviceChart" height="180"></canvas>
            <div class="mt-3">
                @foreach($d['devices'] as $dev)
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-capitalize">{{ $dev->device ?: 'ismeretlen' }}</span>
                        <strong>{{ $dev->c }}</strong>
                    </div>
                @endforeach
                @if($d['devices']->isEmpty())
                    <p class="text-muted small mb-0">Még nincs elég látogatási adat. Böngészd a webshopot, az adatok itt jelennek meg.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-6">
        <div class="p-card h-100">
            <div class="p-card-title"><span>Honnan érkeztek?</span></div>
            <table class="p-table">
                <thead><tr><th>Forrás</th><th>Típus</th><th>Látogató</th></tr></thead>
                <tbody>
                @forelse($d['top_referrers'] as $ref)
                    <tr>
                        <td><strong>{{ $ref->referrer_host }}</strong></td>
                        <td><span class="p-badge blue">{{ $ref->source_type }}</span></td>
                        <td>{{ $ref->visitors }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted">Direct / nincs külső forrás még.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="p-card h-100">
            <div class="p-card-title"><span>Legnézettebb oldalak</span></div>
            <table class="p-table">
                <thead><tr><th>Útvonal</th><th>Views</th><th>Látogató</th></tr></thead>
                <tbody>
                @forelse($d['top_pages'] as $page)
                    <tr>
                        <td><code>{{ $page->path }}</code></td>
                        <td>{{ $page->views }}</td>
                        <td>{{ $page->visitors }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted">Nincs adat.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="p-card">
            <div class="p-card-title">
                <span>Legutóbbi rendelések</span>
                <a href="{{ route('admin.orders.index') }}" data-spa-link>Összes</a>
            </div>
            <div class="table-responsive">
                <table class="p-table p-table-mobile">
                    <thead><tr><th>Szám</th><th>Vásárló</th><th>Összeg</th><th>Státusz</th></tr></thead>
                    <tbody>
                    @forelse($d['recent_orders'] as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}" data-spa-link>{{ $order->order_number }}</a></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ number_format($order->total, 0, ',', '.') }} Ft</td>
                            <td><span class="p-badge">{{ $order->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-muted">Még nincs rendelés.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="p-card mb-3">
            <div class="p-card-title"><span>Gyors teendők</span></div>
            <div class="d-grid gap-2">
                <a class="polaris-btn polaris-btn-ghost justify-content-between" href="{{ route('admin.reviews.index') }}" data-spa-link>
                    Jóváhagyásra váró vélemények <span class="p-badge yellow">{{ $d['pending_reviews'] }}</span>
                </a>
                <a class="polaris-btn polaris-btn-ghost justify-content-between" href="{{ route('admin.seo') }}" data-spa-link>
                    SEO állapot ellenőrzése <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a class="polaris-btn polaris-btn-ghost justify-content-between" href="{{ route('admin.products.index') }}" data-spa-link>
                    Aktív termékek <span class="p-badge green">{{ $d['products'] }}</span>
                </a>
            </div>
        </div>
        <div class="p-card">
            <div class="p-card-title"><span>Alacsony készlet</span></div>
            @forelse($lowStock as $p)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <a href="{{ route('admin.products.edit', $p) }}" data-spa-link>{{ $p->size_label }}</a>
                    <span class="p-badge {{ $p->stock <= 2 ? 'red' : 'yellow' }}">{{ $p->stock }} db</span>
                </div>
            @empty
                <p class="text-muted small mb-0">Minden készlet rendben.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
  if (!window.Chart) return;
  const traffic = @json($d['traffic_chart']);
  const sales = @json($d['sales_chart']);
  const devices = @json($d['devices']->map(fn($x) => ['label' => $x->device ?: 'egyéb', 'value' => (int)$x->c]));

  const ctx = document.getElementById('dashComboChart');
  if (ctx) {
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: traffic.labels,
        datasets: [
          {
            label: 'Látogatók',
            data: traffic.series.visitors,
            borderColor: '#008060',
            backgroundColor: 'rgba(0,128,96,.12)',
            tension: .35,
            fill: true,
            yAxisID: 'y'
          },
          {
            label: 'Bevétel (Ft)',
            data: sales.series.revenue,
            borderColor: '#2c6ecb',
            backgroundColor: 'rgba(44,110,203,.08)',
            tension: .35,
            fill: false,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'bottom' } },
        scales: {
          y: { beginAtZero: true, position: 'left' },
          y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
        }
      }
    });
  }

  const dctx = document.getElementById('dashDeviceChart');
  if (dctx && devices.length) {
    new Chart(dctx, {
      type: 'doughnut',
      data: {
        labels: devices.map(d => d.label),
        datasets: [{
          data: devices.map(d => d.value),
          backgroundColor: ['#008060', '#2c6ecb', '#b98900', '#6d7175']
        }]
      },
      options: { plugins: { legend: { position: 'bottom' } } }
    });
  }
})();
</script>
@endpush
@endsection
