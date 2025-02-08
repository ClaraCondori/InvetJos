@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>TODOS LOS PROVEEDORES</h1>
@stop

@section('content')
    <p>Lista de proveedores</p>
    <div class="card">
        <div class="card-body">
        @php
$heads = [
    'ID',
    'NOMBRE',
    'CORREO',
    'CONTACTO',
    ['label' => 'TELEFONO', 'width' => 20],
    ['label' => 'Actions', 'no-export' => true, 'width' => 20],
];

$btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
$btnDelete = '<button type="submit"class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>';

$config = [
    'language' => [
        'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    ],
];
@endphp

{{-- Pasar la configuración al componente --}}
<x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
    @foreach($provider as $providers)
        <tr>
            <td>{{ $providers->id }}</td>
            <td>{{ $providers->nombre }}</td>
            <td>{{ $providers->correo }}</td>
            <td>{{ $providers->contacto }}</td>
            <td>{{ $providers->telefono }}</td>
            <td>{!! $btnDetails !!}
                
                {!! $btnDelete !!}</td>
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
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop]