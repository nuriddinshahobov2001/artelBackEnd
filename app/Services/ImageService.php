<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
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

    public function get($images)
    {
        try {
            DB::table('images')->truncate();
            foreach ($images as $image) {
                Image::create([
                    'good_id' => $image['good_id'],
                    'image' => $image['image']
                ]);
            }

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
