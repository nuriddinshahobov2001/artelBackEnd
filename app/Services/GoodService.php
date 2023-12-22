<?php

namespace App\Services;

use App\Models\Good;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GoodService
{
    public function store($data): bool
    {
        Good::updateOrCreate([
               'name' => $data['name'],
               'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-'),
               'description' => $data['description'],
               'full_description' => json_encode($data['full_description']),
               'category_id' => $data['category_id'],
               'brand_id' => $data['brand_id'],
               'price' => $data['price'],
               'sale' => $data['sale'],
               'count' => $data['count'],
            ]);

        return true;
    }

    public function update($data, $good): bool
    {
        $good->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . Str::random(5), '-'),
            'description' => $data['description'],
            'full_description' => json_encode($data['full_description']),
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],
            'price' => $data['price'],
            'sale' => $data['sale'],
            'count' => $data['count']
        ]);

        return true;
    }

    public function get($goods)
    {
        try {
//            DB::table('goods')->truncate();
            foreach ($goods as $good) {
                Good::updateOrCreate(
                    ['good_id' => $good['id']],
                    [
                        'name' => $good['name'],
                        'slug' => Str::slug($good['name'] . '-' . Str::random(5), '-'),
                        'description' => $good['description'],
                        'full_description' => json_encode($good['description']) ?? null,
//                        'full_description' => json_encode($good['full_description']) ?? null,
                        'category_id' => $good['category_id'],
                        'brand_id' => $good['brand_id'],
                        'price' => $good['price'],
                        'sale' => $good['sale'],
                        'count' => $good['count'],
                        'present' => $good['present']
                    ]);
            }

            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $e->getMessage();
        }
    }
}
