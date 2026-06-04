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
                @php
                    $dummyProducts = [
                        ['id' => 1, 'name' => 'Conectores RJ45 Cat6', 'price' => 5000, 'stock' => 100, 'image' => 'https://images.unsplash.com/photo-1544144433-d50aff500b91?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'desc' => 'Pacote com 100 unidades de conectores de alta qualidade.'],
                        ['id' => 2, 'name' => 'Cartão SD 64GB Extreme', 'price' => 12000, 'stock' => 5, 'image' => 'https://images.unsplash.com/photo-1526406915894-7bcd65f60845?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'desc' => 'Cartão de Memória Expansível Alta Velocidade Classe 10.'],
                        ['id' => 3, 'name' => 'Teclado Mecânico Lenovo', 'price' => 25000, 'stock' => 10, 'image' => 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'desc' => 'Teclado mecânico luminoso ideal para programadores.'],
                        ['id' => 4, 'name' => 'Dell Latitude Core i7', 'price' => 450000, 'stock' => 2, 'image' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'desc' => 'Notebook Dell Core i7 12ª Geração, 16GB RAM, 512GB SSD.']
                    ];
                @endphp

                @foreach($dummyProducts as $prod)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card transition-all">
                        <div class="position-absolute top-0 end-0 p-3 z-1">
                            <span class="badge bg-success rounded-pill">{{ $prod['stock'] }} em stock</span>
                        </div>
                        <div class="p-4 bg-white text-center" style="height: 200px;">
                            <img src="{{ $prod['image'] }}" class="img-fluid h-100 object-fit-contain" alt="{{ $prod['name'] }}">
                        </div>
                        <div class="card-body p-4 bg-light bg-opacity-50 d-flex flex-column">
                            <h6 class="card-title fw-bold text-truncate">{{ $prod['name'] }}</h6>
                            <p class="card-text text-muted small mb-3">{{ $prod['desc'] }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold fs-5 text-primary">Kz {{ number_format($prod['price'], 2, ',', '.') }}</span>
                                <form action="{{ route('carrinho.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $prod['id'] }}">
                                    <input type="hidden" name="name" value="{{ $prod['name'] }}">
                                    <input type="hidden" name="price" value="{{ $prod['price'] }}">
                                    <input type="hidden" name="image" value="{{ $prod['image'] }}">
                                    <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-cart-plus me-1"></i> Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
