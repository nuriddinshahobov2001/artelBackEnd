<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    const ON_SELF = 30;
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->index();

       return view('admin.orders.index', compact('orders'));
    }

    public function show(string $orderCode)
    {
        $goods = $this->orderService->show($orderCode);

        return view('admin.orders.show', compact('goods'));
    }

    public function acceptOrder($orderCode)
    {
        $res = $this->orderService->acceptOrder($orderCode);

        if ($res) {
            return redirect()->route('orders.index')->with('success', 'Заказ усепшно принят!');
        } else {
            return redirect()->back()->with('error', 'Произошла ошибка!');
        }
    }

    public function complete($orderCode) {
        $this->orderService->completeOrder($orderCode);

        return redirect()->route('orders.index')->with('success', 'Заказ успешно завершен!');
    }

    public function rejectOrder($orderCode)
    {
        $res = $this->orderService->rejectOrder($orderCode);

        if ($res) {
            return redirect()->route('orders.index')->with('success', 'Заказ отклонен!');
        } else {
            return redirect()->back()->with('error', 'Произошла ошибка!');
        }
    }
}
