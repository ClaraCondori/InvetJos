@extends('adminlte::page')

@section('title', 'PRODUCTOS')

@section('content_header')
    <h1>ADMINISTRACION DE PRODUCTOS</h1>
@stop

@section('content')
    <p>Ingrese los datos del nuevo producto</p>
    <div class="card">
        <div class="card-body">
                <form action="{{ route('producto.store') }}" method="POST">
                @csrf
                <x-adminlte-select2 name="categoria_id" label="Categoría" igroup-size="lg" label-class="text-lightblue" data-placeholder="Seleccione una categoría">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-dolly text-lightblue"></i>
                        </div>
                    </x-slot>
                    <!-- Opción vacía para el placeholder -->
                    <option value="">Seleccione una categoría</option>
                    <!-- Iterar sobre las categorías -->
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre_cat }}
                        </option>
                    @endforeach
                </x-adminlte-select2>

                <!-- Campo para el nombre del producto -->
                <x-adminlte-input name="nombre" label="Producto" label-class="text-lightblue" value="{{ old('nombre') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-box text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <!-- Campo para la descripción del producto -->
                <x-adminlte-textarea name="descripcion" label="Descripcion" rows=5 label-class="text-lightblue" igroup-size="sm" placeholder="Inserte descripcion del producto...">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-lg fa-file-alt text-lightblue"></i>
                        </div>
                    </x-slot>
                    {{ old('descripcion') }}
                </x-adminlte-textarea>
                <!-- Campo para el precio de compra -->
                <x-adminlte-input name="precio_comp" label="Precio de compra" label-class="text-lightblue" value="{{ old('precio_comp') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-credit-card text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <!-- Campo para el precio de venta -->
                <x-adminlte-input name="precio_vent" label="Precio de venta" label-class="text-lightblue" value="{{ old('precio_vent') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-credit-card text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <!-- Campo para la cantidad -->
                <x-adminlte-input name="cantidad" label="Cantidad" type="number" igroup-size="sm" min=1 max=100 value="{{ old('cantidad') }}">
                    <x-slot name="appendSlot">
                        <div class="input-group-text">
                            <i class="fas fa-hashtag text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <!-- Botón de envío -->
                <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="primary" icon="fas fa-lg fa-save"/>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Agrega aquí hojas de estilo adicionales --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @if (session("message")) 
        <script>
            $(document).ready(function(){
                let mensaje = "{{ session('message') }}";
                Swal.fire({
                    title: "Datos guardados",
                    text: mensaje,
                    icon: "success",
                    draggable: true
                });
            });
        </script>
    @endif
@stop