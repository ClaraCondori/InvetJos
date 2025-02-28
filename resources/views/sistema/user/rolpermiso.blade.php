@extends('adminlte::page')

@section('title', 'Roles y permisos')

@section('content_header')
    <h1>ROLES Y PERMISOS</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <p>{{$role->name}}</p>
        </div>
        <div class="card-body">
            <h5>Lista de permisos</h5>
            {!! Form::model($role, ['route' => ['roles.update', $role], 'method' => 'put']) !!}
    @foreach ($permisos as $permiso)
        <div>
            <label>
                {!! Form::checkbox('permisos[]', $permiso->id, $role->hasPermissionTo($permiso->id), ['class' => 'mr-1']) !!} 
                {{ $permiso->name }}
            </label>
        </div>
    @endforeach
    {!! Form::submit('Asignar permisos', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop