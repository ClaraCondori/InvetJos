@extends('adminlte::page')

@section('title', 'Reportes de Productos')

@section('content_header')
    <h1>Generar Reportes de Productos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
        <form action="{{ route('reportes.productos.generar') }}" method="GET">
    @csrf
    <div class="row">
                    <!-- Filtro por categoría -->
                    <div class="col-md-3">
                        <x-adminlte-select2 name="categoria" label="Categoría">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre_cat }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <!-- Filtro por estado -->
                    <div class="col-md-3">
                        <x-adminlte-select2 name="estado" label="Estado">
                            <option value="">Todos los estados</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </x-adminlte-select2>
                    </div>
                    <!-- Filtro por cantidad -->
                    <div class="col-md-3">
                        <x-adminlte-input name="cantidad" type="number" label="Cantidad mínima" placeholder="Cantidad mínima"
                            value="{{ request('cantidad') }}" />
                    </div>
                    <!-- Filtro por fecha -->
                    <div class="col-md-3">
                        <x-adminlte-input name="fecha" type="date" label="Fecha de creación"
                            value="{{ request('fecha') }}" />
                    </div>
                </div>    
    <div class="row mt-3">
        <div class="col-md-12">
            <!-- Campo oculto para el formato PDF -->
            <input type="hidden" name="formato" value="pdf">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-filter"></i> Generar Reporte
            </button>
            <!-- Botón para limpiar filtros -->
            <a href="{{ route('reportes.productos.formulario') }}" class="btn btn-secondary">
                <i class="fa fa-times"></i> Limpiar Filtros
            </a>
        </div>
    </div>
</form> 
        </div>
@stop