<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlidersAndBannersResource;
use App\Models\SlidersAndBanners;
use http\Env\Response;
use Illuminate\Http\Request;

class SlidersAndBannersController extends Controller
{
    public function sliders_and_banners($param)
    {
        if ($param == 1) {
            $images = SlidersAndBanners::where('type', SlidersAndBanners::SLIDER)->get();
        } elseif ($param == 2) {
            $images = SlidersAndBanners::whereIn('type', [
                SlidersAndBanners::SALE, SlidersAndBanners::HIT, SlidersAndBanners::SEASONAL
            ])->get();
        } elseif ($param == 3) {
            $images = SlidersAndBanners::where('type', SlidersAndBanners::FOOTER)
                ->orderByDesc('created_at')->limit(2)->get();
        } else {
            return response()->json([
                'message' => 'Ошибка! Вы ввели неправильный параметр!'
            ]);
        }

        return response()->json([
            'images' => SlidersAndBannersResource::collection($images)
        ]);
    }
}
