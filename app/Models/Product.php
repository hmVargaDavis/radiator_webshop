<?php

namespace App\Models;

use App\Services\SeoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'height_mm', 'width_mm', 'size_label', 'price',
        'image', 'short_description', 'description', 'package_contents',
        'stock', 'is_active', 'in_stock', 'sort_order', 'meta_title', 'meta_description',
        'ai_description', 'keywords', 'og_image',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'in_stock' => 'boolean',
            'price' => 'integer',
            'stock' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->size_label.'-mm').'-'.Str::random(4);
            }
        });

        static::saving(function (Product $product) {
            if (empty($product->ai_description)) {
                $product->ai_description = app(SeoService::class)->defaultAiDescription($product);
            }
            if (empty($product->keywords)) {
                $product->keywords = implode(', ', app(SeoService::class)->defaultKeywords($product));
            }
            if (empty($product->meta_title)) {
                $product->meta_title = "22K radiátor {$product->size_label} Budapest | Radiátor Outlet";
            }
            if (empty($product->meta_description)) {
                $price = number_format((int) $product->price, 0, ',', '.');
                $product->meta_description = "Új 22K panelradiátor {$product->size_label} Budapesten, raktárról. Ár: {$price} Ft/db. Kiszállítás Budapesten, átvétel Soroksáron.";
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.').' Ft';
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('images/products/radiator-1.jpg');
        }

        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, '/')) {
            return str_starts_with($this->image, 'http') ? $this->image : asset(ltrim($this->image, '/'));
        }

        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('storage/'.$this->image);
    }

    public function getOgImageUrlAttribute(): string
    {
        if ($this->og_image) {
            if (str_starts_with($this->og_image, 'http')) {
                return $this->og_image;
            }
            if (str_starts_with($this->og_image, 'images/')) {
                return asset($this->og_image);
            }

            return asset('storage/'.$this->og_image);
        }

        return $this->image_url;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('width_mm');
    }

    public function toAiArray(): array
    {
        return app(SeoService::class)->productAiPayload($this);
    }
}
