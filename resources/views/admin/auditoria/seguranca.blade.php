@extends("layouts.admin")

@section("content")
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold"><i class="fa-solid fa-shield-halved text-danger me-2"></i>Relatorio de Seguranca</h2>
        <p class="text-muted mb-0">Analise automatica de padroes suspeitos — ultimas 24 horas.</p>
    </div>
    <a href="{{ route("admin.auditoria") }}" class="btn btn-outline-secondary fw-bold">
        <i class="fa-solid fa-list me-1"></i> Ver Todos os Logs
    </a>
</div>

{{-- RESUMO --}}
<div class="row g-3 mb-4">
    @php
        $metricCards = [
            ["label" => "Acoes Total (24h)",      "value" => $resumo["total_acoes"],  "icon" => "fa-bolt",              "color" => "primary"],
            ["label" => "Logins bem-sucedidos",   "value" => $resumo["logins_ok"],    "icon" => "fa-right-to-bracket",  "color" => "success"],
            ["label" => "Logins falhados",         "value" => $resumo["logins_fail"], "icon" => "fa-ban",               "color" => "danger"],
            ["label" => "Pagamentos registados",  "value" => $resumo["pagamentos"],   "icon" => "fa-money-bill",        "color" => "warning"],
            ["label" => "Certificados emitidos",  "value" => $resumo["certificados"], "icon" => "fa-certificate",       "color" => "info"],
            ["label" => "Registos de Ponto",      "value" => $resumo["pontos"],       "icon" => "fa-clock",             "color" => "secondary"],
        ];
    @endphp
    @foreach($metricCards as $card)
    <div class="col-md-2 col-sm-4 col-6">
        <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
            <i class="fa-solid {{ $card["icon"] }} fa-lg text-{{ $card["color"] }} mb-2"></i>
            <h4 class="fw-bold mb-0">{{ $card["value"] }}</h4>
            <span class="small text-muted">{{ $card["label"] }}</span>
        </div>
    </div>
    @endforeach
</div>

{{-- GRAFICO DE ATIVIDADE POR HORA --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-3"><i class="fa-solid fa-chart-bar me-2 text-primary"></i>Atividade por Hora (ultimas 24h)</h6>
        <div class="d-flex align-items-end gap-1" style="height: 80px;">
            @php $maxVal = max(array_merge(array_values($atividadePorHora), [1])); @endphp
            @for($h = 0; $h < 24; $h++)
                @php
                    $val  = $atividadePorHora[str_pad($h, 2, "0", STR_PAD_LEFT)] ?? 0;
                    $pct  = $maxVal > 0 ? round(($val / $maxVal) * 100) : 0;
                    $hora = now()->hour;
                    $isNow = $h == $hora;
                @endphp
                <div class="flex-grow-1 position-relative" title="{{ $h }}:00 — {{ $val }} acoes">
                    <div class="rounded-top" style="height: {{ max($pct, 3) }}%; background-color: {{ $isNow ? "#f59e0b" : ($val > 0 ? "#1e3a8a" : "#e2e8f0") }}; opacity: {{ $isNow ? 1 : 0.7 }}; transition: height 0.3s;"></div>
                </div>
            @endfor
        </div>
        <div class="d-flex justify-content-between mt-1" style="font-size: 0.65rem; color: #94a3b8;">
            <span>00h</span><span>06h</span><span>12h</span><span>18h</span><span>23h</span>
        </div>
    </div>
</div>

{{-- ALERTAS DE SEGURANCA --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-bottom-0 pt-4 px-4 pb-0">
        <h6 class="fw-bold mb-0">
            <i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>
            Alertas Detectados
            <span class="badge bg-danger ms-2">{{ count($alertas) }}</span>
        </h6>
    </div>
    <div class="card-body p-4">
        @forelse($alertas as $alerta)
        @php
            $borderMap = ["critico" => "border-danger", "suspeito" => "border-warning", "aviso" => "border-info"];
            $bgMap     = ["critico" => "bg-danger bg-opacity-10", "suspeito" => "bg-warning bg-opacity-10", "aviso" => "bg-info bg-opacity-10"];
            $textMap   = ["critico" => "text-danger", "suspeito" => "text-warning", "aviso" => "text-info"];
        @endphp
        <div class="rounded-4 border-start border-4 p-3 mb-3 {{ $borderMap[$alerta["nivel"]] }} {{ $bgMap[$alerta["nivel"]] }}">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-start gap-3">
                    <div class="pt-1">
                        <i class="fa-solid {{ $alerta["icone"] }} fa-lg {{ $textMap[$alerta["nivel"]] }}"></i>
                    </div>
                    <div>
                        <div class="fw-bold {{ $textMap[$alerta["nivel"]] }}">{{ $alerta["titulo"] }}</div>
                        <div class="small text-dark mt-1">{!! $alerta["descricao"] !!}</div>
                        <div class="small text-muted mt-1">
                            <i class="fa-solid fa-clock me-1"></i>{{ $alerta["hora"] }}
                            @if($alerta["ip"] !== "N/D")
                                &nbsp;&bull;&nbsp;<i class="fa-solid fa-network-wired me-1"></i>{{ $alerta["ip"] }}
                            @endif
                        </div>
                    </div>
                </div>
                <span class="badge {{ $alerta["nivel"] === "critico" ? "bg-danger" : ($alerta["nivel"] === "suspeito" ? "bg-warning text-dark" : "bg-info") }} rounded-pill text-uppercase ms-2" style="font-size: 0.65rem;">
                    {{ $alerta["nivel"] }}
                </span>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fa-solid fa-shield-check fa-3x text-success mb-3"></i>
            <h5 class="fw-bold text-success">Sem alertas de seguranca!</h5>
            <p class="text-muted small">Nenhum padrao suspeito foi detectado nas ultimas 24 horas.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
