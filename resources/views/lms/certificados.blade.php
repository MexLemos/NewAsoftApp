@extends('layouts.lms')
@section('title', 'Meus Certificados')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold mb-1">Meus Certificados</h4>
        <p class="text-muted">Aceda aos certificados dos cursos que já concluiu.</p>
    </div>
</div>
<div class="row g-4">
    @forelse($certificados as $cert)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
            <i class="fa-solid fa-award text-warning mb-3" style="font-size: 4rem;"></i>
            <h5 class="fw-bold mb-2">{{ $cert->course->title }}</h5>
            <p class="text-muted small mb-4">Concluído a {{ $cert->created_at->format('d/m/Y') }}</p>
            <a href="{{ route('lms.certificados.show', $cert->certificate_code) }}" target="_blank" class="btn btn-outline-success mt-auto w-100"><i class="fa-solid fa-eye me-2"></i> Ver Certificado</a>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fa-solid fa-certificate fs-1 text-muted mb-3 opacity-50"></i>
        <h5 class="text-muted">Ainda não possui nenhum certificado.</h5>
        <p class="text-muted small">Conclua 100% das aulas de um curso para gerar o seu certificado.</p>
    </div>
    @endforelse
</div>
@endsection
