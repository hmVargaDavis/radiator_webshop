@extends('layouts.admin')
@section('title', $product->exists ? 'Termék szerkesztése' : 'Új termék')
@section('content')
<h1 class="h3 fw-bold mb-3">{{ $product->exists ? 'Termék szerkesztése' : 'Új termék' }}</h1>
<form method="post" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="admin-card">
    @csrf
    @if($product->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Név</label><input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}"></div>
        <div class="col-md-6"><label class="form-label">Méret felirat</label><input type="text" name="size_label" class="form-control" required value="{{ old('size_label', $product->size_label) }}" placeholder="600 × 600 mm"></div>
        <div class="col-md-3"><label class="form-label">Magasság (mm)</label><input type="number" name="height_mm" class="form-control" required value="{{ old('height_mm', $product->height_mm ?: 600) }}"></div>
        <div class="col-md-3"><label class="form-label">Szélesség (mm)</label><input type="number" name="width_mm" class="form-control" required value="{{ old('width_mm', $product->width_mm) }}"></div>
        <div class="col-md-3"><label class="form-label">Ár (Ft)</label><input type="number" name="price" class="form-control" required value="{{ old('price', $product->price) }}"></div>
        <div class="col-md-3"><label class="form-label">Készlet</label><input type="number" name="stock" class="form-control" required value="{{ old('stock', $product->stock ?: 0) }}"></div>
        <div class="col-md-3"><label class="form-label">Sorrend</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $product->sort_order ?: 0) }}"></div>
        <div class="col-md-9"><label class="form-label">Termékfotó</label><input type="file" name="image_file" class="form-control" accept="image/*">@if($product->image)<div class="form-text">Jelenlegi: {{ $product->image }}</div>@endif</div>
        <div class="col-12"><label class="form-label">Rövid leírás</label><textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $product->short_description) }}</textarea></div>
        <div class="col-12"><label class="form-label">Részletes leírás</label><textarea name="description" class="form-control" rows="6">{{ old('description', $product->description) }}</textarea></div>
        <div class="col-12"><label class="form-label">Csomag tartalma (soronként)</label><textarea name="package_contents" class="form-control" rows="5">{{ old('package_contents', $product->package_contents) }}</textarea></div>
        <div class="col-md-6"><label class="form-label">SEO cím</label><input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}"></div>
        <div class="col-md-6"><label class="form-label">SEO leírás</label><input type="text" name="meta_description" class="form-control" value="{{ old('meta_description', $product->meta_description) }}"></div>
        <div class="col-12"><label class="form-label">Kulcsszavak (vesszővel)</label><input type="text" name="keywords" class="form-control" value="{{ old('keywords', $product->keywords) }}" placeholder="22K radiátor Budapest, panelradiátor 600x600..."></div>
        <div class="col-12"><label class="form-label">AI / gépi JSON leírás</label><textarea name="ai_description" class="form-control" rows="6" placeholder="Részletes, tényalapú leírás AI és keresők számára">{{ old('ai_description', $product->ai_description) }}</textarea><div class="form-text">Ez jelenik meg a termék .json végpontján és a schema.org description mezőben.</div></div>
        <div class="col-md-6 form-check ms-2"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $product->is_active ?? true))><label class="form-check-label" for="is_active">Aktív</label></div>
        <div class="col-md-6 form-check"><input class="form-check-input" type="checkbox" name="in_stock" value="1" id="in_stock" @checked(old('in_stock', $product->in_stock ?? true))><label class="form-check-label" for="in_stock">Raktáron</label></div>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn-primary-shop" type="submit">Mentés</button>
        <a href="{{ route('admin.products.index') }}" class="btn-outline-shop">Vissza</a>
    </div>
</form>
@endsection
