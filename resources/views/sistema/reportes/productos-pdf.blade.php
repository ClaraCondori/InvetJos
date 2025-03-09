<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 150px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 16px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
        }
        .signature {
            margin-top: 50px;
            border-top: 1px solid black;
            width: 300px;
            text-align: center;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="header">
        <img src="{{ public_path('vendor/adminlte/dist/img/logo_redondo.png') }}" alt="Logo del negocio" class="logo">
        <div class="title">Reporte de Productos</div>
        <div class="subtitle">
            Generado el: {{ now()->format('d/m/Y') }}<br>
            Por: {{ Auth::user()->name }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Precio de Compra</th>
                <th>Precio de Venta</th>
                <th>Cantidad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->categoria->nombre_cat }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ number_format($producto->precio_comp, 2) }}</td>
                    <td>{{ number_format($producto->precio_vent, 2) }}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>{{ $producto->estado ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <div class="signature">
            Firma: ___________________________<br>
            <small>Autorizado por</small>
        </div>
    </div>
</body>
</html>