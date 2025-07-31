<!-- Sidebar AdminLTE -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo personalizado -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('adminlte/dist/img/logo_SEPRELAD.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light" style="visibility: hidden;">SEPRELAD</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Usuario autenticado -->
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/dist/img/user.png') }}" class="img-circle elevation-2" alt="Usuario">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        @endauth

        <!-- Menú de navegación -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Inicio -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>

                <!-- Resoluciones -->
                <li class="nav-item">
                    <a href="{{ route('resoluciones.index') }}" class="nav-link {{ request()->is('resoluciones*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Resoluciones</p>
                    </a>
                </li>

                <!-- Transparencia -->
                <li class="nav-item">
                    <a href="{{ route('transparencia.index') }}" class="nav-link {{ request()->is('transparencia*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>Transparencia</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
