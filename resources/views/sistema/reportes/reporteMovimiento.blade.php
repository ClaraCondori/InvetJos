<!-- resources/views/movimientos/informes.blade.php -->
@extends('adminlte::page')
@section('title', 'Informes de Movimientos')
@section('content_header')
    <h1>Generar Informes de Movimientos</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('movimiento.generarInforme') }}" method="GET">
            <div class="row">
            <!-- Filtro por usuario -->
                <div class="col-md-3">
                    <label for="users">Usuario</label>
                        <select name="users" id="users" class="form-control">
                        <option value="">Todos los usuarios</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('users') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                    </select>
                </div>
            <!-- Filtro por fecha -->
                <div class="col-md-3">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
                </div>
            <!-- Filtro por tipo de movimiento -->
                <div class="col-md-3">
                    <label for="tipo">Tipo de Movimiento</label>
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="">Todos los tipos</option>
                        <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <!-- Campo oculto para el formato PDF -->
                    <input type="hidden" name="formato" value="pdf">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-filter"></i> Generar Informe
                    </button>
                    <!-- Botón para limpiar filtros -->
                    <a href="{{ route('movimiento.generarInforme') }}" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </div>
    @stop