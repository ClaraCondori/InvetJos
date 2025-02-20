@extends('adminlte::page')

@section('title', 'ROL')

@section('content_header')
    <h1>ADMINISTRACION DE ROLES</h1>
@stop

@section('content')
    <p>Datos de los roles existentes</p>
    <div class="card">
        <div class="card-body">
        <form action="{{ route('rol.update', $rol) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Primer input -->
        <x-adminlte-input name="nombre" label="Rol" label-class="text-lightblue" value="{{ $rol->nombre}}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-bars text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
        <x-adminlte-button class="btn-flat" type="Submit" label="Actualizar" theme="primary" icon="fas fa-lg fa-save"/>
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