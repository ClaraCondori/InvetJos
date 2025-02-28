<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\providerController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\Hash;
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
    Route::resource('/user', UserController::class)-> names ('user');
    Route::resource('/producto', ProductoController::class)-> names ('producto');
    Route::resource('/provider', providerController::class)-> names ('provider');
    Route::resource('/categoria', CategoriaController::class)->names('categoria');
    Route::resource('/movimiento', MovimientoController::class)-> names ('movimiento');
    Route::resource('/roles', RoleController::class)-> names ('roles');
    Route::resource('/permisos', PermissionController::class)-> names ('permisos');
    Route::resource('/usuario', AsignarController::class)-> names ('asignar');
});
