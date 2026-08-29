<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with("causer")->latest();

        if ($request->filled("log_name")) {
            $query->where("log_name", $request->log_name);
        }
        if ($request->filled("causer")) {
            $query->whereHasMorph("causer", [\App\Models\User::class], function($q) use ($request) {
                $q->where("name", "like", "%" . $request->causer . "%");
            });
        }
        if ($request->filled("from")) {
            $query->whereDate("created_at", ">=", $request->from);
        }
        if ($request->filled("to")) {
            $query->whereDate("created_at", "<=", $request->to);
        }

        $logs = $query->paginate(50)->withQueryString();
        $logNames = Activity::distinct()->pluck("log_name")->filter()->sort()->values();

        return view("admin.auditoria.index", compact("logs", "logNames"));
    }

    public function seguranca()
    {
        $alertas = [];
        $agora   = Carbon::now();

        // ─── REGRA 1: Logins falhados em massa (brute force) ──────────────────────
        $loginsFalhados = Activity::where("log_name", "seguranca")
            ->where("description", "like", "Tentativa de login falhada%")
            ->where("created_at", ">=", $agora->copy()->subHour())
            ->get()
            ->groupBy(fn($a) => $a->properties["email"] ?? "desconhecido");

        foreach ($loginsFalhados as $email => $tentativas) {
            if ($tentativas->count() >= 3) {
                $alertas[] = [
                    "nivel"    => "critico",
                    "icone"    => "fa-skull-crossbones",
                    "cor"      => "danger",
                    "titulo"   => "Brute Force detectado",
                    "descricao"=> $tentativas->count() . " tentativas de login falhadas para o email <b>" . e($email) . "</b> na última hora.",
                    "hora"     => $tentativas->last()->created_at->format("d/m H:i"),
                    "ip"       => $tentativas->last()->properties["ip"] ?? "N/D",
                ];
            }
        }

        // ─── REGRA 2: Acesso fora de horário laboral ──────────────────────────────
        $acoesFora = Activity::whereNotIn("log_name", ["seguranca", "autenticacao"])
            ->where("created_at", ">=", $agora->copy()->subDay())
            ->get()
            ->filter(function ($log) {
                $hora = (int) $log->created_at->format("H");
                return $hora < 7 || $hora >= 20;
            });

        foreach ($acoesFora as $log) {
            $alertas[] = [
                "nivel"    => "aviso",
                "icone"    => "fa-moon",
                "cor"      => "warning",
                "titulo"   => "Ação fora do horário laboral",
                "descricao"=> "Utilizador <b>" . e($log->causer->name ?? "N/D") . "</b> realizou: " . e($log->description),
                "hora"     => $log->created_at->format("d/m H:i"),
                "ip"       => $log->properties["ip"] ?? "N/D",
            ];
        }

        // ─── REGRA 3: Muitos pagamentos num curto período (anomalia financeira) ────
        $pagamentosRecentes = Activity::where("log_name", "financeiro")
            ->where("description", "like", "Pagamento registado%")
            ->where("created_at", ">=", $agora->copy()->subHour())
            ->get()
            ->groupBy("causer_id");

        foreach ($pagamentosRecentes as $userId => $pagamentos) {
            if ($pagamentos->count() >= 5) {
                $alertas[] = [
                    "nivel"    => "suspeito",
                    "icone"    => "fa-money-bill-trend-up",
                    "cor"      => "orange",
                    "titulo"   => "Volume anormal de pagamentos",
                    "descricao"=> "O utilizador <b>" . e($pagamentos->first()->causer->name ?? "N/D") . "</b> registou <b>" . $pagamentos->count() . " pagamentos</b> na última hora.",
                    "hora"     => $pagamentos->last()->created_at->format("d/m H:i"),
                    "ip"       => $pagamentos->last()->properties["ip"] ?? "N/D",
                ];
            }
        }

        // ─── REGRA 4: Certificados em série ───────────────────────────────────────
        $certs = Activity::where("log_name", "certificados")
            ->where("created_at", ">=", $agora->copy()->subHour())
            ->get()
            ->groupBy("causer_id");

        foreach ($certs as $userId => $certLogs) {
            if ($certLogs->count() >= 3) {
                $alertas[] = [
                    "nivel"    => "suspeito",
                    "icone"    => "fa-certificate",
                    "cor"      => "warning",
                    "titulo"   => "Emissão em série de certificados",
                    "descricao"=> "O utilizador <b>" . e($certLogs->first()->causer->name ?? "N/D") . "</b> emitiu <b>" . $certLogs->count() . " certificados</b> na última hora.",
                    "hora"     => $certLogs->last()->created_at->format("d/m H:i"),
                    "ip"       => "N/D",
                ];
            }
        }

        // ─── RESUMO DE ATIVIDADE (últimas 24h) ────────────────────────────────────
        $resumo = [
            "total_acoes"    => Activity::where("created_at", ">=", $agora->copy()->subDay())->count(),
            "logins_ok"      => Activity::where("log_name", "autenticacao")->where("description", "like", "Login bem%")->where("created_at", ">=", $agora->copy()->subDay())->count(),
            "logins_fail"    => Activity::where("log_name", "seguranca")->where("created_at", ">=", $agora->copy()->subDay())->count(),
            "pagamentos"     => Activity::where("log_name", "financeiro")->where("description", "like", "Pagamento%")->where("created_at", ">=", $agora->copy()->subDay())->count(),
            "certificados"   => Activity::where("log_name", "certificados")->where("created_at", ">=", $agora->copy()->subDay())->count(),
            "pontos"         => Activity::where("log_name", "ponto")->where("created_at", ">=", $agora->copy()->subDay())->count(),
        ];

        // Atividade por hora (últimas 24h) para o gráfico
        $atividadePorHora = Activity::where("created_at", ">=", $agora->copy()->subDay())
            ->get()
            ->groupBy(fn($a) => $a->created_at->format("H"))
            ->map(fn($g) => $g->count())
            ->toArray();

        // Ordenar alertas por nível (critico > suspeito > aviso)
        $ordem = ["critico" => 0, "suspeito" => 1, "aviso" => 2];
        usort($alertas, fn($a, $b) => ($ordem[$a["nivel"]] ?? 9) - ($ordem[$b["nivel"]] ?? 9));

        return view("admin.auditoria.seguranca", compact("alertas", "resumo", "atividadePorHora"));
    }
}
