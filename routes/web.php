<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/change_password', [\App\Http\Controllers\PasswordController::class, 'index'])->name('change_password.index');
Route::post('/change_password', [\App\Http\Controllers\PasswordController::class, 'store'])->name('change_password.store');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
