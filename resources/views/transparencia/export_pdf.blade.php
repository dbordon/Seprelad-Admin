<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Documentos</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Listado de Documentos de Transparencia</h2>
    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Título</th>
                <th>Mes</th>
                <th>Año</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentos as $doc)
                <tr>
                    <td>{{ $doc->categoria->trans_cat_nombre ?? '-' }}</td>
                    <td>{{ $doc->titulo }}</td>
                    <td>{{ $doc->mes }}</td>
                    <td>{{ $doc->ano }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
