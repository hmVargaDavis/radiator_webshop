<?php
    $qtyName = $qtyName ?? 'quantity';
?>
<div class="qty-control" data-qty-wrap>
    <button type="button" data-qty-minus aria-label="Csökkentés">−</button>
    <select class="qty-value" data-qty-select data-value="1" aria-label="Darabszám"></select>
    <button type="button" data-qty-plus aria-label="Növelés">+</button>
    <input type="hidden" name="<?php echo e($qtyName); ?>" value="1">
</div>
<?php /**PATH C:\Users\vargad\Documents\mgan\radiator_webshop\resources\views/partials/qty.blade.php ENDPATH**/ ?>