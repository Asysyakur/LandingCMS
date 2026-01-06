<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visitor extends Model
{
    protected $fillable = [
        'first_seen_at',
        'last_seen_at',
    ];

    protected $casts = [
        'first_seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'id' => 'string',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the page visits for this visitor.
     */
    public function pageVisits(): HasMany
    {
        return $this->hasMany(PageVisit::class);
    }

    /**
     * Boot function to generate UUID for new visitors.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($visitor) {
            if (empty($visitor->id)) {
                $visitor->id = \Illuminate\Support\Str::uuid();
            }
        });
    }
}
