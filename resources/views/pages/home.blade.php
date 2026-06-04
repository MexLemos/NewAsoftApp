@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="py-5 text-white" style="background-color: var(--asoft-primary); position: relative; overflow: hidden;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 z-1">
                <h1 class="display-4 fw-bolder mb-4">ALÉM DE PRODUTOS E SERVIÇOS, <span style="color: var(--asoft-accent);">CAUSAMOS IMPACTO</span></h1>
                <h3 class="fw-semibold mb-4">Treinamento e Estágio Profissional</h3>
                <p class="lead mb-4" style="color: rgba(255,255,255,0.85);">Investimos no futuro da inovação ao proporcionar programas de treinamento e estágios que aproximam estudantes e jovens profissionais do ambiente real de trabalho em TI — desde desenvolvimento de software até cloud computing, inteligência artificial e segurança digital.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-brand btn-lg">Explorar Cursos</a>
                    <a href="#" class="btn btn-outline-light btn-lg">Fale Connosco</a>
                </div>
            </div>
            <div class="col-lg-6 position-relative z-1">
                <!-- Using a professional placeholder or simple illustration for hero -->
                <div class="bg-white rounded-circle position-absolute top-50 start-50 translate-middle opacity-10" style="width: 500px; height: 500px;"></div>
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Profissional TI" class="img-fluid rounded-4 shadow-lg position-relative">
            </div>
        </div>
    </div>
</section>

<!-- About Section (Mission, Vision, Values) -->
<section id="sobre" class="py-5" style="background-color: #f8fafc;">
    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <div class="mb-4">
                    <div class="d-flex align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border-start border-4" style="border-color: var(--asoft-primary) !important;">
                        <div class="me-4 rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-eye fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Visão</h4>
                            <p class="text-muted mb-0">Ser referência em inovação tecnológica em Angola.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border-start border-4" style="border-color: var(--asoft-primary) !important;">
                        <div class="me-4 rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-bullseye fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Missão</h4>
                            <p class="text-muted mb-0">Oferecer soluções e treinamentos digitais que empoderem comunidades e organizações.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center bg-white p-4 rounded-4 shadow-sm border-start border-4" style="border-color: var(--asoft-primary) !important;">
                        <div class="me-4 rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-heart fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Valores</h4>
                            <p class="text-muted mb-0">Transparência, Inovação, Sustentabilidade.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 px-lg-5">
                <h3 class="fw-bold mb-4">Sobre a ASOFTMEDIA</h3>
                <p class="mb-4 text-muted" style="line-height: 1.8;">A ASOFTMEDIA é uma empresa de tecnologia fundada em 2018, com o objetivo de desenvolver soluções em software e proporcionar a digitalização de empresas. Com uma equipa qualificada, oferece serviços de desenvolvimento de software sob medida para empresas de todos os tamanhos.</p>
                <p class="text-muted" style="line-height: 1.8;">Além disso, oferece serviços de consultoria em tecnologia, implementação de soluções e gerenciamento de ambientes de T.I. das pequenas e médias empresas, ajudando a garantir continuidade, produtividade e redução de custos.</p>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="py-5 bg-white">
    <div class="container py-4 text-center">
        <h3 class="fw-bold mb-5">Nossos Parceiros</h3>
        <div class="d-flex justify-content-center flex-wrap gap-4 gap-md-5 align-items-center opacity-75">
            <!-- Emulating logos with text for now -->
            <h4 class="fw-bold text-secondary mb-0"><i class="fa-brands fa-microsoft text-primary me-2"></i> Microsoft</h4>
            <h4 class="fw-bold text-secondary mb-0"><i class="fa-brands fa-aws text-warning me-2"></i> AWS Partner</h4>
            <h4 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-server text-info me-2"></i> Cegid</h4>
            <h4 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-shield-halved text-success me-2"></i> Kaspersky</h4>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section id="servicos" class="py-5" style="background-color: #f8fafc;">
    <div class="container py-5">
        <h2 class="text-center fw-bolder mb-5">Nossas Áreas de Atuação</h2>
        <div class="row g-4">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Software" style="height: 160px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold">Venda de Softwares de Gestão</h5>
                        <ul class="list-unstyled mt-3 mb-0 text-muted small">
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Cegid PHC</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Cegid Primavera</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Cegid Vendus</li>
                            <li><i class="fa-solid fa-check text-primary me-2"></i> Desenvolvimento de Apps e Sites</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Service 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Equipamentos" style="height: 160px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold">Homologação de Equipamentos de TI</h5>
                        <ul class="list-unstyled mt-3 mb-0 text-muted small">
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Emissão de Certificados</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Renovação de Certificados</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Tradução de Documentação</li>
                            <li><i class="fa-solid fa-check text-primary me-2"></i> Entrega de certificados</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Redes" style="height: 160px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold">Redes e Infraestrutura</h5>
                        <ul class="list-unstyled mt-3 mb-0 text-muted small">
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> CCTV</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Telefonia VoIP</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Otimização de Recursos</li>
                            <li><i class="fa-solid fa-check text-primary me-2"></i> Segurança de Informação</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Consultoria" style="height: 160px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold">Consultoria e Treinamento</h5>
                        <ul class="list-unstyled mt-3 mb-0 text-muted small">
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Venda de Equipamentos</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> Venda de Licenças Microsoft</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> OutSourcing de Serviços</li>
                            <li><i class="fa-solid fa-check text-primary me-2"></i> Treinamento e Estágio de TI</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section (Leads) -->
<section id="contactos" class="py-5 bg-white">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-4">Contacte-nos</h3>
                <p class="text-muted mb-5">Envie-nos uma mensagem e a nossa equipe entrará em contacto o mais breve possível.</p>
                
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="background-color: #f8fafc;">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome Completo</label>
                            <input type="text" name="name" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mensagem</label>
                            <textarea name="message" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100" style="background-color: var(--asoft-primary); border: none;">
                            <i class="fa-solid fa-paper-plane me-2"></i> Enviar Mensagem
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Using a placeholder for the Google Maps iframe shown in the design -->
                <div class="h-100 rounded-4 overflow-hidden shadow-sm" style="min-height: 400px; background-color: #e2e8f0; display: flex; align-items: center; justify-content: center;">
                    <div class="text-center text-muted">
                        <i class="fa-solid fa-map-location-dot fs-1 mb-3"></i>
                        <h5>Mapa de Localização</h5>
                        <p>Sapu 2, Casas Azuis, Rua da Uva<br>Luanda - Angola</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
