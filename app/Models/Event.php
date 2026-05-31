<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'event_date',
        'event_time_start',
        'event_time_end',
        'location',
        'poster_image',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'event_date'  => 'date',
        'is_featured' => 'boolean',
    ];

    /* ─── Accessors ─── */

    /**
     * "Sabtu, 31 Mei 2026"
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->event_date
            ? $this->event_date->translatedFormat('l, d F Y')
            : '-';
    }

    /**
     * "23.00 WIB – Selesai"  or  "20.00 – 23.00 WIB"
     */
    public function getFormattedTimeAttribute(): string
    {
        $start = $this->event_time_start
            ? Carbon::parse($this->event_time_start)->format('H.i')
            : '';

        if ($this->event_time_end) {
            $end = Carbon::parse($this->event_time_end)->format('H.i');
            return "$start – $end WIB";
        }

        return $start ? "$start WIB – Selesai" : '-';
    }

    /**
     * Human-readable category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'nobar'         => 'NOBAR',
            'live_music'    => 'Live Music',
            'special_event' => 'Special Event',
            'promo'         => 'Promo',
            'tournament'    => 'Tournament',
            default         => 'Lainnya',
        };
    }

    /**
     * CSS badge class for category.
     */
    public function getCategoryBadgeAttribute(): string
    {
        return match ($this->category) {
            'nobar'         => 'badge-nobar',
            'live_music'    => 'badge-live',
            'special_event' => 'badge-special',
            'promo'         => 'badge-promo',
            'tournament'    => 'badge-tournament',
            default         => 'badge-lainnya',
        };
    }

    /* ─── Scopes ─── */

    /**
     * Events visible to the public (upcoming or ongoing).
     */
    public function scopeVisible($query)
    {
        return $query->whereIn('status', ['upcoming', 'ongoing'])
                     ->orderBy('event_date', 'asc');
    }

    /**
     * Auto-generate slug from title before saving.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . time();
            }
        });
    }
}
