<?php

namespace App\Services;

use App\Models\Good;
use Illuminate\Support\Str;

class GoodService
{
    public function store($data)
    {
        Good::create([
           'name' => $data['name'],
           'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-'),
           'description' => $data['description'],
           'full_description' => $data['full_description'],
           'category_id' => $data['category_id'],
           'brand_id' => $data['brand_id'],
           'price' => $data['price'],
           'sale' => $data['sale'],
           'count' => $data['count']
        ]);

        return true;
    }

    public function update($data, $good)
    {
        $good->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-'),
            'description' => $data['description'],
            'full_description' => $data['full_description'],
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],
            'price' => $data['price'],
            'sale' => $data['sale'],
            'count' => $data['count']
        ]);
    }
}
