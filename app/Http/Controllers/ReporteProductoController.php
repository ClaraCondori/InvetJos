<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteProductoController extends Controller
{
    /**
     * Muestra el formulario para seleccionar el tipo de reporte.
     */
    public function mostrarFormulario()
    {
        $categorias = Categoria::where('estado', true)->get();
        return view('sistema.reportes.reporteProducto', compact('categorias'));
    }

    /**
     * Genera y descarga el reporte en PDF.
     */
    public function generarReporte(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'categoria' => 'nullable|exists:categorias,id',
            'estado' => 'nullable|in:activo,inactivo',
            'cantidad' => 'nullable|integer|min:0',
            'fecha' => 'nullable|date',
        ]);

        // Filtrar los productos según los criterios seleccionados
        $query = Producto::query();

        // Filtro por categoría
        if ($request->categoria) {
            $query->where('categoria_id', $request->categoria);
        }

        // Filtro por estado
        if ($request->estado) {
            $query->where('estado', $request->estado === 'activo' ? 1 : 0);
        }

        // Filtro por cantidad mínima
        if ($request->cantidad) {
            $query->where('cantidad', '>=', $request->cantidad);
        }

        // Filtro por fecha de creación
        if ($request->fecha) {
            $query->whereDate('created_at', $request->fecha);
        }

        // Obtener los productos filtrados
        $productos = $query->get();

        // Generar el PDF
        $pdf = Pdf::loadView('sistema.reportes.productos-pdf', compact('productos'));

        // Descargar el PDF
        return $pdf->download('reporte_productos.pdf');
    }
}