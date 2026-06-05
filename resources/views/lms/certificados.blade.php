@extends('layouts.lms')

@section('title', 'Meus Certificados')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center">
                <i class="fa-solid fa-certificate fs-1 text-muted opacity-50 mb-4"></i>
                <h4 class="fw-bold mb-3">Área de Certificados</h4>
                <p class="text-muted">Aqui serão listados os certificados dos cursos que concluir com sucesso.<br>Atualmente não possui nenhum certificado disponível.</p>
                
                <a href="{{ route('lms.dashboard') }}" class="btn btn-outline-primary fw-bold px-4 mt-3 rounded-pill">
                    <i class="fa-solid fa-play me-2"></i> Continuar a estudar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
