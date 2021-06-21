<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id', 'product_id',
        'price', 'quantity', 'total',
    ];

    protected $hidden = [
        'order_id', 'product_id',
        'created_at', 'updated_at'
    ];

    /**
     * Model relationships
     */
    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
