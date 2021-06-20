<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
        'role', 'google_user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'google_user_id', 'role',
        'created_at', 'updated_at'
    ];

    /**
     * Automatically Hash password on create & update
     */
    public function setPasswordAttribute($value) {
        if($value != null && $value != '') {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Model relationship
     */
    public function profile() {
        if ($this->role === 'CUSTOMER')
            return $this->hasOne(Customer::class);

        return null;
    }
}
