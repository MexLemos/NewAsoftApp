@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Turmas de Formação</h2>
        <p class="text-muted mb-0">Gestão de turmas, horários e alunos matriculados.</p>
    </div>
    <button class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;" data-bs-toggle="modal" data-bs-target="#modalTurma">
        <i class="fa-solid fa-plus me-1"></i> Nova Turma
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    @foreach($turmas as $turma)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden">
            <div class="card-body p-4 position-relative z-1">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">{{ $turma->course->title ?? 'Curso N/D' }}</span>
                    @if($turma->is_active)
                        <span class="badge bg-success"><i class="fa-solid fa-circle fa-2xs me-1"></i>Ativa</span>
                    @else
                        <span class="badge bg-secondary">Fechada</span>
                    @endif
                </div>
                
                <h4 class="fw-bold mb-1">{{ $turma->name }}</h4>
                <p class="text-muted small mb-4">Criada em {{ $turma->created_at->format('d/m/Y') }}</p>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-light rounded-circle p-3 me-3 text-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-users text-primary"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">{{ $turma->users_count }}</h5>
                        <span class="small text-muted">Alunos Matriculados</span>
                    </div>
                </div>
                
                <div class="p-3 bg-light rounded-3 mb-4">
                    <span class="d-block small text-muted fw-bold mb-1">Mensalidade (Propina)</span>
                    <h5 class="mb-0 fw-bold text-success">{{ number_format($turma->monthly_fee, 2, ',', '.') }} Kz</h5>
                </div>
                
                <a href="{{ route('admin.turmas.show', $turma->id) }}" class="btn btn-outline-primary w-100 fw-bold rounded-pill">Gerir Turma <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <!-- Decorative circle -->
            <div class="position-absolute rounded-circle" style="width: 150px; height: 150px; background-color: var(--asoft-primary); opacity: 0.05; top: -50px; right: -50px; z-index: 0;"></div>
        </div>
    </div>
    @endforeach
    
    @if($turmas->isEmpty())
    <div class="col-12 text-center py-5">
        <i class="fa-solid fa-chalkboard-user fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Nenhuma turma registada.</h5>
    </div>
    @endif
</div>

<!-- Modal Nova Turma -->
<div class="modal fade" id="modalTurma" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Criar Nova Turma</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.turmas.store') }}" method="POST" id="formTurma">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Curso de Referência</label>
                        <select name="course_id" class="form-select" required>
                            <option value="" disabled selected>Selecione o curso...</option>
                            @foreach($courses as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nome da Turma / Horário</label>
                        <input type="text" name="name" class="form-control" placeholder="Ex: Inglês Básico - Manhã (08h-10h)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Valor da Mensalidade (Propina)</label>
                        <input type="number" step="0.01" name="monthly_fee" class="form-control fw-bold text-success" placeholder="Ex: 20000" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formTurma" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Salvar Turma</button>
            </div>
        </div>
    </div>
</div>
@endsection
