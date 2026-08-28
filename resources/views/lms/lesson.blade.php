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
        <!-- Main Video / Content Area -->
        <div class="video-container flex-grow-1 position-relative">
            @if($lesson->type === 'quiz')
                <div class="bg-dark border-bottom border-secondary p-4 p-md-5 flex-shrink-0" style="min-height: 400px;">
                    <div class="text-center text-warning mb-4">
                        <i class="fa-solid fa-clipboard-question fa-3x mb-3"></i>
                        <h3>Avaliação de Conhecimentos</h3>
                        <p class="text-muted">{{ $lesson->description ?? 'Responda às questões abaixo para concluir.' }}</p>
                    </div>
                    
                    <div class="card bg-dark bg-opacity-50 border-secondary shadow-lg mx-auto" style="max-width: 800px;">
                        <div class="card-body p-4" id="quizContainer">
                            @php 
                                $quizData = $lesson->content_data['quiz'] ?? []; 
                                // Filter out empty questions
                                $validQuestions = array_filter($quizData, function($q) { return !empty($q['question']); });
                            @endphp
                            
                            @if(count($validQuestions) > 0)
                                <form id="quizForm" onsubmit="return false;">
                                    @php 
                                        $qIndex = 1; 
                                        $totalQ = count($validQuestions);
                                    @endphp
                                    @foreach($validQuestions as $key => $q)
                                        <div class="mb-4 quiz-step" id="step_{{ $qIndex }}" style="display: {{ $qIndex === 1 ? 'block' : 'none' }};">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="badge bg-secondary">Pergunta {{ $qIndex }} de {{ $totalQ }}</span>
                                                <span class="small text-muted">Progresso: {{ round(($qIndex / $totalQ) * 100) }}%</span>
                                            </div>
                                            <div class="progress mb-4" style="height: 5px;">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($qIndex / $totalQ) * 100 }}%"></div>
                                            </div>

                                            <h4 class="fw-bold text-white mb-4 lh-base">{{ $q['question'] }}</h4>
                                            
                                            <div class="list-group mb-5">
                                                @foreach(['opt_a' => 'A', 'opt_b' => 'B', 'opt_c' => 'C', 'opt_d' => 'D'] as $optField => $optLetter)
                                                    @if(!empty($q[$optField]))
                                                    <label class="list-group-item list-group-item-action bg-transparent text-light border-secondary d-flex align-items-center cursor-pointer quiz-option py-3">
                                                        <input class="form-check-input me-3" type="radio" name="ans_{{ $key }}" value="{{ $optLetter }}">
                                                        <span class="fs-6">{{ $q[$optField] }}</span>
                                                    </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <input type="hidden" id="correct_{{ $key }}" value="{{ $q['correct'] }}">
                                            
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-outline-light px-4" onclick="prevStep({{ $qIndex }})" {{ $qIndex === 1 ? 'disabled' : '' }}><i class="fa-solid fa-arrow-left me-2"></i>Anterior</button>
                                                
                                                @if($qIndex < $totalQ)
                                                    <button type="button" class="btn btn-primary px-4" onclick="nextStep({{ $qIndex }})">Próxima<i class="fa-solid fa-arrow-right ms-2"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-warning fw-bold px-4" onclick="evaluateQuiz()">Submeter Teste <i class="fa-solid fa-check ms-2"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                        @php $qIndex++; @endphp
                                    @endforeach
                                    
                                    <div id="quizResult" class="mt-3 text-center" style="display: none;"></div>
                                </form>
                                
                                <script>
                                    let totalSteps = {{ count($validQuestions) }};
                                    
                                    function nextStep(current) {
                                        document.getElementById('step_' + current).style.display = 'none';
                                        document.getElementById('step_' + (current + 1)).style.display = 'block';
                                    }
                                    
                                    function prevStep(current) {
                                        document.getElementById('step_' + current).style.display = 'none';
                                        document.getElementById('step_' + (current - 1)).style.display = 'block';
                                    }

                                    function evaluateQuiz() {
                                        let total = {{ count($validQuestions) }};
                                        let correct = 0;
                                        let allAnswered = true;
                                        
                                        @foreach($validQuestions as $key => $q)
                                            let selected_{{ $key }} = document.querySelector('input[name="ans_{{ $key }}"]:checked');
                                            let correctAns_{{ $key }} = document.getElementById('correct_{{ $key }}').value;
                                            
                                            if(!selected_{{ $key }}) {
                                                allAnswered = false;
                                            } else {
                                                if (selected_{{ $key }}.value === correctAns_{{ $key }}) {
                                                    correct++;
                                                }
                                            }
                                        @endforeach
                                        
                                        if(!allAnswered) {
                                            alert("Por favor responda a todas as perguntas antes de submeter o teste.");
                                            return;
                                        }
                                        
                                        // Hide all steps
                                        for(let i = 1; i <= totalSteps; i++) {
                                            document.getElementById('step_' + i).style.display = 'none';
                                        }
                                        
                                        let resDiv = document.getElementById('quizResult');
                                        resDiv.style.display = 'block';
                                        
                                        let percent = Math.round((correct / total) * 100);
                                        if(percent >= 50) {
                                            resDiv.innerHTML = `
                                                <div class="p-5 bg-success bg-opacity-25 border border-success rounded-4 shadow-sm">
                                                    <i class="fa-solid fa-trophy fa-4x text-success mb-4"></i>
                                                    <h3 class="text-white fw-bold mb-3">Parabéns! Passou no Teste.</h3>
                                                    <p class="text-success fs-5 fw-bold mb-4">Acertou ${correct} de ${total} perguntas (${percent}%).</p>
                                                    
                                                    @if(!in_array($lesson->id, $completedLessons))
                                                    <form action="{{ route('lms.lesson.complete', ['course' => $course->id, 'lesson' => $lesson->id]) }}" method="POST" class="mt-4">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-check-double me-2"></i> Concluir Aula Oficialmente</button>
                                                    </form>
                                                    @else
                                                        <p class="text-light small mt-3">Já tinha concluído esta aula anteriormente.</p>
                                                    @endif
                                                </div>`;
                                        } else {
                                            resDiv.innerHTML = `
                                                <div class="p-5 bg-danger bg-opacity-25 border border-danger rounded-4 shadow-sm">
                                                    <i class="fa-solid fa-triangle-exclamation fa-4x text-danger mb-4"></i>
                                                    <h3 class="text-white fw-bold mb-3">Não desista! Precisa estudar mais.</h3>
                                                    <p class="text-danger fs-5 fw-bold mb-4">Acertou apenas ${correct} de ${total} perguntas (${percent}%).</p>
                                                    <p class="text-light small">Recomendamos fortemente que reveja a matéria deste módulo e tente novamente mais tarde para consolidar os seus conhecimentos.</p>
                                                    <button type="button" class="btn btn-outline-light mt-3" onclick="location.reload()">Tentar Novamente</button>
                                                </div>`;
                                        }
                                    }
                                </script>
                            @else
                                <div class="text-center text-muted">
                                    <p>Nenhuma pergunta cadastrada.</p>
                                    @if($lesson->attachment_url)
                                        <a href="{{ $lesson->attachment_url }}" target="_blank" class="btn btn-primary">Fazer Teste num Link Externo</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($lesson->type === 'project')
                <div class="bg-dark border-bottom border-secondary p-4 p-md-5 flex-shrink-0" style="min-height: 400px;">
                    <div class="text-center mb-5">
                        <i class="fa-solid fa-laptop-code fa-4x text-danger mb-4"></i>
                        <h2 class="fw-bold text-white">Submissão do Projecto</h2>
                        <p class="text-muted" style="max-width: 600px; margin: 0 auto;">Reveja os requisitos na visão geral (em baixo) e submeta o seu trabalho concluído aqui para avaliação.</p>
                    </div>

                    <div class="card bg-dark bg-opacity-50 border-secondary shadow-lg mx-auto" style="max-width: 800px;">
                        <div class="card-body p-4">
                            @if(in_array($lesson->id, $completedLessons))
                                <div class="text-center p-4">
                                    <i class="fa-solid fa-circle-check text-success fa-4x mb-4"></i>
                                    <h3 class="text-white fw-bold">Projecto Entregue!</h3>
                                    <p class="text-muted fs-5">Já submeteu e concluiu este projecto com sucesso. Parabéns!</p>
                                </div>
                            @else
                                <form action="{{ route('lms.lesson.complete', ['course' => $course->id, 'lesson' => $lesson->id]) }}" method="POST">
                                    @csrf
                                    
                                    @if(isset($lesson->content_data['require_github']) && $lesson->content_data['require_github'])
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-white">Link do Repositório (GitHub) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary border-secondary text-white"><i class="fa-brands fa-github"></i></span>
                                            <input type="url" name="github_link" class="form-control" placeholder="https://github.com/seu-usuario/seu-repositorio" required>
                                        </div>
                                        <div class="form-text text-warning small"><i class="fa-solid fa-circle-info me-1"></i> Este campo é obrigatório para podermos avaliar o seu código.</div>
                                    </div>
                                    @endif

                                    @if(isset($lesson->content_data['linkedin_mention']) && $lesson->content_data['linkedin_mention'])
                                    <div class="alert bg-info bg-opacity-10 border border-info border-opacity-25 mb-4 rounded-4">
                                        <div class="d-flex">
                                            <i class="fa-brands fa-linkedin fa-2x text-info me-3 mt-1"></i>
                                            <div>
                                                <h6 class="fw-bold text-info mb-1">Partilhe a sua conquista!</h6>
                                                <p class="text-light small mb-0 lh-sm">Recomendamos que faça uma publicação no seu LinkedIn mostrando o código e o projeto a funcionar. Não se esqueça de identificar a <strong>ASoftMedia</strong> para destacarmos o seu perfil junto das empresas parceiras!</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-white">Comentários da Submissão (Opcional)</label>
                                        <textarea name="comments" class="form-control bg-dark text-light border-secondary" rows="3" placeholder="Alguma observação, desafio ou mensagem para o avaliador?"></textarea>
                                    </div>

                                    <div class="d-grid mt-2">
                                        <button type="submit" class="btn btn-danger fw-bold py-3 fs-5 rounded-3 shadow-sm"><i class="fa-solid fa-paper-plane me-2"></i> Submeter Projecto e Concluir</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @else
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
            @endif
            
            <div class="p-4 p-md-5 flex-shrink-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold m-0">{{ $lesson->title }}</h2>
                    
                    @if($lesson->type === 'video')
                        @if(in_array($lesson->id, $completedLessons))
                            <button class="btn btn-success fw-bold px-4 rounded-pill disabled"><i class="fa-solid fa-check-double me-2"></i> Aula Concluída</button>
                        @else
                            <form action="{{ route('lms.lesson.complete', ['course' => $course->id, 'lesson' => $lesson->id]) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-success fw-bold px-4 rounded-pill"><i class="fa-solid fa-check me-2"></i> Marcar como Concluída</button>
                            </form>
                        @endif
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
