@extends('adminlte::page')
@section('title', 'Movimientos')
@section('content_header')
    <h1>TODOS LOS MOVIMIENTOS</h1>
@stop

@section('content')
<p>Lista de Movimientos</p>
<!-- Formulario de filtrado -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filtrar Movimientos</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('movimiento.index') }}" method="GET">
            <div class="row">
                <!-- Filtro por producto -->
                <div class="col-md-3">
                    <label for="producto">Producto</label>
                    <select name="producto" id="producto" class="form-control">
                        <option value="">Todos los productos</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" {{ request('producto') == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por usuario -->
                <div class="col-md-3">
                    <label for="usuario">Usuario</label>
                    <select name="usuario" id="usuario" class="form-control">
                        <option value="">Todos los usuarios</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ request('usuario') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por fecha -->
                <div class="col-md-3">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('movimiento.index') }}" class="btn btn-secondary">Limpiar Filtros</a>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        @php
        $heads = [
            'ID',
            'TIPO',
            'FECHA',
            'RESPONSABLE',
            'OBSERVACIÓN',
            ['label' => 'OPCIONES', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            ]
        ];
        @endphp

        {{-- Tabla de movimientos --}}
        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
            @foreach($movimientos as $movimiento)
                <tr>
                    <td>{{ $movimiento->id }}</td>
                    <td>{{ $movimiento->tipo }}</td>
                    <td>{{ $movimiento->fecha }}</td>
                    <td>{{ $movimiento->responsable}}</td>
                    <td>{{ $movimiento->observacion}}</td>
                    <td>
                        <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Ver Detalles" data-toggle="modal" data-target="#detallesModal{{ $movimiento->id }}">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button>
                    </td>
                    <td>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</div>

{{-- Modales para los detalles --}}
@foreach($movimientos as $movimiento)
<div class="modal fade" id="detallesModal{{ $movimiento->id }}" tabindex="-1" role="dialog" aria-labelledby="detallesModalLabel{{ $movimiento->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detallesModalLabel{{ $movimiento->id }}">Detalles del Movimiento #{{ $movimiento->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimiento->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->producto->nombre }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@stop

@section('css')
    {{-- Aquí puedes agregar estilos adicionales --}}
@stop

@section('js')
<script>
</script>
@stop