<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::approved()->paginate(12);

        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'author_name' => 'required|string|max:80',
            'author_city' => 'nullable|string|max:80',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:20|max:1000',
        ], [
            'author_name.required' => 'Adja meg a nevét.',
            'content.required' => 'Írjon értékelést.',
            'content.min' => 'Az értékelés legyen legalább 20 karakter.',
            'rating.required' => 'Válasszon csillagértékelést.',
        ]);

        Review::create([
            'author_name' => $data['author_name'],
            'author_city' => $data['author_city'] ?? 'Budapest',
            'rating' => $data['rating'],
            'content' => $data['content'],
            'is_approved' => false,
            'is_featured' => false,
            'source' => 'customer',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'ok' => true,
                'message' => 'Köszönjük az értékelést! Moderálás után jelenik meg az oldalon.',
            ]);
        }

        return back()->with('success', 'Köszönjük az értékelést! Moderálás után jelenik meg az oldalon.');
    }
}
