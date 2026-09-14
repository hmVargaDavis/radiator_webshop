@extends('layouts.admin')
@section('title', 'Vélemény')
@section('content')
<h1 class="h3 fw-bold mb-3">{{ $review->exists ? 'Vélemény szerkesztése' : 'Új vélemény' }}</h1>
<form method="post" action="{{ $review->exists ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}" class="admin-card">
@csrf
@if($review->exists) @method('PUT') @endif
<div class="row g-3">
<div class="col-md-4"><label class="form-label">Név</label><input name="author_name" class="form-control" required value="{{ old('author_name', $review->author_name) }}"></div>
<div class="col-md-4"><label class="form-label">Város</label><input name="author_city" class="form-control" value="{{ old('author_city', $review->author_city) }}"></div>
<div class="col-md-4"><label class="form-label">Értékelés</label><select name="rating" class="form-select">@for($i=5;$i>=1;$i--)<option value="{{ $i }}" @selected(old('rating', $review->rating ?: 5)==$i)>{{ $i }}</option>@endfor</select></div>
<div class="col-12"><label class="form-label">Szöveg</label><textarea name="content" class="form-control" rows="5" required>{{ old('content', $review->content) }}</textarea></div>
<div class="col-md-4 form-check ms-2"><input type="checkbox" class="form-check-input" name="is_approved" value="1" id="is_approved" @checked(old('is_approved', $review->is_approved ?? true))><label for="is_approved" class="form-check-label">Jóváhagyva</label></div>
<div class="col-md-4 form-check"><input type="checkbox" class="form-check-input" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $review->is_featured ?? true))><label for="is_featured" class="form-check-label">Kiemelt</label></div>
</div>
<button class="btn-primary-shop mt-3" type="submit">Mentés</button>
</form>
@endsection
