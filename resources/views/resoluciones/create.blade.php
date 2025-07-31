@extends('layouts.app')

@section('title', 'Crear Resolución')


@section('content')
<div class="container">
    <h1 class="mb-3">Nueva Resolución</h1>

    <form action="{{ route('resoluciones.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

        <div class="form-group">
            <label>Tipo</label>
            <select name="id_tipo" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo }}">{{ $tipo->descrip_tipo }}</option>
                @endforeach
            </select>
        </div>

         <div class="form-group">
            <label>Sector</label>
            <select name="id_sector" class="form-control">
                <option value="">Seleccione...</option>
                @foreach ($sectores as $sector)
                    <option value="{{ $sector->id_sector }}">{{ $sector->descrip_sector }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>N° Resolución</label>
            <input type="text" name="nro_res" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Título</label>
            <textarea name="titulo_res" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Fecha de Resolución</label>
            <input type="date" name="fecha_res" class="form-control">
        </div>

       

        <div class="form-group">
            <label>Estado</label>
            <select name="estado_res" class="form-control">
                <option value="Vigente">Vigente</option>
                <option value="Derogado">Derogado</option>
                <option value="Abrogado">Abrogado</option>
            </select>
        </div>

        <div class="form-group">
            <label>Mostrar</label>
            <select name="mostrar_res" class="form-control">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="form-group">
            <label>Resolución Padre (opcional)</label>
            <select name="padre_id" class="form-control">
                <option value="">Sin padre</option>
                @foreach ($resolucionesPadre as $res)
                    <option value="{{ $res->id_res }}">{{ $res->nro_res }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="documento_res" class="form-label">Documento (PDF)</label>
            <input type="file" name="documento_res" class="form-control" accept="application/pdf" >
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
        <a href="{{ route('resoluciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
