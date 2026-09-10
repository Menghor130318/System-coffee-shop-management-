<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
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
    protected $guarded = [];
    public function order()
    {
        return $this->belongsTo(Order::class);
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
    public function toppings()
    {
        return $this->belongsToMany(
            Topping::class,
            'topping_order_item',
            'order_item_id',
            'topping_id'
        );
    }
}
