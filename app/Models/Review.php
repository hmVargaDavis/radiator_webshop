<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'author_name', 'author_city', 'rating', 'content',
        'is_approved', 'is_featured', 'source',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
            'rating' => 'integer',
        ];
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true)->latest();
    }

    public function scopeFeatured($query)
    {
        return $query->approved()->where('is_featured', true);
    }
}
