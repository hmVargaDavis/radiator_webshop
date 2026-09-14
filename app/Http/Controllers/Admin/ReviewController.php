<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.reviews.form', ['review' => new Review()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Review::create($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Vélemény létrehozva.');
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.form', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $review->update($this->validated($request));

        return redirect()->route('admin.reviews.index')->with('success', 'Vélemény mentve.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Vélemény törölve.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'author_name' => 'required|string|max:80',
            'author_city' => 'nullable|string|max:80',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:2000',
            'source' => 'nullable|string|max:40',
        ]) + [
            'is_approved' => $request->boolean('is_approved'),
            'is_featured' => $request->boolean('is_featured'),
            'source' => $request->input('source', 'webshop'),
        ];
    }
}
