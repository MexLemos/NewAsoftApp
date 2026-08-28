<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'ASoftMedia'))</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

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
            z-index: 1050;
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
        [data-bs-theme="dark"] body, 
        [data-bs-theme="dark"] .bg-white, 
        [data-bs-theme="dark"] .bg-light,
        [data-bs-theme="dark"] [style*="background-color: #f8fafc"] {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .card[style*="background-color: #f8fafc"] {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] h1, [data-bs-theme="dark"] h2, [data-bs-theme="dark"] h3, 
        [data-bs-theme="dark"] h4, [data-bs-theme="dark"] h5, [data-bs-theme="dark"] h6,
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] [style*="color: #0f172a"],
        [data-bs-theme="dark"] [style*="color: var(--asoft-secondary)"] {
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        /* Scroll Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .animate-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="ASoftMedia Logo" height="55">
                <span style="font-weight: 800; letter-spacing: 1px;">ASOFTMEDIA</span>
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
                    <a href="{{ route('carrinho.index') }}" class="btn btn-link text-white text-decoration-none me-4 position-relative">
                        <i class="fa-solid fa-cart-shopping fs-5"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-brand ms-lg-3">Painel</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Entrar</a>
                        <a href="{{ route('register') }}" class="btn btn-brand">Registar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages (Toast/Alert) -->
    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 1060; margin-top: 60px;">
            <div id="successToast" class="toast align-items-center text-bg-success border-0 show shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-bold">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(() => {
                    let toastEl = document.getElementById('successToast');
                    if(toastEl) {
                        toastEl.classList.remove('show');
                        setTimeout(() => toastEl.remove(), 300);
                    }
                }, 4000);
            });
        </script>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row gy-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4 d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="ASoftMedia Logo" height="55">
                        <span class="text-white fw-bold fs-4" style="letter-spacing: 1px;">ASOFTMEDIA</span>
                    </div>
                    <p class="mb-4 text-sm">A ASoftMedia é uma empresa de tecnologia focada no desenvolvimento de soluções em software, treinamento e digitalização de negócios. Oferecemos serviços inovadores e personalizados.</p>
                    <div class="d-flex gap-3">
                        <a href="https://www.facebook.com/asoftmedia" class="fs-4" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/asoftmedia" class="fs-4" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/asoftmedia" class="fs-4" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://www.youtube.com/@Asoftmedia-ao" class="fs-4" target="_blank"><i class="fa-brands fa-youtube"></i></a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

        // Scroll Animations Observer
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        // Stop observing once animated so it doesn't replay continuously
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-on-scroll').forEach((el) => {
                observer.observe(el);
            });
        });
    </script>
    
    <!-- Global Loading Overlay -->
    <div id="global-page-loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.85); z-index: 10000; justify-content: center; align-items: center; flex-direction: column;">
        <div class="spinner-border" style="width: 3.5rem; height: 3.5rem; color: var(--asoft-primary);" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="mt-4 fw-bold" style="color: var(--asoft-primary);">Processando...</h5>
    </div>
    
    <script>
        // Intercept form submissions and link clicks to show loader
        document.addEventListener('submit', function () {
            document.getElementById('global-page-loader').style.display = 'flex';
        });

        document.addEventListener('click', function(e) {
            let target = e.target.closest('a');
            if(target && target.href) {
                // Ignore JS, empty links, or target="_blank"
                if(target.getAttribute('href').startsWith('javascript:') || target.getAttribute('href') === '#') return;
                if(target.getAttribute('target') === '_blank') return;
                if(target.getAttribute('data-bs-toggle') !== null) return;
                if(target.hasAttribute('download')) return;

                // Ignore if it's the exact same page (only the hash # is changing)
                if (target.hostname === window.location.hostname && 
                    target.pathname === window.location.pathname && 
                    target.search === window.location.search) {
                    return;
                }

                document.getElementById('global-page-loader').style.display = 'flex';
            }
        });
        
        // Hide loader on page load (handles back/forward cache)
        window.addEventListener('pageshow', function() {
            document.getElementById('global-page-loader').style.display = 'none';
        });
    </script>
</body>
</html>
