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
        'price', 'image_link'
    ];

    protected $hidden = [
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
                $this->attributes['image_link'] = $imageUrl;
            } else {
                $this->attributes['image_link'] = $value;
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
}
