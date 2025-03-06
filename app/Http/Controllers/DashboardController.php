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
        $userCount = User::count();

        $productCount = Producto::count();

    
        $categoryCount = Categoria::count();

    
        $users = User::all();

        
        $providerCount = Provider::count();

        
        $movimientoCount = Movimiento::count();

       
        $productData = Producto::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

    
    $months = range(1, 12);
    $productCountByMonth = array_fill_keys($months, 0);
    foreach ($productData as $month => $count) {
        $productCountByMonth[$month] = $count;
    }

    return view('dashboard', compact(
        'userCount',
        'productCount',
        'categoryCount',
        'users',
        'providerCount',
        'movimientoCount',
        'productCountByMonth' 
    ));
    }
}