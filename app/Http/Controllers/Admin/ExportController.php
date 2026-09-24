<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use App\Models\User;
use App\Models\Product;
use App\Models\Course;
use App\Models\Service;
use App\Models\CrmPayment;
use App\Models\CrmCashMovement;
use App\Models\Tuition;

class ExportController extends Controller
{
    /**
     * Retorna os dados e meta-informacao de uma lista.
     */
    private function resolveList(string $list): array
    {
        switch ($list) {
            case 'alunos':
                $rows = User::whereHas('roles', fn($q) => $q->whereIn('name', ['aluno', 'cliente', 'empresa']))
                    ->orWhereDoesntHave('roles')
                    ->get()
                    ->map(fn($u) => [
                        $u->name,
                        $u->email,
                        $u->phone ?? 'N/D',
                        $u->getRoleNames()->first() ?? 'Aluno',
                        $u->is_active ? 'Ativo' : 'Inativo',
                        $u->created_at->format('d/m/Y'),
                    ]);
                $headings = ['Nome', 'Email', 'Contacto', 'Perfil', 'Estado', 'Data Registo'];
                $title    = 'Clientes e Alunos';
                break;

            case 'funcionarios':
                $rows = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'tech', 'formador', 'instrutor']))
                    ->get()
                    ->map(fn($u) => [
                        $u->name,
                        $u->email,
                        $u->phone ?? 'N/D',
                        $u->getRoleNames()->first() ?? 'N/D',
                        $u->is_active ? 'Ativo' : 'Inativo',
                        $u->created_at->format('d/m/Y'),
                    ]);
                $headings = ['Nome', 'Email', 'Contacto', 'Cargo', 'Estado', 'Data Registo'];
                $title    = 'Funcionarios';
                break;

            case 'produtos':
                $rows = Product::latest()->get()->map(fn($p) => [
                    $p->name,
                    $p->description ? \Illuminate\Support\Str::limit(strip_tags($p->description), 60) : 'N/D',
                    number_format($p->price, 2, ',', '.') . ' Kz',
                    $p->created_at->format('d/m/Y'),
                ]);
                $headings = ['Nome', 'Descricao', 'Preco', 'Data Registo'];
                $title    = 'Produtos';
                break;

            case 'servicos':
                $rows = Service::latest()->get()->map(fn($s) => [
                    $s->title,
                    $s->description ? \Illuminate\Support\Str::limit(strip_tags($s->description), 60) : 'N/D',
                    number_format($s->price ?? 0, 2, ',', '.') . ' Kz',
                    $s->created_at->format('d/m/Y'),
                ]);
                $headings = ['Titulo', 'Descricao', 'Preco', 'Data Registo'];
                $title    = 'Servicos';
                break;

            case 'cursos':
                $rows = Course::with('category')->latest()->get()->map(fn($c) => [
                    $c->title,
                    $c->category->name ?? 'N/D',
                    number_format($c->price ?? 0, 2, ',', '.') . ' Kz',
                    $c->created_at->format('d/m/Y'),
                ]);
                $headings = ['Titulo', 'Categoria', 'Preco', 'Data Registo'];
                $title    = 'Cursos';
                break;

            case 'pagamentos':
                $rows = CrmPayment::with(['client', 'employee'])->latest()->get()->map(fn($p) => [
                    $p->date,
                    $p->reference,
                    $p->client->name ?? 'N/D',
                    $p->item_consumed ?? 'N/D',
                    ucfirst($p->method),
                    number_format($p->amount, 2, ',', '.') . ' Kz',
                    $p->status === 'approved' ? 'Aprovado' : 'Pendente',
                    $p->employee->name ?? 'N/D',
                ]);
                $headings = ['Data', 'Referencia', 'Cliente', 'Item Consumido', 'Metodo', 'Valor', 'Estado', 'Registado por'];
                $title    = 'Pagamentos';
                break;

            case 'caixa':
                $rows = CrmCashMovement::with('employee')->latest()->get()->map(fn($m) => [
                    $m->date,
                    $m->type === 'in' ? 'Entrada' : 'Saida',
                    number_format($m->amount, 2, ',', '.') . ' Kz',
                    $m->description,
                    $m->reference,
                    $m->employee->name ?? 'N/D',
                ]);
                $headings = ['Data', 'Tipo', 'Valor', 'Descricao', 'Referencia', 'Funcionario'];
                $title    = 'Movimentos de Caixa';
                break;

            case 'propinas':
                $mes = request('mes', date('m/Y'));
                $status = request('status');

                $query = Tuition::with(['user', 'turma.course']);

                if ($mes) {
                    $query->where('reference_month', $mes);
                }

                if ($status && in_array($status, ['pending', 'paid'])) {
                    $query->where('status', $status);
                } elseif (request()->has('dividas') || request()->boolean('apenas_dividas')) {
                    $query->where('status', 'pending');
                }

                $rows = $query->get()->map(fn($t) => [
                    $t->user->name ?? 'N/D',
                    $t->user->email ?? 'N/D',
                    $t->turma->name ?? 'N/D',
                    $t->turma->course->title ?? 'N/D',
                    $t->reference_month,
                    $t->due_date ? \Carbon\Carbon::parse($t->due_date)->format('d/m/Y') : 'N/D',
                    number_format($t->amount, 2, ',', '.') . ' Kz',
                    $t->status === 'paid' ? 'Pago' : ($t->due_date && \Carbon\Carbon::parse($t->due_date)->isPast() ? 'Inadimplente (Atrasado)' : 'Pendente'),
                ]);
                $headings = ['Aluno', 'Email', 'Turma', 'Curso', 'Mes Ref.', 'Vencimento', 'Valor', 'Estado'];
                $suffix   = ($status === 'pending' || request()->has('dividas') || request()->boolean('apenas_dividas')) ? ' (Dividas)' : '';
                $title    = 'Propinas - ' . $mes . $suffix;
                break;

            case 'inadimplentes':
            case 'dividas':
                $mes = request('mes');
                $query = Tuition::with(['user', 'turma.course'])
                    ->where('status', 'pending');

                if ($mes) {
                    $query->where('reference_month', $mes);
                }

                $rows = $query->orderBy('due_date', 'asc')->get()->map(fn($t) => [
                    $t->user->name ?? 'N/D',
                    $t->user->email ?? 'N/D',
                    $t->turma->name ?? 'N/D',
                    $t->turma->course->title ?? 'N/D',
                    $t->reference_month,
                    $t->due_date ? \Carbon\Carbon::parse($t->due_date)->format('d/m/Y') : 'N/D',
                    number_format($t->amount, 2, ',', '.') . ' Kz',
                    $t->due_date && \Carbon\Carbon::parse($t->due_date)->isPast() ? 'Atrasado (Vencido)' : 'Pendente',
                ]);
                $headings = ['Aluno', 'Email', 'Turma', 'Curso', 'Mes Ref.', 'Vencimento', 'Valor em Divida', 'Situacao'];
                $title    = 'Alunos com Dividas' . ($mes ? ' - ' . $mes : '');
                break;

            case 'auditoria':
                $query = \Spatie\Activitylog\Models\Activity::with('causer')->latest();
                if (request()->filled('log_name')) {
                    $query->where('log_name', request('log_name'));
                }
                $rows = $query->limit(500)->get()->map(fn($a) => [
                    $a->created_at->format('d/m/Y H:i:s'),
                    $a->causer->name ?? 'Sistema',
                    $a->log_name,
                    $a->description,
                    $a->subject_type ? class_basename($a->subject_type) . ' #' . $a->subject_id : 'N/D',
                ]);
                $headings = ['Data/Hora', 'Utilizador', 'Modulo', 'Acao / Descricao', 'Alvo'];
                $title    = 'Logs de Auditoria';
                break;

            default:
                abort(404, 'Lista de exportacao nao encontrada.');
        }

        return ['rows' => $rows, 'headings' => $headings, 'title' => $title];
    }

    /**
     * Sanitiza o nome do ficheiro para download seguro sem barras ou caracteres inválidos.
     */
    private function sanitizeFilename(string $filename): string
    {
        return str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $filename);
    }

    public function exportExcel(string $list)
    {
        $meta = $this->resolveList($list);
        $filename = $this->sanitizeFilename($meta['title'] . ' - ' . now()->format('d-m-Y') . '.xlsx');
        return Excel::download(new GenericExport($meta['rows'], $meta['headings'], $meta['title']), $filename);
    }

    public function exportPdf(string $list)
    {
        $meta  = $this->resolveList($list);
        $pdf   = Pdf::loadView('admin.exports.pdf_template', [
            'title'    => $meta['title'],
            'headings' => $meta['headings'],
            'rows'     => $meta['rows'],
            'date'     => now()->format('d/m/Y H:i'),
        ])->setPaper('a4', 'landscape');

        $filename = $this->sanitizeFilename($meta['title'] . ' - ' . now()->format('d-m-Y') . '.pdf');
        return $pdf->download($filename);
    }
}
