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
        <h5 class="mb-0 fw-bold me-auto text-truncate" style="max-width: 50%;">{{ $course->title }}</h5>
        <div class="d-flex align-items-center">
            <span class="badge bg-success rounded-pill px-3 py-2 me-3"><i class="fa-solid fa-trophy text-warning me-1"></i> Progresso: {{ $enrollment->progress_percent ?? 0 }}%</span>
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

    <!-- Flash Messages (Toast/Alert) -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 position-absolute w-100 rounded-0" style="z-index: 1050;" role="alert">
            <div class="text-center fw-bold"><i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}</div>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex w-100">
        <!-- Main Video Area -->
        <div class="video-container flex-grow-1">
            @if($lesson->video_url)
                <div class="iframe-wrapper">
                    <!-- YouTube iframe embedding -->
                    <iframe src="{{ $lesson->video_url }}" allowfullscreen></iframe>
                </div>
            @else
                <div class="bg-dark d-flex align-items-center justify-content-center border-bottom border-secondary" style="height: 400px; max-height: 56.25%;">
                    <div class="text-center text-muted">
                        <i class="fa-solid fa-video-slash fs-1 mb-3"></i>
                        <h5>Nenhum vídeo disponível para esta aula.</h5>
                    </div>
                </div>
            @endif
            
            <div class="p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fw-bold">{{ $lesson->title }}</h2>
                    @if(in_array($lesson->id, $completedLessons))
                        <button class="btn btn-success fw-bold px-4 rounded-pill disabled"><i class="fa-solid fa-check-double me-2"></i> Aula Concluída</button>
                    @else
                        <form action="{{ route('lms.lesson.complete', ['course' => $course->id, 'lesson' => $lesson->id]) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-success fw-bold px-4 rounded-pill"><i class="fa-solid fa-check me-2"></i> Concluir Aula</button>
                        </form>
                    @endif
                </div>
                
                <ul class="nav nav-tabs border-secondary mb-4" id="lessonTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active bg-transparent text-white border-0 border-bottom border-warning border-3" data-bs-toggle="tab" data-bs-target="#overview" type="button">Visão Geral</button>
                    </li>
                    @if($lesson->attachment_url)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-transparent text-secondary border-0" data-bs-toggle="tab" data-bs-target="#resources" type="button">Recursos</button>
                    </li>
                    @endif
                </ul>
                
                <div class="tab-content" id="lessonTabsContent">
                    <div class="tab-pane fade show active text-secondary" id="overview">
                        <div class="text-light" style="white-space: pre-line;">
                            {{ $lesson->description ?? 'Nenhuma descrição fornecida para esta aula.' }}
                        </div>
                    </div>
                    @if($lesson->attachment_url)
                    <div class="tab-pane fade" id="resources">
                        <a href="{{ $lesson->attachment_url }}" class="btn btn-outline-light mb-2" target="_blank"><i class="fa-solid fa-download text-info me-2"></i> Baixar Anexo</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar / Modules list -->
        <div class="sidebar-modules d-none d-lg-block" style="width: 350px; flex-shrink: 0;">
            <div class="p-3 border-bottom border-secondary bg-dark text-white fw-bold">
                Conteúdo do Curso
            </div>
            
            @forelse($course->modules as $mod)
            <!-- Module -->
            <div class="bg-dark bg-opacity-50 p-3 border-bottom border-secondary text-white fw-semibold d-flex justify-content-between align-items-center {{ $loop->first ? '' : 'mt-1' }}" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#mod{{ $mod->id }}">
                {{ $mod->title }}
                <i class="fa-solid fa-chevron-down small"></i>
            </div>
            <div class="collapse {{ $mod->lessons->contains('id', $lesson->id) || $loop->first ? 'show' : '' }}" id="mod{{ $mod->id }}">
                @foreach($mod->lessons as $l)
                <a href="{{ route('lms.lesson', ['course' => $course->id, 'lesson' => $l->id]) }}" class="lesson-link {{ $l->id == $lesson->id ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <div>
                        @if(in_array($l->id, $completedLessons))
                            <i class="fa-solid fa-circle-check me-2 text-success"></i>
                        @else
                            <i class="fa-regular fa-circle-play me-2 {{ $l->id == $lesson->id ? 'text-warning' : 'text-secondary' }}"></i>
                        @endif
                        {{ \Illuminate\Support\Str::limit($l->title, 25) }}
                    </div>
                </a>
                @endforeach
            </div>
            @empty
            <div class="p-4 text-center text-muted">
                <i class="fa-solid fa-ghost fs-3 mb-2"></i><br>
                Nenhum módulo encontrado.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
