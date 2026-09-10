<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'size_id',
        'sweetness_level_id',
        'ice_level_id',
        'topping_ids',
        'quantity',
        'unit_price',
        'total_price'
    ];

    protected $casts = [
        'topping_ids' => 'array'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function sweetnessLevel()
    {
        return $this->belongsTo(SweetnessLevel::class);
    }

    public function iceLevel()
    {
        return $this->belongsTo(IceLevel::class);
    }
}