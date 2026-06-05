@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Estatísticas Gerais</h2>
    <button class="btn btn-primary d-print-none" style="background-color: var(--asoft-accent); border: none;" onclick="window.print()">
        <i class="fa-solid fa-download me-1"></i> Imprimir Relatório
    </button>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-graduation-cap fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Cursos Vendidos</h6>
                    <h3 class="mb-0 fw-bold">145</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-users fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Alunos Ativos</h6>
                    <h3 class="mb-0 fw-bold">3,200</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-box-open fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Produtos em Catálogo</h6>
                    <h3 class="mb-0 fw-bold">87</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-info bg-opacity-10 text-info rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-handshake fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Parceiros</h6>
                    <h3 class="mb-0 fw-bold">24</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Receitas Mensais</h5>
                <select class="form-select form-select-sm w-auto shadow-none">
                    <option>Este Ano</option>
                    <option>Ano Passado</option>
                </select>
            </div>
            <div class="card-body px-4">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <h6 class="fw-bold mb-3 opacity-75">Crescimento de Alunos (LMS)</h6>
                <h2 class="display-4 fw-bold mb-2">+15%</h2>
                <p class="mb-4 opacity-75">Em relação ao mês anterior.</p>
                <button class="btn btn-light fw-bold w-100 rounded-pill text-primary">Ver Relatório Completo</button>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold mb-0">Últimos Pedidos (E-commerce)</h5>
            </div>
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Pedido ID</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-001</td>
                                <td>João Silva</td>
                                <td>04 Jun 2026</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>Kz 70.000,00</td>
                            </tr>
                            <tr>
                                <td>#ORD-002</td>
                                <td>Maria Costa</td>
                                <td>03 Jun 2026</td>
                                <td><span class="badge bg-warning text-dark">Pendente</span></td>
                                <td>Kz 15.000,00</td>
                            </tr>
                            <tr>
                                <td>#ORD-003</td>
                                <td>Empresa XYZ</td>
                                <td>01 Jun 2026</td>
                                <td><span class="badge bg-info">Processando</span></td>
                                <td>Kz 350.000,00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold mb-0">Novos Leads (CRM)</h5>
            </div>
            <div class="card-body px-4">
                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-start border-0 mb-3">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Carlos Mendes</div>
                            <small class="text-muted">Interesse em Consultoria TI</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">Novo</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-start border-0 mb-3">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Ana Rita</div>
                            <small class="text-muted">Dúvida sobre curso React</small>
                        </div>
                        <span class="badge bg-warning text-dark rounded-pill">Em Contacto</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Receitas (Kz)',
                    data: [120000, 190000, 150000, 220000, 180000, 250000, 300000],
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection
