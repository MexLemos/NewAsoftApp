@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Registo de Ponto</h2>
        <p class="text-muted mb-0">Marcação de assiduidade diária por geolocalização.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
            <h5 class="fw-bold mb-4 text-muted">O Meu Ponto (Hoje)</h5>
            
            <div class="mb-4">
                <div class="d-flex justify-content-center gap-4 mb-3">
                    <div class="p-3 bg-light rounded-3 text-center" style="width: 120px;">
                        <span class="d-block small text-muted fw-bold mb-1">Entrada</span>
                        <h4 class="mb-0 fw-bold text-success">{{ $attendance && $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') : '--:--' }}</h4>
                    </div>
                    <div class="p-3 bg-light rounded-3 text-center" style="width: 120px;">
                        <span class="d-block small text-muted fw-bold mb-1">Saída</span>
                        <h4 class="mb-0 fw-bold text-danger">{{ $attendance && $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') : '--:--' }}</h4>
                    </div>
                </div>
            </div>

            @if(!$attendance || !$attendance->check_out_time)
                <form action="{{ route('admin.ponto.registrar') }}" method="POST" id="pontoForm">
                    @csrf
                    <input type="hidden" name="latitude" id="latInput">
                    <input type="hidden" name="longitude" id="lngInput">
                    
                    <button type="button" id="btnMarcarPonto" class="btn btn-primary btn-lg shadow rounded-pill px-5 fw-bold" style="background-color: var(--asoft-primary); border: none;">
                        <i class="fa-solid fa-location-dot me-2"></i> 
                        {{ !$attendance ? 'Registar Entrada' : 'Registar Saída' }}
                    </button>
                    <p id="geoStatus" class="small text-muted mt-3 mb-0"></p>
                </form>
            @else
                <div class="alert alert-info border-0 rounded-3 mb-0">
                    <i class="fa-solid fa-thumbs-up me-2"></i> Ponto concluído por hoje. Bom descanso!
                </div>
            @endif
        </div>
    </div>
    
    @hasrole('admin')
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold mb-0">Histórico Recente (Visão Admin)</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Funcionário</th>
                                <th>Data</th>
                                <th>Entrada</th>
                                <th>Saída</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allAttendances as $att)
                            <tr>
                                <td class="fw-medium">{{ $att->employee->name ?? 'N/D' }}</td>
                                <td>{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                                <td class="text-success fw-bold">{{ $att->check_in_time ? \Carbon\Carbon::parse($att->check_in_time)->format('H:i') : '-' }}</td>
                                <td class="text-danger fw-bold">{{ $att->check_out_time ? \Carbon\Carbon::parse($att->check_out_time)->format('H:i') : '-' }}</td>
                                <td>
                                    @if($att->location_status == 'valid')
                                        <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-check me-1"></i>Válido</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning text-dark"><i class="fa-solid fa-triangle-exclamation me-1"></i>Irregular</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if(count($allAttendances) === 0)
                            <tr><td colspan="5" class="text-center text-muted">Nenhum registo encontrado.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endhasrole
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('btnMarcarPonto');
        if(!btn) return;
        
        const geoStatus = document.getElementById('geoStatus');
        const latInput = document.getElementById('latInput');
        const lngInput = document.getElementById('lngInput');
        const form = document.getElementById('pontoForm');

        btn.addEventListener('click', function() {
            if (!navigator.geolocation) {
                geoStatus.innerHTML = '<span class="text-danger">A geolocalização não é suportada por este navegador.</span>';
                return;
            }

            btn.disabled = true;
            geoStatus.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> A obter localização... Aguarde.';

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    latInput.value = position.coords.latitude;
                    lngInput.value = position.coords.longitude;
                    form.submit();
                },
                function(error) {
                    btn.disabled = false;
                    let msg = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            msg = "Permissão negada. Ative a localização no seu navegador/telemóvel.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            msg = "Informação de localização indisponível.";
                            break;
                        case error.TIMEOUT:
                            msg = "O tempo de espera para obter a localização esgotou-se.";
                            break;
                        default:
                            msg = "Ocorreu um erro desconhecido.";
                            break;
                    }
                    geoStatus.innerHTML = '<span class="text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i>' + msg + '</span>';
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        });
    });
</script>
@endsection
