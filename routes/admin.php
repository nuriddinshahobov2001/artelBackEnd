<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
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
});

