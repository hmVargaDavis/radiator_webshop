<?php $__env->startSection('title', 'Analitika'); ?>

<?php $__env->startSection('content'); ?>
<?php $d = $data; ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <p class="text-muted mb-0">Látogatottság, források, eszközök, UTM kampányok</p>
    <div class="p-range">
        <?php $__currentLoopData = ['today'=>'Ma','7d'=>'7 nap','30d'=>'30 nap','90d'=>'90 nap']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.analytics', ['range'=>$k])); ?>" class="<?php echo e($d['range']===$k ? 'active' : ''); ?>" data-spa-link><?php echo e($label); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3"><div class="p-kpi"><div class="label">Megtekintések</div><div class="value"><?php echo e(number_format($d['summary']['views'],0,',','.')); ?></div></div></div>
    <div class="col-6 col-md-3"><div class="p-kpi"><div class="label">Látogatók</div><div class="value"><?php echo e(number_format($d['summary']['visitors'],0,',','.')); ?></div></div></div>
    <div class="col-6 col-md-3"><div class="p-kpi"><div class="label">1 oldalas session</div><div class="value"><?php echo e(number_format($d['summary']['bounce_like'],0,',','.')); ?></div></div></div>
    <div class="col-6 col-md-3"><div class="p-kpi"><div class="label">Átlag válaszidő</div><div class="value"><?php echo e($d['summary']['avg_ms']); ?> ms</div></div></div>
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
                <?php $__empty_1 = true; $__currentLoopData = $d['referrers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($r->referrer_host); ?></strong></td>
                        <td><span class="p-badge blue"><?php echo e($r->source_type); ?></span></td>
                        <td><?php echo e($r->views); ?></td>
                        <td><?php echo e($r->visitors); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-muted">Még nincs külső forrás. Ha Google-ból / Facebookról jönnek, itt fog megjelenni.</td></tr>
                <?php endif; ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $d['utm_sources']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between small mb-1"><span><?php echo e($u->name); ?></span><strong><?php echo e($u->c); ?></strong></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="small text-muted">Nincs UTM adat.</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <h3 class="h6">utm_medium</h3>
                    <?php $__empty_1 = true; $__currentLoopData = $d['utm_mediums']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between small mb-1"><span><?php echo e($u->name); ?></span><strong><?php echo e($u->c); ?></strong></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="small text-muted">-</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <h3 class="h6">utm_campaign</h3>
                    <?php $__empty_1 = true; $__currentLoopData = $d['utm_campaigns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between small mb-1"><span><?php echo e($u->name); ?></span><strong><?php echo e($u->c); ?></strong></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="small text-muted">-</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="p-card">
            <div class="p-card-title">Böngészők</div>
            <?php $__currentLoopData = $d['browsers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex justify-content-between mb-2"><span><?php echo e($b->name); ?></span><strong><?php echo e($b->c); ?></strong></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($d['browsers']->isEmpty()): ?><p class="text-muted small mb-0">Nincs adat.</p><?php endif; ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="p-card">
            <div class="p-card-title">Belépő oldalak</div>
            <?php $__currentLoopData = $d['entry_paths']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex justify-content-between mb-2 gap-2"><code class="small"><?php echo e($p->path); ?></code><strong><?php echo e($p->c); ?></strong></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($d['entry_paths']->isEmpty()): ?><p class="text-muted small mb-0">Nincs adat.</p><?php endif; ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="p-card">
            <div class="p-card-title">Top oldalak</div>
            <?php $__currentLoopData = $d['top_pages']->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex justify-content-between mb-2 gap-2"><code class="small"><?php echo e($p->path); ?></code><strong><?php echo e($p->views); ?></strong></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($d['top_pages']->isEmpty()): ?><p class="text-muted small mb-0">Nincs adat.</p><?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
(function(){
  if (!window.Chart) return;
  const traffic = <?php echo json_encode($d['traffic_chart'], 15, 512) ?>;
  const hourly = <?php echo json_encode($d['hourly'], 15, 512) ?>;
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/admin/analytics/index.blade.php ENDPATH**/ ?>