@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Usuários</h2>
        <p class="text-muted mb-0">Gestão de acessos, alunos e clientes.</p>
    </div>
    <button class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;" data-bs-toggle="modal" data-bs-target="#modalUsuario">
        <i class="fa-solid fa-user-plus me-1"></i> Adicionar Usuário
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nome</th>
                        <th>Email</th>
                        <th>Função</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-medium">Administrador Principal</td>
                        <td class="text-muted">admin@asoftmedia.com</td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">Admin</span></td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-medium">João Paulo</td>
                        <td class="text-muted">joao.p@asoftmedia.com</td>
                        <td><span class="badge bg-warning bg-opacity-10 text-warning text-dark">Formador</span></td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-medium">Carlos Silva</td>
                        <td class="text-muted">carlos.tech@asoftmedia.com</td>
                        <td><span class="badge bg-info bg-opacity-10 text-info">Tech</span></td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-medium">Ana Sousa</td>
                        <td class="text-muted">aluno@example.com</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Aluno</span></td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Adicionar Usuário -->
<div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Adicionar Novo Usuário</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.usuarios.store') }}" method="POST" id="formUsuario">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Nome Completo</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Perfil de Acesso (Role)</label>
                            <select name="role" class="form-select" required>
                                <option value="Admin">Administrador (Admin)</option>
                                <option value="Formador">Formador (Cursos)</option>
                                <option value="Tech">Técnico (Tech)</option>
                                <option value="Aluno" selected>Aluno / Cliente</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Senha Inicial</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formUsuario" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Criar Usuário</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('.d-flex .btn-primary').setAttribute('data-bs-toggle', 'modal');
    document.querySelector('.d-flex .btn-primary').setAttribute('data-bs-target', '#modalUsuario');
</script>
@endsection
