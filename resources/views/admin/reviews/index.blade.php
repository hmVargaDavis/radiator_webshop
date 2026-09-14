@extends('layouts.admin')
@section('title', 'Vélemények')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3 fw-bold">Vélemények</h1>
    <a href="{{ route('admin.reviews.create') }}" class="btn-primary-shop">Új vélemény</a>
</div>
<div class="admin-card table-responsive">
<table class="table">
<thead><tr><th>Név</th><th>Csillag</th><th>Szöveg</th><th>Jóváhagyva</th><th></th></tr></thead>
<tbody>
@foreach($reviews as $review)
<tr>
<td>{{ $review->author_name }}</td>
<td>{{ $review->rating }}</td>
<td>{{ \Illuminate\Support\Str::limit($review->content, 80) }}</td>
<td>{{ $review->is_approved ? 'Igen' : 'Nem' }}</td>
<td>
<a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-outline-primary">Szerkesztés</a>
<form action="{{ route('admin.reviews.destroy', $review) }}" method="post" class="d-inline" onsubmit="return confirm('Törli?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Törlés</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $reviews->links() }}
</div>
@endsection
