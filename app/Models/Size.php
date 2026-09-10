<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Size extends Model
{
    protected $fillable = [
        'name',
        'code',
        'status',
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_sizes'
        )->withPivot('price');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
