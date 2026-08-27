@extends('layouts.lms')

@section('title', 'Meus Cursos')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Meus Cursos</h4>
            <p class="text-muted">Continue de onde parou e acompanhe o seu progresso.</p>
        </div>
        <a href="{{ route('cursos') }}" class="btn btn-outline-primary shadow-sm rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-plus me-2"></i> Adicionar Cursos
        </a>
    </div>
</div>

    <div class="row g-4">
        @forelse($enrolledCourses as $course)
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top mx-auto d-block" alt="{{ $course->title }}" style="height: 140px; object-fit: contain; background-color: #f8f9fa; width: 100%;">
                @else
                    <div class="bg-secondary bg-opacity-25 card-img-top d-flex align-items-center justify-content-center" style="height: 140px;">
                        <i class="fa-solid fa-graduation-cap text-secondary" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="card-title fw-bold">{{ $course->title }}</h5>
                    <p class="text-muted small mb-3">Progresso: {{ $course->pivot->progress_percent }}%</p>
                    <div class="progress mb-4" style="height: 8px;">
                        <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: {{ $course->pivot->progress_percent }}%;" aria-valuenow="{{ $course->pivot->progress_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @if($course->pivot->progress_percent == 0)
                        <a href="{{ route('lms.lesson', ['course' => $course->id, 'lesson' => 1]) }}" class="btn btn-brand mt-auto w-100"><i class="fa-solid fa-play me-2"></i> Começar Curso</a>
                    @elseif($course->pivot->progress_percent < 100)
                        <a href="{{ route('lms.lesson', ['course' => $course->id, 'lesson' => 1]) }}" class="btn btn-brand mt-auto w-100"><i class="fa-solid fa-play me-2"></i> Continuar assistindo</a>
                    @else
                        <div class="mt-auto d-flex flex-column gap-2">
                            <a href="{{ route('lms.lesson', ['course' => $course->id, 'lesson' => 1]) }}" class="btn btn-success w-100"><i class="fa-solid fa-check-double me-2"></i> Concluído</a>
                            <a href="{{ route('lms.certificados') }}" class="btn btn-outline-success w-100"><i class="fa-solid fa-award me-2"></i> Ver Certificado</a>
                        </div>
                    @endif
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
