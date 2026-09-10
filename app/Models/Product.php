<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'product_name_kh',
        'product_name_en',
        'product_name_zh',
        'slug',
        'price_min',
        'price_max',
        'price',
        'sale_price',
        'description',
        'image',
        'status',
        'use_all_toppings',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(
            Size::class,
            'product_sizes'
        )->withPivot('price');
    }

    public function toppings(): BelongsToMany
    {
        return $this->belongsToMany(
            Topping::class,
            'product_toppings'
        );
    }

    public function sweetnessLevels(): BelongsToMany
    {
        return $this->belongsToMany(
            SweetnessLevel::class,
            'product_sweetness_levels'
        );
    }

    public function iceLevels(): BelongsToMany
    {
        return $this->belongsToMany(
            IceLevel::class,
            'product_ice_levels'
        );
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}