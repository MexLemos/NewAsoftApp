@extends('layouts.public')

@section('title', 'Meus Cursos - Área do Aluno')

@section('content')
<div class="py-4" style="background-color: var(--asoft-primary); color: #fff;">
    <div class="container">
        <h2 class="fw-bold mb-0">Área do Aluno</h2>
        <p class="mb-0 opacity-75">Bem-vindo de volta, {{ Auth::user()->name }}!</p>
    </div>
</div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Meus Cursos</h4>
        <a href="{{ route('cursos') }}" class="btn btn-outline-primary">Navegar por mais cursos</a>
    </div>

    <div class="row g-4">
        <!-- Enrolled Course Dummy -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="ReactJS" style="height: 180px; object-fit: cover;">
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="card-title fw-bold">Front-End com ReactJS</h5>
                    <p class="text-muted small mb-3">Progresso: 45%</p>
                    <div class="progress mb-4" style="height: 8px;">
                        <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <a href="{{ route('lms.lesson', ['course' => 1, 'lesson' => 1]) }}" class="btn btn-brand mt-auto w-100"><i class="fa-solid fa-play me-2"></i> Continuar Aula</a>
                </div>
            </div>
        </div>

        <!-- Enrolled Course Dummy 2 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="PHP" style="height: 180px; object-fit: cover;">
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="card-title fw-bold">Programação Web (PHP + MySQL)</h5>
                    <p class="text-muted small mb-3">Progresso: 10%</p>
                    <div class="progress mb-4" style="height: 8px;">
                        <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <a href="{{ route('lms.lesson', ['course' => 2, 'lesson' => 1]) }}" class="btn btn-brand mt-auto w-100"><i class="fa-solid fa-play me-2"></i> Continuar Aula</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
