<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoodResource;
use App\Models\Good;
use Illuminate\Http\Request;

class GoodController extends Controller
{
    public function index()
    {
        $goods = Good::all();

        return response()->json([
           'goods' => GoodResource::collection($goods)
        ]);
    }
}
