<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel de Controlo LMS') - ASoftMedia</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --asoft-primary: #020617;
            --asoft-secondary: #0f172a;
            --asoft-accent: #f59e0b;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }
        .sidebar {
            background-color: var(--asoft-primary);
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            z-index: 1000;
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .nav-link i {
            width: 25px;
            text-align: center;
        }
        .navbar-top {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3" id="sidebar">
        <div class="text-center mb-4 mt-2">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" alt="ASoftMedia Logo" height="50">
                <h5 class="text-white mt-3 fw-bold mb-0">ASOFTMEDIA</h5>
                <small class="text-white-50">Área do Aluno</small>
            </a>
        </div>
        
        <hr class="border-secondary opacity-25">

        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('lms.dashboard') }}" class="nav-link {{ request()->routeIs('lms.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-graduation-cap"></i> Meus Cursos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lms.certificados') }}" class="nav-link {{ request()->routeIs('lms.certificados') ? 'active' : '' }}">
                    <i class="fa-solid fa-certificate"></i> Certificados
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lms.historico') }}" class="nav-link {{ request()->routeIs('lms.historico') ? 'active' : '' }}">
                    <i class="fa-solid fa-bag-shopping"></i> Histórico de Compras
                </a>
            </li>
            
            <li class="nav-item mt-4">
                <h6 class="text-uppercase text-muted fw-bold px-3 small">Conta</h6>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fa-solid fa-user"></i> Meu Perfil
                </a>
            </li>
            
            @hasanyrole('admin|tech')
            <li class="nav-item mt-4">
                <h6 class="text-uppercase text-warning fw-bold px-3 small">Administração</h6>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-warning">
                    <i class="fa-solid fa-gauge"></i> Painel de Administração
                </a>
            </li>
            @endhasanyrole

            <li class="nav-item mt-4 pt-3 border-top border-secondary border-opacity-25">
                <a href="{{ function_exists('subdomain_url') ? subdomain_url('', '/') : route('home') }}" class="nav-link text-white-50">
                    <i class="fa-solid fa-arrow-left"></i> Voltar ao Site
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand-lg navbar-top px-4 py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-lg-none me-3 shadow-sm border" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="fw-bold mb-0 text-dark">@yield('title', 'LMS')</h5>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <a href="{{ function_exists('subdomain_url') ? subdomain_url('', '/') : route('home') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-none d-md-inline-flex align-items-center">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao Site
                </a>

                <a href="{{ function_exists('subdomain_url') ? subdomain_url('loja', '/carrinho') : route('carrinho.index') }}" class="btn btn-light position-relative rounded-circle p-2 shadow-sm border" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-cart-shopping text-dark"></i>
                    @if(count(session('cart', [])) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ count(session('cart', [])) }}
                        </span>
                    @endif
                </a>
                
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill dropdown-toggle fw-bold shadow-sm border" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-circle-user me-1 text-primary"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-circle me-2 text-muted"></i> O Meu Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold"><i class="fa-solid fa-right-from-bracket me-2"></i>Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>
