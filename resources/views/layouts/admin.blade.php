<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --asoft-primary: #1e3a8a; /* Dark Blue */
            --asoft-accent: #f59e0b; /* Amber */
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--asoft-primary);
            color: #fff;
        }
        .sidebar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 6px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .navbar-top {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        [data-bs-theme="dark"] body {
            background-color: #121212;
            color: #e0e0e0;
        }
        [data-bs-theme="dark"] .navbar-top {
            background-color: #1e1e1e;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        [data-bs-theme="dark"] .card {
            background-color: #1e1e1e;
            border-color: #333;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3" style="width: 250px;">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="ASoftMedia Logo" height="65">
                <h5 class="text-white mt-3 fw-bold" style="letter-spacing: 1px;">ASOFTMEDIA</h5>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="active"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="fa-solid fa-graduation-cap me-2"></i> Cursos (LMS)</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="fa-solid fa-box-open me-2"></i> Produtos</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="fa-solid fa-users me-2"></i> Usuários</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="fa-solid fa-bullhorn me-2"></i> Leads / CRM</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="fa-solid fa-gear me-2"></i> Configurações</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-top px-4 py-3 d-flex justify-content-between">
                <div>
                    <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button"><i class="fa-solid fa-bars"></i></button>
                    <span class="fw-semibold ms-2">Painel Administrativo</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-3" id="theme-toggle"><i class="fa-solid fa-moon"></i></button>
                    <div class="dropdown d-inline">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.css"></script>
    <script>
        // Dark Mode Toggle Logic
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        
        // Load theme from localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-bs-theme', savedTheme);
        updateToggleIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateToggleIcon(newTheme);
        });

        function updateToggleIcon(theme) {
            if (theme === 'dark') {
                themeToggle.innerHTML = '<i class="fa-solid fa-sun"></i>';
            } else {
                themeToggle.innerHTML = '<i class="fa-solid fa-moon"></i>';
            }
        }
    </script>
</body>
</html>
