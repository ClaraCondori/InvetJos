@extends('adminlte::page')

@section('title', 'REPORTES')

@section('content_header')
    <h1>Generar Reporte</h1>
@stop
@section('content')
    <p>Seleccione los datos para generar el reporte.</p>
    <div class="card">
        <div class="card-body">
        <form action="{{ route('reporte.preview') }}" method="GET">
    @csrf
    <!-- Selección de usuario -->
    <x-adminlte-select2 name="user" label="Usuario" igroup-size="lg" label-class="text-lightblue" data-placeholder="Seleccione un usuario">
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-user text-lightblue"></i>
            </div>
        </x-slot>
        <option value="">Todos los usuarios</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </x-adminlte-select2>

    <!-- Selección de tabla -->
    <x-adminlte-select2 name="table" label="Tabla" igroup-size="lg" label-class="text-lightblue" data-placeholder="Seleccione una tabla">
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-table text-lightblue"></i>
            </div>
        </x-slot>
        <option value="usuarios">Usuarios</option>
        <option value="providers">Proveedores</option>
        <option value="productos">Productos</option>
    </x-adminlte-select2>

    <!-- Selección de fecha de inicio -->
    <x-adminlte-input name="start_date" type="date" label="Fecha de inicio" label-class="text-lightblue">
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-calendar-alt text-lightblue"></i>
            </div>
        </x-slot>
    </x-adminlte-input>

    <!-- Selección de fecha de fin -->
    <x-adminlte-input name="end_date" type="date" label="Fecha de fin" label-class="text-lightblue">
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-calendar-alt text-lightblue"></i>
            </div>
        </x-slot>
    </x-adminlte-input>

    <!-- Botón para previsualizar -->
    <x-adminlte-button class="btn-flat" type="submit" label="Previsualizar Reporte" theme="primary" icon="fas fa-eye"/>
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
                    title: "Reporte generado",
                    text: mensaje,
                    icon: "success",
                    draggable: true
                });
            });
        </script>
    @endif
@stop