@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Serviços</h2>
        <p class="text-muted mb-0">Gerencie os serviços prestados pela sua empresa.</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <x-export-buttons list="servicos" />
        <button class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
            <i class="fa-solid fa-plus me-1"></i> Novo Serviço
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Imagem/Ícone</th>
                        <th>Nome do Serviço</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td class="ps-4">
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                @if($service->icon)
                                    <img src="{{ asset('storage/' . $service->icon) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <i class="fa-solid fa-network-wired text-muted"></i>
                                @endif
                            </div>
                        </td>
                        <td class="fw-medium">{{ $service->title }}</td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-sm btn-light me-1" data-bs-toggle="modal" data-bs-target="#modalEditService{{ $service->id }}"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ route('admin.servicos.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja deletar este serviço?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger" title="Apagar Serviço"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal para Serviço -->
                    <div class="modal fade" id="modalEditService{{ $service->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-bottom-0 pb-0">
                                    <h5 class="modal-title fw-bold">Editar Serviço</h5>
                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('admin.servicos.update', $service->id) }}" method="POST" enctype="multipart/form-data" id="formEditService{{ $service->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label text-muted small fw-bold">Nome</label>
                                            <input type="text" name="name" class="form-control" value="{{ $service->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted small fw-bold">Nova Imagem/Ícone (opcional)</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted small fw-bold">Descrição</label>
                                            <textarea name="description" class="form-control" rows="3" required>{{ $service->description }}</textarea>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" name="is_featured" id="isFeaturedServ{{ $service->id }}" value="1" {{ $service->is_featured ? 'checked' : '' }}>
                                            <label class="form-check-label text-muted small fw-bold" for="isFeaturedServ{{ $service->id }}">Serviço em Destaque (Home)</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="formEditService{{ $service->id }}" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Nenhum serviço cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Cadastrar Serviço -->
<div class="modal fade" id="modalCadastrar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Cadastrar Novo Serviço</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.produtos.store') }}" method="POST" enctype="multipart/form-data" id="formCadastrar">
                    @csrf
                    <input type="hidden" name="category" value="servico">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-bold">Nome do Serviço</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-bold">Imagem de Destaque / Ícone</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Descrição Curta</label>
                            <textarea name="description" class="form-control" rows="2" required></textarea>
                            <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_featured" id="isFeaturedNewServ" value="1">
                                <label class="form-check-label text-muted small fw-bold" for="isFeaturedNewServ">Serviço em Destaque (Mostrar na Home)</label>
                            </div>
                        </div>
                    </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Conteúdo / Detalhes (HTML permitido)</label>
                            <textarea name="content" class="form-control" rows="4" placeholder="Detalhes completos do serviço..."></textarea>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_featured" id="isFeaturedNewServ" value="1">
                                <label class="form-check-label text-muted small fw-bold" for="isFeaturedNewServ">Serviço em Destaque (Mostrar na Home)</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formCadastrar" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Guardar Serviço</button>
            </div>
        </div>
    </div>
</div>
@endsection
