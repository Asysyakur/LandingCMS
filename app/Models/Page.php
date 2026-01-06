<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'status',
        'created_by',
        'business_profile',
        'metadata',
    ];

    protected $casts = [
        'status' => 'string',
        'business_profile' => 'array',
        'metadata' => 'array',
        'id' => 'string',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the user who created this page.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the page components for this page.
     */
    public function pageComponents(): HasMany
    {
        return $this->hasMany(PageComponent::class)->orderBy('order_index');
    }

    /**
     * Get the page versions for this page.
     */
    public function pageVersions(): HasMany
    {
        return $this->hasMany(PageVersion::class);
    }

    /**
     * Get the page visits for this page.
     */
    public function pageVisits(): HasMany
    {
        return $this->hasMany(PageVisit::class);
    }

    /**
     * Boot function to generate UUID for new pages.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($page) {
            if (empty($page->id)) {
                $page->id = \Illuminate\Support\Str::uuid();
            }
        });
    }
}
