@extends('layouts.app')

@section('title', 'Nueva Solicitud')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Nueva Solicitud</h1>

    @include('partials.errors')

    <form action="{{ route('solicitudes.store') }}" method="POST" enctype="multipart/form-data" class="card card-body">
        @csrf
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Puesto</label>
                <select name="id_puesto" class="form-control" required>
                    <option value="">-- Seleccione --</option>
                    @foreach($puestos as $p)
                        <option value="{{ $p->id }}" @selected(old('id_puesto')==$p->id)>{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control" value="{{ old('cedula') }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Celular</label>
                <input type="text" name="celular" class="form-control" value="{{ old('celular') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">CV (PDF)</label>
                <input type="file" name="cv_pdf" accept="application/pdf" class="form-control">
                <small class="text-muted">Máx. 10 MB</small>
            </div>

            <div class="col-12 form-check mt-3">
                <input class="form-check-input" type="checkbox" name="acepta_terminos" value="1" id="ter" required>
                <label class="form-check-label" for="ter">Acepto los términos y condiciones</label>
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-primary">Guardar</button>
                <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </form>
</div>
@endsection
