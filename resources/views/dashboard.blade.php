@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Bienvenido, {{ Auth::user()->name }}
        </div>
        <div class="card-body">
            <p>Este es el panel de inicio de tu sistema de administración. Desde aquí puedes acceder a los módulos de Resoluciones y Transparencia.</p>

            <ul>
                <li>📄 <strong>Resoluciones:</strong> ver, crear, editar y exportar resoluciones.</li>
                <li>📁 <strong>Transparencia:</strong> gestionar documentos públicos y su categorización.</li>
            </ul>

            <p>Utiliza el menú lateral izquierdo para navegar por las secciones.</p>
        </div>
    </div>
</div>
@endsection
