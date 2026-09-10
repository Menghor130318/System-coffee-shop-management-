<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model

{
protected $fillable = [
        'user_id',
        'receiver_user_id',
        'customer_name',
        'phone',
        'email',
        'address',
        'note',
        'subtotal',
        'shipping_fee',
        'discount',
        'total',
'payment_method',
        'payment_status',
        'status',
        'transaction_no',
        'queue_number',
        'paid_at',
        'completed_at',
        
    ];

    // Order has many Order Items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public $timestamps = false;
// Order belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Order belongs to a receiver (admin/employee who accepted the order)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
        
    }

    // Order has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
