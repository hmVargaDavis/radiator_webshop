<?php $__env->startSection('title', 'Kezdőlap'); ?>

<?php $__env->startSection('content'); ?>
<?php $d = $data; ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <div class="text-muted small">Üzleti áttekintés · Budapest webshop</div>
    </div>
    <div class="p-range">
        <a href="<?php echo e(route('admin.dashboard', ['range' => 'today'])); ?>" class="<?php echo e(($d['range'] ?? '') === 'today' ? 'active' : ''); ?>" data-spa-link>Ma</a>
        <a href="<?php echo e(route('admin.dashboard', ['range' => '7d'])); ?>" class="<?php echo e(($d['range'] ?? '') === '7d' ? 'active' : ''); ?>" data-spa-link>7 nap</a>
        <a href="<?php echo e(route('admin.dashboard', ['range' => '30d'])); ?>" class="<?php echo e(($d['range'] ?? '') === '30d' ? 'active' : ''); ?>" data-spa-link>30 nap</a>
        <a href="<?php echo e(route('admin.dashboard', ['range' => '90d'])); ?>" class="<?php echo e(($d['range'] ?? '') === '90d' ? 'active' : ''); ?>" data-spa-link>90 nap</a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-lg-3">
        <div class="p-kpi">
            <div class="label">Bevétel</div>
            <div class="value"><?php echo e(number_format($d['revenue'], 0, ',', '.')); ?> Ft</div>
            <div class="delta <?php echo e($d['revenue_change'] >= 0 ? 'up' : 'down'); ?>">
                <?php echo e($d['revenue_change'] >= 0 ? '+' : ''); ?><?php echo e($d['revenue_change']); ?>% az előző időszakhoz
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="p-kpi">
            <div class="label">Rendelések</div>
            <div class="value"><?php echo e($d['orders']); ?></div>
            <div class="delta">Átlag kosár: <?php echo e(number_format($d['avg_order'], 0, ',', '.')); ?> Ft</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="p-kpi">
            <div class="label">Látogatók</div>
            <div class="value"><?php echo e(number_format($d['visitors'], 0, ',', '.')); ?></div>
            <div class="delta <?php echo e($d['visitor_change'] >= 0 ? 'up' : 'down'); ?>">
                <?php echo e($d['visitor_change'] >= 0 ? '+' : ''); ?><?php echo e($d['visitor_change']); ?>% · <?php echo e(number_format($d['page_views'], 0, ',', '.')); ?> megtekintés
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="p-kpi">
            <div class="label">Konverzió</div>
            <div class="value"><?php echo e(number_format($d['conversion'], 2, ',', '.')); ?>%</div>
            <div class="delta">Ma új rendelés: <?php echo e($d['new_orders_today']); ?></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-8">
        <div class="p-card h-100">
            <div class="p-card-title">
                <span>Forgalom és bevétel</span>
                <a href="<?php echo e(route('admin.analytics', ['range' => $d['range']])); ?>" class="small" data-spa-link>Részletes analitika</a>
            </div>
            <canvas id="dashComboChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="p-card h-100">
            <div class="p-card-title"><span>Eszközök</span></div>
            <canvas id="dashDeviceChart" height="180"></canvas>
            <div class="mt-3">
                <?php $__currentLoopData = $d['devices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-capitalize"><?php echo e($dev->device ?: 'ismeretlen'); ?></span>
                        <strong><?php echo e($dev->c); ?></strong>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($d['devices']->isEmpty()): ?>
                    <p class="text-muted small mb-0">Még nincs elég látogatási adat. Böngészd a webshopot, az adatok itt jelennek meg.</p>
                <?php endif; ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $d['top_referrers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($ref->referrer_host); ?></strong></td>
                        <td><span class="p-badge blue"><?php echo e($ref->source_type); ?></span></td>
                        <td><?php echo e($ref->visitors); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="text-muted">Direct / nincs külső forrás még.</td></tr>
                <?php endif; ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $d['top_pages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><code><?php echo e($page->path); ?></code></td>
                        <td><?php echo e($page->views); ?></td>
                        <td><?php echo e($page->visitors); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="text-muted">Nincs adat.</td></tr>
                <?php endif; ?>
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
                <a href="<?php echo e(route('admin.orders.index')); ?>" data-spa-link>Összes</a>
            </div>
            <div class="table-responsive">
                <table class="p-table p-table-mobile">
                    <thead><tr><th>Szám</th><th>Vásárló</th><th>Összeg</th><th>Státusz</th></tr></thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $d['recent_orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><a href="<?php echo e(route('admin.orders.show', $order)); ?>" data-spa-link><?php echo e($order->order_number); ?></a></td>
                            <td><?php echo e($order->customer_name); ?></td>
                            <td><?php echo e(number_format($order->total, 0, ',', '.')); ?> Ft</td>
                            <td><span class="p-badge"><?php echo e($order->status); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="4" class="text-muted">Még nincs rendelés.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="p-card mb-3">
            <div class="p-card-title"><span>Gyors teendők</span></div>
            <div class="d-grid gap-2">
                <a class="polaris-btn polaris-btn-ghost justify-content-between" href="<?php echo e(route('admin.reviews.index')); ?>" data-spa-link>
                    Jóváhagyásra váró vélemények <span class="p-badge yellow"><?php echo e($d['pending_reviews']); ?></span>
                </a>
                <a class="polaris-btn polaris-btn-ghost justify-content-between" href="<?php echo e(route('admin.seo')); ?>" data-spa-link>
                    SEO állapot ellenőrzése <i class="bi bi-arrow-right"></i>
                </a>
                <a class="polaris-btn polaris-btn-ghost justify-content-between" href="<?php echo e(route('admin.products.index')); ?>" data-spa-link>
                    Aktív termékek <span class="p-badge green"><?php echo e($d['products']); ?></span>
                </a>
            </div>
        </div>
        <div class="p-card">
            <div class="p-card-title"><span>Alacsony készlet</span></div>
            <?php $__empty_1 = true; $__currentLoopData = $lowStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <a href="<?php echo e(route('admin.products.edit', $p)); ?>" data-spa-link><?php echo e($p->size_label); ?></a>
                    <span class="p-badge <?php echo e($p->stock <= 2 ? 'red' : 'yellow'); ?>"><?php echo e($p->stock); ?> db</span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-muted small mb-0">Minden készlet rendben.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
(function(){
  if (!window.Chart) return;
  const traffic = <?php echo json_encode($d['traffic_chart'], 15, 512) ?>;
  const sales = <?php echo json_encode($d['sales_chart'], 15, 512) ?>;
  const devices = <?php echo json_encode($d['devices']->map(fn($x) => ['label' => $x->device ?: 'egyéb', 'value' => (int)$x->c]), 512) ?>;

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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>