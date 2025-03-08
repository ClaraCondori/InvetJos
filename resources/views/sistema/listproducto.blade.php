@extends('adminlte::page')
@section('title', 'Productos')
@section('content_header')
    <h1>TODOS LOS PRODUCTOS</h1>
@stop
@section('content')
    <p>Lista de productos</p>
    <div class="card">
        <div class="card-header">
            <h5>Filtrar Productos</h5>
            <form action="{{ route('producto.index') }}" method="GET">
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
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="{{ route('producto.index') }}" class="btn btn-default">
                            <i class="fas fa-sync"></i> Limpiar filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
        @php
        $heads = [
            'ID',
            'CATEGORIA',
            'NOMBRE',
            'DESCRIPCION',
            'PRECIO DE COMPRA',
            ['label' => 'PRECIO DE VENTA', 'width' => 20],
            ['label' => 'CANTIDAD', 'width' => 20],
            ['label' => 'ESTADO', 'width' => 20],
            ['label' => 'OPCIONES', 'no-export' => true, 'width' => 20],
        ];

        $config = [
            'language' => [
                'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            ],
            'paging' => false, // Deshabilitar paginación
            'searching' => false, // Deshabilitar búsqueda
            'ordering' => false, // Deshabilitar ordenamiento
            'info' => false, // Ocultar información de paginación
            'autoWidth' => false, // Deshabilitar ajuste automático de ancho
            'responsive' => true, // Hacer la tabla responsive
        ];
    @endphp

            {{-- Pasar la configuración al componente --}}
            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->categoria->nombre_cat }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->precio_comp }}</td>
                        <td>{{ $producto->precio_vent }}</td>
                        <td>{{ $producto->cantidad }}</td>
                        <td>{{ $producto->estado }}</td>
                        <td>
                            <a href="{{ route('producto.edit', $producto) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form style="display: inline" action="{{ route('producto.destroy', $producto) }}" method="POST" class="formEliminar">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
        <div class="card-footer">
            <a href="{{ route('sistema.productoinactivos') }}" class="btn btn-info float-right text-white mx-1 shadow">
                <i class="fas fa-info-circle"></i> Ver desactivados
            </a>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.formEliminar').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "¿Desea eliminar el registro?",
                    text: "¡Esta acción no se puede deshacer!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@stop