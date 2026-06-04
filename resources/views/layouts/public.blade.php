<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'ASoftMedia'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --asoft-primary: #1e3a8a; /* Corporate Blue */
            --asoft-secondary: #0f172a; /* Dark Navy */
            --asoft-accent: #f59e0b; /* Amber */
            --asoft-success: #22c55e; /* Green / WhatsApp */
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            transition: background-color 0.3s, color 0.3s;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }
        
        /* Navbar */
        .navbar-custom {
            background-color: var(--asoft-secondary);
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.85);
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active {
            color: var(--asoft-accent);
        }
        .navbar-brand {
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        /* Buttons */
        .btn-brand {
            background-color: var(--asoft-accent);
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 24px;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-brand:hover {
            background-color: #d97706;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Footer */
        .footer {
            background-color: var(--asoft-secondary);
            color: #cbd5e1;
            padding: 60px 0 20px;
        }
        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer a:hover {
            color: var(--asoft-accent);
        }

        /* Floating WhatsApp Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            color: #fff;
        }

        /* Dark Mode overrides */
        [data-bs-theme="dark"] body {
            background-color: #0f172a;
            color: #e2e8f0;
        }
        [data-bs-theme="dark"] .card {
            background-color: #1e293b;
            border-color: #334155;
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fa-solid fa-layer-group me-2" style="color: var(--asoft-accent);"></i> ASOFTMEDIA
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <i class="fa-solid fa-bars text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#servicos">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('cursos') ? 'active' : '' }}" href="{{ route('cursos') }}">Treinamento</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('produtos') ? 'active' : '' }}" href="{{ route('produtos') }}">Loja</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contactos">Contactos</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-white text-decoration-none me-3" id="theme-toggle">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-brand">Painel</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Entrar</a>
                        <a href="{{ route('register') }}" class="btn btn-brand">Registar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row gy-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-bold mb-4"><i class="fa-solid fa-layer-group me-2" style="color: var(--asoft-accent);"></i> ASOFTMEDIA</h5>
                    <p class="mb-4 text-sm">A ASoftMedia é uma empresa de tecnologia focada no desenvolvimento de soluções em software, treinamento e digitalização de negócios. Oferecemos serviços inovadores e personalizados.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="fs-4"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="fs-4"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="fs-4"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="#" class="fs-4"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-4">Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Sobre Nós</a></li>
                        <li class="mb-2"><a href="#">Nossos Cursos</a></li>
                        <li class="mb-2"><a href="#">Produtos de TI</a></li>
                        <li class="mb-2"><a href="#">Área de Downloads</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Serviços</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Desenvolvimento de Software</a></li>
                        <li class="mb-2"><a href="#">Consultoria em TI</a></li>
                        <li class="mb-2"><a href="#">Redes e Infraestrutura</a></li>
                        <li class="mb-2"><a href="#">Gestão Escolar</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Fale Connosco</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fa-solid fa-phone mt-1 me-3 text-white"></i>
                            <span>+244 975 824 787<br>+244 956 616 567</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fa-solid fa-envelope mt-1 me-3 text-white"></i>
                            <span>info@asoftmedia-ao.com</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fa-solid fa-location-dot mt-1 me-3 text-white"></i>
                            <span>Sapu 2, Casas Azuis, Rua da Uva<br>Luanda - Angola</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 mt-4 text-center d-flex flex-column flex-md-row justify-content-between align-items-center">
                <small>&copy; {{ date('Y') }} ASOFTMEDIA. Todos os direitos reservados.</small>
                <small class="mt-2 mt-md-0">Desenvolvido por ASOFTMEDIA</small>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/244975824787" class="whatsapp-float" target="_blank" title="Fale connosco no WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.css"></script>
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        
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
                themeToggle.innerHTML = '<i class="fa-solid fa-sun text-warning"></i>';
            } else {
                themeToggle.innerHTML = '<i class="fa-solid fa-moon"></i>';
            }
        }
    </script>
</body>
</html>
