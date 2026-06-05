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
        @forelse($enrolledCourses as $course)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top" alt="{{ $course->title }}" style="height: 180px; object-fit: cover;">
                @else
                    <div class="bg-secondary bg-opacity-25 card-img-top d-flex align-items-center justify-content-center" style="height: 180px;">
                        <i class="fa-solid fa-graduation-cap text-secondary" style="font-size: 4rem;"></i>
                    </div>
                @endif
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="card-title fw-bold">{{ $course->title }}</h5>
                    <p class="text-muted small mb-3">Progresso: {{ $course->pivot->progress_percent }}%</p>
                    <div class="progress mb-4" style="height: 8px;">
                        <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: {{ $course->pivot->progress_percent }}%;" aria-valuenow="{{ $course->pivot->progress_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <a href="{{ route('lms.lesson', ['course' => $course->id, 'lesson' => 1]) }}" class="btn btn-brand mt-auto w-100"><i class="fa-solid fa-play me-2"></i> Continuar Aula</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fa-solid fa-box-open fs-1 text-muted mb-3 opacity-50"></i>
            <h5 class="text-muted">Ainda não está inscrito em nenhum curso.</h5>
            <a href="{{ route('cursos') }}" class="btn btn-primary mt-3">Explorar Catálogo</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
