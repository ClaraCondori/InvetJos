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
        $provider = Provider::where('estado', true)->get();
        return view('sistema.listprovider', compact('provider'));
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
        'nombre' => 'required|string|max:75', 
        'correo' => 'required|email|unique:providers,correo|max:75', 
        'contacto' => 'required|string|max:75',
        'telefono' => 'required|numeric|min:15', 
    ]);

    
    $provider = new Provider();
    $provider->nombre = $request->input('nombre');
    $provider->correo = $request->input('correo');
    $provider->contacto = $request->input('contacto');
    $provider->telefono = $request->input('telefono');
    $provider->save();

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
        $provider = Provider::find($id);
        return view('sistema.editprovider', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $provider = Provider::find($id);
        $provider->nombre = $request->input('nombre');
        $provider->correo = $request->input('correo');
        $provider->contacto = $request->input('contacto');
        $provider->telefono = $request->input('telefono');
        $provider->save();
        return back()->with('message', 'Actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $provider = Provider::findOrFail($id);
        $provider->estado = false;
        $provider->save();
        return back(); 
    }
    public function inactivos()
    {
    $provider = Provider::where('estado', false)->get();
    return view('sistema.inactivoprov', compact('provider'));
    }
    public function activar($id){
    $provider = Provider::findOrFail($id);
    $provider->estado = true;
    $provider->save();
    return back()->with('message', 'Producto activado correctamente.');
    }
}
