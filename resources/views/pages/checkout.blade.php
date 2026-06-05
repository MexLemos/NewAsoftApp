@extends('layouts.public')

@section('title', 'Finalizar Compra - ASoftMedia')

@section('content')
<div class="py-5" style="background-color: var(--asoft-primary); color: #fff;">
    <div class="container py-3">
        <h1 class="fw-bolder mb-0">Finalizar Compra</h1>
        <p class="lead opacity-75 mb-0">Preencha os seus dados para concluir o pedido.</p>
    </div>
</div>

<div class="container py-5 my-3">
    <div class="row g-5">
        <div class="col-lg-7">
            <h4 class="fw-bold mb-4">Dados de Faturação</h4>
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <form action="#" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label">Nome Próprio</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Apelido</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Endereço de E-mail</label>
                            <input type="email" class="form-control" placeholder="nome@exemplo.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Telemóvel</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Morada (Local de Entrega/Serviço)</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">NIF (Opcional)</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <h4 class="fw-bold mb-4">Resumo do Pedido</h4>
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
                @if(session('cart') && count(session('cart')) > 0)
                    @php $total = 0; @endphp
                    <ul class="list-group list-group-flush mb-4 bg-transparent">
                        @foreach(session('cart') as $id => $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <li class="list-group-item d-flex justify-content-between lh-sm bg-transparent px-0">
                                <div>
                                    <h6 class="my-0 fw-bold">{{ $item['name'] }}</h6>
                                    <small class="text-muted">Quantidade: {{ $item['quantity'] }}</small>
                                </div>
                                <span class="text-muted">{{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }} Kz</span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between bg-transparent px-0 py-3 mt-3 border-top border-dark border-opacity-10">
                            <strong class="fs-5">Total</strong>
                            <strong class="fs-5 text-primary">{{ number_format($total, 2, ',', '.') }} Kz</strong>
                        </li>
                    </ul>
                    
                    <button class="btn btn-brand btn-lg w-100 shadow rounded-pill" type="button" onclick="alert('Pedido submetido com sucesso! Entraremos em contacto para o pagamento.'); window.location='{{ route('produtos') }}'">
                        Confirmar Pedido <i class="fa-solid fa-check ms-2"></i>
                    </button>
                    <p class="text-muted small text-center mt-3"><i class="fa-solid fa-lock me-1"></i> Pagamento seguro a ser processado após confirmação.</p>
                @else
                    <p class="text-muted">O seu carrinho está vazio.</p>
                    <a href="{{ route('produtos') }}" class="btn btn-outline-primary w-100">Voltar à Loja</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
