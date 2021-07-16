<?php

namespace App;

use App\Traits\FileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
    public function setImageAttribute($value) {
        if ($value != null && $value != '') {

            if (strpos($value, 'http') === FALSE) {

                // if have existing, remove
                if ($this->image != null && $this->image != '') {
                    Storage::delete($this->banner);
                }

                $destinationFolder  = 'products';
                $productName = strtolower($this->name);
                $productName = preg_replace('/[^A-Za-z0-9. -]/', '', $productName);
                $trimmedProductName = str_replace(' ', '', $productName) . '_' . time();
                $imageUrl = $this->imageUploadForBase64($value, $trimmedProductName, $destinationFolder);
                $this->attributes['image'] = $imageUrl;
            } else {
                $this->attributes['image'] = $value;
            }
        }
    }

    public function getImageAttribute($value) {
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
