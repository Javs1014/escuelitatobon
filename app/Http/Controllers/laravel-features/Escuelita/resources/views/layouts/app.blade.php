<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Escuelita') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        {{-- Se aplica una clase personalizada 'navbar-custom' y se eliminan todos los estilos en línea --}}
        <nav class="navbar navbar-expand-md navbar-dark shadow-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Escuelita" style="height: 40px; margin-right: 10px;">
                    Escuelita
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    @auth
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('alumnos.index') }}">Alumnos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('profesores.index') }}">Profesores</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('materias.index') }}">Materias</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('grupos.index') }}">Grupos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('carreras.index') }}">Carreras</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('areas.index') }}">Áreas</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
                        @endif

                        @if(auth()->user()->role === 'profesor')
                            <li class="nav-item"><a class="nav-link" href="{{ route('grupos.index') }}">Mis Grupos</a></li>
                        @endif

                        @if(in_array(auth()->user()->role, ['alumno', 'profesor', 'admin']))
                            <li class="nav-item"><a class="nav-link" href="{{ route('historiales.index') }}">Historiales</a></li>
                        @endif

                    </ul>
                    @endauth
                    {{-- Menú de Usuario a la Derecha --}}
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Regístrate') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                                </a>

                                {{-- Menú desplegable mejorado --}}
                                <div class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item dropdown-item-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-fw me-2"></i> {{ __('Cerrar Sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>