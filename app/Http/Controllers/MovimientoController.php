<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\DetalleMovimiento;
use App\Models\Provider;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MovimientoController extends Controller
{
    /**
     * Listar movimientos con filtros.
     */
    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda
        $productoId = $request->input('producto');
        $usuarioId = $request->input('usuario');
        $fecha = $request->input('fecha');

        // Consulta base con relaciones
        $query = Movimiento::with(['responsable', 'detalles.producto']);

        // Aplicar filtros
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

        // Obtener movimientos filtrados
        $movimientos = $query->get();

        // Obtener listas para los filtros
        $productos = Producto::all();
        $usuarios = User::all();

        return view('sistema.listmovimientos', compact('movimientos', 'productos', 'usuarios'));
    }

    /**
     * Mostrar el formulario para crear un nuevo movimiento.
     */
    public function create()
    {
        $providers = Provider::all();
        $products = Producto::all();
        return view('sistema.addmovimiento', compact('providers', 'products'));
    }

    /**
     * Guardar un nuevo movimiento en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        try {
            $request->validate([
                'tipo' => 'required|in:entrada,salida',
                'provider_id' => 'nullable|exists:providers,id',
                'productos' => 'required|array',
                'productos.*.producto_id' => 'required|exists:productos,id',
                'productos.*.cantidad' => 'required|integer|min:1',
                'productos.*.precio_comp' => 'required_if:tipo,entrada|numeric|min:0',
                'fecha' => 'required|date',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }

        // Iniciar una transacción de base de datos
        DB::beginTransaction();
        try {
            // Crear el movimiento
            $movimiento = Movimiento::create([
                'tipo' => $request->tipo,
                'provider_id' => $request->tipo === 'entrada' ? $request->provider_id : null,
                'responsable' => Auth::id(), // Usuario autenticado
                'fecha' => $request->fecha,
                'observacion' => $request->observacion,
            ]);

            // Registrar los detalles del movimiento
            foreach ($request->productos as $producto) {
                // Crear el detalle del movimiento
                DetalleMovimiento::create([
                    'movimiento_id' => $movimiento->id,
                    'producto_id' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                    'precio_comp' => $request->tipo === 'entrada' ? $producto['precio_comp'] : null,
                ]);

                // Actualizar el inventario y el precio del producto
                $productoModel = Producto::find($producto['producto_id']);

                if ($request->tipo === 'entrada') {
                    // Actualizar el precio de compra y venta
                    $productoModel->precio_comp = $producto['precio_comp'];
                    $productoModel->precio_vent = $producto['precio_comp'] * 1.40;
                    $productoModel->cantidad += $producto['cantidad']; // Añadir al inventario
                } elseif ($request->tipo === 'salida') {
                    // Verificar si hay suficiente stock
                    if ($productoModel->cantidad < $producto['cantidad']) {
                        DB::rollBack();
                        return back()->withErrors(['productos' => 'No hay suficiente cantidad de ' . $productoModel->nombre . ' en inventario.'])->withInput();
                    }
                    $productoModel->cantidad -= $producto['cantidad']; // Restar del inventario
                }

                // Guardar los cambios en el producto
                $productoModel->save();
            }

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('movimiento.index')->with('success', 'Movimiento registrado exitosamente.');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al registrar el movimiento.'])->withInput();
        }
    }

    /**
     * Mostrar los detalles de un movimiento específico.
     */
    public function show(string $id)
    {
        // Obtener el movimiento con sus detalles y relaciones
        $movimiento = Movimiento::with(['detalles.producto', 'provider', 'responsable'])->findOrFail($id);

        return view('sistema.showmovimiento', compact('movimiento'));
    }
}