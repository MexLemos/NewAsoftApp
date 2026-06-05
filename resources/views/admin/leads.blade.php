@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Leads & CRM</h2>
        <p class="text-muted mb-0">Gestão de potenciais clientes e contactos gerados no site.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary bg-opacity-10">
            <div class="card-body">
                <h6 class="text-primary fw-bold mb-1">Novas Leads (Hoje)</h6>
                <h2 class="fw-bolder text-primary mb-0">12</h2>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <h6 class="text-muted fw-bold mb-1">Total de Contactos</h6>
                <h2 class="fw-bolder mb-0">348</h2>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <h6 class="text-muted fw-bold mb-1">Taxa de Conversão</h6>
                <h2 class="fw-bolder text-success mb-0">14.5%</h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
        <h5 class="fw-bold mb-0">Lista de Contactos Recentes</h5>
    </div>
    <div class="card-body px-0 pb-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nome</th>
                        <th>Email</th>
                        <th>Assunto / Interesse</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-medium">Carlos Mendes</td>
                        <td class="text-muted">carlos.m@example.com</td>
                        <td>Consultoria TI</td>
                        <td class="text-muted small">Hoje, 14:30</td>
                        <td><span class="badge bg-warning text-dark">Pendente</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalLead">Ver Detalhes</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-medium">Ana Rita</td>
                        <td class="text-muted">ana.rita@example.com</td>
                        <td>Curso de React</td>
                        <td class="text-muted small">Ontem, 09:15</td>
                        <td><span class="badge bg-info">Em Contacto</span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalLead">Ver Detalhes</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detalhes Lead -->
<div class="modal fade" id="modalLead" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Detalhes da Lead</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Nome</label>
                    <p class="mb-0 fw-medium">Exemplo Lead</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Email</label>
                    <p class="mb-0">lead@example.com</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Interesse</label>
                    <p class="mb-0">Consultoria TI</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold">Mensagem</label>
                    <div class="p-3 bg-light rounded mt-1 text-muted small">
                        "Gostaria de saber mais informações sobre a implementação de redes para o meu escritório..."
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;" data-bs-dismiss="modal">Marcar como Contactado</button>
            </div>
        </div>
    </div>
</div>
@endsection
