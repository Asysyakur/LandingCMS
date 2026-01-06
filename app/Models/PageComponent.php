<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageComponent extends Model
{
    protected $fillable = [
        'page_id',
        'component_id',
        'order_index',
        'content',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
        'order_index' => 'integer',
        'id' => 'string',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the page that owns this page component.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the component that owns this page component.
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Boot function to generate UUID for new page components.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($pageComponent) {
            if (empty($pageComponent->id)) {
                $pageComponent->id = \Illuminate\Support\Str::uuid();
            }
        });
    }
}
