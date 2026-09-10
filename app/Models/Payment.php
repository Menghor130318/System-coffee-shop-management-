<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'payment_method',
        'status',
        'transaction_no',
    ];

    // Payment belongs to an Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Payment belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
