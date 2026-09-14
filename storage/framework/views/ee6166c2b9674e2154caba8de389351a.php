<div id="productListMobile">
<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="product-list-row">
        <a href="<?php echo e(route('products.show', $product)); ?>">
            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>">
        </a>
        <div>
            <a href="<?php echo e(route('products.show', $product)); ?>"><strong class="text-navy"><?php echo e($product->size_label); ?></strong></a>
            <div class="product-price mb-0"><?php echo e($product->formatted_price); ?>/db</div>
        </div>
        <div class="row-actions">
            <form action="<?php echo e(route('cart.add')); ?>" method="post" data-add-to-cart class="d-flex flex-wrap gap-2 align-items-center">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <?php echo $__env->make('partials.qty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <button class="btn-primary-shop" type="submit"><i class="fa-solid fa-cart-shopping"></i> Kosárba</button>
            </form>
            <a href="<?php echo e(route('products.show', $product)); ?>" class="small d-inline-block mt-1">Részletek →</a>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="admin-card text-center py-4">
        <p class="mb-0 text-muted">Nincs találat.</p>
    </div>
<?php endif; ?>
</div>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/partials/product-list-mobile.blade.php ENDPATH**/ ?>