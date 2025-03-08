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
    // Consulta base para productos activos
    $query = Producto::where('estado', true);
    // Filtrar por categoría
    if ($request->has('categoria') && $request->categoria != '') {
        $query->where('categoria_id', $request->categoria);
    }
    // Filtrar por cantidad mínima
    if ($request->has('cantidad') && $request->cantidad != '') {
        $query->where('cantidad', '>=', $request->cantidad);
    }
    // Filtrar por fecha de creación
    if ($request->has('fecha') && $request->fecha != '') {
        $query->whereDate('created_at', $request->fecha);
    }
    // Obtener las categorías para el filtro
    $categorias = Categoria::all();
    // Obtener los productos filtrados
    $productos = $query->get();
    // Pasar los productos y categorías a la vista
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
        
        $validacion = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_vent' => 'required|numeric|min:0', 
            'precio_comp' => 'required|numeric|min:0', 
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = new Producto();
        $producto->categoria_id = $request->input('categoria_id');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio_vent = $request->input('precio_vent');
        $producto->precio_comp = $request->input('precio_comp');
        $producto->cantidad = $request->input('cantidad',0);
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
        //
        $producto = Producto::find($id);
        $producto->categoria_id = $request->input('categoria_id');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio_vent = $request->input('precio_vent');
        $producto->precio_comp = $request->input('precio_comp');
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