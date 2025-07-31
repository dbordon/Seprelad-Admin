@extends('layouts.app')

@section('title', 'Nuevo Documento de Transparencia')

@section('content')
<div class="container">
    <h1 class="mb-4">Nuevo Documento de Transparencia</h1>

    @include('partials.alerts')

   <form action="{{ route('transparencia.update', $documento->trans_doc_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Categoría</label>
        <select name="trans_cat_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->trans_cat_id }}" {{ $documento->trans_cat_id == $cat->trans_cat_id ? 'selected' : '' }}>
                    {{ $cat->trans_cat_descrip }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Título</label>
        <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $documento->titulo) }}" required>
    </div>

    <div class="form-group">
        <label>Mes</label>
        <select name="mes" class="form-control">
            @foreach(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $m)
                <option value="{{ $m }}" {{ $m == $documento->mes ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Año</label>
        <select name="ano" class="form-control">
            @for ($y = 2015; $y <= now()->year; $y++)
                <option value="{{ $y }}" {{ $documento->ano == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </div>

    <div class="form-group">
        <label>Documento PDF (opcional)</label>
        <input type="file" name="archivo" class="form-control" accept="application/pdf">
        @if($documento->archivo)
            <p class="mt-2">Actual: <a href="{{ asset('seprelad/transparencia/transparencia/'.$documento->archivo) }}" target="_blank">Ver archivo</a></p>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>

</div>
@endsection
