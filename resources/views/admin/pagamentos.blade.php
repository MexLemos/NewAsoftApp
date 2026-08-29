@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Pagamentos (CRM)</h2>
        <p class="text-muted mb-0">Gestão de recebimentos, mensalidades e faturas.</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <x-export-buttons list="pagamentos" />
        <button class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;" data-bs-toggle="modal" data-bs-target="#modalPagamento">
            <i class="fa-solid fa-plus me-1"></i> Registar Pagamento
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Data</th>
                        <th>Ref. / Descrição</th>
                        <th>Cliente / Aluno</th>
                        <th>Item Consumido</th>
                        <th>Método</th>
                        <th>Valor (AOA)</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Registado por</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $pay)
                    <tr>
                        <td class="ps-4 text-muted">{{ \Carbon\Carbon::parse($pay->date)->format('d/m/Y') }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $pay->reference }}</div>
                            <small class="text-muted">{{ Str::limit($pay->observation, 30) }}</small>
                        </td>
                        <td class="fw-medium">{{ $pay->client->name ?? 'N/D' }}</td>
                        <td><span class="text-primary fw-medium">{{ $pay->item_consumed ?? 'N/D' }}</span></td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary text-uppercase">{{ $pay->method }}</span></td>
                        <td class="fw-bold">{{ number_format($pay->amount, 2, ',', '.') }} Kz</td>
                        <td>
                            @if($pay->status == 'approved')
                                <span class="badge bg-success">Aprovado</span>
                            @elseif($pay->status == 'pending')
                                <span class="badge bg-warning text-dark">Pendente</span>
                            @else
                                <span class="badge bg-danger">Rejeitado</span>
                            @endif
                        </td>
                        <td class="text-end pe-4 small text-muted">{{ $pay->employee->name ?? 'Sistema' }}</td>
                    </tr>
                    @endforeach
                    @if($payments->isEmpty())
                        <tr><td colspan="7" class="text-center py-4 text-muted">Nenhum pagamento registado.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Registar Pagamento -->
<div class="modal fade" id="modalPagamento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Registo Manual de Pagamento</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.pagamentos.store') }}" method="POST" id="formPagamento">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Data do Pagamento</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Referência / Fatura (Opcional)</label>
                            <input type="text" name="reference" class="form-control" placeholder="Ex: FT 2023/123">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-bold">Cliente / Aluno</label>
                            <select name="client_id" class="form-select" required>
                                <option value="" disabled selected>Selecione um cliente...</option>
                                @foreach($clients as $cli)
                                    <option value="{{ $cli->id }}">{{ $cli->name }} ({{ $cli->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-bold">Serviço / Produto Consumido</label>
                            <select name="item_consumed" class="form-select" required>
                                <option value="" disabled selected>Selecione o que foi consumido...</option>
                                <optgroup label="Cursos / Formações">
                                    @foreach($courses as $course)
                                        <option value="Curso: {{ $course->title }}">Curso: {{ $course->title }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Serviços (TI / Consultoria)">
                                    @foreach($services as $service)
                                        <option value="Serviço: {{ $service->title }}">Serviço: {{ $service->title }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Produtos (Loja)">
                                    @foreach($products as $product)
                                        <option value="Produto: {{ $product->name }}">Produto: {{ $product->name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Outros">
                                    <option value="Outro (Mensalidade Personalizada)">Outro (Mensalidade Personalizada)</option>
                                    <option value="Pagamento Diversos">Pagamento Diversos</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Valor (Kz)</label>
                            <input type="number" step="0.01" name="amount" class="form-control fw-bold text-success" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Método</label>
                            <select name="method" class="form-select" required>
                                <option value="multicaixa">Multicaixa (TPA)</option>
                                <option value="transferencia">Transferência Bancária</option>
                                <option value="dinheiro">Dinheiro Físico</option>
                                <option value="online">Pagamento Online</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Estado</label>
                            <select name="status" class="form-select" required>
                                <option value="approved" selected>Aprovado / Liquidado</option>
                                <option value="pending">Pendente (A aguardar verificação)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Observações (Descrição do Serviço/Curso)</label>
                            <textarea name="observation" class="form-control" rows="2" placeholder="Ex: Mensalidade de Novembro - Curso de Inglês"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 pe-4 pb-4">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formPagamento" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Salvar Pagamento</button>
            </div>
        </div>
    </div>
</div>
@endsection
