<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExcelController extends Controller
{
    public function excel()
    {
        $goods = Good::unFilter()->get();

        $fileName = uniqid();

        $storagePath = "report/{$fileName}.xlsx";

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile(storage_path("app/public/{$storagePath}"));


        $headerRow = WriterEntityFactory::createRowFromArray(['Название', 'Категория', 'Описание', 'Цена']);
        $writer->addRow($headerRow);

        foreach ($goods as $task) {
            $rowData = WriterEntityFactory::createRowFromArray([$task->name, $task->category?->name, $task->description, $task->price]);
            $writer->addRow($rowData);
        }

        $writer->close();

        Storage::disk('public')->put($storagePath, file_get_contents(storage_path("app/public/{$storagePath}")));

        storage_path("app/public/{$storagePath}");


        $files = storage_path('app/public/' . $storagePath);


        return response()->file(storage_path("app/public/{$storagePath}"));


    }

    public function GoodReport()
    {
        $goods = Good::query()
            ->select(
                'goods.name',
                'c.name as category',
                'goods.price',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(CASE WHEN orders.status_id = 3 THEN 1 ELSE 0 END) as completed_orders'),
                DB::raw('SUM(CASE WHEN orders.status_id = 1 THEN 1 ELSE 0 END) as pending_orders'),
                DB::raw('SUM(CASE WHEN orders.status_id = 4 THEN 1 ELSE 0 END) as rejected_orders')
            )
            ->leftJoin('categories as c', 'c.category_id', '=', 'goods.category_id')
            ->leftJoin('orders', 'orders.good_id', '=', 'goods.good_id')
            ->groupBy('goods.id', 'c.name', 'goods.name', 'goods.price')
            ->orderByDesc('total_orders')
            ->withCount('orders')
            ->get();



        $fileName = uniqid();

        $storagePath = "report/{$fileName}.xlsx";

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile(storage_path("app/public/{$storagePath}"));


        $headerRow = WriterEntityFactory::createRowFromArray(['Название', 'Категория', 'Цена', 'Общее Количество заказов', 'Завершенные', 'На рассмотрении', 'Отклоненные']);
        $writer->addRow($headerRow);

        foreach ($goods as $task) {
            $rowData = WriterEntityFactory::createRowFromArray([$task->name, $task->category,  $task->price, $task->orders_count, $task->completed_orders, $task->pending_orders, $task->rejected_orders ]);
            $writer->addRow($rowData);
        }

        $writer->close();

        Storage::disk('public')->put($storagePath, file_get_contents(storage_path("app/public/{$storagePath}")));

        storage_path("app/public/{$storagePath}");


        $files = storage_path('app/public/' . $storagePath);


        return response()->file(storage_path("app/public/{$storagePath}"));
    }
}
