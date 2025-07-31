@extends('layouts.app')

@section('title', 'Documentos de Transparencia')

@section('content')

<div class="container-fluid">
    <h1 class="mb-4">Documentos de Transparencia</h1>

    <a href="{{ route('transparencia.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nuevo Documento
    </a>

    @include('partials.alerts')
    <a href="{{ route('transparencia.exportar.excel') }}" class="btn btn-success mb-3">
        <i class="fas fa-file-excel"></i> Exportar a Excel
    </a>
  
    <a href="{{ route('transparencia.export.pdf') }}" class="btn btn-danger mb-3">
        <i class="fas fa-file-pdf"></i> Exportar PDF
    </a>


    <form method="GET" action="{{ route('transparencia.index') }}" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por título, mes o año" value="{{ request('buscar') }}">
        </div>
        <div class="col-md-4">
            <select name="categoria" class="form-control">
                <option value="">-- Categoría --</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->trans_cat_id }}" {{ request('categoria') == $cat->trans_cat_id ? 'selected' : '' }}>
                        {{ $cat->trans_cat_descrip }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('transparencia.index') }}" class="btn btn-secondary w-100">Limpiar</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Documento</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentos as $doc)
                <tr>
                    <td>{{ $doc->titulo }}</td>
                    <td>{{ $doc->categoria->trans_cat_descrip ?? 'Sin categoría' }}</td>
                    <td>{{ $doc->mes }}</td>
                    <td>{{ $doc->ano }}</td>
                    <td>
                        @if ($doc->archivo)
                            <a href="{{ asset('transparencia/transparencia/' . $doc->archivo) }}" target="_blank">
                                <i class="fas fa-file-pdf"></i> Ver PDF
                            </a>
                        @else
                            <span class="text-muted">Sin archivo</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('transparencia.edit', $doc->trans_doc_id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('transparencia.destroy', $doc->trans_doc_id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este documento?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $documentos->links() }}
    </div>
</div>
@endsection
