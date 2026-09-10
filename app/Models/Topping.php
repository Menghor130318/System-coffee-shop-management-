<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topping extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'status',
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_toppings'
        )->withPivot('price');
    }
}
