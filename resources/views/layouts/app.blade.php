<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SEPRELAD</title>


    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Fuente opcional --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">

    {{-- Laravel Breeze (opcional, por si querés Alpine, etc.) --}}
    {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}
</head>
<body class="hold-transition sidebar-mini layout-fixed"> {{-- clase recomendada por AdminLTE para layout fluido --}}

    <div class="wrapper">

        {{-- Top Navbar --}}
        @include('layouts.navigation')

        {{-- Sidebar Lateral --}}
        @include('layouts.sidebar')

        {{-- Contenedor principal de contenido --}}
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid pt-4">
                    @isset($header)
                        <div class="mb-4">
                            <h1>{{ $header }}</h1>
                        </div>
                    @endisset

                    {{-- Aquí se inyectan las vistas --}}
                    @yield('content')
                </div>
            </div>
        </div>

        {{-- Footer opcional --}}
        {{-- <footer class="main-footer text-center">Sistema SEPRELAD - © {{ date('Y') }}</footer> --}}

    </div>

    @stack('scripts')

    {{-- Scripts de AdminLTE --}}
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

</body>
</html>
