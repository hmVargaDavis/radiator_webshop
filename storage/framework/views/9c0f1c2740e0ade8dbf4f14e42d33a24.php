<?php $__env->startSection('title', 'Vélemények | Radiátor Outlet Budapest'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h1 class="section-title">Vélemények</h1>
    <p class="section-sub">Valódi visszajelzések elégedett ügyfeleinktől.</p>
    <div class="row g-3 mb-4">
        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 col-lg-4">
                <article class="review-card">
                    <div class="stars">
                        <?php for($i=1;$i<=5;$i++): ?>
                            <i class="<?php echo e($i <= $review->rating ? 'fa-solid' : 'fa-regular'); ?> fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="review-text">„<?php echo e($review->content); ?>”</p>
                    <div class="review-author"><?php echo e($review->author_name); ?><?php if($review->author_city): ?>, <?php echo e($review->author_city); ?><?php endif; ?></div>
                </article>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>Még nincsenek jóváhagyott vélemények.</p>
        <?php endif; ?>
    </div>
    <?php echo e($reviews->links()); ?>


    <div class="package-box mt-4">
        <h2 class="h5 fw-bold mb-3">Értékelés írása</h2>
        <form method="post" action="<?php echo e(route('reviews.store')); ?>" class="row g-3" data-ajax-review>
            <?php echo csrf_field(); ?>
            <div class="col-md-4"><input type="text" name="author_name" class="form-control" placeholder="Név" required value="<?php echo e(old('author_name')); ?>"></div>
            <div class="col-md-4"><input type="text" name="author_city" class="form-control" placeholder="Város" value="<?php echo e(old('author_city', 'Budapest')); ?>"></div>
            <div class="col-md-4">
                <select name="rating" class="form-select" required>
                    <?php for($i=5;$i>=1;$i--): ?><option value="<?php echo e($i); ?>"><?php echo e($i); ?> csillag</option><?php endfor; ?>
                </select>
            </div>
            <div class="col-12"><textarea name="content" class="form-control" rows="4" required minlength="20" placeholder="Írja meg tapasztalatait"><?php echo e(old('content')); ?></textarea></div>
            <div class="col-12"><button class="btn-primary-shop" type="submit">Értékelés elküldése</button></div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/reviews/index.blade.php ENDPATH**/ ?>