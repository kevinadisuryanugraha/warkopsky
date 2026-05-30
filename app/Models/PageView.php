<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class PageView extends Model
{
    /**
     * Disable default timestamps (we use visited_at instead).
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'url',
        'page_name',
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'device_type',
        'referer',
        'country',
        'session_id',
        'visited_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }

    /* ========================================
       QUERY SCOPES
       ======================================== */

    /**
     * Scope: filter by today's visits only.
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('visited_at', Carbon::today());
    }

    /**
     * Scope: filter by this week's visits.
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('visited_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    /**
     * Scope: filter by this month's visits.
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereBetween('visited_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ]);
    }

    /**
     * Scope: filter by a custom date range.
     */
    public function scopeDateRange(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('visited_at', [
            Carbon::parse($from)->startOfDay(),
            Carbon::parse($to)->endOfDay(),
        ]);
    }

    /**
     * Scope: filter visits from the last N days.
     */
    public function scopeLastDays(Builder $query, int $days): Builder
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays($days)->startOfDay());
    }
}
