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
                $rows = Tuition::with(['user', 'turma.course'])
                    ->where('reference_month', $mes)->get()->map(fn($t) => [
                        $t->user->name ?? 'N/D',
                        $t->user->email ?? 'N/D',
                        $t->turma->name ?? 'N/D',
                        $t->turma->course->title ?? 'N/D',
                        $t->reference_month,
                        \Carbon\Carbon::parse($t->due_date)->format('d/m/Y'),
                        number_format($t->amount, 2, ',', '.') . ' Kz',
                        $t->status === 'paid' ? 'Pago' : 'Pendente',
                    ]);
                $headings = ['Aluno', 'Email', 'Turma', 'Curso', 'Mes Ref.', 'Vencimento', 'Valor', 'Estado'];
                $title    = 'Propinas - ' . $mes;
                break;

            default:
                abort(404, 'Lista de exportacao nao encontrada.');
        }

        return ['rows' => $rows, 'headings' => $headings, 'title' => $title];
    }

    public function exportExcel(string $list)
    {
        $meta = $this->resolveList($list);
        $filename = $meta['title'] . ' - ' . now()->format('d-m-Y') . '.xlsx';
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

        $filename = $meta['title'] . ' - ' . now()->format('d-m-Y') . '.pdf';
        return $pdf->download($filename);
    }
}
