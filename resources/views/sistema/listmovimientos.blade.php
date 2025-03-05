@extends('adminlte::page')
@section('title', 'Movimientos')
@section('content_header')
    <h1>TODOS LOS MOVIMIENTOS</h1>
@stop

@section('content')
<p>Lista de Movimientos</p>
<div class="card">
    <div class="card-body">
        @php
        $heads = [
            'ID',
            'TIPO',
            'FECHA',
            'RESPONSABLE',
            'OBSERVACIÓN',
            ['label' => 'DETALLES', 'no-export' => true, 'width' => 20],
            ['label' => 'OPCIONES', 'no-export' => true, 'width' => 20],
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
                    <td>{{ $movimiento->responsable }}</td>
                    <td>{{ $movimiento->observacion }}</td>
                    <td>
                        <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Ver Detalles" data-toggle="modal" data-target="#detallesModal{{ $movimiento->id }}">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button>
                    </td>
                    <td>
                        <form style="display: inline" action="{{ route('movimiento.destroy', $movimiento) }}" method="POST" class="formEliminar">
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