<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
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

    public function get($brands)
    {
        DB::table('brands')->truncate();
        foreach ($brands as $brand)
        {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name'] . '-' . Str::random(5), '-'),
            ]);
        }

        return true;
    }
}
