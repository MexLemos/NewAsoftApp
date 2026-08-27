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
                <form action="{{ route('produtos') }}" method="GET" class="input-group input-group-lg shadow-sm">
                    <!-- Preserve other query parameters -->
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    
                    <input type="text" name="search" class="form-control border-0" placeholder="Pesquisar produtos..." value="{{ request('search') }}" aria-label="Pesquisar">
                    <button class="btn btn-brand px-4" type="submit"><i class="fa-solid fa-search"></i></button>
                </form>
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
                        <a href="{{ route('produtos', ['search' => request('search'), 'sort' => request('sort')]) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center {{ !request('category') ? 'fw-bold text-primary' : 'text-muted' }}">
                            Todos os Produtos
                            <span class="badge bg-light text-dark rounded-pill">{{ $totalProducts }}</span>
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('produtos', ['category' => $cat->id, 'search' => request('search'), 'sort' => request('sort')]) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center {{ request('category') == $cat->id ? 'fw-bold text-primary' : 'text-muted' }}">
                            {{ $cat->name }}
                            <span class="badge bg-light text-dark rounded-pill">{{ $cat->products_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    @if(request('category'))
                        {{ $categories->firstWhere('id', request('category'))?->name ?? 'Todos os Produtos' }}
                    @else
                        Todos os Produtos
                    @endif
                </h4>
                <form action="{{ route('produtos') }}" method="GET" class="m-0">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    
                    <select name="sort" class="form-select w-auto border-0 shadow-sm rounded-pill px-4" onchange="this.form.submit()">
                        <option value="recentes" {{ request('sort') == 'recentes' ? 'selected' : '' }}>Ordenar por Mais Recentes</option>
                        <option value="menor_preco" {{ request('sort') == 'menor_preco' ? 'selected' : '' }}>Menor Preço</option>
                        <option value="maior_preco" {{ request('sort') == 'maior_preco' ? 'selected' : '' }}>Maior Preço</option>
                    </select>
                </form>
            </div>

            <div class="row g-4">
                @forelse($products as $prod)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card transition-all">
                        <div class="position-absolute top-0 end-0 p-3 z-1">
                            <span class="badge bg-success rounded-pill">Em stock</span>
                        </div>
                        <div class="p-4 bg-white text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                            @if($prod->image)
                                <img src="{{ asset('storage/' . $prod->image) }}" class="img-fluid h-100 object-fit-contain" alt="{{ $prod->name }}">
                            @else
                                <i class="fa-solid fa-box-open text-primary opacity-50" style="font-size: 5rem;"></i>
                            @endif
                        </div>
                        <div class="card-body p-4 bg-light bg-opacity-50 d-flex flex-column">
                            <h6 class="card-title fw-bold text-truncate">{{ $prod->name }}</h6>
                            <p class="card-text text-muted small mb-3">{{ \Illuminate\Support\Str::limit($prod->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold fs-5 text-primary">Kz {{ number_format($prod->price, 2, ',', '.') }}</span>
                                <form action="{{ route('carrinho.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $prod->id }}">
                                    <input type="hidden" name="name" value="{{ $prod->name }}">
                                    <input type="hidden" name="price" value="{{ $prod->price }}">
                                    <input type="hidden" name="image" value="{{ $prod->image ? asset('storage/' . $prod->image) : '' }}">
                                    <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-cart-plus me-1"></i> Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted mb-0">Nenhum produto encontrado.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-5') }}
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
