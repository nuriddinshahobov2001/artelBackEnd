<?php

namespace App\Http\Controllers\Api\GetDataFrom1C;

use App\Http\Controllers\Controller;
use App\Services\GoodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class GoodController extends Controller
{
    public function __construct(GoodService $goodService)
    {
        $this->goodService = $goodService;
    }

    public function get()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withBasicAuth(
            Config::get('constants.credentials.login'),
            Config::get('constants.credentials.password')
        )->get(Config::get('constants.api.get_goods'));

        if ($response->successful()) {
            $goods = $response->json()['data'];
            $res = $this->goodService->get($goods);

            return response()->json([
                'message' => $res
            ]);
        }
    }
}
