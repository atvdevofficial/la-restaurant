<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'address', 'latitude', 'longitude',
        'sub_total', 'delivery_fee', 'grand_total',
        'status',
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
}
