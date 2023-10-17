<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function order(Request $request)
    {
        $data = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.good_id' => 'required',
            'products.*.count' => 'required',
            'products.*.price' => 'required',
            'products.*.sale' => '',
            'email' => 'required|email',
            'product_sum' => 'required',
            'delivery' => '',
            'delivery_sum' => '',
            'total_summa' => ''
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => false,
                'errors' => $data->errors()
            ], 200);
        }

        $order = $this->orderService->order($data->validated());

        return  response()->json([
            'message' => $order
        ]);

    }
}
