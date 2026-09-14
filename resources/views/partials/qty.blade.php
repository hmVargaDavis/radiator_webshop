@php
    $qtyName = $qtyName ?? 'quantity';
@endphp
<div class="qty-control" data-qty-wrap>
    <button type="button" data-qty-minus aria-label="Csökkentés">−</button>
    <select class="qty-value" data-qty-select data-value="1" aria-label="Darabszám"></select>
    <button type="button" data-qty-plus aria-label="Növelés">+</button>
    <input type="hidden" name="{{ $qtyName }}" value="1">
</div>
