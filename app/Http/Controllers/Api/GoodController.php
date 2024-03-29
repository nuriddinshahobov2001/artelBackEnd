<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllGoodsResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\GoodResource;
use App\Http\Resources\SimilarGoodResource;
use App\Models\Category;
use App\Models\Good;
use App\Models\SlidersAndBanners;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class GoodController extends Controller
{
    public function getAllGoods()
    {
        return response()->json([
            'goods' => AllGoodsResource::collection(
                Good:://filter()
                select('good_id', 'name', 'slug')
                    ->get()
            )
        ]);
    }

    public function getRandomGoods(): JsonResponse
    {
        $goods = Good::query()
            //->filter()
            ->with('brand', 'category', 'images')
            ->inRandomOrder()
            ->limit(20)
            ->get();

        return response()->json([
            'message' => true,
            'goods' => GoodResource::collection($goods)
        ]);
    }


    public function getBySlug($slug): JsonResponse
    {
        $good = Good::query()
            ->with('brand', 'category', 'images')
            ->where('slug', $slug)
            ->first();

        if (!$good) {
            return response()->json([
                'message' => false,
                'info' => 'Такого товара не существует!'
            ]);
        }

        return response()->json([
            'message' => true,
            'good' => GoodResource::make($good)
        ]);
    }

    public function getGoodsByCategory($slug): JsonResponse
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->first();
        if (!$category) {
            return response()->json([
                'message' => false
            ]);
        }

        if ($category->parent_id != null) {
            $goods = Good:://filter()
            with('category', 'images')
                ->where('category_id', $category->category_id)
                ->get();


            return response()->json([
                'message' => true,
                'category_name' => $category->name,
                'goods' => GoodResource::collection($goods)
            ]);
        }

        $count = $category->good->count();
        
        if ($count > 0) {
            return response()->json([
                'message' => true,
                'category_name' => $category->name,
                'goods' => GoodResource::collection($category->good)
            ]);
        }

        $goods = Good::select('goods.*')
            ->join('categories', 'categories.category_id', '=', 'goods.category_id')
            ->where([
                ['categories.parent_id', $category->category_id],
                ['goods.category_id', '!=', null],
//                ['goods.price', '!=', 0],
//                ['goods.name', '!=', ''],
//                ['goods.description', '!=', ''],
//                ['goods.full_description', '!=', '[]']
            ])
//            ->whereHas('images', function ($query) {
//                $query->where('is_main', true);
//            })
            ->get();

        return response()->json([
            'message' => true,
            'category_name' => $category->name,
            'goods' => GoodResource::collection($goods)
        ]);
    }

    public function getSimilarProducts($categorySlug, $goodSlug): JsonResponse
    {
        $category = Category::query()
            ->where('slug', $categorySlug)
            ->select('category_id')
            ->first();

        if ($category === null) {
            return response()->json([
                'message' => false,
                'info' => 'Такой категории не существует!'
            ]);
        }

        $goods = Good::query()
            // ->filter()
            ->with('images')
            ->where([
                ['category_id', $category->category_id],
                ['slug', '!=', $goodSlug]
            ])->inRandomOrder()
            ->limit(20)
            ->get();

        return response()->json([
            'message' => true,
            'goods' => SimilarGoodResource::collection($goods)
        ]);
    }

    public function getHitProducts(): JsonResponse
    {
        $goods = Good:://filter()
        with('brand', 'category', 'images')
            ->where('is_hit', '=', true)
            ->get();

        $image = SlidersAndBanners::where('type', SlidersAndBanners::HIT)->get();
        if ($image->isEmpty()) {
            return response()->json([
                'banner' => '',
                'goods' => GoodResource::collection($goods)
            ]);
        }
        return response()->json([
            'banner' => BannerResource::make($image[0]),
            'goods' => GoodResource::collection($goods)
        ]);
    }

    public function getSaleProducts(): JsonResponse
    {
        $goods = Good:://filter()
        with('brand', 'category', 'images')
            ->where('is_sale', '=', true)
            ->get();

        $image = SlidersAndBanners::where('type', SlidersAndBanners::SALE)->get();
        if ($image->isEmpty()) {
            return response()->json([
                'banner' => '',
                'goods' => GoodResource::collection($goods)
            ]);
        }
        return response()->json([
            'banner' => BannerResource::make($image[0]),
            'goods' => GoodResource::collection($goods)
        ]);
    }

    public function getSeasonalProducts(): JsonResponse
    {
        $goods = Good:://filter()
        with('brand', 'category', 'images')
            ->where('is_seasonal', '=', true)
            ->get();

        $image = SlidersAndBanners::where('type', SlidersAndBanners::SEASONAL)->get();
        if ($image->isEmpty()) {
            return response()->json([
                'banner' => '',
                'goods' => GoodResource::collection($goods)
            ]);
        }
        return response()->json([
            'banner' => BannerResource::make($image[0]),
            'goods' => GoodResource::collection($goods)
        ]);
    }
}
