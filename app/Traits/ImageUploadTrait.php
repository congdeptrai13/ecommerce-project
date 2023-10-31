<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
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
        }
    }

    public function uploadMultiImage(Request $request, $inputName, $path)
    {
        $multiImagePath = [];
        if ($request->hasFile($inputName)) {
            $images = $request->{$inputName};
            foreach ($images as $image) {
                $ext = $image->getClientOriginalextension();
                $nameImage = 'media_' . uniqid() . '.' . $ext;
                $image->move(public_path($path), $nameImage);
                $multiImagePath[] = $path . "/" . $nameImage;
            }
            return $multiImagePath;


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
