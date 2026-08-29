@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Movimentos de Caixa</h2>
        <p class="text-muted mb-0">Controlo financeiro de entradas e saídas da empresa.</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <x-export-buttons list="caixa" />
        <button class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;" data-bs-toggle="modal" data-bs-target="#modalCaixa">
            <i class="fa-solid fa-plus me-1"></i> Registar Movimento
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-success bg-opacity-10">
            <div class="card-body p-4">
                <div class="text-success small fw-bold mb-1"><i class="fa-solid fa-arrow-up me-1"></i> Total Entradas</div>
                <h3 class="mb-0 fw-bold text-success">{{ number_format($totalEntradas, 2, ',', '.') }} Kz</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-danger bg-opacity-10">
            <div class="card-body p-4">
                <div class="text-danger small fw-bold mb-1"><i class="fa-solid fa-arrow-down me-1"></i> Total Saídas</div>
                <h3 class="mb-0 fw-bold text-danger">{{ number_format($totalSaidas, 2, ',', '.') }} Kz</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 {{ $saldo >= 0 ? 'bg-primary' : 'bg-danger' }} text-white">
            <div class="card-body p-4">
                <div class="small fw-bold mb-1 text-white-50"><i class="fa-solid fa-scale-balanced me-1"></i> Saldo Atual</div>
                <h3 class="mb-0 fw-bold">{{ number_format($saldo, 2, ',', '.') }} Kz</h3>
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
                        <th class="ps-4">Data</th>
                        <th>Tipo</th>
                        <th>Descrição / Referência</th>
                        <th>Valor (AOA)</th>
                        <th class="text-end pe-4">Funcionário</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movements as $mov)
                    <tr>
                        <td class="ps-4 text-muted">{{ \Carbon\Carbon::parse($mov->date)->format('d/m/Y') }}</td>
                        <td>
                            @if($mov->type == 'in')
                                <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-arrow-up me-1"></i>Entrada</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger"><i class="fa-solid fa-arrow-down me-1"></i>Saída</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $mov->description }}</div>
                            @if($mov->reference)
                                <small class="text-muted"><i class="fa-solid fa-hashtag me-1"></i>{{ $mov->reference }}</small>
                            @endif
                        </td>
                        <td class="fw-bold {{ $mov->type == 'in' ? 'text-success' : 'text-danger' }}">
                            {{ $mov->type == 'in' ? '+' : '-' }} {{ number_format($mov->amount, 2, ',', '.') }} Kz
                        </td>
                        <td class="text-end pe-4 small text-muted">{{ $mov->employee->name ?? 'Sistema' }}</td>
                    </tr>
                    @endforeach
                    @if($movements->isEmpty())
                        <tr><td colspan="5" class="text-center py-4 text-muted">Nenhum movimento registado no caixa.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Registar Movimento -->
<div class="modal fade" id="modalCaixa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Registar Movimento</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.caixa.store') }}" method="POST" id="formCaixa">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Data</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Tipo de Movimento</label>
                            <select name="type" class="form-select fw-bold" required>
                                <option value="in" class="text-success">Entrada (Receita)</option>
                                <option value="out" class="text-danger">Saída (Despesa)</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-bold">Valor (Kz)</label>
                            <input type="number" step="0.01" name="amount" class="form-control fw-bold" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Descrição</label>
                            <input type="text" name="description" class="form-control" placeholder="Ex: Pagamento da Fatura de Internet, Compra de Tinteiros..." required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Referência / Nº Fatura (Opcional)</label>
                            <input type="text" name="reference" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formCaixa" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Salvar Movimento</button>
            </div>
        </div>
    </div>
</div>
@endsection
