<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;

class BrandService
{
    public function store($data): bool
    {
        Brand::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-')
        ]);

        return true;
    }

    public function update($data, $brand): bool
    {
        $brand->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-')
        ]);

        return true;
    }

    public function get($brands)
    {
        try {
//            DB::table('brands')->truncate();
            foreach ($brands as $brand)
            {
                Brand::updateOrCreate(
                    ['brand_id' => $brand['id']],
                    [
                        'name' => $brand['name'],
                        'slug' => Str::slug($brand['name'] . '-' . Str::random(5), '-'),
                    ]);
            }

            return true;
        } catch (Exception $e) {
           return $e->getMessage();
        }

    }
}
