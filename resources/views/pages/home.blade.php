@extends('layouts.public')

@section('content')
<!-- Hero Carousel Section -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <!-- Slide 1: Impacto/Treinamento -->
        <div class="carousel-item active" style="background-image: url('{{ asset('images/hero-bg-new.png') }}'); background-size: cover; background-position: center; background-color: #0f172a;">
            <!-- Dark overlay to ensure text is readable and blends well -->
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(15,23,42,0.9) 0%, rgba(15,23,42,0.4) 50%, rgba(15,23,42,0) 100%);"></div>
            <div class="container py-5 position-relative z-1">
                <div class="row align-items-center min-vh-50 py-5">
                    <div class="col-lg-7 mb-5 mb-lg-0">
                        <h2 class="fs-1 fw-bolder mb-3 text-white text-uppercase" style="letter-spacing: 0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Além de produtos e serviços,<br><span style="color: var(--asoft-accent);">causamos impacto</span></h2>
                        <h5 class="fw-bold mb-3 text-white" style="text-shadow: 0 1px 3px rgba(0,0,0,0.5);">Treinamento e Estágio Profissional</h5>
                        <p class="mb-4 small" style="color: rgba(255,255,255,0.9); line-height: 1.8; max-width: 650px;">Investimos no futuro da inovação ao proporcionar programas de treinamento e estágios que aproximam estudantes do ambiente real de trabalho em TI — desde desenvolvimento de software até cloud computing e IA.</p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('cursos') }}" class="btn btn-brand px-4 py-2 fw-bold shadow btn-sm">Explorar Cursos</a>
                            <a href="#contactos" class="btn btn-outline-light px-4 py-2 fw-bold shadow btn-sm">Fale Connosco</a>
                        </div>
                    </div>
                    <div class="col-lg-5"></div>
                </div>
            </div>
        </div>
        <!-- Slide 2: Treinamentos LMS -->
        <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center; background-color: #0f172a;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(15,23,42,0.95) 0%, rgba(15,23,42,0.6) 50%, rgba(15,23,42,0) 100%);"></div>
            <div class="container py-5 position-relative z-1">
                <div class="row align-items-center min-vh-50 py-5">
                    <div class="col-lg-7 mb-5 mb-lg-0 z-1">
                        <h2 class="fs-1 fw-bolder mb-3 text-white text-uppercase" style="letter-spacing: 0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">TRANSFORME A SUA CARREIRA COM <span style="color: var(--asoft-accent);">NOSSOS CURSOS</span></h2>
                        <p class="mb-5 small" style="color: rgba(255,255,255,0.9); line-height: 1.8; max-width: 650px;">Aceda à nossa plataforma E-learning com aulas práticas focadas no mercado atual. Aprenda programação, gestão e redes com especialistas e alcance o próximo nível na sua carreira.</p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('cursos') }}" class="btn btn-brand px-4 py-2 fw-bold shadow btn-sm">Ver Catálogo de Cursos</a>
                        </div>
                    </div>
                    <div class="col-lg-5"></div>
                </div>
            </div>
        </div>
        <!-- Slide 3: Serviços Corporativos -->
        <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'); background-size: cover; background-position: center; background-color: #0f172a;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(15,23,42,0.95) 0%, rgba(15,23,42,0.6) 50%, rgba(15,23,42,0) 100%);"></div>
            <div class="container py-5 position-relative z-1">
                <div class="row align-items-center min-vh-50 py-5">
                    <div class="col-lg-7 mb-5 mb-lg-0 z-1">
                        <h2 class="fs-1 fw-bolder mb-3 text-white text-uppercase" style="letter-spacing: 0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">SOLUÇÕES INOVADORAS PARA O <span style="color: var(--asoft-accent);">SEU NEGÓCIO</span></h2>
                        <p class="mb-5 small" style="color: rgba(255,255,255,0.9); line-height: 1.8; max-width: 650px;">Fornecemos os melhores equipamentos, venda de software de gestão avançada (Cegid), consultoria em TI e implementação de redes para otimizar os seus resultados.</p>
                        <div class="d-flex gap-3">
                            <a href="#servicos" class="btn btn-brand px-4 py-2 fw-bold shadow btn-sm">Conhecer Serviços</a>
                            <a href="{{ route('produtos') }}" class="btn btn-outline-light px-4 py-2 fw-bold shadow btn-sm">Ir para a Loja</a>
                        </div>
                    </div>
                    <div class="col-lg-5"></div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>

<!-- Statistics Section -->
<section class="py-4 position-relative" style="background-color: #f8fafc; z-index: 10;">
    <div class="container">
        <!-- Negative margin to pull the cards slightly up over the hero if desired, but standard layout per image -->
        <div class="row g-4 justify-content-center" style="margin-top: -30px;">
            <div class="col-6 col-md-3">
                <div class="bg-white rounded-4 shadow-sm p-4 text-center h-100 animate-on-scroll delay-100">
                    <h2 class="fw-bolder mb-1" style="color: var(--asoft-accent); font-size: 2.5rem;">150+</h2>
                    <p class="text-muted small fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">Clientes</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="bg-white rounded-4 shadow-sm p-4 text-center h-100 animate-on-scroll delay-200">
                    <h2 class="fw-bolder mb-1" style="color: var(--asoft-accent); font-size: 2.5rem;">25+</h2>
                    <p class="text-muted small fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">Cursos</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="bg-white rounded-4 shadow-sm p-4 text-center h-100 animate-on-scroll delay-300">
                    <h2 class="fw-bolder mb-1" style="color: var(--asoft-accent); font-size: 2.5rem;">12+</h2>
                    <p class="text-muted small fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">Produtos</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="bg-white rounded-4 shadow-sm p-4 text-center h-100 animate-on-scroll delay-400">
                    <h2 class="fw-bolder mb-1" style="color: var(--asoft-accent); font-size: 2.5rem;">10+</h2>
                    <p class="text-muted small fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">Anos</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="pt-5 pb-3 bg-white">
    <div class="container pt-4 pb-2">
        <h3 class="fw-bold mb-5" style="color: var(--asoft-secondary);">Cursos em destaque</h3>
        <div class="row g-4 justify-content-center">
            @forelse($courses as $course)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden animate-on-scroll delay-100">
                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}" class="card-img-top mx-auto d-block" alt="{{ $course->title }}" style="height: 180px; object-fit: contain; background-color: #f8f9fa; width: 100%;">
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="fw-bold mb-2">{{ $course->title }}</h5>
                        <p class="text-muted small mb-4">{{ \Illuminate\Support\Str::limit($course->description, 100) }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <a href="{{ route('cursos') }}" class="btn btn-warning fw-bold btn-sm px-3 shadow-sm" style="background-color: var(--asoft-accent); border-color: var(--asoft-accent); color: white;">Ver curso</a>
                            @if($course->is_free)
                                <span class="badge bg-success shadow-sm px-3 py-2 rounded-pill">Grátis</span>
                            @else
                                <span class="fw-bold text-primary small">{{ number_format($course->price, 2, ',', '.') }} Kz</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted">
                <p>Nenhum curso cadastrado de momento.</p>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('cursos') }}" class="btn btn-outline-warning fw-bold px-4 py-2 rounded-pill shadow-sm" style="color: var(--asoft-accent); border-color: var(--asoft-accent);">Todos os cursos</a>
        </div>
    </div>
</section>

<!-- Products & Services Section -->
<section class="pt-3 pb-5" style="background-color: #f8fafc;">
    <div class="container pt-2 pb-4">
        <h3 class="fw-bold mb-5" style="color: var(--asoft-secondary);">Produtos & Serviços</h3>
        <div class="row g-4 justify-content-center">
            @forelse($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 animate-on-scroll delay-100">
                    <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                        <div class="text-center mb-3 w-100 d-flex align-items-center justify-content-center" style="height: 120px;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mx-auto d-block" style="max-height: 120px; object-fit: contain; width: 100%;">
                            @else
                                <i class="fa-solid fa-box-open text-primary" style="font-size: 4rem;"></i>
                            @endif
                        </div>
                        <h6 class="fw-bold mb-3 text-center">{{ $product->name }}</h6>
                        <div class="mt-auto w-100 text-center">
                            <form action="{{ route('carrinho.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="image" value="{{ $product->image ? asset('storage/' . $product->image) : '' }}">
                                <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold w-100"><i class="fa-solid fa-cart-plus me-1"></i> Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted">
                <p>Nenhum produto em destaque.</p>
            </div>
            @endforelse

            @foreach($services->take(3) as $service)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 animate-on-scroll delay-200">
                    <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                        <div class="text-center mb-3 w-100 d-flex align-items-center justify-content-center" style="height: 120px;">
                            @if($service->icon)
                                <img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->title }}" class="mx-auto d-block" style="max-height: 120px; object-fit: contain; width: 100%;">
                            @else
                                <i class="fa-solid fa-network-wired text-primary" style="font-size: 4rem;"></i>
                            @endif
                        </div>
                        <h6 class="fw-bold mb-2 text-center">{{ $service->title }}</h6>
                        <p class="text-muted small mb-4 text-center">{{ \Illuminate\Support\Str::limit($service->description, 80) }}</p>
                        <div class="mt-auto w-100 text-center">
                            <a href="#contactos" class="btn btn-outline-secondary btn-sm rounded-pill px-4 fw-bold w-100"><i class="fa-solid fa-envelope me-1"></i> Fale Connosco</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- About Section (Mission, Vision, Values) -->
<section id="sobre" class="pt-5 pb-2" style="background-color: #f8fafc;">
    <div class="container pt-5 pb-0">
        <div class="row g-4 align-items-center mb-5">
            <div class="col-lg-5">
                <div class="mb-4 mb-lg-0">
                    <div class="d-flex align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border-start border-4 animate-on-scroll delay-100" style="border-color: var(--asoft-primary) !important;">
                        <div class="me-4 rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-eye fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Visão</h4>
                            <p class="text-muted mb-0">Ser referência em inovação tecnológica em Angola.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border-start border-4 animate-on-scroll delay-200" style="border-color: var(--asoft-primary) !important;">
                        <div class="me-4 rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-bullseye fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Missão</h4>
                            <p class="text-muted mb-0">Oferecer soluções e treinamentos digitais que empoderem comunidades e organizações.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center bg-white p-4 rounded-4 shadow-sm border-start border-4 animate-on-scroll delay-300" style="border-color: var(--asoft-primary) !important;">
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
            <div class="col-lg-7 px-lg-5 animate-on-scroll delay-400">
                <img src="{{ asset('images/asoftmedia-team.jpg') }}" alt="Equipa Asoftmedia" class="img-fluid rounded-4 shadow-sm w-100" style="object-fit: cover; max-height: 400px;">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h3 class="fw-bold mb-4 text-center">Sobre a ASOFTMEDIA</h3>
                <p class="mb-4 text-muted" style="line-height: 1.8; text-align: justify;">A ASOFTMEDIA é uma empresa de tecnologia fundada em 2018, com o objetivo de desenvolver soluções em software e proporcionar a digitalização de empresas. Com uma equipa qualificada, oferece serviços de desenvolvimento de software sob medida para empresas de todos os tamanhos.</p>
                <p class="text-muted" style="line-height: 1.8; text-align: justify;">Além disso, oferece serviços de consultoria em tecnologia, implementação de soluções e gerenciamento de ambientes de T.I. das pequenas e médias empresas, ajudando a garantir continuidade, produtividade e redução de custos.</p>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="pt-2 pb-5 bg-white">
    <div class="container pt-2 pb-4 text-center">
        <h3 class="fw-bold mb-5">Nossos Parceiros</h3>
        <style>
            .partners-carousel-container {
                overflow: hidden;
                width: 100%;
                white-space: nowrap;
                position: relative;
            }
            .partners-carousel-container::before,
            .partners-carousel-container::after {
                content: '';
                position: absolute;
                top: 0;
                width: 150px;
                height: 100%;
                z-index: 2;
            }
            .partners-carousel-container::before {
                left: 0;
                background: linear-gradient(to right, white 0%, rgba(255, 255, 255, 0) 100%);
            }
            .partners-carousel-container::after {
                right: 0;
                background: linear-gradient(to left, white 0%, rgba(255, 255, 255, 0) 100%);
            }
            .partners-carousel-track {
                display: inline-block;
                animation: scroll-partners 15s linear infinite;
            }
            .partners-carousel-track:hover {
                animation-play-state: paused;
            }
            .partner-logo {
                height: 70px;
                margin: 0 40px;
                object-fit: contain;
                transition: all 0.3s ease;
            }
            .partner-logo:hover {
                transform: scale(1.05);
            }
            @keyframes scroll-partners {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
        </style>
        <div class="partners-carousel-container">
            <div class="partners-carousel-track">
                <!-- Loop over the dynamic partners twice for seamless scrolling if needed -->
                @foreach($partners as $partner)
                    <img src="{{ $partner->logo_url ? asset('storage/' . $partner->logo_url) : asset('images/default-partner.png') }}" class="partner-logo" alt="{{ $partner->name }}" title="{{ $partner->name }}">
                @endforeach
                <!-- Duplicated set for seamless scrolling if there are at least some partners -->
                @if($partners->count() > 0)
                    @foreach($partners as $partner)
                        <img src="{{ $partner->logo_url ? asset('storage/' . $partner->logo_url) : asset('images/default-partner.png') }}" class="partner-logo" alt="{{ $partner->name }}" title="{{ $partner->name }}">
                    @endforeach
                    @foreach($partners as $partner)
                        <img src="{{ $partner->logo_url ? asset('storage/' . $partner->logo_url) : asset('images/default-partner.png') }}" class="partner-logo" alt="{{ $partner->name }}" title="{{ $partner->name }}">
                    @endforeach
                @else
                    <p class="text-muted">Parceiros em breve</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section id="servicos" class="pt-5 pb-2" style="background-color: #f8fafc;">
    <div class="container pt-5 pb-2">
        <h2 class="text-center fw-bolder mb-5">Nossas Áreas de Atuação</h2>
        <div class="row g-5 justify-content-center text-center">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="mb-4">
                    <i class="fa-solid fa-laptop-code" style="font-size: 3.5rem; color: #0f172a;"></i>
                </div>
                <h5 class="fw-bold mb-3" style="color: #0f172a;">Venda de Softwares de Gestão</h5>
                <p class="text-muted small" style="line-height: 1.7;">Fornecemos e implementamos as melhores soluções em software de gestão, incluindo Cegid PHC, Primavera e Vendus, além do desenvolvimento personalizado de aplicações e websites.</p>
            </div>
            
            <!-- Service 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="mb-4">
                    <i class="fa-solid fa-file-contract" style="font-size: 3.5rem; color: #0f172a;"></i>
                </div>
                <h5 class="fw-bold mb-3" style="color: #0f172a;">Homologação de Equipamentos de TI</h5>
                <p class="text-muted small" style="line-height: 1.7;">Cuidamos de todo o processo de emissão e renovação de certificados, além da tradução técnica e entrega de documentação necessária para os seus equipamentos.</p>
            </div>

            <!-- Service 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="mb-4">
                    <i class="fa-solid fa-network-wired" style="font-size: 3.5rem; color: #0f172a;"></i>
                </div>
                <h5 class="fw-bold mb-3" style="color: #0f172a;">Redes e Infraestrutura</h5>
                <p class="text-muted small" style="line-height: 1.7;">Projetamos e implementamos soluções robustas de CFTV, telefonia VoIP e otimização de recursos para garantir a segurança da informação na sua empresa.</p>
            </div>

            <!-- Service 4 -->
            <div class="col-md-6 col-lg-4 mt-lg-5">
                <div class="mb-4">
                    <i class="fa-solid fa-chalkboard-user" style="font-size: 3.5rem; color: #0f172a;"></i>
                </div>
                <h5 class="fw-bold mb-3" style="color: #0f172a;">Consultoria e Treinamento</h5>
                <p class="text-muted small" style="line-height: 1.7;">Oferecemos outsourcing de serviços, venda de equipamentos e licenças Microsoft, além de programas especializados de treinamento e estágio em TI.</p>
            </div>
        </div>

        <div class="text-center mt-5">
            <h5 class="mb-4 text-muted">A sua empresa precisa de uma solução à medida?</h5>
            <a href="#contactos" class="btn btn-brand btn-lg shadow px-5 py-3 rounded-pill fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                Fale com os nossos especialistas <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="pt-2 pb-5 bg-white">
    <div class="container pt-2 pb-5 text-center">
        <h3 class="fw-bold mb-5" style="color: var(--asoft-secondary);">O que dizem os nossos clientes</h3>
        <div class="row justify-content-center g-4 text-start">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 animate-on-scroll delay-100" style="background-color: #f8fafc;">
                    <div class="card-body">
                        <p class="fst-italic text-muted mb-4">"O curso de Excel Avançado aumentou a minha produtividade em 40%."</p>
                        <h6 class="fw-bold mb-1">Ana Paula</h6>
                        <p class="text-muted small mb-0">Analista Financeira</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 animate-on-scroll delay-200" style="background-color: #f8fafc;">
                    <div class="card-body">
                        <p class="fst-italic text-muted mb-4">"A formação em Laravel transformou a nossa equipa de desenvolvimento."</p>
                        <h6 class="fw-bold mb-1">João Manuel</h6>
                        <p class="text-muted small mb-0">Director de TI, Empresa XYZ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section (Leads) -->
<section id="contactos" class="py-5 bg-light">
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
                <!-- Google Maps iframe -->
                <div class="h-100 rounded-4 overflow-hidden shadow-sm position-relative" style="min-height: 400px; background-color: #e2e8f0;">
                    <iframe width="100%" height="100%" frameborder="0" style="border:0; position: absolute; top: 0; left: 0;" src="https://maps.google.com/maps?q=Sapu%202,%20Luanda,%20Angola&t=&z=14&ie=UTF8&iwloc=&output=embed" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
