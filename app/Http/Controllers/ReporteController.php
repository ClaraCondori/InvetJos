<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Provider; // Asegúrate de importar los modelos necesarios
use App\Models\Producto;
use App\Models\Movimiento;

class ReporteController extends Controller
{
    // Mostrar el formulario de selección de datos
    public function showForm()
    {
        $users = User::all();
        return view('sistema.reportes.addreporte', compact('users'));
    }

    // Previsualizar el reporte
    public function previewReport(Request $request)
    {
        // Obtener los datos del formulario
        $userId = $request->input('user');
        $table = $request->input('table');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Obtener los datos según las selecciones
        $data = $this->getData($table, $userId, $startDate, $endDate);
    
        // Obtener el nombre del usuario seleccionado (si se seleccionó uno)
        $selectedUserName = 'Todos los usuarios'; // Valor por defecto
        if ($userId) {
            $selectedUser = User::find($userId);
            if ($selectedUser) {
                $selectedUserName = $selectedUser->name;
            }
        }
    
    
        // Pasar los datos a la vista de previsualización
        return view('sistema.reportes.reportes', [
            'data' => $data,
            'table' => $table,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'selectedUserName' => $selectedUserName, // Pasar el nombre del usuario seleccionado
        ]);
    }

    // Descargar el reporte en PDF
    public function downloadReport(Request $request)
    {
        // Obtener los datos del formulario
        $userId = $request->input('user');
        $table = $request->input('table');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Obtener los datos según las selecciones
        $data = $this->getData($table, $userId, $startDate, $endDate);

        // Generar el PDF
        $pdf = Pdf::loadView('sistema.reportes.reportes', [
            'data' => $data,
            'table' => $table,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        // Descargar el PDF
        return $pdf->download('reporte.pdf');
    }

    // Función para obtener los datos según las selecciones
    private function getData($table, $userId, $startDate, $endDate)
    {
        switch ($table) {
            case 'users':
                $query = User::query();
                break;
            case 'providers':
                $query = Provider::query();
                break;
            case 'productos':
                $query = Producto::query();
                break;
                case 'movimientos':
                    $query = Movimiento::query();
                    break;
            default:
                $query = User::query();
                break;
        }

        // Filtrar por usuario si se seleccionó uno
        if ($userId) {
            $query->where('id', $userId);
        }

        // Filtrar por intervalo de tiempo si se seleccionó
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query->get();
    }
}