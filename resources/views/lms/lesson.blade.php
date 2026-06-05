<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizador de Aulas - ASoftMedia</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #f8fafc; overflow: hidden; }
        .navbar-custom { background-color: #1e293b; border-bottom: 1px solid #334155; }
        .sidebar-modules { background-color: #1e293b; height: calc(100vh - 60px); overflow-y: auto; border-left: 1px solid #334155; }
        .video-container { height: calc(100vh - 60px); display: flex; flex-direction: column; overflow-y: auto; }
        .iframe-wrapper { position: relative; width: 100%; padding-bottom: 56.25%; background: #000; }
        .iframe-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
        
        .lesson-link { color: #cbd5e1; text-decoration: none; padding: 12px 20px; display: block; border-bottom: 1px solid #334155; transition: background 0.2s; }
        .lesson-link:hover { background-color: rgba(255,255,255,0.05); color: #fff; }
        .lesson-link.active { background-color: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b; color: #fff; }
        
        /* Custom scrollbar for dark mode */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-custom py-2 px-3" style="height: 60px;">
        <a href="{{ route('lms.dashboard') }}" class="btn btn-outline-light btn-sm me-3"><i class="fa-solid fa-arrow-left"></i> Painel</a>
        <h5 class="mb-0 fw-bold me-auto text-truncate" style="max-width: 50%;">Front-End com ReactJS</h5>
        <div class="d-flex align-items-center">
            <span class="badge bg-success rounded-pill px-3 py-2 me-3"><i class="fa-solid fa-trophy text-warning me-1"></i> Progresso: 45%</span>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle btn-sm rounded-circle" type="button" data-bs-toggle="dropdown" style="width: 35px; height: 35px;">
                    <i class="fa-solid fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                    <li><a class="dropdown-item" href="{{ route('lms.dashboard') }}">Meu Painel</a></li>
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

    <div class="d-flex w-100">
        <!-- Main Video Area -->
        <div class="video-container flex-grow-1">
            <div class="iframe-wrapper">
                <!-- YouTube iframe embedding -->
                <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY?rel=0&modestbranding=1&autohide=1&showinfo=0&controls=1" allowfullscreen></iframe>
            </div>
            
            <div class="p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fw-bold">1. Introdução ao React (Hooks)</h2>
                    <button class="btn btn-success fw-bold px-4 rounded-pill"><i class="fa-solid fa-check me-2"></i> Concluir Aula</button>
                </div>
                
                <ul class="nav nav-tabs border-secondary mb-4" id="lessonTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active bg-transparent text-white border-0 border-bottom border-warning border-3" data-bs-toggle="tab" data-bs-target="#overview" type="button">Visão Geral</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-transparent text-secondary border-0" data-bs-toggle="tab" data-bs-target="#resources" type="button">Recursos</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="lessonTabsContent">
                    <div class="tab-pane fade show active text-secondary" id="overview">
                        <p>Nesta aula abordaremos os conceitos essenciais dos React Hooks (useState, useEffect), permitindo criar componentes funcionais mais limpos e reativos. Acompanhe a documentação anexada na aba Recursos.</p>
                        <p>Instrutor: <strong>João Silva</strong></p>
                    </div>
                    <div class="tab-pane fade" id="resources">
                        <a href="#" class="btn btn-outline-light mb-2"><i class="fa-solid fa-file-pdf text-danger me-2"></i> Slides da Aula.pdf</a><br>
                        <a href="#" class="btn btn-outline-light"><i class="fa-solid fa-file-code text-info me-2"></i> Codigo-Fonte.zip</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Modules list -->
        <div class="sidebar-modules d-none d-lg-block" style="width: 350px; flex-shrink: 0;">
            <div class="p-3 border-bottom border-secondary bg-dark text-white fw-bold">
                Conteúdo do Curso
            </div>
            
            <!-- Module 1 -->
            <div class="bg-dark bg-opacity-50 p-3 border-bottom border-secondary text-white fw-semibold d-flex justify-content-between align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#mod1">
                Módulo 1: Fundamentos
                <i class="fa-solid fa-chevron-down small"></i>
            </div>
            <div class="collapse show" id="mod1">
                <a href="#" class="lesson-link active d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa-solid fa-circle-play me-2 text-warning"></i> 1. Introdução ao React
                    </div>
                    <small class="text-muted">12:45</small>
                </a>
                <a href="#" class="lesson-link d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa-regular fa-circle-play me-2 text-secondary"></i> 2. Componentes e Props
                    </div>
                    <small class="text-muted">18:20</small>
                </a>
                <a href="#" class="lesson-link d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa-regular fa-circle-play me-2 text-secondary"></i> 3. Estado e Ciclo de Vida
                    </div>
                    <small class="text-muted">22:10</small>
                </a>
            </div>

            <!-- Module 2 -->
            <div class="bg-dark bg-opacity-50 p-3 border-bottom border-secondary text-white fw-semibold d-flex justify-content-between align-items-center mt-1" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#mod2">
                Módulo 2: Hooks Avançados
                <i class="fa-solid fa-chevron-down small"></i>
            </div>
            <div class="collapse" id="mod2">
                <a href="#" class="lesson-link d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa-solid fa-lock me-2 text-secondary"></i> 1. useContext
                    </div>
                    <small class="text-muted">15:00</small>
                </a>
                <a href="#" class="lesson-link d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa-solid fa-lock me-2 text-secondary"></i> 2. Custom Hooks
                    </div>
                    <small class="text-muted">20:45</small>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
