<?php $__env->startSection('title', 'Keresés'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-card mb-3">
    <form action="<?php echo e(route('admin.search')); ?>" method="get" class="d-flex gap-2">
        <input type="search" name="q" class="form-control form-control-lg" value="<?php echo e($q); ?>" placeholder="Rendelésszám, név, e-mail, méret..." autofocus>
        <button class="polaris-btn polaris-btn-primary" type="submit">Keresés</button>
    </form>
</div>
<?php echo $__env->make('admin.partials.search-results', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/admin/search.blade.php ENDPATH**/ ?>