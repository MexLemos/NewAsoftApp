@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="h3 mb-1 fw-bold">Notificações, Leads & Tráfego</h2>
        <p class="text-muted mb-0">Gestão de pedidos, mensagens de contacto e acessos em tempo real ao site.</p>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form action="{{ route('admin.leads.read_all') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold">
                <i class="fa-solid fa-check-double me-1"></i> Marcar Todas como Lidas
            </button>
        </form>

        <div class="dropdown">
            <button class="btn btn-outline-danger btn-sm rounded-pill fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-trash-can me-1"></i> Excluir Notificações
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                <li>
                    <form action="{{ route('admin.leads.bulk_destroy') }}" method="POST" onsubmit="return confirm('Deseja excluir todas as notificações/pedidos já qualificados e concluídos?')">
                        @csrf
                        <input type="hidden" name="clear_all" value="qualified">
                        <button type="submit" class="dropdown-item text-danger small">
                            <i class="fa-solid fa-check me-2"></i> Excluir Aprovadas / Concluídas
                        </button>
                    </form>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('admin.leads.bulk_destroy') }}" method="POST" onsubmit="return confirm('ATENÇÃO: Tem a certeza que deseja excluir TODAS as notificações e leads do sistema? Esta ação é irreversível!')">
                        @csrf
                        <input type="hidden" name="clear_all" value="all">
                        <button type="submit" class="dropdown-item text-danger fw-bold small">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> Excluir TODAS as Notificações
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4 rounded-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4 rounded-4" role="alert">
        <i class="fa-solid fa-circle-exmark me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
@media print {
    body * { visibility: hidden; }
    .modal.show .modal-content, .modal.show .modal-content * { visibility: visible; }
    .modal.show { position: absolute; left: 0; top: 0; margin: 0; padding: 0; width: 100%; }
    .modal-footer { display: none !important; }
}
</style>

<!-- Métricas de Leads & CRM -->
<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary bg-opacity-10">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="text-primary fw-bold mb-0">Novas Notificações (Hoje)</h6>
                    <i class="fa-solid fa-bell text-primary fs-5"></i>
                </div>
                <h2 class="fw-bolder text-primary mb-0">{{ $leadsHoje }}</h2>
                <small class="text-muted">Mensagens e encomendas recebidas hoje</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="text-muted fw-bold mb-0">Total de Contactos / Leads</h6>
                    <i class="fa-solid fa-address-book text-muted fs-5"></i>
                </div>
                <h2 class="fw-bolder mb-0">{{ $totalLeads }}</h2>
                <small class="text-muted">Base total de leads acumuladas</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="text-muted fw-bold mb-0">Taxa de Conversão</h6>
                    <i class="fa-solid fa-chart-line text-success fs-5"></i>
                </div>
                <h2 class="fw-bolder text-success mb-0">{{ $taxaConversao }}%</h2>
                <small class="text-muted">{{ $leadsQualificados }} pedidos aprovados / convertidos</small>
            </div>
        </div>
    </div>
</div>

<!-- Métricas de Tráfego e Acessos ao Site -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-bold small text-uppercase"><i class="fa-solid fa-globe me-1 text-primary"></i> Total Acessos</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary">Global</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalAcessos, 0, ',', '.') }}</h3>
                <small class="text-muted">Visualizações totais de páginas</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-bold small text-uppercase"><i class="fa-solid fa-calendar-day me-1 text-success"></i> Acessos Hoje</span>
                    <span class="badge bg-success bg-opacity-10 text-success">Hoje</span>
                </div>
                <h3 class="fw-bold mb-0 text-success">{{ number_format($acessosHoje, 0, ',', '.') }}</h3>
                <small class="text-muted">Visitas no dia de hoje</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-bold small text-uppercase"><i class="fa-solid fa-calendar-week me-1 text-warning"></i> Últimos 7 Dias</span>
                    <span class="badge bg-warning bg-opacity-10 text-dark">7 Dias</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark">{{ number_format($acessosSemana ?? 0, 0, ',', '.') }}</h3>
                <small class="text-muted">Acessos nesta semana</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted fw-bold small text-uppercase"><i class="fa-solid fa-users-viewfinder me-1 text-info"></i> Visitantes Únicos</span>
                    <span class="badge bg-info bg-opacity-10 text-info">IPs</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark">{{ number_format($visitantesUnicos, 0, ',', '.') }}</h3>
                <small class="text-muted">Endereços IP únicos rastreados</small>
            </div>
        </div>
    </div>
</div>

<!-- Painel de Tráfego Recente em Tempo Real (Transparência de Acessos) -->
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-chart-line text-primary me-2"></i>Últimos Acessos ao Site (Tempo Real)</h5>
                    <small class="text-muted">
                        Última visita registada: 
                        <b class="text-dark">{{ $ultimaVisita ? $ultimaVisita->created_at->diffForHumans() : 'Aguardando visitas...' }}</b>
                        @if($ultimaVisita) ({{ $ultimaVisita->created_at->format('d/m/Y H:i:s') }}) @endif
                    </small>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <a href="{{ route('admin.leads') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Atualizar dados de tráfego">
                        <i class="fa-solid fa-arrows-rotate me-1"></i> Atualizar
                    </a>
                    <form action="{{ route('admin.visitas.reset') }}" method="POST" onsubmit="return confirm('Deseja zerar o histórico de visitas ao site? (Recomendado se quiser reiniciar o contador do zero)')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light text-muted border-0" title="Limpar registos de acessos">
                            <i class="fa-solid fa-rotate-left"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body px-0 pb-0 mt-3">
                <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="ps-4">Página (Rota)</th>
                                <th>Endereço IP</th>
                                <th>Dispositivo / Navegador</th>
                                <th class="text-end pe-4">Data & Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVisits as $visit)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold font-monospace">{{ $visit->path ?: '/' }}</span>
                                </td>
                                <td>
                                    <span class="font-monospace text-muted">{{ $visit->ip }}</span>
                                </td>
                                <td>
                                    @if($visit->device === 'Telemóvel')
                                        <i class="fa-solid fa-mobile-screen-button text-muted me-1"></i>
                                    @else
                                        <i class="fa-solid fa-laptop text-muted me-1"></i>
                                    @endif
                                    {{ $visit->device }} &bull; {{ $visit->browser }}
                                </td>
                                <td class="text-end pe-4 text-muted">
                                    {{ $visit->created_at->format('d/m H:i:s') }}
                                    <small class="d-block text-muted opacity-75" style="font-size: 0.72rem;">{{ $visit->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    Nenhum acesso gravado ainda. As visitas às páginas públicas aparecerão aqui automaticamente.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-fire text-danger me-2"></i>Top Páginas Mais Visitadas</h5>
                <small class="text-muted">Distribuição de visualizações</small>
            </div>
            <div class="card-body p-4">
                @forelse($topPages as $page)
                    @php
                        $maxTop = $topPages->max('total') ?: 1;
                        $pct = round(($page->total / $maxTop) * 100);
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold font-monospace small text-truncate" style="max-width: 180px;">{{ $page->path ?: '/' }}</span>
                            <span class="badge bg-secondary rounded-pill">{{ number_format($page->total, 0, ',', '.') }} visitas</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $pct }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">
                        Sem dados suficientes para o ranking de páginas.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Tabela de Notificações / Leads -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-0">Lista de Notificações & Mensagens</h5>
            <small class="text-muted">Mensagens enviadas pelo site e encomendas recebidas</small>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" form="bulkForm" class="btn btn-sm btn-outline-danger rounded-pill fw-bold" id="btnDeleteSelected" style="display: none;">
                <i class="fa-solid fa-trash-can me-1"></i> Excluir Selecionadas
            </button>
        </div>
    </div>
    <div class="card-body px-0 pb-0 mt-3">
        <form action="{{ route('admin.leads.bulk_destroy') }}" method="POST" id="bulkForm" onsubmit="return confirm('Tem a certeza que deseja excluir as notificações selecionadas?')">
            @csrf
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 40px;">
                                <input type="checkbox" class="form-check-input" id="checkAllLeads" title="Selecionar todas">
                            </th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Assunto / Resumo</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                        <tr class="{{ $lead->status === 'new' ? 'bg-primary bg-opacity-10' : '' }}">
                            <td class="ps-4">
                                <input type="checkbox" name="ids[]" value="{{ $lead->id }}" class="form-check-input lead-check">
                            </td>
                            <td class="fw-medium">
                                {{ $lead->name }}
                                @if(str_contains($lead->message, 'PEDIDO DE COMPRA'))
                                    <span class="badge bg-success bg-opacity-10 text-success ms-1 small">Pedido</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $lead->email }}</td>
                            <td>{{ Str::limit($lead->message, 40) }}</td>
                            <td class="text-muted small">
                                {{ $lead->created_at->format('d/m/Y H:i') }}
                                <small class="d-block text-muted opacity-75">{{ $lead->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                @if($lead->status === 'new')
                                    <span class="badge bg-warning text-dark">Novo / Pendente</span>
                                @elseif($lead->status === 'qualified')
                                    <span class="badge bg-success">Aprovado / Qualificado</span>
                                @elseif($lead->status === 'contacted')
                                    <span class="badge bg-info">Visualizado</span>
                                @else
                                    <span class="badge bg-secondary">{{ $lead->status }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalLead{{ $lead->id }}">
                                    Ver Detalhes
                                </button>
                                
                                {{-- Formulário de Exclusão Individual --}}
                                <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem a certeza que deseja excluir a notificação de {{ addslashes($lead->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-1" title="Excluir Notificação">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-bell-slash fa-3x mb-3 d-block opacity-25"></i>
                                Nenhuma notificação ou lead registada.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<!-- Modais Detalhes Lead (Renderizados fora do corpo da tabela para evitar problemas de z-index) -->
@foreach($leads as $lead)
<div class="modal fade" id="modalLead{{ $lead->id }}" tabindex="-1" aria-labelledby="modalLeadLabel{{ $lead->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalLeadLabel{{ $lead->id }}">Detalhes do Pedido / Notificação</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small fw-bold">Telemóvel</label>
                        <p class="mb-0">{{ $lead->phone ?: 'Não informado' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small fw-bold">Data de Envio</label>
                        <p class="mb-0">{{ $lead->created_at->format('d/m/Y H:i:s') }} ({{ $lead->created_at->diffForHumans() }})</p>
                    </div>
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
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4 d-flex justify-content-between flex-wrap gap-2">
                <div>
                    {{-- Botão Excluir Notificação no Modal --}}
                    <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem a certeza que deseja excluir esta notificação/lead de {{ addslashes($lead->name) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger fw-bold">
                            <i class="fa-solid fa-trash me-1"></i> Excluir Notificação
                        </button>
                    </form>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-secondary fw-bold" onclick="window.print()"><i class="fa-solid fa-download me-1"></i> Imprimir</button>
                    
                    @if($proofUrl)
                        <a href="{{ $proofUrl }}" target="_blank" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;"><i class="fa-solid fa-file-invoice-dollar me-1"></i> Ver Comprovativo</a>
                    @endif
                    
                    @if(str_contains($lead->message, 'PEDIDO DE COMPRA') && $lead->status !== 'qualified')
                        <form action="{{ route('admin.leads.approve_courses', $lead->id) }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="btn btn-success fw-bold"><i class="fa-solid fa-check me-1"></i> Aprovar Pedido</button>
                        </form>
                    @endif

                    <a href="mailto:{{ $lead->email }}?subject=Contacto%20ASoftMedia:%20Referente%20ao%20seu%20pedido/submissão" class="btn btn-info fw-bold text-white shadow-sm"><i class="fa-solid fa-reply me-1"></i> Responder</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('checkAllLeads');
    const leadChecks = document.querySelectorAll('.lead-check');
    const btnDeleteSelected = document.getElementById('btnDeleteSelected');

    function updateDeleteButton() {
        const checkedCount = document.querySelectorAll('.lead-check:checked').length;
        if (checkedCount > 0) {
            btnDeleteSelected.style.display = 'inline-block';
            btnDeleteSelected.innerHTML = '<i class="fa-solid fa-trash-can me-1"></i> Excluir (' + checkedCount + ')';
        } else {
            btnDeleteSelected.style.display = 'none';
        }
    }

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            leadChecks.forEach(cb => cb.checked = checkAll.checked);
            updateDeleteButton();
        });
    }

    leadChecks.forEach(cb => {
        cb.addEventListener('change', function() {
            updateDeleteButton();
            if (!this.checked && checkAll) {
                checkAll.checked = false;
            }
        });
    });
});
</script>
@endsection
