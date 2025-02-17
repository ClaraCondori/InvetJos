@extends('adminlte::page')

@section('title', 'PROVEEDORES')

@section('content_header')
    <h1>ADMINISTRACION DE PROVEEDORES</h1>
@stop

@section('content')
    <p>Datos del proveedor</p>
    <div class="card">
        <div class="card-body">
        <form action="{{ route('provider.update', $provider) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Primer input -->
        <x-adminlte-input name="nombre" label="Proveedor" label-class="text-lightblue" value="{{ $provider->nombre}}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-users text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <!-- Segundo input -->
        <x-adminlte-input name="correo" label="Correo electronico" label-class="text-lightblue" value="{{ $provider->correo }}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-envelope text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <!-- Tercer input -->
        <x-adminlte-input name="contacto" label="Contacto"  label-class="text-lightblue" value="{{ $provider->contacto }}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-user text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <!-- Cuarto input -->
        <x-adminlte-input name="telefono" label="Telefono de Contacto" label-class="text-lightblue" value="{{ $provider->telefono }}">
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
@if (session("message")) 
    <script>
    $(document).ready(function(){
        let mensaje = "{{ session ('message')}}";
        Swal.fire({
            title: "Datos guardados",
            icon: "success",
            draggable: true
        })
    })
    </script>
    @endif
@stop