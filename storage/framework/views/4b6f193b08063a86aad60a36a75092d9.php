<div class="product-card">
    <a href="<?php echo e(route('products.show', $product)); ?>" class="product-card-img">
        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" loading="lazy" width="400" height="300">
    </a>
    <a href="<?php echo e(route('products.show', $product)); ?>">
        <h3 class="product-size"><?php echo e($product->size_label); ?></h3>
    </a>
    <div class="product-price"><?php echo e($product->formatted_price); ?>/db</div>

    <form action="<?php echo e(route('cart.add')); ?>" method="post" data-add-to-cart class="mt-auto">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <?php echo $__env->make('partials.qty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <button type="submit" class="btn-primary-shop flex-grow-1">
                <i class="fa-solid fa-cart-shopping"></i> Kosárba
            </button>
        </div>
        <a href="<?php echo e(route('products.show', $product)); ?>" class="small d-inline-block mt-2">Részletek →</a>
    </form>
</div>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/partials/product-card.blade.php ENDPATH**/ ?>