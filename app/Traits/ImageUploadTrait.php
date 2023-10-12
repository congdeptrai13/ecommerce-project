<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImageUploadTrait
{
    public function uploadImage(Request $request, $inputName, $path)
    {
        if ($request->hasFile($inputName)) {
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalextension();
            $nameImage = 'media_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $nameImage);
            return $path . "/" . $nameImage;
            // $user->image = $path;
        }
    }

    public function updateImage(Request $request, $inputName, $path, $oldPath = null)
    {
        if ($request->hasFile($inputName)) {
            if (!is_null($oldPath)) {
                @unlink($oldPath);
            }
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalextension();
            $nameImage = 'media_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $nameImage);
            return $path . "/" . $nameImage;
            // $user->image = $path;
        }
    }

    //handle delete file
    public function deleteImage(string $path)
    {
        if (!is_null($path)) {
            @unlink($path);
        }
    }
}
