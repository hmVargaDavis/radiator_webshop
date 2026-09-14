<?php if(mb_strlen($q) < 2): ?>
    <div class="p-card"><p class="text-muted mb-0">Írjon be legalább 2 karaktert.</p></div>
<?php else: ?>
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="p-card h-100">
                <div class="p-card-title">Termékek</div>
                <?php $__empty_1 = true; $__currentLoopData = $results['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a class="d-block mb-2" href="<?php echo e(route('admin.products.edit', $p)); ?>" data-spa-link>
                        <strong><?php echo e($p->size_label); ?></strong>
                        <div class="small text-muted"><?php echo e(number_format($p->price, 0, ',', '.')); ?> Ft</div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted small mb-0">Nincs találat.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="p-card h-100">
                <div class="p-card-title">Rendelések</div>
                <?php $__empty_1 = true; $__currentLoopData = $results['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a class="d-block mb-2" href="<?php echo e(route('admin.orders.show', $o)); ?>" data-spa-link>
                        <strong><?php echo e($o->order_number); ?></strong>
                        <div class="small text-muted"><?php echo e($o->customer_name); ?> · <?php echo e(number_format($o->total, 0, ',', '.')); ?> Ft</div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted small mb-0">Nincs találat.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="p-card h-100">
                <div class="p-card-title">Vélemények</div>
                <?php $__empty_1 = true; $__currentLoopData = $results['reviews']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a class="d-block mb-2" href="<?php echo e(route('admin.reviews.edit', $rev)); ?>" data-spa-link>
                        <strong><?php echo e($rev->author_name); ?></strong>
                        <div class="small text-muted"><?php echo e(\Illuminate\Support\Str::limit($rev->content, 70)); ?></div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted small mb-0">Nincs találat.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/admin/partials/search-results.blade.php ENDPATH**/ ?>