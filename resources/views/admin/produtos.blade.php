@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Produtos</h2>
        <p class="text-muted mb-0">Gerencie os produtos do seu e-commerce.</p>
    </div>
    <button class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
        <i class="fa-solid fa-plus me-1"></i> Novo Produto
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Imagem</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="ps-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-box-open text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-medium">{{ $product->name }}</td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">Produto</span></td>
                        <td>Kz {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-sm btn-light me-1" data-bs-toggle="modal" data-bs-target="#modalEditProduct{{ $product->id }}"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ route('admin.produtos.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja deletar este produto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger" title="Apagar Produto"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <!-- Edit Modal para Produto -->
                    <div class="modal fade" id="modalEditProduct{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-bottom-0 pb-0">
                                    <h5 class="modal-title fw-bold">Editar Produto</h5>
                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('admin.produtos.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="formEditProduct{{ $product->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label text-muted small fw-bold">Nome</label>
                                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted small fw-bold">Preço (Kz)</label>
                                            <input type="number" name="price" class="form-control" value="{{ $product->price }}" step="0.01">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted small fw-bold">Nova Imagem (opcional)</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted small fw-bold">Descrição</label>
                                            <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" name="is_featured" id="isFeatured{{ $product->id }}" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                                            <label class="form-check-label text-muted small fw-bold" for="isFeatured{{ $product->id }}">Produto em Destaque (Home)</label>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="formEditProduct{{ $product->id }}" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($products->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Nenhum produto cadastrado.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Cadastrar Produto -->
<div class="modal fade" id="modalCadastrar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Cadastrar Novo Produto</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.produtos.store') }}" method="POST" enctype="multipart/form-data" id="formCadastrar">
                    @csrf
                    <input type="hidden" name="category" value="produto">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-bold">Nome do Produto</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Preço (Kz)</label>
                            <input type="number" name="price" class="form-control" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Imagem de Destaque</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Descrição Curta</label>
                            <textarea name="description" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Conteúdo / Detalhes (HTML permitido)</label>
                            <textarea name="content" class="form-control" rows="4" placeholder="Detalhes do serviço ou módulos do curso..."></textarea>
                            <small class="text-muted">Use este campo para adicionar informações detalhadas ou listar os módulos de um curso.</small>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_featured" id="isFeaturedNew" value="1">
                                <label class="form-check-label text-muted small fw-bold" for="isFeaturedNew">Produto em Destaque (Mostrar na Home)</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formCadastrar" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Guardar Item</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('[data-bs-target="#modalCadastrar"]') || 
    document.querySelector('.d-flex .btn-primary').setAttribute('data-bs-toggle', 'modal');
    document.querySelector('.d-flex .btn-primary').setAttribute('data-bs-target', '#modalCadastrar');
</script>
@endsection
