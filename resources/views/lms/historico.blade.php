@extends('layouts.lms')

@section('title', 'Histórico de Compras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="fa-solid fa-bag-shopping fs-1 text-muted opacity-50 mb-4"></i>
                <h4 class="fw-bold mb-3">Histórico de Compras</h4>
                <p class="text-muted">Acompanhe as compras efetuadas, faça download de faturas e acesse os detalhes das encomendas.<br>Ainda não efetuou nenhuma compra na nossa loja.</p>
                
                <a href="{{ route('produtos') }}" class="btn btn-primary fw-bold px-4 mt-3 rounded-pill" style="background-color: var(--asoft-primary); border: none;">
                    <i class="fa-solid fa-store me-2"></i> Ir para a Loja
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
