@extends('layouts.app') <!-- o tu layout principal -->

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Recuperar</b>Contraseña</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">¿Olvidaste tu contraseña? Ingresá tu correo para recibir el enlace</p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('email')
                    <div class="text-danger mb-2">{{ $message }}</div>
                @enderror
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Enviar enlace</button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">Volver al login</a>
            </p>
        </div>
    </div>
</div>
@endsection
