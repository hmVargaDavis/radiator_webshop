<div class="row g-3 g-md-4" id="productGrid">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-6 col-md-4 col-xl-3 product-grid-item" data-product-id="<?php echo e($product->id); ?>">
            <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="admin-card text-center py-5">
                <p class="mb-0 text-muted">Nincs találat a szűrésre. Próbáljon másik méretet vagy árintervallumot.</p>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/partials/product-grid.blade.php ENDPATH**/ ?>