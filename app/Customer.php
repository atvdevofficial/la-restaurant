<?php

namespace App;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $cascadeDeletes = ['user'];

    protected $fillable = [
        'user_id',
        'first_name', 'last_name', 'contact_number',
        'address', 'latitude', 'longitude'
    ];

    protected $hidden = [
        'user_id',
        'created_at', 'updated_at'
    ];

    /**
     * Model relationships
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
