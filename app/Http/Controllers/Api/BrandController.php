<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(): JsonResponse
    {
        $brands = Brand::all();

        return response()->json([
           'message' => true,
           'brands' => BrandResource::collection($brands)
        ]);
    }

    public function getBySlug($slug): JsonResponse
    {
        $brand = Brand::where('slug', $slug)->first();

        return response()->json([
            'message' => true,
            'brand' => BrandResource::make($brand)
        ]);
    }
}
