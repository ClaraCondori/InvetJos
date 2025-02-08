<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;

class providerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return "Lista de Proveedores";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('sistema.addprovider');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
    
        // Validar los datos del formulario
    $validacion = $request->validate([
        'nombre' => 'required|string|max:75', // Regla válida
        'correo' => 'required|email|unique:providers,correo|max:75',  // Regla válida
        'contacto' => 'required|string|max:75', // Regla válida
        'telefono' => 'required|numeric|min:15', // Regla válida
    ]);

    // Crear un nuevo proveedor
    $provider = new Provider();
    $provider->nombre = $request->input('nombre');
    $provider->correo = $request->input('correo');
    $provider->contacto = $request->input('contacto');
    $provider->telefono = $request->input('telefono');
    $provider->save();

    // Redirigir de vuelta con un mensaje de éxito
    return back()->with('message', 'Proveedor creado correctamente.');
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
