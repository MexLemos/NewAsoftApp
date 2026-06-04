@extends('layouts.public')

@section('title', 'Treinamentos e Cursos - ASoftMedia')

@section('content')
<!-- Page Header -->
<div class="py-5" style="background-color: var(--asoft-primary); color: #fff;">
    <div class="container py-5 text-center">
        <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">Melhor Plataforma de Cursos {{ date('Y') }}</span>
        <h1 class="display-4 fw-bolder mb-3">Transforme sua Carreira<br>com Nossos Cursos Profissionais</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 700px;">Aprenda com especialistas do mercado de modo híbrido (presencial e online). Agende as suas aulas práticas e interaja com nossa comunidade.</p>
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
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold mb-2">Principais Cursos</h3>
            <p class="text-muted">Cursos selecionados para iniciar hoje mesmo</p>
        </div>

        <div class="row g-4">
            <!-- Sample Course 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-card transition-all">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Programação Web" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Desenvolvimento</span>
                        <h5 class="card-title fw-bold">Programação Web (PHP + MySQL)</h5>
                        <p class="card-text text-muted small mb-4">Duração: 1 Mês - Focado em desenvolvimento backend, aborda a criação de sites dinâmicos utilizando PHP e banco de dados.</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="fw-bold fs-5 text-dark">Kz 25.000</span>
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4">Ver</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sample Course 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-card transition-all">
                    <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="ReactJS" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Frontend</span>
                        <h5 class="card-title fw-bold">Front-End com ReactJS</h5>
                        <p class="card-text text-muted small mb-4">Aborda o desenvolvimento de interfaces modernas e dinâmicas usando ReactJS. Ensina componentes reutilizáveis, gerenciamento de estado.</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="fw-bold fs-5 text-dark">Kz 25.000</span>
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4">Ver</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sample Course 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-card transition-all">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Gestão de Projetos" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <span class="badge bg-success bg-opacity-10 text-success mb-2">Gestão</span>
                        <h5 class="card-title fw-bold">Fundamentos de Gestão de Projetos</h5>
                        <p class="card-text text-muted small mb-4">Duração: 2 Semanas - Apresenta conceitos essenciais de planejamento, execução e monitoramento de projetos. Aborda metodologia ágil.</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="fw-bold fs-5 text-dark">Kz 40.000</span>
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sample Course 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-card transition-all">
                    <img src="https://images.unsplash.com/photo-1542744094-24638ea0b56c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Marketing" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <span class="badge bg-warning bg-opacity-10 text-warning text-dark mb-2">Marketing</span>
                        <h5 class="card-title fw-bold">Marketing Digital</h5>
                        <p class="card-text text-muted small mb-4">Duração: 2 Semanas - Explora estratégias de promoção online, incluindo redes sociais, SEO, campanhas pagas e análise de dados.</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="fw-bold fs-5 text-dark">Kz 20.000</span>
                            <a href="#" class="btn btn-outline-primary rounded-pill px-4">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing / Plans -->
<section class="py-5" style="background-color: #f8fafc;">
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
                    <a href="#" class="btn btn-outline-secondary mt-auto py-2 rounded-pill fw-bold">Começar</a>
                </div>
            </div>

            <!-- Pro Plan -->
            <div class="col-md-4">
                <div class="card border-primary border-2 shadow rounded-4 h-100 text-center p-4 position-relative">
                    <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-primary px-3 py-2">Recomendado</span>
                    <h5 class="text-primary mb-3 mt-3">Pro</h5>
                    <h2 class="fw-bold mb-4">Kz 50.000 <small class="fs-6 text-muted">/ Mensal</small></h2>
                    <ul class="list-unstyled text-start mb-4 mx-auto" style="max-width: 250px;">
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Acesso a todos os cursos</li>
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Mentorias mensais</li>
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Práticas presenciais</li>
                        <li class="mb-3"><i class="fa-solid fa-check text-success me-2"></i> Certificado Físico/Digital</li>
                    </ul>
                    <a href="#" class="btn btn-primary mt-auto py-2 rounded-pill fw-bold" style="background-color: var(--asoft-primary);">Assinar Agora</a>
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
