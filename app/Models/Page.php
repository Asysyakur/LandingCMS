<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'business_profile' => 'array',
        'metadata' => 'array',
    ];
}