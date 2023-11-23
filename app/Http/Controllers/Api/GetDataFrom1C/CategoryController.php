<?php

namespace App\Http\Controllers\Api\GetDataFrom1C;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function get(): JsonResponse
    {
        $response = Http::withHeaders([
           'Content-Type' => 'application/json; charset=utf-8'
            ])->withBasicAuth(
                Config::get('constants.credentials.login'),
                Config::get('constants.credentials.password')
            )->get(Config::get('constants.api.get_categories'));

        if ($response->successful()) {
            $res = $this->categoryService->get($response->json()['data']);

            return response()->json([
                'message' => $res
            ]);
        } else {
            return response()->json([
                'message' => 'Произошла ошибка!'
            ]);
        }
    }
}
