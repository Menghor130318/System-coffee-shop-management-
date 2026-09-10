<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [

        'code',

        'type',

        'value',

        'min_order',

        'expired_at',

        'is_active'

    ];

    protected $casts = [

        'expired_at' => 'datetime',

        'is_active' => 'boolean',

    ];
}
