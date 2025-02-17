<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\providerController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RolController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('/producto', ProductoController::class)-> names ('producto');
    Route::resource('/provider', providerController::class)-> names ('provider');
    Route::resource('/categoria', CategoriaController::class)->names('categoria');
    Route::resource('/rol', RolController::class)-> names ('rol');
});
