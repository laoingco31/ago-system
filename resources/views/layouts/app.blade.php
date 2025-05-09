<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('', '') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            transition: background 0.3s, color 0.3s;
        }
        [data-bs-theme="dark"] {
            background-color: #121212;
            color: #ffffff;
        }
        [data-bs-theme="dark"] .navbar {
            background-color: #1e1e1e;
        }
        [data-bs-theme="dark"] .table {
            color: #ffffff;
        }
        [data-bs-theme="dark"] .table-dark {
            background-color: #333;
        }
        [data-bs-theme="dark"] .form-control, 
        [data-bs-theme="dark"] .btn-outline-primary {
            background-color: #222;
            color: #fff;
            border-color: #555;
        }

        /* Styling for the logo */
        .navbar-brand img.logo {
            height: 50px; /* Set the height of the logo */
            width: auto;  /* Maintain aspect ratio */
            margin-right: 15px; /* Add some space between the logo and text */
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: bold;
            color: #000;
        }

    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <!-- Center the logo and text -->
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" class="logo"> <!-- Logo with styling -->
                    {{ config('', '') }} <!-- Company name or title -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    @auth
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="{{ url('/entries') }}" class="nav-link">Entries</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/entries/create') }}" class="nav-link">Create</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/users') }}" class="nav-link">Users</a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/proof-images') }}" class="nav-link">Proof</a>
                        </li>
                    </ul>
                    <form action="{{ url('/entries') }}" method="GET" class="d-flex w-50">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search entries..." aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    @endauth
                    <button id="darkModeToggle" class="btn btn-outline-secondary ms-3">
                        <i id="themeIcon" class="fas fa-moon"></i>
                    </button>
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const themeToggleBtn = document.getElementById("darkModeToggle");
            const themeIcon = document.getElementById("themeIcon");
            const htmlElement = document.documentElement;

            function setTheme(theme) {
                localStorage.setItem("theme", theme);
                htmlElement.setAttribute("data-bs-theme", theme);
                themeIcon.className = theme === "dark" ? "fas fa-sun" : "fas fa-moon";
            }

            const savedTheme = localStorage.getItem("theme") || "light";
            setTheme(savedTheme);

            themeToggleBtn.addEventListener("click", function () {
                const currentTheme = htmlElement.getAttribute("data-bs-theme");
                const newTheme = currentTheme === "light" ? "dark" : "light";
                setTheme(newTheme);
            });
        });
    </script>
</body>
</html>
