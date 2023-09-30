<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    public function store($data)
    {
        $img = Storage::disk('public')->put('good_img', $data['image']);

        Image::create([
            'good_id' => $data['good_id'],
            'image' => $img
        ]);

        return true;
    }

    public function update($data, $image)
    {
        if (isset($data['image'])) {
            $img = Storage::disk('public')->put('good_img', $data['image']);
            $photo = str_replace('good_img/', 'public/good_img/', $image->image);

            Storage::delete($photo);

            $image->update([
                'good_id' => $data['good_id'],
                'image' => $img,
            ]);
        } else {
            $image->update([
                'good_id' => $data['good_id'],
            ]);
        }

        return true;
    }

}
