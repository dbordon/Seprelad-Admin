@extends('layouts.app')

@section('title', 'Editar Resolución')

@section('content')
<div class="container">
    <h1 class="mb-3">Editar Resolución</h1>

    @include('partials.alerts')

    <form action="{{ route('resoluciones.update', $resolucion->id_res) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Tipo</label>
            <select name="id_tipo" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo }}" {{ $tipo->id_tipo == $resolucion->id_tipo ? 'selected' : '' }}>
                        {{ $tipo->descrip_tipo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>N° Resolución</label>
            <input type="text" name="nro_res" class="form-control" value="{{ old('nro_res', $resolucion->nro_res) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Título</label>
            <textarea name="titulo_res" class="form-control" required>{{ old('titulo_res', $resolucion->titulo_res) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha_res" class="form-control" value="{{ old('fecha_res', $resolucion->fecha_res) }}">
        </div>

        <div class="form-group mb-3">
            <label>Sector</label>
            <select name="id_sector" class="form-control">
                <option value="">Seleccione...</option>
                @foreach ($sectores as $sector)
                    <option value="{{ $sector->id_sector }}" {{ $sector->id_sector == $resolucion->id_sector ? 'selected' : '' }}>
                        {{ $sector->descrip_sector }}
                    </option>
                @endforeach
            </select>
        </div>

          <div class="form-group">
            <label>Estado</label>
            <select name="estado_res" class="form-control">
                <option value="Vigente">Vigente</option>
                <option value="Derogado">Derogado</option>
                <option value="Abrogado">Abrogado</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Mostrar</label>
            <select name="mostrar_res" class="form-control">
                <option value="1" {{ $resolucion->mostrar_res == 1 ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ $resolucion->mostrar_res == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Resolución Padre (opcional)</label>
            <select name="padre_id" class="form-control">
                <option value="">Sin padre</option>
                @foreach ($padres as $padre)
                    <option value="{{ $padre->id_res }}" {{ $padre->id_res == $resolucion->padre_id ? 'selected' : '' }}>
                        {{ $padre->nro_res }}
                    </option>
                @endforeach
            </select>
        </div>

    <div class="mb-3">
        <label for="documento_res" class="form-label">Documento (PDF)</label>
        <input type="file" name="documento_res" class="form-control" accept="application/pdf" >
    </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Actualizar</button>
        <a href="{{ route('resoluciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
