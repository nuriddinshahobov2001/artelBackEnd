<?php

namespace App\Services;


use App\Mail\OrderMail;
use App\Mail\SendMessageAboutOrderMail;
use App\Models\Good;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function order($order)
    {
        try {
            DB::beginTransaction();
            $random = time();

            foreach ($order['products'] as $product) {
                Order::create([
                    'good_id' => $product['good_id'],
                    'count' => $product['count'],
                    'price' => $product['price'],
                    'sale' => $product['sale'],
                    'phone' => $order['phone'],
                    'comments' => $order['comments'] ?? '',
                    'address' => $order['address'],
                    'totalPrice' => $order['total_sum'],
                    'delivery' => $order['delivery'],
                    'order_code' => $random,
                    'status_id' => OrderStatus::UNDER_CONSIDERATION,
                    'toOrder' => $order['toOrder']
                ]);
            }
            DB::commit();

            $orders = Order::where('order_code', $random)->get();
dd($orders);
//            Mail::to('khusravmuhammadi.73@gmail.com')->send(new OrderMail($orders));

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function index()
    {
        return DB::table('orders as o')
            ->where('toOrder', false)
            ->select('o.created_at', 'o.phone', 'o.order_code', 'o.address', 's.title as status')
            ->join('order_statuses as s', 's.id', '=', 'o.status_id')
            ->groupBy('o.created_at', 'o.phone', 'o.order_code', 'o.address', 's.title')
            ->paginate(30);
    }

    public function show(string $orderCode)
    {
        return DB::table('orders as o')
            ->leftJoin('goods as g', 'g.good_id', '=', 'o.good_id')
            ->select('g.name', 'o.count', 'o.price', 'o.sale', 'o.status_id', 'o.order_code')
            ->where('o.order_code', $orderCode)
            ->get();
    }

    public function goods_to_order()
    {
        return DB::table('orders as o')
            ->where('toOrder', '=',true)
            ->select('o.created_at', 'o.phone', 'o.order_code', 'o.address', 's.title as status')
            ->join('order_statuses as s', 's.id', '=', 'o.status_id')
            ->groupBy('o.created_at', 'o.phone', 'o.order_code', 'o.address', 's.title')
            ->paginate(30);
    }

    public function completeOrder(string $orderCode)
    {
        Order::query()->where('order_code', $orderCode)->update(['status_id' => OrderStatus::COMPLETED]);

    }

    public function acceptOrder($orderCode)
    {
        try {
            $orders = Order::where('order_code', $orderCode)->get();

            foreach ($orders as $order) {
                $order->status_id = OrderStatus::APPROVED;
                $order->save();
            }

//            Mail::to('amr_1990@mail.ru')->send(new SendMessageAboutOrderMail($orders, $status));
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function rejectOrder($orderCode)
    {
        try {
            $orders = Order::where('order_code', $orderCode)->get();

            foreach ($orders as $order) {
                $order->status_id = OrderStatus::REJECTED;
                $order->save();
            }

//        Mail::to('amr_1990@mail.ru')->send(new SendMessageAboutOrderMail($orders, $status));
            return true;
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
