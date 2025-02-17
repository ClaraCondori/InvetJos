@extends('adminlte::page')

@section('title', 'CATEGORIAS')

@section('content_header')
    <h1>ADMINISTRACION DE CATEGORIAS</h1>
@stop

@section('content')
    <p>Ingrese los datos de una nueva categoria</p>
    <div class="card">
        <div class="card-body">
        <form action="{{ route('categoria.store') }}" method="POST">
        @csrf
        <!-- Primer input -->
        <x-adminlte-input name="nombre_cat" label="Categoria" placeholder="Nombre Categoria" label-class="text-lightblue" value="{{ old('nombre_cat') }}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-bars text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
        <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="primary" icon="fas fa-lg fa-save"/>
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