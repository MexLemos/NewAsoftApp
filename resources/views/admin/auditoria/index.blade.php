@extends("layouts.admin")

@section("content")
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 fw-bold">Logs de Auditoria</h2>
        <p class="text-muted mb-0">Registo completo de todas as acoes criticas do sistema.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route("admin.auditoria.seguranca") }}" class="btn btn-danger fw-bold">
            <i class="fa-solid fa-shield-halved me-1"></i> Relatorio de Seguranca
        </a>
        <x-export-buttons list="auditoria" />
    </div>
</div>

@if(session("success"))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session("success") }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- FILTROS --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route("admin.auditoria") }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Modulo / Categoria</label>
                <select name="log_name" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach($logNames as $name)
                        <option value="{{ $name }}" {{ request("log_name") == $name ? "selected" : "" }}>{{ ucfirst($name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Utilizador</label>
                <input type="text" name="causer" class="form-control form-control-sm" placeholder="Nome do utilizador..." value="{{ request("causer") }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">Data Inicio</label>
                <input type="date" name="from" class="form-control form-control-sm" value="{{ request("from") }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">Data Fim</label>
                <input type="date" name="to" class="form-control form-control-sm" value="{{ request("to") }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm fw-bold flex-grow-1" style="background-color: var(--asoft-primary); border:none;">Filtrar</button>
                <a href="{{ route("admin.auditoria") }}" class="btn btn-light btn-sm fw-bold">Limpar</a>
            </div>
        </form>
    </div>
</div>

{{-- TABELA DE LOGS --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-0 pb-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Data / Hora</th>
                        <th>Utilizador</th>
                        <th>Modulo</th>
                        <th>Descricao da Acao</th>
                        <th>IP</th>
                        <th class="text-end pe-4">Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="ps-4 text-muted">
                            <span class="fw-bold text-dark">{{ $log->created_at->format("d/m/Y") }}</span>
                            <div class="small">{{ $log->created_at->format("H:i:s") }}</div>
                        </td>
                        <td>
                            @if($log->causer)
                                <span class="fw-medium">{{ $log->causer->name }}</span>
                                <div class="small text-muted">{{ $log->causer->email }}</div>
                            @else
                                <span class="text-muted fst-italic">Sistema</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badgeMap = [
                                    "financeiro"    => "bg-success",
                                    "ponto"         => "bg-primary",
                                    "certificados"  => "bg-warning text-dark",
                                    "seguranca"     => "bg-danger",
                                    "autenticacao"  => "bg-secondary",
                                ];
                                $badge = $badgeMap[$log->log_name] ?? "bg-info";
                            @endphp
                            <span class="badge {{ $badge }} rounded-pill">{{ ucfirst($log->log_name ?? "sistema") }}</span>
                        </td>
                        <td class="fw-medium">{{ $log->description }}</td>
                        <td class="text-muted small">{{ $log->properties["ip"] ?? "—" }}</td>
                        <td class="text-end pe-4">
                            @if($log->properties->count() > 1)
                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#det{{ $log->id }}">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @if($log->properties->count() > 1)
                    <tr class="collapse" id="det{{ $log->id }}">
                        <td colspan="6" class="bg-light px-4 py-3">
                            <pre class="mb-0 small text-muted" style="font-size:0.75rem;">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-magnifying-glass fa-2x mb-3 d-block"></i>
                            Nenhum log encontrado para os filtros seleccionados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
