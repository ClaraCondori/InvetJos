@extends('adminlte::page')
@section('title', 'ROLES')
@section('content_header')
    <h1>TODOS LOS ROLES</h1>
@stop
@section('content')
    <p>Administracion de roles</p>
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
@foreach($roles as $rol)
    <tr>
        <td>{{ $rol->id }}</td>
        <td>{{ $rol->name }}</td>
        <td> 
            <a href="{{ route('roles.edit', $rol) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>
            <form style="display: inline" action="{{ route('roles.destroy', $rol) }}" method="POST" class="formEliminar">
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
<x-adminlte-modal id="modalPurple" title="Nuevo Rol" theme="primary" icon="fas fa-user-plus" size='lg' disable-animations>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="row">
            <x-adminlte-input name="name" label="Nombre Rol" placeholder="Nuevo Rol" fgroup-class="col-md-6" disable-feedback/>
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