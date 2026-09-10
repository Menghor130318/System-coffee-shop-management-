<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class IceLevel extends Model
{
    protected $fillable = [
        'name',
        'percent',
        'status',
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_ice_levels'
        );
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
