@extends('layouts.guest')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="register-box w-100" style="max-width: 450px;">

        <!-- Logo -->
        <div class="text-center mb-3">
            <img src="{{ asset('adminlte/dist/img/logo_SEPRELAD.png') }}" alt="Logo UNP" style="max-height: 80px;">
        </div>

        <!-- Card -->
        <div class="card shadow">
            <div class="card-body register-card-body">
                <p class="login-box-msg font-weight-bold text-center">Registro de nuevo usuario</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nombre completo" value="{{ old('name') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror

                    <!-- Email -->
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror

                    <!-- Confirm Password -->
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1 text-center">
                    <a href="{{ route('login') }}">Ya tengo una cuenta</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
