@extends('adminlte::page')

@section('title', 'Movimientos')

@section('content_header')
    <h1>Administración de Movimientos</h1>
@stop

@section('content')
    <p>Ingrese información del movimiento</p>
    <div class="card">
        <div class="card-body">
        <form action="{{ route('movimiento.store') }}" method="POST">
            @csrf
            <!-- Tipo de Movimiento -->
            <x-adminlte-select name="tipo" label="Tipo de Movimiento" label-class="text-lightblue" igroup-size="lg">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-inbox text-lightblue"></i>
                    </div>
                </x-slot>
                    <x-adminlte-options :options="['entrada' => 'Entrada', 'salida' => 'Salida']" empty-option="Seleccione el tipo de movimiento"/>
            </x-adminlte-select>

            <!-- Proveedor (solo visible para entradas) -->
            <div id="provider-field" style="display: none;">
            <x-adminlte-select name="provider_id" label="Proveedor" label-class="text-lightblue" igroup-size="lg">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-truck text-lightblue"></i>
                    </div>
                </x-slot>
                    <x-adminlte-options :options="$providers->pluck('nombre', 'id')->toArray()" empty-option="Seleccione un proveedor"/>
            </x-adminlte-select>
            </div>

            <!-- Fecha del Movimiento -->
            <x-adminlte-input name="fecha" type="date" label="Fecha del Movimiento" label-class="text-lightblue" value="{{ old('fecha', now()->format('Y-m-d')) }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>

            <!-- Observación -->
            <x-adminlte-textarea name="observacion" label="Observación" rows=5 label-class="text-lightblue" igroup-size="sm" placeholder="Ingrese una observación...">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-lg fa-file-alt text-lightblue"></i>
                    </div>
                </x-slot>
                    {{ old('observacion') }}
            </x-adminlte-textarea>

            <!-- Detalles del Movimiento -->
            <div id="detalles">
                <h5>Detalles del Movimiento</h5>
                <div class="detalle">
                <!-- Producto -->
                <x-adminlte-select name="productos[0][producto_id]" label="Producto" label-class="text-lightblue" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-box text-lightblue"></i>
                        </div>
                    </x-slot>
                        <x-adminlte-options :options="$products->pluck('nombre', 'id')->toArray()" empty-option="Seleccione un producto"/>
                    </x-adminlte-select>

                <!-- Cantidad -->
                <x-adminlte-input name="productos[0][cantidad]" type="number" label="Cantidad" label-class="text-lightblue" placeholder="Ingrese la cantidad" min="1">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-hashtag text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <!-- Precio de Compra (solo visible para entradas) -->
                <div class="precio-comp-field" style="display: none;">
                    <x-adminlte-input name="productos[0][precio_comp]" type="number" label="Precio de Compra" label-class="text-lightblue" placeholder="Ingrese el precio de compra" step="0.01" min="0">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-dollar-sign text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                </div>
            </div>

            <!-- Botón para agregar más detalles -->
            <button type="button" id="agregar-detalle" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Agregar Producto
            </button>

            <!-- Botón de envío -->
            <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="primary" icon="fas fa-lg fa-save"/>
        </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Agrega aquí hojas de estilo adicionales --}}
@stop
@section('js')
<script>
    // Mostrar u ocultar el campo de proveedor y precio de compra según el tipo de movimiento
    document.querySelector('select[name="tipo"]').addEventListener('change', function() {
        const providerField = document.getElementById('provider-field');
        const precioCompFields = document.querySelectorAll('.precio-comp-field');
        if (this.value === 'entrada') {
            providerField.style.display = 'block';
            precioCompFields.forEach(field => field.style.display = 'block');
        } else {
            providerField.style.display = 'none';
            precioCompFields.forEach(field => field.style.display = 'none');
        }
    });

    // Lógica para agregar más detalles de productos
    let contador = 1;
    document.getElementById('agregar-detalle').addEventListener('click', function() {
        const detallesDiv = document.getElementById('detalles');
        const nuevoDetalle = `
            <div class="detalle">
                <!-- Producto -->
                <x-adminlte-select name="productos[${contador}][producto_id]" label="Producto" label-class="text-lightblue" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-box text-lightblue"></i>
                        </div>
                    </x-slot>
                    <x-adminlte-options :options="$products->pluck('nombre', 'id')->toArray()" empty-option="Seleccione un producto"/>
                </x-adminlte-select>

                <!-- Cantidad -->
                <x-adminlte-input name="productos[${contador}][cantidad]" type="number" label="Cantidad" label-class="text-lightblue" placeholder="Ingrese la cantidad" min="1">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-hashtag text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <!-- Precio de Compra (solo visible para entradas) -->
                <div class="precio-comp-field" style="display: none;">
                    <x-adminlte-input name="productos[${contador}][precio_comp]" type="number" label="Precio de Compra" label-class="text-lightblue" placeholder="Ingrese el precio de compra" step="0.01" min="0">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-dollar-sign text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>`;
        detallesDiv.insertAdjacentHTML('beforeend', nuevoDetalle);
        contador++;
    });

    // Mostrar mensaje de éxito
    @if (session("message")) 
        $(document).ready(function(){
            let mensaje = "{{ session('message') }}";
            Swal.fire({
                title: "Datos guardados",
                text: mensaje,
                icon: "success",
                draggable: true
            });
        });
    @endif
</script>
@stop