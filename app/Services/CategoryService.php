<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
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

    public function get($categories)
    {
        try {
            DB::table('categories')->truncate();
            foreach ($categories as $category) {
                Category::updateOrCreate([
                    'category_id' => $category['id'],
                    'name' => $category['name'],
                    'slug' => Str::slug($category['name'] . '-' . Str::random(5), '-'),
                    'parent_id' => $category['parent_id'],
                    'image' => $category['img']
                ]);
            }

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
