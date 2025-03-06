<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\ReporteController;

// Página de inicio (redirige a login si no está autenticado)
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Agrupar rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('/user', UserController::class)->names('user');
    Route::resource('/producto', ProductoController::class)->names('producto');
    Route::resource('/provider', ProviderController::class)->names('provider');
    Route::resource('/categoria', CategoriaController::class)->names('categoria');
    Route::resource('/movimiento', MovimientoController::class)->names('movimiento');
    Route::resource('/roles', RoleController::class)->names('roles');
    Route::resource('/permisos', PermissionController::class)->names('permisos');
    Route::resource('/asignar', AsignarController::class)->names('asignar');

    Route::get('/inactivos', [ProductoController::class, 'inactivos'])->name('sistema.productoinactivos');
    Route::put('/activar/{id}', [ProductoController::class, 'activar'])->name('productos.activar');
    Route::get('/inactivosCat', [CategoriaController::class, 'inactivos'])->name('sistema.inactivocat');
    Route::put('/categorias/activar/{id}', [CategoriaController::class, 'activar'])->name('categorias.activar');
    Route::get('/inactivosProv', [ProviderController::class, 'inactivos'])->name('sistema.inactivoprov');
    Route::put('/prov/activar/{id}', [ProviderController::class, 'activar'])->name('providers.activar');
    Route::get('/inactivosUser', [UserController::class, 'inactivos'])->name('sistema.inactivouser');
    Route::put('/user/activar/{id}', [UserController::class, 'activar'])->name('user.activar');

    // Rutas de reportes
    Route::get('/generar-reporte', [ReporteController::class, 'showForm'])->name('reporte.form');
    Route::get('/previsualizar-reporte', [ReporteController::class, 'previewReport'])->name('reporte.preview');
    Route::get('/descargar-reporte', [ReporteController::class, 'downloadReport'])->name('reporte.download');
});

// Si no existe auth.php, no lo incluyas
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

