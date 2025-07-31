<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Sección izquierda del navbar -->
    <ul class="navbar-nav">
        <!-- Botón para contraer el sidebar -->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

        <!-- Enlaces de navegación -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('resoluciones.index') }}" class="nav-link">Resoluciones</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('transparencia.index') }}" class="nav-link">Transparencia</a>
        </li>
    </ul>

    <!-- Sección derecha del navbar -->
    <ul class="navbar-nav ml-auto">
        @auth
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                    </form>
                </div>
            </li>
        @endauth

        @guest
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">Ingresar</a>
            </li>
        @endguest
    </ul>
</nav>
