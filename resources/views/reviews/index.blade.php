@extends('layouts.app')
@section('title', 'Vélemények | Radiátor Outlet Budapest')
@section('content')
<div class="container py-4">
    <h1 class="section-title">Vélemények</h1>
    <p class="section-sub">Valódi visszajelzések elégedett ügyfeleinktől.</p>
    <div class="row g-3 mb-4">
        @forelse($reviews as $review)
            <div class="col-md-6 col-lg-4">
                <article class="review-card">
                    <div class="stars">
                        @for($i=1;$i<=5;$i++)
                            <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <p class="review-text">„{{ $review->content }}”</p>
                    <div class="review-author">{{ $review->author_name }}@if($review->author_city), {{ $review->author_city }}@endif</div>
                </article>
            </div>
        @empty
            <p>Még nincsenek jóváhagyott vélemények.</p>
        @endforelse
    </div>
    {{ $reviews->links() }}

    <div class="package-box mt-4">
        <h2 class="h5 fw-bold mb-3">Értékelés írása</h2>
        <form method="post" action="{{ route('reviews.store') }}" class="row g-3" data-ajax-review>
            @csrf
            <div class="col-md-4"><input type="text" name="author_name" class="form-control" placeholder="Név" required value="{{ old('author_name') }}"></div>
            <div class="col-md-4"><input type="text" name="author_city" class="form-control" placeholder="Város" value="{{ old('author_city', 'Budapest') }}"></div>
            <div class="col-md-4">
                <select name="rating" class="form-select" required>
                    @for($i=5;$i>=1;$i--)<option value="{{ $i }}">{{ $i }} csillag</option>@endfor
                </select>
            </div>
            <div class="col-12"><textarea name="content" class="form-control" rows="4" required minlength="20" placeholder="Írja meg tapasztalatait">{{ old('content') }}</textarea></div>
            <div class="col-12"><button class="btn-primary-shop" type="submit">Értékelés elküldése</button></div>
        </form>
    </div>
</div>
@endsection
