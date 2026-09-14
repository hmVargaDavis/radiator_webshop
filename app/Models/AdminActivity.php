<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $fillable = ['type', 'title', 'description', 'link', 'meta'];

    protected function casts(): array
    {
        return ['meta' => 'array'];
    }

    public static function log(string $type, string $title, ?string $description = null, ?string $link = null, array $meta = []): self
    {
        return static::create([
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'link' => $link,
            'meta' => $meta ?: null,
        ]);
    }
}
