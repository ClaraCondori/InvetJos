@extends('adminlte::page')

@section('title', 'USUARIOS')

@section('content_header')
    <h1>ADMINISTRACION DE USUARIOS</h1>
@stop

@section('content')
    <p>Ingrese los datos del nuevo usuario</p>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <x-adminlte-input name="name" label="Usuario" label-class="text-lightblue" value="{{ old('name') }}" placeholder="Juan Perez" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="email" label="Correo Electronico" label-class="text-lightblue" value="{{ old('email') }}" placeholder="usuario@gmail.com" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-envelope text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="password" type="password" label="Contraseña" label-class="text-lightblue" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-keyboard text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="telefono" label="Telefono de Contacto" enable-old-support label-class="text-lightblue" value="{{ old('telefono') }}" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-olive">
                            <i class="fas fa-mobile text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-select name="estado" label="Estado" label-class="text-lightblue" required>
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </x-adminlte-select>
                <!-- Botón de envío -->
                <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="primary" icon="fas fa-lg fa-save"/>
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
                    title: "Datos guardados",
                    text: mensaje,
                    icon: "success",
                    draggable: true
                });
            });
        </script>
    @endif
@stop