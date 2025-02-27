@extends('adminlte::page')
@section('title', 'Movimientos')
@section('content_header')
    <h1>Administración de Movimientos</h1>
@stop
@section('content')
    <p>Ingrese informacion del movimiento</p>
    <div class="card">
        <div class="card-body">
                <form action="{{ route('movimiento.store') }}" method="POST">
                @csrf
                <x-adminlte-select2 name="tipo" label="Tipo de Movimiento" label-class="text-lightblue" igroup-size="lg" data-placeholder="Seleccione una opcion...">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-inbox text-lightblue"></i>
                        </div>
                    </x-slot>
                    <option value="">Seleccione el tipo de movimiento</option>
                    <option>ENTRADA</option>
                    <option>SALIDA</option>
                </x-adminlte-select2>
                <x-adminlte-input name="fecha" type="date" label="Fecha" label-class="text-lightblue" value="{{ old('fecha', $modelo->fecha ?? '') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-select2 name="responsable" label="Responsable" igroup-size="lg" label-class="text-lightblue" data-placeholder="Seleccione su usuario">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-user text-lightblue"></i>
                        </div>
                    </x-slot>
                    <!-- Opción vacía para el placeholder -->
                    <option value="">Seleccione su usuario</option>
                    <!-- Iterar sobre las categorías -->
                    @foreach ($responsable as $responsables)
                        <option value="{{ $responsables->id }}" {{ old('responsables_id') == $responsables->id ? 'selected' : '' }}>
                            {{ $responsables->name}}
                        </option>
                    @endforeach
                </x-adminlte-select2>
                <!-- Campo para la descripción del producto -->
                <x-adminlte-textarea name="observacion" label="Observacion" rows=5 label-class="text-lightblue" igroup-size="sm" placeholder="observacion...">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-lg fa-file-alt text-lightblue"></i>
                        </div>
                    </x-slot>
                    {{ old('observacion') }}
                </x-adminlte-textarea>
                <!-- Sección para los detalles del movimiento -->
                <div id="detalles">
                    <h5>Detalles del Movimiento</h5>
                    <div class="detalle">
                    <x-adminlte-select2 name="producto" label="Producto" label-class="text-lightblue" igroup-size="lg" data-placeholder="Seleccione un producto...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-box text-lightblue"></i> <!-- Cambia el ícono a uno más apropiado -->
                                </div>
                            </x-slot>
                        <option value="">Seleccione un producto</option>
                        @foreach ($productos as $producto) <!-- Usa $productos en lugar de $producto -->
                        <option value="{{ $producto->id }}" {{ old('producto') == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre }}
                        </option>
                        @endforeach
                    </x-adminlte-select2>
                        <x-adminlte-input name="cantidad" type="number" label="Cantidad" label-class="text-lightblue" placeholder="Ingrese la cantidad">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-hashtag text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>

                        <x-adminlte-input name="precio_unitario" type="number" step="0.01" label="Precio Unitario" label-class="text-lightblue" placeholder="Ingrese el precio unitario">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-dollar-sign text-lightblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
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
        let contador = 1;
        document.getElementById('agregar-detalle').addEventListener('click', function() {
    const detallesDiv = document.getElementById('detalles');
    const nuevoDetalle = `
        <div class="detalle">
            <x-adminlte-select2 name="[${contador}][producto_id]" label="Producto" label-class="text-lightblue" igroup-size="lg" data-placeholder="Seleccione un producto...">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-box text-lightblue"></i>
                    </div>
                </x-slot>
                <option value="">Seleccione un producto</option>
                @foreach ($productos as $producto) <!-- Usa $productos en lugar de $producto -->
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </x-adminlte-select2>

            <x-adminlte-input name="[${contador}][cantidad]" type="number" label="Cantidad" label-class="text-lightblue" placeholder="Ingrese la cantidad">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-hashtag text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input name="[${contador}][precio_unitario]" type="number" step="0.01" label="Precio Unitario" label-class="text-lightblue" placeholder="Ingrese el precio unitario">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fas fa-dollar-sign text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
        </div>`;
    detallesDiv.insertAdjacentHTML('beforeend', nuevoDetalle);
    contador++;
});
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