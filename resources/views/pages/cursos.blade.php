@extends('layouts.public')

@section('title', 'Treinamentos e Cursos - ASoftMedia')

@section('content')
<!-- Page Header -->
<div class="py-5 position-relative" style="background-image: url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(15, 23, 42, 0.85);"></div>
    <div class="container py-5 text-center position-relative z-1 text-white">
        <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">Melhor Plataforma de Cursos {{ date('Y') }}</span>
        <h1 class="display-4 fw-bolder mb-3 text-white">Transforme sua Carreira<br>com Nossos Cursos Profissionais</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 700px; color: #fff;">Aprenda com especialistas do mercado de modo híbrido (presencial e online). Agende as suas aulas práticas e interaja com nossa comunidade.</p>
    </div>
</div>

<div class="container py-5 mt-n5 position-relative z-2">
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 text-center p-4">
                <h2 class="fw-bolder text-primary mb-1">100+</h2>
                <p class="text-muted mb-0 fw-semibold">Alunos Ativos</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 text-center p-4">
                <h2 class="fw-bolder text-warning mb-1">15+</h2>
                <p class="text-muted mb-0 fw-semibold">Cursos Online</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 text-center p-4">
                <h2 class="fw-bolder text-success mb-1">95%</h2>
                <p class="text-muted mb-0 fw-semibold">Satisfação</p>
            </div>
        </div>
    </div>
</div>

<!-- Courses Grid -->
<section class="py-5 bg-white" id="cursos-grid">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold mb-2">Principais Cursos</h3>
            <p class="text-muted">Cursos selecionados para iniciar hoje mesmo</p>
        </div>

        <div class="row g-4">
            @forelse($courses as $course)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-card transition-all">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top mx-auto d-block" alt="{{ $course->title }}" style="height: 200px; object-fit: contain; background-color: #f8f9fa; width: 100%;">
                    @else
                        <div class="bg-secondary bg-opacity-25 card-img-top d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fa-solid fa-graduation-cap text-secondary" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <div class="card-body p-4 d-flex flex-column">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2 align-self-start">{{ $course->category->name ?? 'Geral' }}</span>
                        <h5 class="card-title fw-bold">{{ $course->title }}</h5>
                        <p class="card-text text-muted small mb-4">{{ \Illuminate\Support\Str::limit($course->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            @if($course->is_free)
                                <span class="badge bg-success px-3 py-2 fs-6 rounded-pill">Grátis</span>
                            @else
                                <span class="fw-bold fs-5 text-dark">{{ number_format($course->price, 2, ',', '.') }} Kz</span>
                            @endif
                            
                            @auth
                                @if(Auth::user()->enrollments()->where('course_id', $course->id)->exists())
                                    <a href="{{ route('lms.dashboard') }}" class="btn btn-success rounded-pill px-4">Acessar Curso</a>
                                @else
                                    @if($course->is_free)
                                        <form action="{{ route('lms.enroll', $course->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success rounded-pill px-4">Acesso Gratuito</button>
                                        </form>
                                    @else
                                        <form action="{{ route('carrinho.add') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="course_{{ $course->id }}">
                                            <input type="hidden" name="name" value="{{ $course->title }}">
                                            <input type="hidden" name="price" value="{{ $course->price }}">
                                            <input type="hidden" name="image" value="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : '' }}">
                                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4">Inscrever-se</button>
                                        </form>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('register') }}" class="btn btn-outline-primary rounded-pill px-4">Inscrever-se</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted mb-0">Nenhum curso publicado de momento.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Pricing / Plans -->
<section class="py-5" style="background-color: #f8fafc;" id="planos">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h3 class="fw-bold mb-2">Planos de Assinatura</h3>
            <p class="text-muted">Escolha um plano que se adapta ao seu ritmo de estudos</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Basic Plan -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
                    <h5 class="text-muted mb-3">Básico</h5>
                    <h2 class="fw-bold mb-4">Valor por Curso</h2>
                    <ul class="list-unstyled text-start mb-4 mx-auto" style="max-width: 250px;">
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Acesso ilimitado ao curso pago</li>
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Sem práticas presenciais</li>
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Certificado digital</li>
                    </ul>
                    <a href="#cursos-grid" class="btn btn-outline-secondary mt-auto py-2 rounded-pill fw-bold">Escolher um Curso</a>
                </div>
            </div>

            <!-- Pro Plan -->
            <div class="col-md-4">
                <div class="card border-primary border-2 shadow rounded-4 h-100 text-center p-4 position-relative">
                    <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-primary px-3 py-2">Recomendado</span>
                    <h5 class="text-primary mb-3 mt-3">Pro (Anual)</h5>
                    <h2 class="fw-bold mb-4">Kz 50.000 <small class="fs-6 text-muted">/ Ano</small></h2>
                    <ul class="list-unstyled text-start mb-4 mx-auto" style="max-width: 250px;">
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> <strong>Acesso a todos os cursos</strong></li>
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Mentorias mensais</li>
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Práticas presenciais</li>
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Certificado Físico/Digital</li>
                    </ul>
                    <form action="{{ route('carrinho.add') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="id" value="plan_pro_anual">
                        <input type="hidden" name="name" value="Assinatura Pro (Anual) - Acesso total">
                        <input type="hidden" name="price" value="50000">
                        <input type="hidden" name="image" value="">
                        <button type="submit" class="btn btn-primary py-2 w-100 rounded-pill fw-bold" style="background-color: var(--asoft-primary);">Assinar Agora</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-white text-center" style="background-color: var(--asoft-primary);">
    <div class="container py-4">
        <h2 class="fw-bold mb-3">Pronto para começar?</h2>
        <p class="lead mb-4 opacity-75">Inscreva-se hoje e comece a aprender com os melhores.</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary fw-bold px-5 rounded-pill shadow">Inscrever-me</a>
    </div>
</section>

<style>
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
