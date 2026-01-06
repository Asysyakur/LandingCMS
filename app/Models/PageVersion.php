<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVersion extends Model
{
    protected $fillable = [
        'page_id',
        'version_name',
        'version_description',
        'data_snapshot',
    ];

    protected $casts = [
        'data_snapshot' => 'array',
        'id' => 'string',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the page that owns this page version.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Boot function to generate UUID for new page versions.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($pageVersion) {
            if (empty($pageVersion->id)) {
                $pageVersion->id = \Illuminate\Support\Str::uuid();
            }
        });
    }
}
