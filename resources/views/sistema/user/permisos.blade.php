@extends('adminlte::page')
@section('title', 'PERMISOS')
@section('content_header')
    <h1>TODOS LOS PERMISOS</h1>
@stop
@section('content')
    <p>Administracion de permisos</p>
    <div class="card">
        <div class="card-header">
            <x-adminlte-button label="Nuevo" theme="primary" icon="fas fa-key" class="float-right" data-toggle="modal" data-target="#modalPurple" />
        </div>
        <div class="card-body">
        @php
$heads = [
    'ID',
    'NOMBRE',
    ['label' => 'Actions', 'no-export' => true, 'width' => 20],
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
@foreach($permisos as $permiso)
    <tr>
        <td>{{ $permiso->id }}</td>
        <td>{{ $permiso->name }}</td>
        <td> 
            <a href="{{ route('permisos.edit', $permiso) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>
            <form style="display: inline" action="{{ route('permisos.destroy', $permiso) }}" method="POST" class="formEliminar">
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
{{-- Themed --}}
<x-adminlte-modal id="modalPurple" title="Nuevo Permiso" theme="primary" icon="fas fa-user-plus" size='lg' disable-animations>
    <form action="{{ route('permisos.store') }}" method="POST">
        @csrf
        <div class="row">
            <x-adminlte-input name="name" label="Nombre Permiso" placeholder="Nuevo Permiso" fgroup-class="col-md-6" disable-feedback/>
        </div>
        <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save"/>
    </form>
</x-adminlte-modal>

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