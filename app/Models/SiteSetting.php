<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'label'];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('site_settings', 300, function () {
            return static::query()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    public static function setValue(string $key, mixed $value, string $group = 'general', ?string $label = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'label' => $label]
        );
        Cache::forget('site_settings');
    }

    public static function clearCache(): void
    {
        Cache::forget('site_settings');
    }
}
