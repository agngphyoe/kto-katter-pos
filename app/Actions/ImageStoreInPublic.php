<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;

class ImageStoreInPublic
{
    public function storePublic(string $destination, UploadedFile $image)
    {
        $image_name = time() . '.' . $image->getClientOriginalExtension();

        if (!file_exists(public_path($destination))) {
            mkdir(public_path($destination), 0755, true);
        }

        $image->move(public_path($destination), $image_name);

        return $image_name;
    }
}
