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
        <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
            <h5 class="fw-bold mb-1">O Meu Ponto (Hoje)</h5>
            <p class="text-muted small mb-4">{{ now()->translatedFormat('l, d \d\e F \d\e Y') }} &mdash; {{ now()->format('H:i') }}</p>

            {{-- STATUS CARDS --}}
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <div class="rounded-4 p-3 text-center border {{ $attendance && $attendance->check_in_time ? 'border-success bg-success bg-opacity-10' : 'bg-light border-0' }}">
                        <div class="mb-2">
                            <i class="fa-solid fa-right-to-bracket fa-lg {{ $attendance && $attendance->check_in_time ? 'text-success' : 'text-muted' }}"></i>
                        </div>
                        <span class="d-block small fw-bold {{ $attendance && $attendance->check_in_time ? 'text-success' : 'text-muted' }}">Entrada</span>
                        <h3 class="fw-bold mb-0 {{ $attendance && $attendance->check_in_time ? 'text-success' : 'text-muted' }}">
                            {{ $attendance && $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') : '08:00' }}
                        </h3>
                        @if($attendance && $attendance->check_in_time)
                            <span class="badge bg-success mt-1"><i class="fa-solid fa-check me-1"></i>Registado</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-25 text-secondary mt-1">Pendente</span>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="rounded-4 p-3 text-center border {{ $attendance && $attendance->check_out_time ? 'border-danger bg-danger bg-opacity-10' : 'bg-light border-0' }}">
                        <div class="mb-2">
                            <i class="fa-solid fa-right-from-bracket fa-lg {{ $attendance && $attendance->check_out_time ? 'text-danger' : 'text-muted' }}"></i>
                        </div>
                        <span class="d-block small fw-bold {{ $attendance && $attendance->check_out_time ? 'text-danger' : 'text-muted' }}">Saída</span>
                        <h3 class="fw-bold mb-0 {{ $attendance && $attendance->check_out_time ? 'text-danger' : 'text-muted' }}">
                            {{ $attendance && $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') : '17:00' }}
                        </h3>
                        @if($attendance && $attendance->check_out_time)
                            <span class="badge bg-danger mt-1"><i class="fa-solid fa-check me-1"></i>Registado</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-25 text-secondary mt-1">Pendente</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- BOTÕES DE AÇÃO --}}
            @if($attendance && $attendance->check_out_time)
                {{-- Ambos registados --}}
                <div class="alert alert-success border-0 rounded-3 text-center mb-0">
                    <i class="fa-solid fa-circle-check fa-lg me-2"></i>
                    <strong>Ponto completo!</strong> Bom descanso.
                </div>
            @else
                <form action="{{ route('admin.ponto.registrar') }}" method="POST" id="pontoForm">
                    @csrf
                    <input type="hidden" name="latitude" id="latInput">
                    <input type="hidden" name="longitude" id="lngInput">
                    <input type="hidden" name="type" id="pontoType" value="{{ !$attendance ? 'entrada' : 'saida' }}">

                    @if(!$attendance)
                        {{-- Entrada ainda não feita --}}
                        <button type="button" id="btnMarcarPonto"
                            class="btn btn-success btn-lg w-100 fw-bold rounded-pill shadow-sm mb-2">
                            <i class="fa-solid fa-right-to-bracket me-2"></i> Registar Entrada
                        </button>
                        <p class="small text-muted text-center mb-0"><i class="fa-solid fa-clock me-1"></i> Horário previsto: <b>08:00</b></p>
                    @elseif(!$attendance->check_out_time)
                        {{-- Entrada feita, saída pendente --}}
                        <div class="alert alert-warning border-0 rounded-3 small text-center mb-3 py-2">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i>
                            Entrada registada às <b>{{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}</b>
                        </div>
                        <button type="button" id="btnMarcarPonto"
                            class="btn btn-danger btn-lg w-100 fw-bold rounded-pill shadow-sm mb-2">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Registar Saída
                        </button>
                        <p class="small text-muted text-center mb-0"><i class="fa-solid fa-clock me-1"></i> Horário previsto: <b>17:00</b></p>
                    @endif

                    <p id="geoStatus" class="small text-muted mt-3 mb-0 text-center"></p>
                </form>
            @endif
        </div>
    </div>

    @hasrole('admin')
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold mb-0">Historial Recente da Equipa</h5>
            </div>
            <div class="card-body px-0 pb-0 mt-2">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Funcionário</th>
                                <th>Data</th>
                                <th class="text-success">Entrada</th>
                                <th class="text-danger">Saída</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allAttendances as $att)
                            <tr>
                                <td class="ps-4 fw-medium">{{ $att->employee->name ?? 'N/D' }}</td>
                                <td>{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                                <td class="text-success fw-bold">{{ $att->check_in_time ? \Carbon\Carbon::parse($att->check_in_time)->format('H:i') : '-' }}</td>
                                <td class="text-danger fw-bold">{{ $att->check_out_time ? \Carbon\Carbon::parse($att->check_out_time)->format('H:i') : '-' }}</td>
                                <td>
                                    @if($att->check_out_time)
                                        <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-check-double me-1"></i>Completo</span>
                                    @elseif($att->check_in_time)
                                        <span class="badge bg-warning bg-opacity-10 text-warning text-dark"><i class="fa-solid fa-clock me-1"></i>No escritório</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Ausente</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if(count($allAttendances) === 0)
                            <tr><td colspan="5" class="text-center py-5 text-muted">Nenhum registo encontrado.</td></tr>
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
