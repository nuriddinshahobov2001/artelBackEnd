<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth.basic')->group(function () {
    Route::get('category', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::get('category/{slug}', [\App\Http\Controllers\Api\CategoryController::class, 'getBySlug']);

    Route::get('brand', [\App\Http\Controllers\Api\BrandController::class, 'index']);
    Route::get('brand/{slug}', [\App\Http\Controllers\Api\BrandController::class, 'getBySlug']);

    Route::get('getAllGoods', [\App\Http\Controllers\Api\GoodController::class, 'getAllGoods']);
    Route::get('getRandomGoods', [\App\Http\Controllers\Api\GoodController::class, 'getRandomGoods']);
    Route::get('getBySlug/{slug}', [\App\Http\Controllers\Api\GoodController::class, 'getBySlug']);
    Route::get('getGoodsByCategory/{slug}', [\App\Http\Controllers\Api\GoodController::class, 'getGoodsByCategory']);
    Route::get('getSimilarProducts/{categorySlug}/{goodSlug}', [\App\Http\Controllers\Api\GoodController::class, 'getSimilarProducts']);

    Route::post('convertPhoto', [\App\Http\Controllers\Api\ConvertPhotoController::class, 'convert']);
    Route::delete('destroy', [\App\Http\Controllers\Api\ConvertPhotoController::class, 'destroy']);

    Route::post('/order', [\App\Http\Controllers\Api\OrderController::class, 'order']);//->middleware('auth:sanctum');

    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

});

    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('forget_password', [App\Http\Controllers\Api\AuthController::class, 'forget_password']);
    Route::post('check_code', [App\Http\Controllers\Api\AuthController::class, 'check_code']);
    Route::post('change_password', [App\Http\Controllers\Api\AuthController::class, 'change_password']);

    Route::get('get_categories', [\App\Http\Controllers\Api\GetDataFrom1C\CategoryController::class, 'get']);
    Route::get('get_goods', [\App\Http\Controllers\Api\GetDataFrom1C\GoodController::class, 'get']);
    Route::get('get_brands', [\App\Http\Controllers\Api\GetDataFrom1C\BrandController::class, 'get']);
    Route::get('get_images', [\App\Http\Controllers\Api\GetDataFrom1C\ImageController::class, 'get']);
