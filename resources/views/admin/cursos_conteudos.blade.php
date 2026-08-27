@extends('layouts.admin')

@section('title', 'Gerir Conteúdos: ' . $course->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.cursos') }}" class="btn btn-sm btn-outline-secondary mb-2"><i class="fa-solid fa-arrow-left"></i> Voltar aos Cursos</a>
        <h4 class="fw-bold mb-0">Gerir Conteúdos: {{ $course->title }}</h4>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal">
        <i class="fa-solid fa-folder-plus me-2"></i> Novo Módulo
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        @forelse($course->modules->sortBy('order_index') as $mod)
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-folder-open me-2 text-warning"></i> {{ $mod->title }}</h5>
                    <div>
                        <button class="btn btn-sm btn-light text-primary me-2" data-bs-toggle="modal" data-bs-target="#addLessonModal{{ $mod->id }}"><i class="fa-solid fa-video me-1"></i> Aula</button>
                        <button class="btn btn-sm btn-light text-success me-2" data-bs-toggle="modal" data-bs-target="#addQuizModal{{ $mod->id }}"><i class="fa-solid fa-clipboard-question me-1"></i> Avaliação</button>
                        <button class="btn btn-sm btn-light text-danger me-2" data-bs-toggle="modal" data-bs-target="#addProjectModal{{ $mod->id }}"><i class="fa-solid fa-laptop-code me-1"></i> Projecto</button>
                        
                        <button class="btn btn-sm btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#editModuleModal{{ $mod->id }}"><i class="fa-solid fa-pen"></i></button>
                        <form action="{{ route('admin.modules.destroy', $mod->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem a certeza que deseja eliminar este módulo e todas as suas aulas?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($mod->lessons->count() > 0)
                        <ul class="list-group list-group-flush rounded-bottom-4">
                            @foreach($mod->lessons as $l)
                                <li class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($l->type === 'quiz')
                                            <i class="fa-solid fa-clipboard-question text-success me-2"></i>
                                        @elseif($l->type === 'project')
                                            <i class="fa-solid fa-laptop-code text-danger me-2"></i>
                                        @else
                                            <i class="fa-regular fa-circle-play text-primary me-2"></i>
                                        @endif
                                        
                                        <span class="fw-semibold">{{ $l->title }}</span>
                                        @if($l->video_url && $l->type === 'video')
                                            <span class="badge bg-secondary ms-2 small">Vídeo</span>
                                        @endif
                                        @if($l->attachment_url)
                                            <span class="badge bg-info ms-1 small">Anexo</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if($l->type === 'quiz')
                                            <button class="btn btn-sm btn-outline-secondary rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#editQuizModal{{ $l->id }}"><i class="fa-solid fa-pen"></i></button>
                                        @elseif($l->type === 'project')
                                            <button class="btn btn-sm btn-outline-secondary rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#editProjectModal{{ $l->id }}"><i class="fa-solid fa-pen"></i></button>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#editLessonModal{{ $l->id }}"><i class="fa-solid fa-pen"></i></button>
                                        @endif
                                        
                                        <form action="{{ route('admin.lessons.destroy', $l->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Eliminar este item?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </li>

                                <!-- Edit Lesson Modal -->
                                <div class="modal fade" id="editLessonModal{{ $l->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('admin.lessons.update', $l->id) }}" method="POST" class="modal-content">
                                            @csrf @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Editar Aula</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Título da Aula</label>
                                                    <input type="text" name="title" class="form-control" value="{{ $l->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Descrição / Conteúdo (Opcional)</label>
                                                    <textarea name="description" class="form-control" rows="4">{{ $l->description }}</textarea>
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">URL do Vídeo (Embed/YouTube)</label>
                                                        <input type="text" name="video_url" class="form-control" value="{{ $l->video_url }}" placeholder="https://www.youtube.com/embed/...">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">URL do Anexo / Recurso</label>
                                                        <input type="text" name="attachment_url" class="form-control" value="{{ $l->attachment_url }}">
                                                    </div>
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Ordem (Opcional)</label>
                                                        <input type="number" name="order_index" class="form-control" value="{{ $l->order_index }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Duração (minutos)</label>
                                                        <input type="number" name="duration_minutes" class="form-control" value="{{ $l->duration_minutes ?? 0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Quiz Modal -->
                                <div class="modal fade" id="editQuizModal{{ $l->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('admin.lessons.update', $l->id) }}" method="POST" class="modal-content">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="type" value="quiz">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Editar Avaliação</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Título da Avaliação</label>
                                                    <input type="text" name="title" class="form-control" value="{{ $l->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Instruções Gerais</label>
                                                    <textarea name="description" class="form-control" rows="2">{{ $l->description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Perguntas da Avaliação (Pode ser um link de um formulário no anexo ou texto aqui)</label>
                                                    <textarea name="quiz_questions" class="form-control" rows="5" placeholder="1. O que é...&#10;2. Como funciona...">{{ $l->content_data['quiz_questions'] ?? '' }}</textarea>
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">URL do Formulário Externo (Opcional)</label>
                                                        <input type="url" name="attachment_url" class="form-control" value="{{ $l->attachment_url }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Ordem</label>
                                                        <input type="number" name="order_index" class="form-control" value="{{ $l->order_index }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success">Guardar Alterações</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Project Modal -->
                                <div class="modal fade" id="editProjectModal{{ $l->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('admin.lessons.update', $l->id) }}" method="POST" class="modal-content">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="type" value="project">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Editar Projecto</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Título do Projecto</label>
                                                    <input type="text" name="title" class="form-control" value="{{ $l->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Descrição / Requisitos</label>
                                                    <textarea name="description" class="form-control" rows="4">{{ $l->description }}</textarea>
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-6">
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="require_github" id="reqGitEdit{{ $l->id }}" value="1" {{ isset($l->content_data['require_github']) && $l->content_data['require_github'] ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold" for="reqGitEdit{{ $l->id }}">Exigir envio por GitHub</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="linkedin_mention" id="reqLinkEdit{{ $l->id }}" value="1" {{ isset($l->content_data['linkedin_mention']) && $l->content_data['linkedin_mention'] ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold" for="reqLinkEdit{{ $l->id }}">Sugerir menção no LinkedIn</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">URL de Recursos Iniciais (Opcional)</label>
                                                    <input type="url" name="attachment_url" class="form-control" value="{{ $l->attachment_url }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Ordem</label>
                                                    <input type="number" name="order_index" class="form-control" value="{{ $l->order_index }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Guardar Alterações</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-4 text-center text-muted small">
                            Nenhuma aula cadastrada neste módulo ainda.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Add Lesson Modal -->
            <div class="modal fade" id="addLessonModal{{ $mod->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form action="{{ route('admin.lessons.store', $mod->id) }}" method="POST" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Nova Aula: {{ $mod->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Título da Aula</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Descrição / Conteúdo (Opcional)</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">URL do Vídeo (Embed/YouTube)</label>
                                    <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/embed/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">URL do Anexo / Recurso</label>
                                    <input type="url" name="attachment_url" class="form-control">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Ordem</label>
                                    <input type="number" name="order_index" class="form-control" value="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Duração (minutos)</label>
                                    <input type="number" name="duration_minutes" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Criar Aula</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Quiz Modal -->
            <div class="modal fade" id="addQuizModal{{ $mod->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form action="{{ route('admin.lessons.store', $mod->id) }}" method="POST" class="modal-content">
                        @csrf
                        <input type="hidden" name="type" value="quiz">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Nova Avaliação: {{ $mod->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Título da Avaliação</label>
                                <input type="text" name="title" class="form-control" placeholder="Ex: Teste Final do Módulo 1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Instruções Gerais</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Descreva o que o aluno deve fazer..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Perguntas da Avaliação</label>
                                <textarea name="quiz_questions" class="form-control" rows="5" placeholder="1. O que é...&#10;2. Como funciona..."></textarea>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">URL do Formulário Externo (Opcional)</label>
                                    <input type="url" name="attachment_url" class="form-control" placeholder="Ex: link do Google Forms">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Ordem</label>
                                    <input type="number" name="order_index" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Criar Avaliação</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Project Modal -->
            <div class="modal fade" id="addProjectModal{{ $mod->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form action="{{ route('admin.lessons.store', $mod->id) }}" method="POST" class="modal-content">
                        @csrf
                        <input type="hidden" name="type" value="project">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Novo Projecto: {{ $mod->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Título do Projecto</label>
                                <input type="text" name="title" class="form-control" placeholder="Ex: Desenvolver um e-commerce simples" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Descrição / Requisitos do Projecto</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Descreva as regras, tecnologias a utilizar, e o resultado final esperado."></textarea>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="require_github" id="reqGit{{ $mod->id }}" value="1" checked>
                                        <label class="form-check-label fw-bold" for="reqGit{{ $mod->id }}">Exigir envio por GitHub</label>
                                    </div>
                                    <small class="text-muted d-block mt-1">O aluno deverá colar o link do repositório para avaliação.</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="linkedin_mention" id="reqLink{{ $mod->id }}" value="1" checked>
                                        <label class="form-check-label fw-bold" for="reqLink{{ $mod->id }}">Sugerir menção no LinkedIn</label>
                                    </div>
                                    <small class="text-muted d-block mt-1">Sugere ao aluno que faça uma publicação e identifique a ASoftMedia.</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">URL de Recursos Iniciais (Opcional)</label>
                                <input type="url" name="attachment_url" class="form-control" placeholder="Link de ficheiros base para o projeto">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ordem</label>
                                <input type="number" name="order_index" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Criar Projecto</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Module Modal -->
            <div class="modal fade" id="editModuleModal{{ $mod->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('admin.modules.update', $mod->id) }}" method="POST" class="modal-content">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Editar Módulo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nome do Módulo</label>
                                <input type="text" name="title" class="form-control" value="{{ $mod->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ordem</label>
                                <input type="number" name="order_index" class="form-control" value="{{ $mod->order_index }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-folder-open fs-1 mb-3 opacity-50"></i>
                <h5>Nenhum módulo criado neste curso.</h5>
                <p>Comece por adicionar o primeiro módulo estrutural do curso.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Module Modal -->
<div class="modal fade" id="addModuleModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.modules.store', $course->id) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Novo Módulo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nome do Módulo</label>
                    <input type="text" name="title" class="form-control" required placeholder="Ex: Módulo 1 - Introdução">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Ordem</label>
                    <input type="number" name="order_index" class="form-control" value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Criar Módulo</button>
            </div>
        </form>
    </div>
</div>
@endsection
