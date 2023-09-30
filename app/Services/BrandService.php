<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    public function store($data)
    {
        Brand::create($data);

        return true;
    }

    public function update($data, $brand)
    {
        $brand->update($data);

        return true;
    }
}
