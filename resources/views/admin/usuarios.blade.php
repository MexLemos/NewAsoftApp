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

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

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
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            @php
                                $role = class_exists(\Spatie\Permission\Models\Role::class) && method_exists($user, 'getRoleNames') 
                                        ? ($user->getRoleNames()->first() ?? 'Aluno') 
                                        : 'Aluno';
                            @endphp
                            @if($role === 'admin' || $role === 'Admin')
                                <span class="badge bg-primary bg-opacity-10 text-primary">Admin</span>
                            @elseif($role === 'instrutor' || $role === 'Formador')
                                <span class="badge bg-warning bg-opacity-10 text-warning text-dark">Formador</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $role }}</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active ?? true)
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-danger">Inativo</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalEditUsuario{{ $user->id }}"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                    
                    <!-- Modal Editar Usuário -->
                    <div class="modal fade" id="modalEditUsuario{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-bottom-0 pb-0">
                                    <h5 class="modal-title fw-bold">Editar Usuário</h5>
                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('admin.usuarios.update', $user->id) }}" method="POST" id="formEditUsuario{{ $user->id }}">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label text-muted small fw-bold">Nome Completo</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted small fw-bold">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted small fw-bold">Perfil de Acesso (Role)</label>
                                                <select name="role" class="form-select" required>
                                                    <option value="Admin" {{ $role == 'Admin' || $role == 'admin' ? 'selected' : '' }}>Administrador (Admin)</option>
                                                    <option value="Formador" {{ $role == 'Formador' || $role == 'instrutor' ? 'selected' : '' }}>Formador (Cursos)</option>
                                                    <option value="Tech" {{ $role == 'Tech' ? 'selected' : '' }}>Técnico (Tech)</option>
                                                    <option value="Aluno" {{ $role == 'Aluno' ? 'selected' : '' }}>Aluno / Cliente</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted small fw-bold">Nova Senha (deixe em branco para não alterar)</label>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                                @error('password')<div class="invalid-feedback fw-bold">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActiveSwitch{{ $user->id }}" {{ ($user->is_active ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold text-muted small" for="isActiveSwitch{{ $user->id }}">Conta Ativa</label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="formEditUsuario{{ $user->id }}" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Guardar Alterações</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
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
                        <input type="hidden" name="action_type" value="create">
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Nome Completo</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback fw-bold">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback fw-bold">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Perfil de Acesso (Role)</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Administrador (Admin)</option>
                                <option value="Formador" {{ old('role') == 'Formador' ? 'selected' : '' }}>Formador (Cursos)</option>
                                <option value="Tech" {{ old('role') == 'Tech' ? 'selected' : '' }}>Técnico (Tech)</option>
                                <option value="Aluno" {{ old('role') == 'Aluno' ? 'selected' : (old('role') ? '' : 'selected') }}>Aluno / Cliente</option>
                            </select>
                            @error('role')<div class="invalid-feedback fw-bold">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Senha Inicial</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback fw-bold">{{ $message }}</div>@enderror
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

@if($errors->any() && old('action_type') == 'create')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('modalUsuario'));
        myModal.show();
    });
</script>
@endif
@endsection
