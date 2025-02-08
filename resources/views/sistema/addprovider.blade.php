@extends('adminlte::page')

@section('title', 'PROVEEDORES')

@section('content_header')
    <h1>ADMINISTRACION DE PROVEEDORES</h1>
@stop

@section('content')
    <p>Ingrese los datos del nuevo proveedor</p>
    <div class="card">
    @if (session()->has('message'))
        <x-adminlte-alert theme="success" title="Éxito">
            {{ session('message') }}
        </x-adminlte-alert>
    @endif
        <div class="card-body">
        <form action="{{ route('provider.store') }}" method="POST">
        @csrf
        <!-- Primer input -->
        <x-adminlte-input name="nombre" label="Proveedor" placeholder="Nombre Proveedor" label-class="text-lightblue" value="{{ old('nombre') }}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-users text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <!-- Segundo input -->
        <x-adminlte-input name="correo" label="Correo electronico" placeholder="proveedor@example.com" label-class="text-lightblue" value="{{ old('correo') }}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-envelope text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <!-- Tercer input -->
        <x-adminlte-input name="contacto" label="Contacto" placeholder="Nombre de contacto" label-class="text-lightblue" value="{{ old('contacto') }}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-user text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <!-- Cuarto input -->
        <x-adminlte-input name="telefono" label="Telefono de Contacto" placeholder="Numero de telefono" label-class="text-lightblue" value="{{ old('telefono') }}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-phone-volume text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="primary" icon="fas fa-lg fa-save"/>
    </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop