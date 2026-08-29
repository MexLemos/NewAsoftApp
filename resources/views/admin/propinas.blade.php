@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Propinas Mensais</h2>
        <p class="text-muted mb-0">Gestão e faturação de mensalidades recorrentes por turma.</p>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <x-export-buttons list="propinas" :extra-params="'?mes=' . $mesFiltro" />
        <form action="{{ route('admin.propinas.gerar') }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja gerar as faturas de propinas para o mês atual ({{ date('m/Y') }}) em todas as turmas ativas?')">
            @csrf
            <button type="submit" class="btn btn-warning text-dark fw-bold shadow-sm">
                <i class="fa-solid fa-bolt me-1"></i> Gerar Propinas (Mês Atual)
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <form action="{{ route('admin.propinas') }}" method="GET" class="d-flex gap-3 align-items-end">
                    <div class="flex-grow-1">
                        <label class="form-label text-muted small fw-bold">Filtrar por Mês de Referência</label>
                        <select name="mes" class="form-select">
                            @php
                                // Gerar opções de meses (ex: últimos 6 e próximos 2)
                                $meses = [];
                                for($i = -6; $i <= 2; $i++) {
                                    $m = \Carbon\Carbon::now()->addMonths($i)->format('m/Y');
                                    $meses[] = $m;
                                }
                            @endphp
                            @foreach($meses as $m)
                                <option value="{{ $m }}" {{ $mesFiltro == $m ? 'selected' : '' }}>Mês {{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary fw-bold px-4" style="background-color: var(--asoft-primary); border: none;">Filtrar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
            <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                <h2 class="fw-bold mb-0 text-primary">{{ $turmasAtivas }}</h2>
                <span class="text-muted small fw-bold">Turmas Ativas no Sistema</span>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Aluno</th>
                        <th>Turma / Curso</th>
                        <th>Valor</th>
                        <th>Limite (Vencimento)</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tuitions as $t)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $t->user->name ?? 'N/D' }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $t->turma->name ?? 'Turma N/D' }}</div>
                            <small class="text-muted">{{ $t->turma->course->title ?? '' }}</small>
                        </td>
                        <td class="fw-bold text-dark">{{ number_format($t->amount, 2, ',', '.') }} Kz</td>
                        <td>
                            @php
                                $isLate = $t->status == 'pending' && \Carbon\Carbon::parse($t->due_date)->isPast();
                            @endphp
                            <span class="badge bg-light {{ $isLate ? 'text-danger fw-bold border border-danger' : 'text-muted' }}">
                                Dia {{ \Carbon\Carbon::parse($t->due_date)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            @if($t->status == 'paid')
                                <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-check-double me-1"></i>Pago</span>
                                <div class="small text-muted mt-1" style="font-size: 0.7rem;">Ref: {{ $t->payment->reference ?? '' }}</div>
                            @else
                                @if($isLate)
                                    <span class="badge bg-danger">Inadimplente (Atrasado)</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pendente</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if($t->status == 'pending')
                                <button class="btn btn-sm btn-outline-success fw-bold" onclick="preencherPagamento({{ $t->id }}, {{ $t->user_id }}, {{ $t->amount }}, '{{ addslashes("Propina " . $mesFiltro . " - " . ($t->turma->name ?? "")) }}')" data-bs-toggle="modal" data-bs-target="#modalPagamento">
                                    <i class="fa-solid fa-money-bill-wave me-1"></i> Liquidar
                                </button>
                            @else
                                <span class="text-success small fw-bold"><i class="fa-solid fa-check"></i> Liquidado</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if($tuitions->isEmpty())
                        <tr><td colspan="6" class="text-center py-5 text-muted">Nenhuma propina registada para o mês {{ $mesFiltro }}.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- O Modal de pagamento será incluído diretamente ou reaproveitado. Para ser simples, copiamos a estrutura base do modal de pagamento e adicionamos o tuition_id -->
<div class="modal fade" id="modalPagamento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Liquidar Propina</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.pagamentos.store') }}" method="POST" id="formPagamento">
                    @csrf
                    <input type="hidden" name="tuition_id" id="modal_tuition_id">
                    <input type="hidden" name="client_id" id="modal_client_id">
                    
                    <div class="alert alert-info border-0 rounded-3 small mb-4">
                        <i class="fa-solid fa-circle-info me-1"></i> Ao liquidar esta propina, será gerado automaticamente o recibo de pagamento e um movimento de "Entrada" no Caixa.
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Data do Pagamento</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Referência (Ex: Nº Bordero)</label>
                            <input type="text" name="reference" class="form-control" placeholder="Opcional">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-bold">Serviço / Produto Consumido</label>
                            <input type="text" name="item_consumed" id="modal_item_consumed" class="form-control" readonly>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Valor a Liquidar (Kz)</label>
                            <input type="number" step="0.01" name="amount" id="modal_amount" class="form-control fw-bold text-success" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Método</label>
                            <select name="method" class="form-select" required>
                                <option value="multicaixa">Multicaixa (TPA)</option>
                                <option value="transferencia">Transferência Bancária</option>
                                <option value="dinheiro">Dinheiro Físico</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Estado</label>
                            <select name="status" class="form-select" required>
                                <option value="approved" selected>Aprovado / Liquidado</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formPagamento" class="btn btn-success fw-bold border-0"><i class="fa-solid fa-check me-1"></i> Confirmar Liquidação</button>
            </div>
        </div>
    </div>
</div>

<script>
function preencherPagamento(tuitionId, clientId, amount, description) {
    document.getElementById('modal_tuition_id').value = tuitionId;
    document.getElementById('modal_client_id').value = clientId;
    document.getElementById('modal_amount').value = amount;
    document.getElementById('modal_item_consumed').value = description;
}
</script>
@endsection
