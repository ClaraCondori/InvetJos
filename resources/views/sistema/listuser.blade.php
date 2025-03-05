@extends('adminlte::page')

@section('title', 'USUARIOS')

@section('content_header')
    <h1>TODOS LOS USUARIOS</h1>
@stop

@section('content')
    <p>Lista de usuarios del sistema</p>
    <div class="card">
        <div class="card-body">
            @php
                $heads = [
                    'ID',
                    'NOMBRE',
                    'CORREO',
                    'TELEFONO',
                    ['label' => 'ESTADO', 'width' => 20],
                    ['label' => 'Actions', 'no-export' => true, 'width' => 20],
                ];

                $config = [
                    'language' => [
                        'url' => 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    ]
                ];
            @endphp

            {{-- Pasar la configuración al componente --}}
            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->telefono }}</td>
                        <td>{{ $user->estado }}</td>
                        <td>
                            <a href="{{ route('user.edit', $user) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form style="display: inline" action="{{ route('user.destroy', $user) }}" method="POST" class="formEliminar">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
        <div class="card-footer">
            <a href="{{ route('sistema.inactivouser') }}" class="btn btn-info float-right text-white mx-1 shadow">
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