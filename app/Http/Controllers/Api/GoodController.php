<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoodResource;
use App\Http\Resources\SimilarGoodResource;
use App\Models\Category;
use App\Models\Good;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class GoodController extends Controller
{
    public function getRandomGoods(): JsonResponse
    {
        $goods = Good::inRandomOrder()->limit(20)->get();

        return response()->json([
           'message' => true,
            'goods' => GoodResource::collection($goods)
        ]);
    }


    public function getBySlug($slug): JsonResponse
    {
        $good = Good::where('slug', $slug)->first();

        return response()->json([
           'message' => true,
           'good' => GoodResource::make($good)
        ]);
    }

    public function getGoodsByCategory($slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->first();
        $goods = Good::where('category_id', $category?->category_id)->get();

        return response()->json([
            'message' => true,
            'goods' => GoodResource::collection($goods)
        ]);
    }

    public function getSimilarProducts($categorySlug, $goodSlug): JsonResponse
    {
        $category = Category::where('slug', $categorySlug)->select('category_id')->first();

        if ($category === null) {
            return response()->json([
                'message' => false,
                'info' => 'Такой категории не существует!'
            ]);
        }

        $goods = Good::filter()->where([
            ['category_id', $category->category_id],
            ['slug', '!=', $goodSlug]
        ])->inRandomOrder()->limit(20)->get();

        return response()->json([
            'message' => true,
            'goods' => SimilarGoodResource::collection($goods)
        ]);
    }
}
