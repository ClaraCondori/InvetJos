<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users= User::all();
        return view('sistema.listuser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $config = [
            'liveSearch' => true, // Habilitar búsqueda en vivo
            'actionsBox' => true, // Mostrar caja de acciones
        ];
        return view('sistema.adduser', compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:75',
            'password' => 'required|string|min:8',
            'telefono' => 'required|string|max:20',
            'estado' => 'required|string|in:ACTIVO,INACTIVO',
        ]);
        
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->telefono = $request->input('telefono');
        $user->estado = $request->input('estado');
        $user->save();
        return redirect()->route('user.index')->with('message', 'Usuario creado correctamente.');
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
        $user = User::find($id);

        $estados = ['ACTIVO', 'INACTIVO']; 
        return view('sistema.edituser', compact('user' , 'estados'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->telefono = $request->input('telefono');
        $user->estado = $request->input('estado');
        $user->save();
        return back()->with('message', 'Actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        $user->delete();
        return back();
    }
}
