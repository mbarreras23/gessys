<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- App CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                @auth
                    <button class="toggle-btn" id="sidebarToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                @endauth
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-user-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('me') }}">
                                            <i class="fa-solid fa-user"></i> Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        @auth
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <!-- Logo de la empresa -->
                <div class="sidebar-header text-center mb-4">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="max-width: 50px; height: auto;">
                </div>
                <hr>
                <a href="{{ route('welcome') }}" class="{{ Request::is('/') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('projects.index') }}" class="{{ Request::is('projects*') ? 'active' : '' }}">
                    <i class="fa-solid fa-spinner"></i>
                    <span>Proyectos</span>
                </a>
                <a href="#"><i class="fa-solid fa-chart-line"></i> <span>Reportes</span></a>
                <a href="#"><i class="fa-solid fa-gear"></i> <span>Configuración</span></a>
            </div>
        @endauth

        <!-- Contenido principal -->
        <div class="main-content" id="mainContent">
            <div class="container mt-5 pt-4">
                @yield('content')
            </div>
        </div>

        @if (isset($show_footer))
            <footer class="bg-dark text-white text-center py-3 mt-4">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos
                    reservados.</p>
            </footer>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para colapsar el sidebar -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('collapsed');
        });
    </script>
</body>

</html>
