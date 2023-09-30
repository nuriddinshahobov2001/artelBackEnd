<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService
{
    public function store($data)
    {
        if (isset($data['image'])) $img = Storage::disk('public')->put('category_img', $data['image']);

        Category::create([
            'name' => $data['name'],
            'image' => $img ?? null,
            'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-')
        ]);

        return true;
    }

    public function update($data, $category)
    {
        if (isset($data['image'])) {
            $img = Storage::disk('public')->put('category_img', $data['image']);
            $photo = str_replace('category_img/', 'public/category_img/', $category->image);

            Storage::delete($photo);

            $category->update([
                'name' => $data['name'],
                'image' => $img,
                'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-')
            ]);
        } else {
            $category->update([
                'name' => $data['name'],
                'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-')
            ]);
        }

        return true;
    }
}
