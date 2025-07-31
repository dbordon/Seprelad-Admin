@extends('layouts.app')

@section('title', 'Resoluciones Eliminadas')

@section('content')
<div class="container">
    <h1 class="mb-4">Resoluciones Eliminadas</h1>

    @include('partials.alerts')

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>N°</th>
                <th>Título</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Restaurar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resoluciones as $resolucion)
                <tr>
                    <td>{{ $resolucion->nro_res }}</td>
                    <td>{{ $resolucion->titulo_res }}</td>
                    <td>{{ $resolucion->fecha_res }}</td>
                    <td>{{ $resolucion->estado_res }}</td>
                    <td>
                        <form action="{{ route('resoluciones.restaurar', $resolucion->id_res) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm" onclick="return confirm('¿Restaurar esta resolución?')">
                                <i class="fas fa-undo"></i> Restaurar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $resoluciones->links() }}
    </div>

    <a href="{{ route('resoluciones.index') }}" class="btn btn-primary mt-3">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
</div>
@endsection
