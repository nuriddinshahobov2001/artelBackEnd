<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoodResource;
use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class GoodController extends Controller
{
    public function getRandomGoods()
    {
        $goods = Good::inRandomOrder()->limit(20)->get();

//        $response = Http::withHeaders([
//            'Content-Type' => 'application/json; charset=utf-8',
//        ])->withBasicAuth('Admin', 3008)->get('http://95.142.94.22:8080/OSONSRV/hs/shop/GetAllProducts');

        return response()->json([
           'message' => true,
            'goods' => GoodResource::collection($goods)
        ]);
    }
}
