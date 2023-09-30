<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Str;

class BrandService
{
    public function store($data)
    {
        Brand::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-')
        ]);

        return true;
    }

    public function update($data, $brand)
    {
        $brand->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-')
        ]);

        return true;
    }
}
