<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Component extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'default_schema',
    ];

    protected $casts = [
        'default_schema' => 'array',
        'id' => 'string',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the page components for this component.
     */
    public function pageComponents(): HasMany
    {
        return $this->hasMany(PageComponent::class);
    }

    /**
     * Boot function to generate UUID for new components.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($component) {
            if (empty($component->id)) {
                $component->id = \Illuminate\Support\Str::uuid();
            }
        });
    }
}
