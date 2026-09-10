<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    /**
     * Get the order that owns the detail.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
    public function getUnitPriceUsdAttribute()
    {
        return $this->unit_price > 500 ? $this->unit_price / 4100 : $this->unit_price;
    }

    /**
     * គណនាតម្លៃ total_price ជា $ (USD)
     */
    public function getTotalPriceUsdAttribute()
    {
        return $this->total_price > 500 ? $this->total_price / 4100 : $this->total_price;
    }

    /**
     * គណនាតម្លៃ total_price ជា ៛ (KHR)
     */
    public function getTotalPriceKhrAttribute()
    {
        return $this->total_price > 500 ? $this->total_price : $this->total_price * 4100;
    }
}