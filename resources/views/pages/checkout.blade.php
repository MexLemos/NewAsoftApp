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
                <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                    @csrf
                    <div class="row g-3">
                        @php
                            $user = auth()->user();
                            $firstName = '';
                            $lastName = '';
                            if ($user) {
                                $nameParts = explode(' ', $user->name);
                                $firstName = $nameParts[0];
                                $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
                            }
                        @endphp
                        <div class="col-sm-6">
                            <label class="form-label">Nome Próprio</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $firstName }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Apelido</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $lastName }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Endereço de E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="nome@exemplo.com" value="{{ $user->email ?? '' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Telemóvel</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Morada (Local de Entrega/Serviço)</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">NIF (Opcional)</label>
                            <input type="text" name="nif" class="form-control">
                        </div>
                        <div class="col-12 mt-4">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Forma de Pagamento</h5>
                            <div class="form-check mb-3 p-3 border rounded shadow-sm">
                                <input class="form-check-input ms-1" type="radio" name="payment_method" id="payBank" value="Transferência Bancária" checked>
                                <label class="form-check-label ms-2 w-100" for="payBank">
                                    <strong>Transferência Bancária</strong>
                                    <div class="text-muted small mt-1">IBAN Fictício: AO06.0000.0000.0000.0000.0000.0</div>
                                </label>
                            </div>
                            <div class="form-check mb-3 p-3 border rounded shadow-sm">
                                <input class="form-check-input ms-1" type="radio" name="payment_method" id="payTPA" value="Pagamento por Referência / TPA">
                                <label class="form-check-label ms-2 w-100" for="payTPA">
                                    <strong>Pagamento por Referência / TPA</strong>
                                    <div class="text-muted small mt-1">Pague através de qualquer Multicaixa usando a referência da empresa.</div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Comprovativo de Pagamento</h5>
                            <label class="form-label text-muted small">Anexe aqui o PDF ou Imagem do seu comprovativo para aprovação do pedido.</label>
                            <input type="file" name="proof" class="form-control" accept="image/*,.pdf" required>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <h4 class="fw-bold mb-4">Resumo do Pedido</h4>
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
                @if(session('cart') && count(session('cart')) > 0)
                    @php 
                        $total = 0; 
                        $hasProducts = false;
                    @endphp
                    <ul class="list-group list-group-flush mb-4 bg-transparent">
                        @foreach(session('cart') as $id => $item)
                            @php 
                                $total += $item['price'] * $item['quantity']; 
                                if (!str_starts_with((string)$id, 'course_') && !str_starts_with((string)$id, 'plan_')) {
                                    $hasProducts = true;
                                }
                            @endphp
                            <li class="list-group-item d-flex justify-content-between lh-sm bg-transparent px-0">
                                <div>
                                    <h6 class="my-0 fw-bold">{{ $item['name'] }}</h6>
                                    <small class="text-muted">Quantidade: {{ $item['quantity'] }}</small>
                                </div>
                                <span class="text-muted">{{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }} Kz</span>
                            </li>
                        @endforeach
                        
                        @if($hasProducts)
                        <li class="list-group-item bg-transparent px-0 pt-4 pb-2 border-top border-dark border-opacity-10 mt-3">
                            <h6 class="fw-bold mb-3">Modo de Entrega</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input delivery-radio" type="radio" name="delivery_mode" id="deliveryYes" value="delivery" form="checkoutForm" checked>
                                <label class="form-check-label w-100 d-flex justify-content-between" for="deliveryYes">
                                    <span>Entrega ao domicílio</span>
                                    <span>3.000,00 Kz</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input delivery-radio" type="radio" name="delivery_mode" id="deliveryNo" value="pickup" form="checkoutForm">
                                <label class="form-check-label w-100 d-flex justify-content-between" for="deliveryNo">
                                    <span>Levantamento Presencial (Loja)</span>
                                    <span class="text-success">Grátis</span>
                                </label>
                            </div>
                        </li>
                        @endif

                        <li class="list-group-item d-flex justify-content-between lh-sm bg-transparent px-0 pt-3 border-top">
                            <div>
                                <h6 class="my-0 text-muted">Taxa de Entrega / Deslocação</h6>
                            </div>
                            <span class="text-muted" id="taxDisplay">
                                @if($hasProducts) 3.000,00 Kz @else 0,00 Kz @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-transparent px-0 py-3 mt-2 border-top border-dark border-opacity-10">
                            <strong class="fs-5">Total</strong>
                            <strong class="fs-5 text-primary" id="totalDisplay">
                                {{ number_format($total + ($hasProducts ? 3000 : 0), 2, ',', '.') }} Kz
                            </strong>
                        </li>
                    </ul>
                    
                    <button id="btnSubmit" class="btn btn-brand btn-lg w-100 shadow rounded-pill" type="submit" form="checkoutForm">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkoutForm');
        if (form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('btnSubmit');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> A processar pedido...';
                }
            });
        }

        // Logic for dynamic pricing update
        const deliveryRadios = document.querySelectorAll('.delivery-radio');
        const taxDisplay = document.getElementById('taxDisplay');
        const totalDisplay = document.getElementById('totalDisplay');
        const baseTotal = {{ $total ?? 0 }};
        const hasProducts = {{ isset($hasProducts) && $hasProducts ? 'true' : 'false' }};
        
        function formatMoney(amount) {
            return amount.toLocaleString('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Kz';
        }

        if (hasProducts && deliveryRadios.length > 0) {
            deliveryRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    let tax = this.value === 'delivery' ? 3000 : 0;
                    taxDisplay.innerHTML = formatMoney(tax);
                    totalDisplay.innerHTML = formatMoney(baseTotal + tax);
                });
            });
        }
    });
</script>
@endsection
