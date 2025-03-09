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
    public function index(Request $request)
    {
    $productoId = $request->input('producto');
    $usuarioId = $request->input('usuario');
    $fecha = $request->input('fecha');

    $query = Movimiento::with(['responsable', 'detalles.producto']);


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

    $movimientos = $query->get();
    $productos = Producto::all();   
    $usuarios = User::all();       

    return view('sistema.listmovimientos', compact('movimientos', 'productos', 'usuarios'));
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
        'productos.*.precio_comp' => 'required_if:tipo,entrada|numeric|min:0', // Validar precio_comp
        'fecha' => 'required|date',
    ]);

    // Crear el movimiento
    $movement = Movimiento::create([
        'tipo' => $request->tipo,
        'provider_id' => $request->tipo === 'entrada' ? $request->provider_id : null,
        'responsable' => auth()->id(),
        'fecha' => $request->fecha,
        'observacion' => $request->observacion,
    ]);

    // Registrar los detalles del movimiento
    foreach ($request->productos as $producto) {
        // Crear el detalle del movimiento
        DetalleMovimiento::create([
            'movimiento_id' => $movement->id,
            'producto_id' => $producto['producto_id'],
            'cantidad' => $producto['cantidad'],
            'precio_comp' => $request->tipo === 'entrada' ? $producto['precio_comp'] : null, // Guardar precio_comp
        ]);

        // Actualizar el inventario y el precio de compra del producto
        $productModel = Producto::find($producto['producto_id']);

        if ($request->tipo === 'entrada') {
            // Actualizar el precio de compra del producto
            $productModel->precio_comp = $producto['precio_comp'];
            $productModel->precio_vent = $producto['precio_comp'] * 1.40;
            $productModel->cantidad += $producto['cantidad']; // Añadir al inventario
        } elseif ($request->tipo === 'salida') {
            if ($productModel->cantidad < $producto['cantidad']) {
                return back()->withErrors(['productos' => 'No hay suficiente cantidad de ' . $productModel->nombre . ' en inventario.'])->withInput();
            }
            $productModel->cantidad -= $producto['cantidad']; // Restar del inventario
        }

        // Guardar los cambios en el producto
        $productModel->save();
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
    /**
 * Show the form for editing the specified resource.
 */
    public function edit(string $id)
    {
    // Obtener el movimiento con sus detalles y relaciones
    $movimiento = Movimiento::with(['detalles.producto', 'provider'])->findOrFail($id);

    // Obtener listas de proveedores, productos y usuarios
    $providers = Provider::all();
    $products = Producto::all();
    $users = User::all();

    // Retornar la vista de edición con los datos necesarios
    return view('sistema.editmovimiento', compact('movimiento', 'providers', 'products', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    // Validar los datos del formulario
    $request->validate([
        'tipo' => 'required|in:entrada,salida',
        'provider_id' => 'nullable|exists:providers,id',
        'productos' => 'required|array',
        'productos.*.producto_id' => 'required|exists:productos,id',
        'productos.*.cantidad' => 'required|integer|min:1',
        'productos.*.precio_comp' => 'required_if:tipo,entrada|numeric|min:0', // Validar precio_comp
        'fecha' => 'required|date',
    ]);

    // Obtener el movimiento a actualizar
    $movimiento = Movimiento::findOrFail($id);

    // Revertir el inventario de los productos asociados al movimiento actual
    foreach ($movimiento->detalles as $detalle) {
        $producto = Producto::find($detalle->producto_id);
        if ($movimiento->tipo === 'entrada') {
            $producto->cantidad -= $detalle->cantidad; // Revertir entrada
        } elseif ($movimiento->tipo === 'salida') {
            $producto->cantidad += $detalle->cantidad; // Revertir salida
        }
        $producto->save();
    }

    // Eliminar los detalles antiguos del movimiento
    $movimiento->detalles()->delete();

    // Actualizar los datos del movimiento
    $movimiento->update([
        'tipo' => $request->tipo,
        'provider_id' => $request->tipo === 'entrada' ? $request->provider_id : null,
        'responsable' => auth()->id(),
        'fecha' => $request->fecha,
    ]);

    // Registrar los nuevos detalles del movimiento
    foreach ($request->productos as $producto) {
        DetalleMovimiento::create([
            'movimiento_id' => $movimiento->id,
            'producto_id' => $producto['producto_id'],
            'cantidad' => $producto['cantidad'],
            'precio_comp' => $request->tipo === 'entrada' ? $producto['precio_comp'] : null, // Guardar precio_comp
        ]);

        // Actualizar el inventario y el precio de compra del producto
        $productModel = Producto::find($producto['producto_id']);
        if ($request->tipo === 'entrada') {
            // Actualizar el precio de compra del producto
            $productModel->precio_comp = $producto['precio_comp'];
            $productModel->precio_vent = $producto['precio_comp'] * 1.40;
            $productModel->cantidad += $producto['cantidad']; // Añadir al inventario
        } elseif ($request->tipo === 'salida') {
            if ($productModel->cantidad < $producto['cantidad']) {
                return back()->withErrors(['productos' => 'No hay suficiente cantidad de ' . $productModel->nombre . ' en inventario.'])->withInput();
            }
            $productModel->cantidad -= $producto['cantidad']; // Restar del inventario
        }
        $productModel->save();
    }

    return redirect()->route('movimiento.index')->with('success', 'Movimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Lógica para eliminar un movimiento
    }
}