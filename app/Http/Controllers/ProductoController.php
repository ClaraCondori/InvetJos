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
    public function index()
    {
        // Obtener todos los productos
        $productos = Producto::all();
        return view('sistema.listproducto', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todas las categorías
        $categorias = Categoria::all();
        return view('sistema.addproducto', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validacion = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_vent' => 'required|numeric|min:0', // Usar numeric para decimales
            'precio_comp' => 'required|numeric|min:0', // Usar numeric para decimales
            'cantidad' => 'required|integer|min:1',
        ]);

        // Crear un nuevo producto
        $producto = new Producto();
        $producto->categoria_id = $request->input('categoria_id');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio_vent = $request->input('precio_vent');
        $producto->precio_comp = $request->input('precio_comp');
        $producto->cantidad = $request->input('cantidad');
        $producto->save();

        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('producto.index')->with('message', 'Producto creado correctamente.');
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
    }
}