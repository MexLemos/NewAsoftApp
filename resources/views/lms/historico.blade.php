@extends('layouts.lms')

@section('title', 'Histórico de Compras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <i class="fa-solid fa-bag-shopping fs-3 text-primary me-3"></i>
                    <h4 class="fw-bold mb-0">O Meu Histórico de Compras</h4>
                </div>
                
                @if($purchases->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Pedido ID</th>
                                    <th>Data</th>
                                    <th>Resumo do Pedido</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchases as $purchase)
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">#ORD-{{ str_pad($purchase->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="text-muted">{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="small text-dark" style="white-space: pre-line; max-width: 400px; font-family: monospace;">
                                            {{ \Illuminate\Support\Str::limit(preg_replace('/--- NOVO PEDIDO DE COMPRA ---\n.*?\n.*?\n.*?\n\nITENS:\n/', '', $purchase->message), 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($purchase->status === 'new')
                                            <span class="badge bg-warning text-dark">Pendente</span>
                                        @elseif($purchase->status === 'qualified')
                                            <span class="badge bg-success">Aprovado</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $purchase->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa-solid fa-box-open fs-1 text-muted opacity-50 mb-4"></i>
                        <h5 class="text-muted">Ainda não efetuou nenhuma compra na nossa loja.</h5>
                        <a href="{{ route('produtos') }}" class="btn btn-primary fw-bold px-4 mt-3 rounded-pill" style="background-color: var(--asoft-primary); border: none;">
                            <i class="fa-solid fa-store me-2"></i> Ir para a Loja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
