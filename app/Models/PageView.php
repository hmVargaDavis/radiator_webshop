<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'path', 'full_url', 'method', 'referrer', 'referrer_host',
        'utm_source', 'utm_medium', 'utm_campaign', 'ip_hash', 'session_id',
        'user_agent', 'device', 'browser', 'country', 'is_bot', 'response_time_ms',
    ];

    protected function casts(): array
    {
        return [
            'is_bot' => 'boolean',
            'response_time_ms' => 'integer',
        ];
    }

    public function scopeHuman($query)
    {
        return $query->where('is_bot', false);
    }

    public function scopeBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }
}
