@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Gestão de Cursos (LMS)</h2>
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addCursoModal">
        <i class="fa-solid fa-plus me-1"></i> Novo Curso
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="py-3">Capa</th>
                        <th class="py-3">Título do Curso</th>
                        <th class="py-3">Categoria</th>
                        <th class="py-3">Preço</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td class="px-4">#{{ $course->id }}</td>
                        <td>
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Capa" class="rounded" style="width: 50px; height: 35px; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center text-secondary" style="width: 50px; height: 35px;">
                                    <i class="fa-solid fa-image small"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $course->title }}</td>
                        <td>{{ $course->category->name ?? 'Geral' }}</td>
                        <td>
                            @if($course->is_free)
                                <span class="badge bg-success">Grátis</span>
                            @else
                                {{ number_format($course->price, 2, ',', '.') }} Kz
                            @endif
                        </td>
                        <td class="text-center">
                            @if($course->is_published)
                                <span class="badge bg-success rounded-pill px-3">Publicado</span>
                            @else
                                <span class="badge bg-warning rounded-pill px-3 text-dark">Rascunho</span>
                            @endif
                        </td>
                        <td class="px-4 text-end">
                            <a href="{{ route('admin.cursos.conteudos', $course->id) }}" class="btn btn-sm btn-info text-white rounded-circle" title="Gerir Conteúdos"><i class="fa-solid fa-list-check"></i></a>
                            <button class="btn btn-sm btn-outline-secondary rounded-circle" data-bs-toggle="modal" data-bs-target="#editCursoModal{{ $course->id }}"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ route('admin.cursos.destroy', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" onclick="return confirm('Tem certeza que deseja remover este curso?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-box-open fs-2 mb-3 text-opacity-50"></i><br>
                            Nenhum curso cadastrado ainda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Novo Curso -->
<div class="modal fade" id="addCursoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('admin.cursos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Cadastrar Novo Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Título do Curso</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Categoria</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nível</label>
                            <select name="level" class="form-select" required>
                                <option value="basic">Básico</option>
                                <option value="intermediate">Intermédio</option>
                                <option value="advanced">Avançado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Preço (Kz)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Capa (Imagem)</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Descrição do Curso</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch mt-2 d-inline-block me-4">
                                <input class="form-check-input" type="checkbox" name="is_published" id="isPublished" value="1" checked>
                                <label class="form-check-label" for="isPublished">Publicar imediatamente</label>
                            </div>
                            <div class="form-check form-switch mt-2 d-inline-block">
                                <input class="form-check-input" type="checkbox" name="is_free" id="isFree" value="1">
                                <label class="form-check-label text-success fw-bold" for="isFree">Curso Gratuito</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--asoft-primary); border: none;">Salvar Curso</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($courses as $course)
<!-- Modal Editar Curso {{ $course->id }} -->
<div class="modal fade" id="editCursoModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('admin.cursos.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Editar Curso #{{ $course->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Título do Curso</label>
                            <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Categoria</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $course->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nível</label>
                            <select name="level" class="form-select" required>
                                <option value="basic" {{ $course->level == 'basic' ? 'selected' : '' }}>Básico</option>
                                <option value="intermediate" {{ $course->level == 'intermediate' ? 'selected' : '' }}>Intermédio</option>
                                <option value="advanced" {{ $course->level == 'advanced' ? 'selected' : '' }}>Avançado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Preço (Kz)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ $course->price }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Capa (Imagem)</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                            @if($course->thumbnail)
                                <small class="text-muted d-block mt-1">Deixe vazio para manter a capa atual.</small>
                            @endif
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Descrição do Curso</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ $course->description }}</textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch mt-2 d-inline-block me-4">
                                <input class="form-check-input" type="checkbox" name="is_published" id="isPublished{{ $course->id }}" value="1" {{ $course->is_published ? 'checked' : '' }}>
                                <label class="form-check-label" for="isPublished{{ $course->id }}">Publicar imediatamente</label>
                            </div>
                            <div class="form-check form-switch mt-2 d-inline-block">
                                <input class="form-check-input" type="checkbox" name="is_free" id="isFree{{ $course->id }}" value="1" {{ $course->is_free ? 'checked' : '' }}>
                                <label class="form-check-label text-success fw-bold" for="isFree{{ $course->id }}">Curso Gratuito</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--asoft-primary); border: none;">Atualizar Curso</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
