<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'pivot',
        'created_at', 'updated_at'
    ];

    /**
     * Model relationships
     */
    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
