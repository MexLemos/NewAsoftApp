@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.turmas') }}" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="fa-solid fa-arrow-left me-1"></i> Voltar às Turmas</a>
    <div class="d-flex justify-content-between align-items-center mt-2">
        <div>
            <h2 class="h3 mb-1 fw-bold">{{ $turma->name }}</h2>
            <p class="text-muted mb-0"><span class="badge bg-primary bg-opacity-10 text-primary me-2">{{ $turma->course->title }}</span> Propina: <b>{{ number_format($turma->monthly_fee, 2, ',', '.') }} Kz</b></p>
        </div>
        <button class="btn btn-primary fw-bold shadow-sm" style="background-color: var(--asoft-primary); border: none;" data-bs-toggle="modal" data-bs-target="#modalAddAluno">
            <i class="fa-solid fa-user-plus me-1"></i> Adicionar Aluno
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
        <h5 class="fw-bold mb-0">Alunos Matriculados ({{ $turma->users->count() }})</h5>
    </div>
    <div class="card-body px-0 pb-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nome</th>
                        <th>Email</th>
                        <th>Contacto</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turma->users as $user)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td class="text-muted">{{ $user->phone ?? 'N/D' }}</td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.turmas.remove_student', [$turma->id, $user->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem a certeza que deseja remover este aluno da turma?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Remover da Turma"><i class="fa-solid fa-user-xmark"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($turma->users->isEmpty())
                        <tr><td colspan="4" class="text-center py-5 text-muted">Nenhum aluno matriculado nesta turma.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Adicionar Aluno -->
<div class="modal fade" id="modalAddAluno" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Matricular Aluno</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.turmas.add_student', $turma->id) }}" method="POST" id="formAddAluno">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Selecione o Cliente / Aluno</label>
                        <select name="user_id" class="form-select" required>
                            <option value="" disabled selected>Pesquisar utilizador...</option>
                            @foreach($availableUsers as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                        <div class="form-text mt-2">Só aparecem na lista os utilizadores que não estão matriculados nesta turma.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formAddAluno" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Matricular na Turma</button>
            </div>
        </div>
    </div>
</div>
@endsection
