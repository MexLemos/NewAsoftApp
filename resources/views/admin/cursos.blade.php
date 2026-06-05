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
                        <td>{{ number_format($course->price, 2, ',', '.') }} Kz</td>
                        <td class="text-center">
                            @if($course->is_published)
                                <span class="badge bg-success rounded-pill px-3">Publicado</span>
                            @else
                                <span class="badge bg-warning rounded-pill px-3 text-dark">Rascunho</span>
                            @endif
                        </td>
                        <td class="px-4 text-end">
                            <button class="btn btn-sm btn-outline-secondary rounded-circle"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>
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
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_published" id="isPublished" value="1" checked>
                                <label class="form-check-label" for="isPublished">Publicar curso imediatamente</label>
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
@endsection
