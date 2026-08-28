@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Relatórios e Estatísticas</h2>
        <p class="text-muted mb-0">Visão geral do desempenho financeiro da empresa.</p>
    </div>
    <button class="btn btn-outline-secondary fw-bold shadow-sm" onclick="window.print()">
        <i class="fa-solid fa-print me-1"></i> Imprimir Relatório
    </button>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-muted"><i class="fa-solid fa-chart-pie me-2"></i>Resumo do Mês Atual</h5>
                
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <span class="text-muted">Total Entradas:</span>
                    <span class="fw-bold text-success">{{ number_format($mesEntradas, 2, ',', '.') }} Kz</span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <span class="text-muted">Total Saídas:</span>
                    <span class="fw-bold text-danger">{{ number_format($mesSaidas, 2, ',', '.') }} Kz</span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <span class="text-muted">Saldo do Mês:</span>
                    <span class="fw-bold {{ ($mesEntradas - $mesSaidas) >= 0 ? 'text-primary' : 'text-danger' }}">
                        {{ number_format($mesEntradas - $mesSaidas, 2, ',', '.') }} Kz
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Pagamentos Pendentes:</span>
                    <span class="fw-bold text-warning text-dark">{{ number_format($mesPendentes, 2, ',', '.') }} Kz</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold mb-0 text-muted"><i class="fa-solid fa-triangle-exclamation me-2 text-danger"></i>Alunos/Clientes Inadimplentes</h5>
                <p class="small text-muted mt-1">Clientes com pagamentos pendentes/rejeitados.</p>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive" style="max-height: 250px;">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Cliente</th>
                                <th>Valor Pendente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inadimplentes as $inad)
                            <tr>
                                <td class="fw-medium">
                                    {{ $inad->user->name ?? 'N/D' }}
                                    <div class="small text-muted">Turma: {{ $inad->turma->name ?? 'N/D' }}</div>
                                    <div class="small text-danger"><i class="fa-solid fa-calendar-xmark me-1"></i>Venceu: {{ \Carbon\Carbon::parse($inad->due_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="fw-bold text-danger">{{ number_format($inad->amount, 2, ',', '.') }} Kz</td>
                            </tr>
                            @endforeach
                            @if(count($inadimplentes) === 0)
                            <tr><td colspan="2" class="text-center py-3 text-muted">Nenhum cliente inadimplente. Bom trabalho!</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
