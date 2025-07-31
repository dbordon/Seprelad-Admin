
@extends('layouts.app', ['verEliminadosRoute' => route('resoluciones.eliminadas')])

@section('title', 'Listado de Resoluciones')



@section('content')

<a href="{{ route('resoluciones.eliminadas') }}" class="btn btn-warning mb-2">
    <i class="fas fa-trash-restore-alt"></i> Resoluciones eliminadas
</a>



<div class="container-fluid">
    <h1 class="mb-4">Listado de Resoluciones</h1>

    <!-- Botón para agregar -->
    <a href="{{ route('resoluciones.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nueva Resolución
    </a>

    <!-- Alertas -->
    @include('partials.alerts')

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>¡Revisa los siguientes errores!</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    <!-- Formulario de búsqueda y filtros -->
    <form method="GET" action="{{ route('resoluciones.index') }}" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por título o número..." value="{{ request('buscar') }}">
            </div>

            <div class="col-md-3">
                <select name="tipo" class="form-control">
                    <option value="">-- Tipo --</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id_tipo }}" {{ request('tipo') == $tipo->id_tipo ? 'selected' : '' }}>
                            {{ $tipo->descrip_tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select name="sector" class="form-control">
                    <option value="">-- Sector --</option>
                    @foreach ($sectores as $sector)
                        <option value="{{ $sector->id_sector }}" {{ request('sector') == $sector->id_sector ? 'selected' : '' }}>
                            {{ $sector->descrip_sector }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('resoluciones.index') }}" class="btn btn-secondary w-100">Limpiar</a>
            </div>
        </div>
    </form>

    <a href="{{ route('resoluciones.export.excel') }}" class="btn btn-success mb-2">
    📤 Exportar a Excel
    </a>

    <a href="{{ route('resoluciones.export.pdf') }}" class="btn btn-danger mb-2">
        <i class="fas fa-file-pdf"></i> Exportar PDF
    </a>
    <!-- Tabla de resultados -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>N°</th>
                <th>Título</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Documento</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($resoluciones as $res)
                <tr>
                    <td>{{ $res->nro_res }}</td>
                    <td>{{ $res->titulo_res }}</td>
                    <td>{{ $res->fecha_res }}</td>
                    <td>{{ $res->estado_res }}</td>
                    <td>
                        @if($res->documento_res)
                            <a href="{{ asset('seprelad/resoluciones/resoluciones/' . $res->documento_res) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary"
                            title="Ver PDF">
                                <i class="fas fa-file-pdf"></i> Ver
                            </a>
                        @else
                            <span class="text-muted">Sin documento</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('resoluciones.edit', $res->id_res) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('resoluciones.destroy', $res->id_res) }}" method="POST" style="display:inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta resolución?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No se encontraron resoluciones con los filtros aplicados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $resoluciones->links() }}
    </div>
</div>
@endsection