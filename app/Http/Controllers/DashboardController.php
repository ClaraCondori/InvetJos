<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Provider;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener la cantidad de usuarios registrados
        $userCount = User::count();

        // Obtener la cantidad de productos registrados
        $productCount = Producto::count();

        // Obtener la cantidad de categorías registradas
        $categoryCount = Categoria::count();

        // Obtener la lista de usuarios (para la tabla)
        $users = User::all();

        // Obtener la cantidad de proveedores registrados
        $providerCount = Provider::count();

        // Obtener la cantidad de movimientos registrados
        $movimientoCount = Movimiento::count();

        // Obtener la cantidad de productos registrados por mes
        $productData = Producto::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

    // Rellenar los meses faltantes con 0
    $months = range(1, 12);
    $productCountByMonth = array_fill_keys($months, 0);
    foreach ($productData as $month => $count) {
        $productCountByMonth[$month] = $count;
    }

    // Pasar los datos a la vista
    return view('dashboard', compact(
        'userCount',
        'productCount',
        'categoryCount',
        'users',
        'providerCount',
        'movimientoCount',
        'productCountByMonth' // Nuevo dato para el gráfico
    ));
    }
}