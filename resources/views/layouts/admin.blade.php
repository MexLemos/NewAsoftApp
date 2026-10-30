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
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --asoft-primary: #1e3a8a;
            --asoft-accent: #f59e0b;
        }
        *, body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        body {
            background-color: #f0f2f5;
            font-size: 0.875rem;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--asoft-primary);
            color: #fff;
        }
        .sidebar a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            padding: 7px 14px;
            display: flex;
            align-items: center;
            border-radius: 6px;
            margin-bottom: 2px;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.01em;
            transition: all 0.2s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.12);
            color: #fff;
        }
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.18);
            font-weight: 600;
        }
        .sidebar .nav-item.border-top {
            margin-top: 10px !important;
            padding-top: 10px !important;
        }
        .w-20px {
            width: 22px;
            text-align: center;
            flex-shrink: 0;
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
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge me-2 w-20px"></i> Dashboard</a>
                </li>
                
                @hasanyrole('admin|tech|instrutor')
                <li class="nav-item">
                    <a href="{{ route('admin.cursos') }}" class="{{ request()->routeIs('admin.cursos') ? 'active' : '' }}"><i class="fa-solid fa-chalkboard-user me-2 w-20px"></i> Gerir Cursos</a>
                </li>
                @endhasanyrole
                
                @hasanyrole('admin|tech')
                <li class="nav-item">
                    <a href="{{ route('admin.produtos') }}" class="{{ request()->routeIs('admin.produtos') ? 'active' : '' }}"><i class="fa-solid fa-box-open me-2 w-20px"></i> Produtos</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.servicos') }}" class="{{ request()->routeIs('admin.servicos') ? 'active' : '' }}"><i class="fa-solid fa-network-wired me-2 w-20px"></i> Serviços</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.leads') }}" class="{{ request()->routeIs('admin.leads') ? 'active' : '' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fa-solid fa-bullhorn me-2 w-20px"></i> Leads / CRM</div>
                            @php $newLeadsCount = \App\Models\Lead::where('status', 'new')->count(); @endphp
                            @if($newLeadsCount > 0)
                                <span class="badge bg-danger rounded-pill">{{ $newLeadsCount }}</span>
                            @endif
                        </div>
                    </a>
                </li>
                @endhasanyrole

                @hasanyrole('admin|tech|formador|instrutor')
                <li class="nav-item border-top mt-3 pt-3 border-secondary border-opacity-25">
                    <a href="{{ route('admin.ponto') }}" class="{{ request()->routeIs('admin.ponto') ? 'active' : '' }}"><i class="fa-solid fa-clock me-2 w-20px"></i> Registo de Ponto</a>
                </li>
                @endhasanyrole

                @hasrole('admin')
                <li class="nav-item border-top mt-3 pt-3 border-secondary border-opacity-25">
                    <a href="{{ route('admin.cursos') }}" class="{{ request()->routeIs('admin.cursos') ? 'active' : '' }}"><i class="fa-solid fa-book-open me-2 w-20px"></i> Cursos</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.turmas') }}" class="{{ request()->routeIs('admin.turmas*') ? 'active' : '' }}"><i class="fa-solid fa-chalkboard-user me-2 w-20px"></i> Turmas</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.servicos') }}" class="{{ request()->routeIs('admin.servicos') ? 'active' : '' }}"><i class="fa-solid fa-briefcase me-2 w-20px"></i> Serviços</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.produtos') }}" class="{{ request()->routeIs('admin.produtos') ? 'active' : '' }}"><i class="fa-solid fa-box me-2 w-20px"></i> Loja</a>
                </li>

                <li class="nav-item border-top mt-3 pt-3 border-secondary border-opacity-25">
                    <a href="{{ route('admin.pagamentos') }}" class="{{ request()->routeIs('admin.pagamentos') ? 'active' : '' }}"><i class="fa-solid fa-money-bill-transfer me-2 w-20px"></i> Pagamentos</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.propinas') }}" class="{{ request()->routeIs('admin.propinas') ? 'active' : '' }}"><i class="fa-solid fa-file-invoice-dollar me-2 w-20px"></i> Propinas Mensais</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.funcionarios') }}" class="{{ request()->routeIs('admin.funcionarios') ? 'active' : '' }}"><i class="fa-solid fa-user-tie me-2 w-20px"></i> Funcionários</a>
                </li>
                <li class="nav-item border-top mt-3 pt-3 border-secondary border-opacity-25">
                    <a href="{{ route('admin.usuarios') }}" class="{{ request()->routeIs('admin.usuarios') ? 'active' : '' }}"><i class="fa-solid fa-users me-2 w-20px"></i> Clientes / Alunos</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.caixa') }}" class="{{ request()->routeIs('admin.caixa') ? 'active' : '' }}"><i class="fa-solid fa-cash-register me-2 w-20px"></i> Movimentos de Caixa</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.relatorios') }}" class="{{ request()->routeIs('admin.relatorios') ? 'active' : '' }}"><i class="fa-solid fa-chart-line me-2 w-20px"></i> Relatórios Financeiros</a>
                </li>

                <li class="nav-item border-top mt-3 pt-3 border-secondary border-opacity-25">
                    <a href="{{ route('admin.auditoria') }}" class="{{ request()->routeIs('admin.auditoria') ? 'active' : '' }}"><i class="fa-solid fa-shield-halved me-2 w-20px"></i> Logs de Auditoria</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.auditoria.seguranca') }}" class="{{ request()->routeIs('admin.auditoria.seguranca') ? 'active' : '' }}"><i class="fa-solid fa-triangle-exclamation me-2 w-20px"></i> Segurança</a>
                </li>

                <li class="nav-item border-top mt-3 pt-3 border-secondary border-opacity-25">
                    <a href="{{ route('admin.configuracoes') }}" class="{{ request()->routeIs('admin.configuracoes') ? 'active' : '' }}"><i class="fa-solid fa-gear me-2 w-20px"></i> Configurações</a>
                </li>
                @endhasrole
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-top px-4 py-3 d-flex justify-content-between">
                <div>
                    <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button"><i class="fa-solid fa-bars"></i></button>
                    <a href="{{ function_exists('subdomain_url') ? subdomain_url('', '/') : 'https://softmedia-ao.com' }}" class="btn btn-sm btn-outline-secondary me-2 ms-lg-2"><i class="fa-solid fa-arrow-left"></i> Voltar ao Site</a>
                    <span class="fw-semibold ms-2 d-none d-md-inline">Painel Administrativo</span>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Notifications Dropdown -->
                    @php
                        $unreadNotificationsCount = \App\Models\Lead::where('status', 'new')->count();
                        $latestNotifications = \App\Models\Lead::latest()->take(6)->get();
                    @endphp
                    <div class="dropdown d-inline me-3">
                        <button class="btn btn-sm btn-light position-relative rounded-pill px-3 py-1 border shadow-sm" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notificações">
                            <i class="fa-solid fa-bell text-secondary"></i>
                            @if($unreadNotificationsCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.65rem;">
                                    {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                                </span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-0 mt-2" style="width: 340px; max-width: 90vw;" aria-labelledby="notifDropdown">
                            <div class="p-3 bg-light border-bottom rounded-top-4 d-flex justify-content-between align-items-center">
                                <div class="fw-bold text-dark">
                                    <i class="fa-solid fa-bell me-1 text-primary"></i> Notificações
                                    @if($unreadNotificationsCount > 0)
                                        <span class="badge bg-danger rounded-pill ms-1" style="font-size: 0.7rem;">{{ $unreadNotificationsCount }} novas</span>
                                    @endif
                                </div>
                                @if($unreadNotificationsCount > 0)
                                <form action="{{ route('admin.leads.read_all') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-decoration-none text-muted small p-0" title="Marcar todas como lidas" style="font-size: 0.75rem;">
                                        Marcar lidas
                                    </button>
                                </form>
                                @endif
                            </div>
                            <div class="list-group list-group-flush" style="max-height: 320px; overflow-y: auto;">
                                @forelse($latestNotifications as $notif)
                                <div class="list-group-item p-3 {{ $notif->status === 'new' ? 'bg-primary bg-opacity-10' : '' }} d-flex justify-content-between align-items-start gap-2 border-bottom">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            @if(str_contains($notif->message, 'PEDIDO DE COMPRA'))
                                                <span class="badge bg-success rounded-pill" style="font-size: 0.65rem;">Pedido</span>
                                            @else
                                                <span class="badge bg-info rounded-pill" style="font-size: 0.65rem;">Contacto</span>
                                            @endif
                                            <span class="fw-bold small text-dark text-truncate d-inline-block" style="max-width: 160px;">{{ $notif->name }}</span>
                                        </div>
                                        <div class="text-muted small text-truncate" style="font-size: 0.75rem;">
                                            {{ Str::limit(strip_tags($notif->message), 45) }}
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">
                                            <i class="fa-regular fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        {{-- Botão Excluir Notificação --}}
                                        <form action="{{ route('admin.leads.destroy', $notif->id) }}" method="POST" onsubmit="return confirm('Excluir esta notificação?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" title="Excluir notificação">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted small">
                                    <i class="fa-regular fa-bell-slash fa-2x mb-2 d-block opacity-50"></i>
                                    Nenhuma notificação encontrada.
                                </div>
                                @endforelse
                            </div>
                            <div class="p-2 text-center bg-light border-top rounded-bottom-4">
                                <a href="{{ route('admin.leads') }}" class="small fw-bold text-decoration-none text-primary">
                                    Ver todas as notificações / leads <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-sm btn-outline-secondary me-3" id="theme-toggle"><i class="fa-solid fa-moon"></i></button>
                    <div class="dropdown d-inline">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
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

    <!-- Global Loading Overlay -->
    <div id="global-page-loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15,23,42,0.7); z-index: 10000; justify-content: center; align-items: center; flex-direction: column; color: #fff;">
        <div class="spinner-border text-primary" style="width: 3.5rem; height: 3.5rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="mt-4 fw-bold text-white">A processar...</h5>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

        // Global Form Submission Handler & Double-Click Prevention (Non-blocking with Safety Timeout)
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.dataset.submitting === 'true') {
                e.preventDefault();
                return false;
            }
            form.dataset.submitting = 'true';
            
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                // Store original button text to restore later
                submitBtn.dataset.originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> A guardar...';
                // Allow browser event loop to dispatch POST before disabling
                setTimeout(() => { if (submitBtn) submitBtn.disabled = true; }, 50);
            }
            
            const loader = document.getElementById('global-page-loader');
            if (loader) {
                loader.style.display = 'flex';
                // Safety timeout: never freeze the UI for more than 6 seconds
                setTimeout(() => {
                    loader.style.display = 'none';
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = submitBtn.dataset.originalText || 'Salvar';
                    }
                    form.dataset.submitting = 'false';
                }, 6000);
            }
        });

        // Hide loader on page show (handles browser back/forward cache)
        window.addEventListener('pageshow', function() {
            const loader = document.getElementById('global-page-loader');
            if (loader) {
                loader.style.display = 'none';
            }
            document.querySelectorAll('form').forEach(f => f.dataset.submitting = 'false');
            document.querySelectorAll('button[type="submit"]').forEach(b => b.disabled = false);
        });
    </script>
<script>
    // Autofocus first input in forms and modals
    function focusFirstInput(form) {
        const input = form.querySelector('input:not([type="hidden"]), textarea, select');
        if (input) input.focus();
    }
    // On page load (non‑modal forms)
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form').forEach(f => {
            if (!f.closest('.modal')) focusFirstInput(f);
        });
    });
    // When a Bootstrap modal is shown
    document.addEventListener('shown.bs.modal', e => {
        const modal = e.target;
        const form = modal.querySelector('form');
        if (form) focusFirstInput(form);
    });
</script>
</body>
</html>
