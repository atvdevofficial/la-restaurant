<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'address', 'latitude', 'longitude',
        'sub_total', 'delivery_fee', 'grand_total',
        'status', 'notes',
    ];

    protected $hidden = [
        'customer_id',
    ];

    /**
     * Model relationships
     */
    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function orderProducts() {
        return $this->hasMany(OrderProduct::class);
    }

    public static function boot() {
        parent::boot();

        self::creating(function($order) {
            $permittedChars = '1234567890QWERTYUIOPASDFGHJKLZXCVBNM';
            $order->code = substr(str_shuffle($permittedChars), 0, 5) . $order->customer_id . time();
        });
    }
}
