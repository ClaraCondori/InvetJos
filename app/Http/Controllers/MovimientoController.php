<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\User;
use App\Models\Producto;
class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $movimientos = Movimiento::with(['responsableUser', 'detalles.producto'])->get();
        return view('sistema.listmovimientos', compact('movimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $responsable = User::all();
        $productos = Producto::all();
        return view('sistema.addmovimiento', compact('responsable', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del movimiento
    $validacion = $request->validate([
        'tipo' => 'required|in:ENTRADA,SALIDA',
        'fecha' => 'required|date',
        'responsable' => 'required|exists:users,id',
        'observacion' => 'nullable|string',
        'detalles' => 'required|array|min:1',
        'detalles.*.producto_id' => 'required|exists:productos,id',
        'detalles.*.cantidad' => 'required|integer|min:1',
        'detalles.*.precio_unitario' => 'required|numeric|min:0',
    ]);

    // Iniciar una transacción de base de datos
    DB::beginTransaction();

    try {
        // Crear el movimiento
        $movimiento = new Movimiento();
        $movimiento->tipo = $request->input('tipo');
        $movimiento->fecha = $request->input('fecha');
        $movimiento->responsable = $request->input('responsable');
        $movimiento->observacion = $request->input('observacion');
        $movimiento->save();

        // Crear los detalles del movimiento
        foreach ($request->input('detalles') as $detalle) {
            $producto = Producto::find($detalle['producto_id']);

            // Verificar si el producto existe
            if (!$producto) {
                throw new \Exception("El producto con ID {$detalle['producto_id']} no existe.");
            }

            // Actualizar el stock según el tipo de movimiento
            if ($movimiento->tipo == 'ENTRADA') {
                $producto->cantidad += $detalle['cantidad'];
            } elseif ($movimiento->tipo == 'SALIDA') {
                if ($producto->cantidad < $detalle['cantidad']) {
                    throw new \Exception("No hay suficiente stock para el producto: {$producto->nombre}");
                }
                $producto->cantidad -= $detalle['cantidad'];
            }

            // Guardar el producto con el stock actualizado
            $producto->save();

            // Crear el detalle del movimiento
            $detalleMovimiento = new DetalleMovimiento();
            $detalleMovimiento->movimiento_id = $movimiento->id;
            $detalleMovimiento->producto_id = $detalle['producto_id'];
            $detalleMovimiento->cantidad = $detalle['cantidad'];
            $detalleMovimiento->precio_unitario = $detalle['precio_unitario'];
            $detalleMovimiento->save();
        }

        // Confirmar la transacción
        DB::commit();

        // Redirigir con un mensaje de éxito
        return redirect()->route('movimiento.index')->with('message', 'Movimiento creado correctamente.');

    } catch (\Exception $e) {
        // Revertir la transacción en caso de error
        DB::rollBack();

        // Redirigir con un mensaje de error
        return redirect()->back()->with('error', 'Error al crear el movimiento: ' . $e->getMessage());
    }
    }
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $moviento = Movimientoo::find($id);
        $movimiento->delete();
        return back();
    }
}
