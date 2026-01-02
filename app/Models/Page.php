<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $casts = [
        'business_profile' => 'array',
        'metadata' => 'array',
    ];
}