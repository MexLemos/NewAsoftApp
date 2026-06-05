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
            <div class="card border-0 shadow-sm rounded-4">
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
        </div>
    </div>
</form>
@endsection
