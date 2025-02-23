<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::with('rol')->get();
        return view('sistema.listuser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $rol = Rol::all(); // Obtener todos los roles
        $config = [
            'liveSearch' => true, // Habilitar búsqueda en vivo
            'actionsBox' => true, // Mostrar caja de acciones
        ];
        return view('sistema.adduser', compact('rol', 'config'));
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
            'rol_id' => 'required|exists:rols,id', 
            'estado' => 'required|string|in:ACTIVO,INACTIVO',
        ]);
        
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->telefono = $request->input('telefono');
        $user->rol_id = $request->input('rol_id');
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
        $rol = Rol::all();
        $estados = ['ACTIVO', 'INACTIVO']; 
        return view('sistema.edituser', compact('user' , 'rol', 'estados'));

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
        $user->rol_id = $request->input('rol_id');
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
