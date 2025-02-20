@extends('adminlte::page')
@section('title', 'Productos')
@section('content_header')
    <h1>TODOS LOS PRODUCTOS</h1>
@stop
@section('content')
    <p>Lista de productos</p>
    <div class="card">
        <div class="card-body">
        @php
$heads = [
    'ID',
    'ID CATEGORIA',
    'NOMBRE',
    'DESCRIPCION',
    'PRECIO DE VENTA',
    ['label' => 'PRECIO DE COMPRA', 'width' => 20],
    ['label' => 'CANTIDAD', 'width' => 20],
    ['label' => 'OPCIONES', 'no-export' => true, 'width' => 20],
];

$btnEdit = '';
$btnDelete = '<button type="submit"class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>';

$config = [
    'language' => [
        'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    ]
];
@endphp

{{-- Pasar la configuración al componente --}}
<x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
    @foreach($productos as $productos)
        <tr>
            <td>{{ $productos->id }}</td>
            <td>{{ $productos->categoria->nombre_cat }}</td>
            <td>{{ $productos->nombre }}</td>
            <td>{{ $productos->descripcion }}</td>
            <td>{{ $productos->precio_vent }}</td>
            <td>{{ $productos->precio_comp }}</td>
            <td>{{ $productos->cantidad }}</td>
            <td> <a href="{{ route('producto.edit', $productos) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>
                <form style="display: inline" action="{{ route('producto.destroy', $productos) }}" method="POST" class="formEliminar">
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