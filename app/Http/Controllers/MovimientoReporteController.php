<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class MovimientoReporteController extends Controller
{
    public function generarInforme(Request $request)
    {
        $productoId = $request->input('producto');
        $usuarioId = $request->input('users');
        $fecha = $request->input('fecha');
        $tipo = $request->input('tipo');
        $query = Movimiento::with(['responsable', 'detalles.producto']) ->withSum('detalles', 'cantidad');
        if ($productoId) {
            $query->whereHas('detalles.producto', function ($q) use ($productoId) {
                $q->where('id', $productoId);
            });
        }
        if ($usuarioId) {
            $query->where('responsable', $usuarioId);
        }
        if ($fecha) {
            $query->whereDate('fecha', $fecha);
        }
        if ($tipo) {
            $query->where('tipo', $tipo);
        }
        $movimientos = $query->get();
        $productos = Producto::all();
        $users = User::where('estado', 'activo')->get();
        if ($request->input('formato') === 'pdf') {
            $pdf = Pdf::loadView('sistema.reportes.movimientos-pdf', compact('movimientos'));
            return $pdf->download('informe_movimientos.pdf');
        }
        return view('sistema.reportes.reporteMovimiento', compact('movimientos', 'productos', 'users'));
    }
}