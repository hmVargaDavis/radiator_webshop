<?php $__env->startSection('title', 'SEO'); ?>

<?php $__env->startSection('content'); ?>
<?php $r = $report; $scoreClass = $r['score'] >= 80 ? 'good' : ($r['score'] >= 55 ? 'mid' : 'bad'); ?>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="p-card h-100 text-center">
            <div class="p-card-title justify-content-center"><span>Termék SEO átlag</span></div>
            <div class="seo-score <?php echo e($scoreClass); ?> mx-auto mb-2"><?php echo e($r['score']); ?></div>
            <p class="text-muted small mb-0"><?php echo e($r['active_count']); ?> aktív termék · <?php echo e($r['with_ai']); ?> AI leírással</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-card h-100 text-center">
            <div class="p-card-title justify-content-center"><span>Technikai checklist</span></div>
            <div class="seo-score good mx-auto mb-2"><?php echo e($r['checklist_score']); ?></div>
            <p class="text-muted small mb-0">Sitemap, schema, PWA, robots</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-card h-100">
            <div class="p-card-title"><span>Gyors linkek</span></div>
            <div class="d-grid gap-2">
                <a class="polaris-btn polaris-btn-ghost" href="<?php echo e(url('/sitemap.xml')); ?>" target="_blank">sitemap.xml</a>
                <a class="polaris-btn polaris-btn-ghost" href="<?php echo e(url('/llms.txt')); ?>" target="_blank">llms.txt</a>
                <a class="polaris-btn polaris-btn-ghost" href="<?php echo e(url('/api/katalogus.json')); ?>" target="_blank">katalógus JSON</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-6">
        <div class="p-card">
            <div class="p-card-title">SEO / GEO checklist</div>
            <?php $__currentLoopData = $r['checklist']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="check-row">
                    <span class="check-ico <?php echo e($item['ok'] ? 'ok' : 'bad'); ?>"><i class="bi <?php echo e($item['ok'] ? 'bi-check-lg' : 'bi-x-lg'); ?>"></i></span>
                    <div>
                        <strong><?php echo e($item['label']); ?></strong>
                        <div class="small text-muted"><?php echo e($item['hint']); ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="p-card">
            <div class="p-card-title">Organikus / kereső forgalmú útvonalak</div>
            <?php $__empty_1 = true; $__currentLoopData = $r['top_organic_paths']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex justify-content-between mb-2 gap-2">
                    <code class="small"><?php echo e($p->path); ?></code>
                    <strong><?php echo e($p->c); ?></strong>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-muted small mb-0">Még nincs organikus forgalmi adat.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="p-card">
    <div class="p-card-title">
        <span>Termék SEO problémák</span>
        <a href="<?php echo e(route('admin.products.index')); ?>" data-spa-link>Termékek</a>
    </div>
    <?php $__empty_1 = true; $__currentLoopData = $r['issues']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="border rounded-3 p-3 mb-2">
            <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                <div>
                    <strong><?php echo e($issue['product']->name); ?></strong>
                    <div class="small text-muted"><?php echo e($issue['product']->size_label); ?></div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="p-badge <?php echo e($issue['score'] >= 80 ? 'green' : ($issue['score'] >= 55 ? 'yellow' : 'red')); ?>"><?php echo e($issue['score']); ?>/100</span>
                    <a class="polaris-btn polaris-btn-ghost" href="<?php echo e(route('admin.products.edit', $issue['product'])); ?>" data-spa-link>Javítás</a>
                </div>
            </div>
            <ul class="mb-0 mt-2 small text-muted">
                <?php $__currentLoopData = $issue['issues']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($msg); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-muted mb-0">Minden termék SEO mezője rendben van.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/admin/seo/index.blade.php ENDPATH**/ ?>