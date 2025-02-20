<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rol= rol::all();
        return view( 'sistema.listrol', compact('rol'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('sistema.addrol');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validacion = $request->validate([
            'nombre' => 'required|string', // Regla válida
        ]);
    
        // Crear un nuevo proveedor
        $rol = new Rol();
        $rol->nombre = $request->input('nombre');
        $rol->save();
    
        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('message', 'Rol creado correctamente.');
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
        $rol = Categoria::find($id);
        return view('sistema.editrol', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $rol = Rol::find($id);
        $rol->nombre = $request->input('nombre');
        $rol->save();
        return back()->with('message', 'Actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $rol = Rol::find($id);
        $rol->delete();
        return back();
    }
}
