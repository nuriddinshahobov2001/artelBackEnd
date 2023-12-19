<?php

use Illuminate\Support\Facades\Route;


Route::middleware('checkRole:admin')->group(function () {
    Route::get('/brands', [\App\Http\Controllers\BrandController::class, 'index'])->name('brands.index');
    Route::post('/brands', [\App\Http\Controllers\BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{brand}', [\App\Http\Controllers\BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [\App\Http\Controllers\BrandController::class, 'destroy'])->name('brands.destroy');
    Route::get('/brands/get', [\App\Http\Controllers\BrandController::class, 'get'])->name('brands.get');

    Route::get('/category', [\App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::post('/category', [\App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/category/get', [\App\Http\Controllers\CategoryController::class, 'get'])->name('category.get');

    Route::get('/images', [\App\Http\Controllers\ImageController::class, 'index'])->name('image.index');
    Route::post('/images', [\App\Http\Controllers\ImageController::class, 'store'])->name('image.store');
    Route::put('/images/{image}', [\App\Http\Controllers\ImageController::class, 'update'])->name('image.update');
    Route::delete('/images/{image}', [\App\Http\Controllers\ImageController::class, 'destroy'])->name('image.destroy');
    Route::get('/images/get', [\App\Http\Controllers\ImageController::class, 'get'])->name('image.get');

   Route::resource('/good', \App\Http\Controllers\GoodController::class);
   Route::get('/get', [\App\Http\Controllers\GoodController::class, 'get'])->name('good.get');
   Route::get('goodsWithDefects', [\App\Http\Controllers\GoodController::class, 'goodsWithDefects'])->name('goodsWithDefects');
   Route::get('goodsWithDefects/{slug}', [\App\Http\Controllers\GoodController::class, 'showGoodsWithDefects'])->name('showGoodsWithDefects');

    Route::get('get/goods/excel', [\App\Http\Controllers\ExcelController::class, 'excel'])->name('excel');

});

Route::middleware('checkRole:admin|consultant')->group(function () {
    Route::group(['as' => 'orders.'], function () {
        Route::get('orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('index');
        Route::get('orders/show/{orderCode}', [\App\Http\Controllers\OrderController::class, 'show'])->name('show');
        Route::post('/orders/accept/{orderCode}', [\App\Http\Controllers\OrderController::class, 'acceptOrder'])->name('acceptOrder');
        Route::post('/orders/reject/{orderCode}', [\App\Http\Controllers\OrderController::class, 'rejectOrder'])->name('rejectOrder');

    });

});

