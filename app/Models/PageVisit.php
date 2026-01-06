<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVisit extends Model
{
    protected $fillable = [
        'visitor_id',
        'page_id',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'id' => 'string',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the visitor that owns this page visit.
     */
    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * Get the page that owns this page visit.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Boot function to generate UUID for new page visits.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($pageVisit) {
            if (empty($pageVisit->id)) {
                $pageVisit->id = \Illuminate\Support\Str::uuid();
            }
        });
    }
}
