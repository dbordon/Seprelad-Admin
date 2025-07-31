@extends('layouts.app')

@section('title', 'Nuevo Documento de Transparencia')

@section('content')
<div class="container">
    <h1 class="mb-4">Nuevo Documento de Transparencia</h1>

    @include('partials.alerts')

    <form action="{{ route('transparencia.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="trans_cat_id" class="form-label">Categoría</label>
            <select name="trans_cat_id" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->trans_cat_id }}" {{ old('trans_cat_id') == $cat->trans_cat_id ? 'selected' : '' }}>
                        {{ $cat->trans_cat_descrip }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="mes">Mes</label>
            <select name="mes" class="form-control" required>
                <option value="">Seleccione un mes</option>
                @foreach ($meses as $mes)
                    <option value="{{ $mes }}" {{ old('mes') == $mes ? 'selected' : '' }}>{{ $mes }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="ano">Año</label>
            <select name="ano" class="form-control" required>
                <option value="">Seleccione un año</option>
                @foreach ($anios as $anio)
                    <option value="{{ $anio }}" {{ old('ano') == $anio ? 'selected' : '' }}>{{ $anio }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="archivo" class="form-label">Archivo (PDF)</label>
            <input type="file" name="archivo" class="form-control" accept="application/pdf" required>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar
        </button>
        <a href="{{ route('transparencia.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
