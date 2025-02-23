@extends('adminlte::page')

@section('title', 'USUARIOS')

@section('content_header')
    <h1>ADMINISTRACION DE USUARIOS</h1>
@stop

@section('content')
    <p>Ingrese los datos nuevos del usuario</p>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo para el nombre de usuario -->
                <x-adminlte-input name="name" label="Usuario" label-class="text-lightblue" value="{{ $user->name }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <!-- Campo para el correo electrónico -->
                <x-adminlte-input name="email" label="Correo Electrónico" label-class="text-lightblue" value="{{ $user->email }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-envelope text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <!-- Campo para la contraseña -->
                <x-adminlte-input name="password" label="Contraseña" label-class="text-lightblue" value="{{ $user->password }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-keyboard text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <!-- Campo para el teléfono de contacto -->
                <x-adminlte-input name="telefono" label="Teléfono de Contacto" enable-old-support label-class="text-lightblue" value="{{ $user->telefono }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-olive">
                            <i class="fas fa-mobile text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <!-- Selector de rol -->
                <x-adminlte-select2 name="rol_id" label="Rol" igroup-size="lg" label-class="text-lightblue" data-placeholder="Seleccione un rol">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-address-card text-lightblue"></i>
                        </div>
                    </x-slot>
                    <option value="">Seleccione un rol</option>
                    @foreach ($rol as $role)
                        <option value="{{ $role->id }}" {{ old('rol_id', $user->rol_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->nombre }}
                        </option>
                    @endforeach
                </x-adminlte-select2>

                <!-- Selector de estado -->
                <x-adminlte-select2 name="estado" label="Estado" label-class="text-lightblue" igroup-size="lg" data-placeholder="Seleccione una opción">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-inbox text-lightblue"></i>
                        </div>
                    </x-slot>
                    <option value="">Seleccione una opción</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado }}" {{ $user->estado == $estado ? 'selected' : '' }}>
                            {{ $estado }}
                        </option>
                    @endforeach
                </x-adminlte-select2>

                <!-- Botón de guardar -->
                <x-adminlte-button class="btn-flat" type="submit" label="Actualizar" theme="primary" icon="fas fa-lg fa-save"/>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Agrega aquí hojas de estilo adicionales --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @if (session("message")) 
        <script>
            $(document).ready(function(){
                let mensaje = "{{ session('message') }}";
                Swal.fire({
                    title: "Datos actualizados",
                    text: mensaje,
                    icon: "success",
                    draggable: true
                });
            });
        </script>
    @endif
@stop