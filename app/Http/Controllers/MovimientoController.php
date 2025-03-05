<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\DetalleMovimiento;
use App\Models\Provider;
use App\Models\Producto;
use App\Models\User;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movimientos = Movimiento::with(['responsable', 'detalles.producto'])->get();
        return view('sistema.listmovimientos', compact('movimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movimientos = Movimiento::all();
        $providers = Provider::all();
        $products = Producto::all();
        $user = User::all();
        return view('sistema.addmovimiento', compact('movimientos', 'providers', 'products', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'provider_id' => 'nullable|exists:providers,id',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'fecha' => 'required|date',
        ]);
    
        // Crear el movimiento
        $movement = Movimiento::create([
            'tipo' => $request->tipo,
            'provider_id' => $request->tipo === 'entrada' ? $request->provider_id : null,
            'responsable' => auth()->id(), // Asignar el ID del usuario logueado
            'fecha' => $request->fecha,
        ]);
    
        // Verificar que 'productos' sea un array
        if (is_array($request->productos)) {
            foreach ($request->productos as $producto) {
                // Registrar el detalle del movimiento
                DetalleMovimiento::create([
                    'movimiento_id' => $movement->id,
                    'producto_id' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                ]);
    
                // Obtener el producto
                $productModel = Producto::find($producto['producto_id']);
    
                // Validar la cantidad disponible en caso de salida
                if ($request->tipo === 'salida') {
                    if ($productModel->cantidad < $producto['cantidad']) {
                        return back()->withErrors(['productos' => 'No hay suficiente cantidad de ' . $productModel->nombre . ' en inventario.'])->withInput();
                    }
                    $productModel->cantidad -= $producto['cantidad']; // Disminuir la cantidad
                } elseif ($request->tipo === 'entrada') {
                    $productModel->cantidad += $producto['cantidad']; // Aumentar la cantidad
                }
    
                // Guardar los cambios en la tabla de productos
                $productModel->save();
            }
        } else {
            return back()->withErrors(['productos' => 'Los datos de productos no son válidos.'])->withInput();
        }
    
        return redirect()->route('movimiento.index')->with('success', 'Movimiento registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lógica para mostrar un movimiento específico
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Lógica para mostrar el formulario de edición
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Lógica para actualizar un movimiento
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Lógica para eliminar un movimiento
    }
}