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

Route::get('/qwerty', function (){
    return 'test';
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
   Route::get('category', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
   Route::get('category/{slug}', [\App\Http\Controllers\Api\CategoryController::class, 'getBySlug']);

   Route::get('brand', [\App\Http\Controllers\Api\BrandController::class, 'index']);
   Route::get('brand/{slug}', [\App\Http\Controllers\Api\BrandController::class, 'getBySlug']);
});

Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

