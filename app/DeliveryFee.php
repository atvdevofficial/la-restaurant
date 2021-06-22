<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryFee extends Model
{
    protected $fillable = [
        'from', 'to', 'fee'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
