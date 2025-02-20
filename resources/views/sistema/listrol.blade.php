@extends('adminlte::page')
@section('title', 'ROL')
@section('content_header')
    <h1>TODOS LOS ROLES</h1>
@stop
@section('content')
    <p>Lista de roles</p>
    <div class="card">
        <div class="card-body">
        @php
$heads = [
    'ID',
    'NOMBRE ROL',
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
    @foreach($rol as $roles)
        <tr>
            <td>{{ $roles->id }}</td>
            <td>{{ $roles->nombre }}</td>
            <td> <a href= "{{route('rol.edit', $roles)}}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>
            <form style="display: inline" action="{{ route('rol.destroy', $roles) }}" method="POST" class="formEliminar">
                @csrf 
                @method('delete')
                {!! $btnDelete !!}
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