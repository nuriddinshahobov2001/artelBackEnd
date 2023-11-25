<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExcelController extends Controller
{
    public function excel() {

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
}
