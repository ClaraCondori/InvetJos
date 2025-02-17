<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categoria= Categoria::all();
        return view( 'sistema.listcategoria', compact('categoria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('sistema.addcategoria');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validacion = $request->validate([
            'nombre_cat' => 'required|string', // Regla válida
        ]);
    
        // Crear un nuevo proveedor
        $categoria = new Categoria();
        $categoria->nombre_cat = $request->input('nombre_cat');
        $categoria->save();
    
        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('message', 'Categoria creada correctamente.');
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
        $categoria = Categoria::find($id);
        return view('sistema.edircatergoria', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $categoria = Categoria::find($id);
        $categoria->nombre_cat = $request->input('nombre_cat');
        $categoria->save();
        return back()->with('message', 'Actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $categoria = Categoria::find($id);
        $categoria->delete();
        return back();
    }
}
