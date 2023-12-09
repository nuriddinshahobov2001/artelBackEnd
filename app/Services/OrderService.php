<?php

namespace App\Services;


use App\Models\Order;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
                   'comments' => $order['comments'],
                   'address' => $order['address'],
                   'totalPrice' => $order['totalPrice'],
                   'delivery' =>$order['isDelivery'],
                   'order_code' => $random
                ]);
            }
            DB::commit();

            Http::withHeaders([
               'Content-Type' => 'application/json; charset=utf-8'
            ])->withBasicAuth(
                Config::get('constants.credentials.login'),
                Config::get('constants.credentials.password')
            )->post(Config::get('constants.api.order'), $order);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
