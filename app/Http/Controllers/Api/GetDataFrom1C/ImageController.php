<?php

namespace App\Http\Controllers\Api\GetDataFrom1C;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function get()
    {
        $response = Http::withHeaders([
           'Content-Type' => 'application/json; charset=utf-8'
        ])->withBasicAuth(
            Config::get('constants.credentials.login'),
            Config::get('constants.credentials.password'),
        )->get(Config::get('constants.api.get_images'));

        $res = $this->imageService->get($response->json()['data']);

        return response()->json([
            'message' => $res
        ]);
    }
}
