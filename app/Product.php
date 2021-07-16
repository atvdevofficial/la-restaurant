<?php

namespace App;

use App\Traits\FileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use FileUpload;

    protected $fillable = [
        'name', 'description',
        'price', 'image'
    ];

    protected $hidden = [
        'pivot',
        'created_at', 'updated_at'
    ];

    /**
     * Model mutators and accessors
     */
    public function setImageLinkAttribute($value) {
        if ($value != null && $value != '') {

            if (strpos($value, 'http') === FALSE) {
                $destinationFolder  = 'products';
                $imageUrl = $this->imageUploadForBase64($value, $this->name, $destinationFolder);
                $this->attributes['image'] = $imageUrl;
            } else {
                $this->attributes['image'] = $value;
            }
        }
    }

    public function getImageLinkAttribute($value) {
        if (strpos($value, 'http') === FALSE) {
            return URL::to('/') . $value;
        } else {
            return $value;
        }
    }

    /**
     * Model relationships
     */
    public function productCategories() {
        return $this->belongsToMany(ProductCategory::class);
    }
}
