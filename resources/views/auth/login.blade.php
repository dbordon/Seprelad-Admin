@extends('layouts.guest')

@section('content')

   <div class="text-center mb-3">
        </div>
<div class="login-box">
    <div class="login-logo">
     <img src="{{ asset('adminlte/dist/img/logo_SEPRELAD.png') }}" alt="Logo UNP" style="max-height: 60px;">

    </div>
  <!-- Logo -->
     

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Iniciar sesión para comenzar</p>

            @if (session('status'))
                <div class="alert alert-success mb-3" role="alert">
                    {{ session('status') }}
                </div>
            @endif
  
            <!-- Formulario de inicio de sesión -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Recordarme</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </div>
                </div>
            </form>

            @if (Route::has('password.request'))
                <p class="mb-1">
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                </p>
            @endif

            <!-- @if (Route::has('register'))
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">Registrarse</a>
                </p>
            @endif -->
        </div>
    </div>
</div>
@endsection
