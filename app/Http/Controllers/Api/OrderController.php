<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function order(OrderRequest $request): JsonResponse
    {
        $data = $request->validated();

        $order = $this->orderService->order($data);

        return  response()->json([
            'message' => $order
        ]);

    }
}
