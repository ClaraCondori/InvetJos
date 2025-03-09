<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = Producto::where('estado', true);
    if ($request->has('categoria') && $request->categoria != '') {
        $query->where('categoria_id', $request->categoria);
    }
    if ($request->has('cantidad') && $request->cantidad != '') {
        $query->where('cantidad', '>=', $request->cantidad);
    }
    if ($request->has('fecha') && $request->fecha != '') {
        $query->whereDate('created_at', $request->fecha);
    }
    $categorias = Categoria::all();
    $productos = $query->get();
    return view('sistema.listproducto', compact('productos', 'categorias'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
        $categorias = Categoria::all();
        return view('sistema.addproducto', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validar los datos del formulario
    $validacion = $request->validate([
        'categoria_id' => 'required|exists:categorias,id',
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio_comp' => 'required|numeric|min:0',
        'cantidad' => 'required|integer|min:1',
    ]);
    $precioVent = $request->precio_comp * 1.40;

    // Crear el producto
    $producto = new Producto();
    $producto->categoria_id = $request->input('categoria_id');
    $producto->nombre = $request->input('nombre');
    $producto->descripcion = $request->input('descripcion');
    $producto->precio_comp = $request->input('precio_comp');
    $producto->precio_vent = $precioVent;
    $producto->cantidad = $request->input('cantidad', 0);
    $producto->save();

    return back()->with('message', 'Producto creado correctamente.');
}
    /**
     * Display the specified resource.
     */
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
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        return view('sistema.editproducto', compact('producto' , 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);
        $precioVent = $request->precio_comp * 1.30;
        $producto->categoria_id = $request->input('categoria_id');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio_comp = $request->input('precio_comp');
        $producto->precio_vent = $precioVent;
        $producto->cantidad = $request->input('cantidad');
        $producto->save();
    
        return back()->with('message', 'Actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $producto = Producto::findOrFail($id);
    $producto->estado = false;
    $producto->save();
    return back(); 
}
    public function inactivos()
    {
    $productos = Producto::where('estado', false)->get();
    return view('sistema.productoinactivos', compact('productos'));
    }
    public function activar($id){
    $producto = Producto::findOrFail($id);
    $producto->estado = true;
    $producto->save();
    return back()->with('message', 'Producto activado correctamente.');
}
}