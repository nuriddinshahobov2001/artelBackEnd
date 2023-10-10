<?php

namespace App\Http\Controllers\Api\GetDataFrom1C;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class BrandController extends Controller
{
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function get()
    {
        $response = Http::withHeaders([
           'Content-Type' => 'application/json; charset=utf-8'
        ])->withBasicAuth(
            Config::get('constants.credentials.login'),
            Config::get('constants.credentials.password')
        )->get(Config::get('constants.api.get_brands'));

        if ($response->successful()) {
            $brands = $response->json()['data'];
            $res = $this->brandService->get($brands);

            return response()->json([
                'message' => $res
            ]);
        }
    }
}
