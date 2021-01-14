<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    public function imageUpload($imageFile, $filename = '', $uploadFolder = 'images')
    {
        $fileExtension = $imageFile->getClientOriginalExtension();
        $filenameWithExtension = $filename . '.' . $fileExtension;
        $imageUploadedPath = $imageFile->storeAs($uploadFolder, $filenameWithExtension, 'public');
        $fileUrl = Storage::disk('public')->url($imageUploadedPath);

        if (env('APP_ENV', 'local') == 'local') {
            $fileUrl = str_replace('localhost', '127.0.0.1:8000', $fileUrl);
        }

        return $fileUrl;
    }
}
