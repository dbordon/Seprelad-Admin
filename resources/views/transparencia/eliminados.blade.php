@extends('layouts.app', ['verEliminadosRoute' => null])

@section('title', 'Documentos Eliminados')

@section('content')
<div class="container">
    <h1 class="mb-4">Documentos de Transparencia Eliminados</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('transparencia.eliminados') }}" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por título, mes o año...">
        </div>
        <div class="col-md-4">
            <select name="categoria" class="form-control">
                <option value="">-- Todas las categorías --</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->trans_cat_id }}" {{ request('categoria') == $cat->trans_cat_id ? 'selected' : '' }}>
                        {{ $cat->trans_cat_descrip }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Filtrar</button>
            <a href="{{ route('transparencia.eliminados') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Limpiar</a>
        </div>
    </form>

    <!-- Tabla de eliminados -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="thead-dark">
                <tr>
                    <th>Categoría</th>
                    <th>Título</th>
                    <th>Año</th>
                    <th>Mes</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documentos as $doc)
                <tr>
                    <td>{{ $doc->categoria->trans_cat_descrip ?? '-' }}</td>
                    <td>{{ $doc->titulo }}</td>
                    <td>{{ $doc->ano }}</td>
                    <td>{{ $doc->mes }}</td>
                    <td>
                        @if ($doc->archivo)
                            <a href="{{ asset('seprelad/transparencia/transparencia/' . $doc->archivo) }}" target="_blank">
                                <i class="fas fa-file-pdf text-danger"></i> Ver PDF
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('transparencia.restore', $doc->trans_doc_id) }}" method="POST" onsubmit="return confirm('¿Restaurar este documento?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-undo"></i> Restaurar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">No hay documentos eliminados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-3">
        {{ $documentos->links() }}
    </div>
</div>
@endsection
