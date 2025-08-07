@extends('layouts.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Restablecer</b> Contraseña</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Ingresá tu nueva contraseña</p>

            <!-- Errores de validación -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Token de reset -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email', $request->email) }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>

                <!-- Nueva contraseña -->
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Nueva contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <!-- Confirmar contraseña -->
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Restablecer contraseña</button>
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
