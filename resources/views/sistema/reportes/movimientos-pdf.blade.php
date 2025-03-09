<!DOCTYPE html>
<html>
<head>
    <title>Informe de Movimientos</title>
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
    <!-- Encabezado con logo y título -->
    <div class="header">
        <!-- Logo del negocio -->
        <img src="{{ public_path('vendor/adminlte/dist/img/logo_redondo.png') }}" alt="Logo del negocio" class="logo">
        <div class="title">Informe de Movimientos</div>
        <div class="subtitle">
            Generado el: {{ now()->format('d/m/Y') }}<br>
            Por: {{ Auth::user()->name }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Responsable</th>
                <th>Cantidad Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $movimiento)
                    <tr>
                        <td>{{ $movimiento->id }}</td>
                        <td>{{ $movimiento->tipo }}</td>
                        <td>{{ $movimiento->fecha }}</td>
                        <td>{{ $movimiento->responsable }}</td>
                        <td>{{ $movimiento->detalles_sum_cantidad }}</td>
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