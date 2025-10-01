@extends('layouts.app')

@section('title', 'Solicitudes')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Solicitudes</h1>

    <!-- <a href="{{ route('solicitudes.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nueva Solicitud
    </a> -->

    @include('partials.alerts')

    <form method="GET" action="{{ route('solicitudes.index') }}" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <select name="puesto" class="form-control">
                    <option value="">-- Filtrar por Puesto --</option>
                    @foreach($puestos as $p)
                        <option value="{{ $p->id }}" @if(request('puesto')==$p->id) selected @endif>
                            {{ $p->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary w-100">Limpiar</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Fecha</th>
            <th>Puesto</th>
            <th>Cédula</th>
            <th>Postulante</th>
            <th>Email</th>
            <th>Celular</th>
            <th>CV</th>
            <th>Código de Postulante</th>
            <th class="text-center">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($solicitudes as $s)
            <tr>
                <td>{{ $s->created_at ? $s->created_at->format('Y-m-d H:i') : '' }}</td>
                <td>{{ $s->puesto ? $s->puesto->nombre : '' }}</td>
                <td>{{ $s->cedula }}</td>
                <td>{{ $s->nombre }} {{ $s->apellido }}</td>
                <td>{{ $s->email }}</td>
                <td>{{ $s->celular }}</td>
                
                <td>
                    @if($s->pdf_path)
                        <a class="btn btn-sm btn-outline-dark"
                           href="{{ route('solicitudes.descargarCv', $s) }}">Descargar</a>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>

                <td>{{ $s->cod_postulante }}</td>

      
                <td class="text-center">
                    <!-- <a href="{{ route('solicitudes.show', $s) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i>
                    </a> -->
                    <a href="{{ route('solicitudes.edit', $s) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('solicitudes.destroy', $s) }}" method="POST" style="display:inline-block"
                          onsubmit="return confirm('¿Eliminar solicitud?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">Sin resultados</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $solicitudes->links() }}
    </div>
</div>
@endsection
