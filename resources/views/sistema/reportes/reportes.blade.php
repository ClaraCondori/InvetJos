<!DOCTYPE html>
<html>
<head>
<title>Reporte de {{ ucfirst($table) }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2c3e50; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; color: #333; font-weight: bold; }
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #777; }
        .logo { max-width: 150px; height: auto; } /* Ajusta el tamaño del logo */
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('vendor/adminlte/dist/img/logo_redondo.png') }}" alt="Logo de la empresa" class="logo">
        <h1>Reporte de {{ ucfirst($table) }}</h1>
    </div>

    <div class="details">
        <h2>Información del Reporte</h2>
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Generado por:</strong> _________________________</p>
        <p><strong>Intervalo de tiempo:</strong> {{ $startDate }} a {{ $endDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                @if($table == 'users')
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                @elseif($table == 'providers')
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Contacto</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                @elseif($table == 'productos')
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Nombre</th>
                    <th>Descrpcion</th>
                    <th>Precio de Venta</th>
                    <th>Precio de Compra</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    @if($table == 'users')
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telefono }}</td>
                        <td>{{ $item->estado }}</td>
                    @elseif($table == 'providers')
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->correo }}</td>
                        <td>{{ $item->contacto }}</td>
                        <td>{{ $item->telefono }}</td>
                        <td>{{ $item->estado }}</td>
                    @elseif($table == 'productos')
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->categoria_id }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->precio_vent }}</td>
                        <td>{{ $item->precio_comp }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ $item->estado }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>_________________________</p>
        <p><strong>Firma</strong></p>
    </div>

    <div class="footer">
        <p>Este es un reporte generado automáticamente por el sistema.</p>
        <p>&copy; {{ date('Y') }} Nombre de la Empresa. Todos los derechos reservados.</p>
    </div>
    <a href="{{ route('reporte.download', request()->all()) }}" class="btn btn-success">Descargar PDF</a>
</body>
</html>