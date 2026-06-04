@extends('layouts.public')

@section('title', 'Loja de Produtos TI - ASoftMedia')

@section('content')
<!-- Page Header -->
<div class="py-5" style="background-color: var(--asoft-secondary); color: #fff;">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill fw-bold">Equipamentos de TI e Material de Escritório</span>
                <h1 class="display-5 fw-bolder mb-3">Encontre tudo o que precisa<br>para o seu negócio.</h1>
                <p class="lead opacity-75">PCs, redes, periféricos e materiais de escritório com os melhores preços e garantia total.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <div class="input-group input-group-lg shadow-sm">
                    <input type="text" class="form-control border-0" placeholder="Pesquisar produtos..." aria-label="Pesquisar">
                    <button class="btn btn-brand px-4" type="button"><i class="fa-solid fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Categorias</h5>
                </div>
                <div class="card-body px-4">
                    <div class="list-group list-group-flush border-0">
                        <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center fw-bold" style="color: var(--asoft-primary);">
                            Todos os Produtos
                            <span class="badge bg-primary rounded-pill">120</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center text-muted">
                            Computadores
                            <span class="badge bg-light text-dark rounded-pill">24</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center text-muted">
                            Redes e Conectividade
                            <span class="badge bg-light text-dark rounded-pill">45</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center text-muted">
                            Material de Escritório
                            <span class="badge bg-light text-dark rounded-pill">32</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center text-muted">
                            Outros
                            <span class="badge bg-light text-dark rounded-pill">19</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Todos os Produtos</h4>
                <select class="form-select w-auto border-0 shadow-sm rounded-pill px-4">
                    <option selected>Ordenar por Mais Recentes</option>
                    <option value="1">Menor Preço</option>
                    <option value="2">Maior Preço</option>
                </select>
            </div>

            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card transition-all">
                        <div class="position-absolute top-0 end-0 p-3 z-1">
                            <span class="badge bg-success rounded-pill">100 em stock</span>
                        </div>
                        <div class="p-4 bg-white text-center" style="height: 200px;">
                            <img src="https://images.unsplash.com/photo-1544144433-d50aff500b91?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="img-fluid h-100 object-fit-contain" alt="Conectores">
                        </div>
                        <div class="card-body p-4 bg-light bg-opacity-50">
                            <h6 class="card-title fw-bold text-truncate">Conectores RJ45 Cat6</h6>
                            <p class="card-text text-muted small mb-3">Pacote com 100 unidades de conectores de alta qualidade.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5 text-primary">Kz 5.000</span>
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-cart-plus me-1"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card transition-all">
                        <div class="position-absolute top-0 end-0 p-3 z-1">
                            <span class="badge bg-success rounded-pill">5 em stock</span>
                        </div>
                        <div class="p-4 bg-white text-center" style="height: 200px;">
                            <img src="https://images.unsplash.com/photo-1526406915894-7bcd65f60845?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="img-fluid h-100 object-fit-contain" alt="Cartão SD">
                        </div>
                        <div class="card-body p-4 bg-light bg-opacity-50">
                            <h6 class="card-title fw-bold text-truncate">Cartão SD 64GB Extreme</h6>
                            <p class="card-text text-muted small mb-3">Cartão de Memória Expansível Alta Velocidade Classe 10.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5 text-primary">Kz 12.000</span>
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-cart-plus me-1"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card transition-all">
                        <div class="position-absolute top-0 end-0 p-3 z-1">
                            <span class="badge bg-success rounded-pill">10 em stock</span>
                        </div>
                        <div class="p-4 bg-white text-center" style="height: 200px;">
                            <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="img-fluid h-100 object-fit-contain" alt="Teclado Lenovo">
                        </div>
                        <div class="card-body p-4 bg-light bg-opacity-50">
                            <h6 class="card-title fw-bold text-truncate">Teclado Mecânico Lenovo</h6>
                            <p class="card-text text-muted small mb-3">Teclado mecânico luminoso ideal para programadores.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5 text-primary">Kz 25.000</span>
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-cart-plus me-1"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card transition-all">
                        <div class="position-absolute top-0 end-0 p-3 z-1">
                            <span class="badge bg-success rounded-pill">2 em stock</span>
                        </div>
                        <div class="p-4 bg-white text-center" style="height: 200px;">
                            <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="img-fluid h-100 object-fit-contain" alt="Dell Laptop">
                        </div>
                        <div class="card-body p-4 bg-light bg-opacity-50">
                            <h6 class="card-title fw-bold text-truncate">Dell Latitude Core i7</h6>
                            <p class="card-text text-muted small mb-3">Notebook Dell Core i7 12ª Geração, 16GB RAM, 512GB SSD.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5 text-primary">Kz 450.000</span>
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-cart-plus me-1"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg">
                        <li class="page-item disabled"><a class="page-link border-0 shadow-sm rounded-start-pill" href="#">Anterior</a></li>
                        <li class="page-item active"><a class="page-link border-0 shadow-sm" href="#">1</a></li>
                        <li class="page-item"><a class="page-link border-0 shadow-sm" href="#">2</a></li>
                        <li class="page-item"><a class="page-link border-0 shadow-sm rounded-end-pill" href="#">Próximo</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<style>
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        border-color: var(--asoft-primary) !important;
    }
</style>
@endsection
