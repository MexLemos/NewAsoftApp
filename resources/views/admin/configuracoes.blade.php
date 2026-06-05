@extends('layouts.admin')

@section('content')
<form action="{{ route('admin.configuracoes.update') }}" method="POST">
    @csrf
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1 fw-bold">Configurações</h2>
            <p class="text-muted mb-0">Gerencie as definições globais da plataforma.</p>
        </div>
        <button type="submit" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">
            <i class="fa-solid fa-save me-1"></i> Salvar Alterações
        </button>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold mb-0">Informações da Empresa</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Nome da Empresa</label>
                            <input type="text" name="company_name" class="form-control" value="ASoftMedia">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Email de Contacto</label>
                            <input type="email" name="contact_email" class="form-control" value="geral@asoftmedia.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Endereço</label>
                            <input type="text" name="address" class="form-control" value="Rua Principal, Luanda, Angola">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold mb-0">Redes Sociais</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold"><i class="fa-brands fa-facebook text-primary me-1"></i> Facebook</label>
                        <input type="url" name="facebook" class="form-control" value="https://facebook.com/asoftmedia">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold"><i class="fa-brands fa-instagram text-danger me-1"></i> Instagram</label>
                        <input type="url" name="instagram" class="form-control" value="https://instagram.com/asoftmedia">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold mb-0">Aparência</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 text-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid rounded p-3 bg-light mb-2" style="max-height: 100px;">
                        <button type="button" class="btn btn-sm btn-outline-secondary d-block w-100">Alterar Logotipo</button>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="maintenanceMode">
                        <label class="form-check-label text-muted fw-bold" for="maintenanceMode">Modo de Manutenção</label>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Parceiros</h5>
                    <button type="button" class="btn btn-sm btn-light text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddPartner">
                        <i class="fa-solid fa-plus"></i> Novo
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush mb-0">
                        @foreach($partners as $partner)
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-bottom-0 mb-2 rounded bg-light p-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white rounded p-1 shadow-sm me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 40px;">
                                        @if($partner->logo_url)
                                            <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="Logo" class="img-fluid" style="max-height: 30px; object-fit: contain;">
                                        @else
                                            <i class="fa-solid fa-image text-muted"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold fs-6">{{ $partner->name }}</h6>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="event.preventDefault(); document.getElementById('delete-partner-{{ $partner->id }}').submit();">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                        @if($partners->isEmpty())
                            <div class="text-center text-muted small py-3">Nenhum parceiro cadastrado.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@foreach($partners as $partner)
    <form id="delete-partner-{{ $partner->id }}" action="{{ route('admin.parceiros.destroy', $partner->id) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<!-- Modal Novo Parceiro -->
<div class="modal fade" id="modalAddPartner" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Adicionar Parceiro</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formAddPartner" action="{{ route('admin.parceiros.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nome do Parceiro</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Logotipo da Marca</label>
                        <input type="file" name="logo" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Website (Opcional)</label>
                        <input type="url" name="website_url" class="form-control" placeholder="https://...">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formAddPartner" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Salvar Parceiro</button>
            </div>
        </div>
    </div>
</div>
@endsection
