@extends('layouts.public')

@section('title', 'Carrinho de Compras - ASoftMedia')

@section('content')
<div class="py-5" style="background-color: var(--asoft-primary); color: #fff;">
    <div class="container py-3">
        <h1 class="fw-bolder mb-0">Carrinho de Compras</h1>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    @php $total = 0; @endphp
                    @if(session('cart') && count(session('cart')) > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" colspan="2">Produto</th>
                                        <th scope="col">Preço</th>
                                        <th scope="col" class="text-center">Quantidade</th>
                                        <th scope="col" class="text-end">Subtotal</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity']; @endphp
                                        <tr>
                                            <td style="width: 80px;">
                                                <img src="{{ $details['image'] ?? 'https://images.unsplash.com/photo-1544144433-d50aff500b91?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80' }}" alt="{{ $details['name'] }}" class="img-fluid rounded">
                                            </td>
                                            <td class="fw-bold text-dark">{{ $details['name'] }}</td>
                                            <td>Kz {{ number_format($details['price'], 2, ',', '.') }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <span class="badge bg-light text-dark border px-3 py-2 fs-6">{{ $details['quantity'] }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold text-primary">Kz {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}</td>
                                            <td class="text-end">
                                                <form action="{{ route('carrinho.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa-solid fa-cart-shopping fs-1 text-muted mb-3 opacity-50"></i>
                            <h4 class="text-muted">Seu carrinho está vazio</h4>
                            <a href="{{ route('produtos') }}" class="btn btn-brand mt-3">Continuar Comprando</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Resumo do Pedido</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">Kz {{ number_format($total, 2, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Impostos (IVA 14%)</span>
                        <span class="fw-semibold">Kz {{ number_format($total * 0.14, 2, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 pb-4 border-bottom">
                        <span class="text-muted">Envio</span>
                        <span class="text-success fw-semibold">Grátis</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bolder fs-4 text-primary">Kz {{ number_format($total + ($total * 0.14), 2, ',', '.') }}</span>
                    </div>

                    @if(session('cart') && count(session('cart')) > 0)
                        @auth
                            <a href="#" class="btn btn-primary btn-lg w-100 fw-bold" style="background-color: var(--asoft-primary); border: none;">Finalizar Compra</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 fw-bold" style="background-color: var(--asoft-primary); border: none;">Login para Finalizar</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
