@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Leads & CRM</h2>
        <p class="text-muted mb-0">Gestão de potenciais clientes e contactos gerados no site.</p>
    </div>
</div>

<div class="row g-4 mb-4">
<style>
@media print {
    body * { visibility: hidden; }
    .modal.show .modal-content, .modal.show .modal-content * { visibility: visible; }
    .modal.show { position: absolute; left: 0; top: 0; margin: 0; padding: 0; width: 100%; }
    .modal-footer { display: none !important; }
}
</style>
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
                <h2 class="fw-bolder mb-0">{{ $leads->count() }}</h2>
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
                    @foreach($leads as $lead)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $lead->name }}</td>
                        <td class="text-muted">{{ $lead->email }}</td>
                        <td>{{ Str::limit($lead->message, 40) }}</td>
                        <td class="text-muted small">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($lead->status === 'new')
                                <span class="badge bg-warning text-dark">Novo / Pendente</span>
                            @elseif($lead->status === 'qualified')
                                <span class="badge bg-success">Aprovado / Qualificado</span>
                            @else
                                <span class="badge bg-secondary">{{ $lead->status }}</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalLead{{ $lead->id }}">Ver Detalhes</button>
                        </td>
                    </tr>

                    <!-- Modal Detalhes Lead -->
                    <div class="modal fade" id="modalLead{{ $lead->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-bottom-0 pb-0">
                                    <h5 class="modal-title fw-bold">Detalhes do Pedido / Contacto</h5>
                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small fw-bold">Nome</label>
                                            <p class="mb-0 fw-medium">{{ $lead->name }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small fw-bold">Email</label>
                                            <p class="mb-0">{{ $lead->email }}</p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted small fw-bold">Telemóvel</label>
                                        <p class="mb-0">{{ $lead->phone }}</p>
                                    </div>
                                    @php
                                        $messageDisplay = $lead->message;
                                        $proofUrl = '';
                                        if(preg_match('/COMPROVATIVO:\s*([^\s]+)/', $messageDisplay, $matches)) {
                                            $proofUrl = $matches[1];
                                            $messageDisplay = preg_replace('/COMPROVATIVO:\s*([^\s]+)/', '', $messageDisplay);
                                        }
                                    @endphp
                                    <div class="mb-3">
                                        <label class="text-muted small fw-bold">Mensagem / Resumo do Pedido</label>
                                        <div class="p-3 bg-light rounded mt-1 text-dark" style="white-space: pre-line; font-family: monospace;">
                                            {!! nl2br(e(trim($messageDisplay))) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-outline-secondary fw-bold" onclick="window.print()"><i class="fa-solid fa-download me-2"></i>Baixar Detalhes</button>
                                    
                                    @if($proofUrl)
                                        <a href="{{ $proofUrl }}" target="_blank" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;"><i class="fa-solid fa-file-invoice-dollar me-2"></i>Ver Comprovativo</a>
                                    @endif
                                    
                                    @if(str_contains($lead->message, 'PEDIDO DE COMPRA') && $lead->status !== 'qualified')
                                        <form action="{{ route('admin.leads.approve_courses', $lead->id) }}" method="POST" class="m-0 p-0">
                                            @csrf
                                            <button type="submit" class="btn btn-success fw-bold"><i class="fa-solid fa-check me-2"></i>Aprovar Pagamento e Liberar Cursos</button>
                                        </form>
                                    @endif

                                    <a href="mailto:{{ $lead->email }}?subject=Contacto%20ASoftMedia:%20Referente%20ao%20seu%20pedido/submissão" class="btn btn-info fw-bold text-white shadow-sm"><i class="fa-solid fa-reply me-2"></i>Responder por Email</a>
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
@endsection
