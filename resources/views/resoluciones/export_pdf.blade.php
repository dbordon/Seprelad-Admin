<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Resoluciones</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #eaeaea; }
        .header { text-align: center; }
        .logo { width: 200px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo_SEPRELAD.png') }}" class="logo" alt="Logo SEPRELAD">
        <h3>Secretaría de Prevención de Lavado de Dinero o Bienes</h3>
        <h4>Listado de Resoluciones</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Título</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resoluciones as $res)
                <tr>
                    <td>{{ $res->nro_res }}</td>
                    <td>{{ $res->titulo_res }}</td>
                    <td>{{ $res->fecha_res }}</td>
                    <td>{{ $res->estado_res }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
