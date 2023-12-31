<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllCategoryResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::where('parent_id', null)->get();

        return response()->json([
           'message' => true,
           'categories' => CategoryResource::collection($categories)
        ]);
    }

    public function getBySlug($slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return response()->json([
                'message' => false
            ]);
        }

        return response()->json([
           'message' => true,
           'category' => AllCategoryResource::make($category)
        ]);
    }
}
