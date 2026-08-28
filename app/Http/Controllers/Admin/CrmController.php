<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CrmPayment;
use App\Models\CrmCashMovement;
use App\Models\User;

class CrmController extends Controller
{
    // --- PAGAMENTOS ---
    public function pagamentos()
    {
        $payments = CrmPayment::with(['client', 'employee'])->latest()->get();
        // Buscar apenas users que sejam clientes/alunos
        $clients = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['aluno', 'cliente', 'empresa']);
        })->orWhereDoesntHave('roles')->get();

        $courses = \App\Models\Course::latest()->get();
        $services = \App\Models\Service::latest()->get();
        $products = \App\Models\Product::latest()->get();

        return view('admin.pagamentos', compact('payments', 'clients', 'courses', 'services', 'products'));
    }

    public function registrarPagamento(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'status' => 'required|string',
            'client_id' => 'required|exists:users,id',
            'reference' => 'nullable|string',
            'item_consumed' => 'required|string'
        ]);

        $reference = $request->reference ?? 'PAG-' . strtoupper(uniqid());

        $payment = CrmPayment::create([
            'date' => $request->date,
            'amount' => $request->amount,
            'item_consumed' => $request->item_consumed,
            'method' => $request->method,
            'status' => $request->status,
            'client_id' => $request->client_id,
            'reference' => $reference,
            'observation' => $request->observation,
            'employee_id' => auth()->id()
        ]);

        // Se o pagamento for criado já como 'aprovado', gera movimento de caixa automático
        if ($payment->status === 'approved') {
            CrmCashMovement::create([
                'date' => $payment->date,
                'type' => 'in',
                'amount' => $payment->amount,
                'description' => 'Pagamento Recebido: ' . ($payment->client->name ?? 'Cliente Desconhecido'),
                'reference' => $payment->reference,
                'employee_id' => auth()->id()
            ]);
            
            // Se veio um tuition_id na request, atualiza o status da propina
            if ($request->has('tuition_id')) {
                \App\Models\Tuition::where('id', $request->tuition_id)->update([
                    'status' => 'paid',
                    'crm_payment_id' => $payment->id
                ]);
            }
        }

        return back()->with('success', 'Pagamento registado com sucesso!');
    }

    // --- CAIXA ---
    public function caixa()
    {
        $movements = CrmCashMovement::with('employee')->latest()->get();
        
        $totalEntradas = $movements->where('type', 'in')->sum('amount');
        $totalSaidas = $movements->where('type', 'out')->sum('amount');
        $saldo = $totalEntradas - $totalSaidas;

        return view('admin.caixa', compact('movements', 'totalEntradas', 'totalSaidas', 'saldo'));
    }

    public function registrarMovimentoCaixa(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        CrmCashMovement::create([
            'date' => $request->date,
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'reference' => $request->reference,
            'employee_id' => auth()->id()
        ]);

        return back()->with('success', 'Movimento de caixa registado com sucesso!');
    }

    // --- PROPINas (TUITIONS) ---
    public function propinas(Request $request)
    {
        $mesFiltro = $request->mes ?? date('m/Y');
        
        $tuitions = \App\Models\Tuition::with(['user', 'turma.course', 'payment'])
            ->where('reference_month', $mesFiltro)
            ->latest()
            ->get();
            
        $turmasAtivas = \App\Models\Turma::where('is_active', true)->count();
        
        return view('admin.propinas', compact('tuitions', 'mesFiltro', 'turmasAtivas'));
    }
    
    public function gerarPropinas(Request $request)
    {
        $mes = date('m/Y'); // Mês atual, ex: 08/2026
        
        // Calcular dia 10 do mês atual
        $dueDate = \Carbon\Carbon::now()->startOfMonth()->addDays(9)->format('Y-m-d');
        if (\Carbon\Carbon::now()->day > 10) {
            // Se já passou o dia 10, podemos estar a gerar para o próximo mês?
            // Para simplificar, gera sempre a propina deste mês atual referenciado
        }

        $turmas = \App\Models\Turma::with('users')->where('is_active', true)->get();
        $generated = 0;
        
        foreach ($turmas as $turma) {
            foreach ($turma->users as $user) {
                // Verificar se a propina já existe para este utilizador, nesta turma e mês
                $exists = \App\Models\Tuition::where('user_id', $user->id)
                    ->where('turma_id', $turma->id)
                    ->where('reference_month', $mes)
                    ->exists();
                    
                if (!$exists) {
                    \App\Models\Tuition::create([
                        'user_id' => $user->id,
                        'turma_id' => $turma->id,
                        'reference_month' => $mes,
                        'due_date' => $dueDate,
                        'amount' => $turma->monthly_fee,
                        'status' => 'pending'
                    ]);
                    $generated++;
                }
            }
        }
        
        return back()->with('success', "Propinas geradas com sucesso! ($generated novas cobranças geradas para $mes)");
    }

    // --- RELATÓRIOS ---
    public function relatorios()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        $mesEntradas = CrmCashMovement::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->where('type', 'in')
            ->sum('amount');

        $mesSaidas = CrmCashMovement::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->where('type', 'out')
            ->sum('amount');

        $mesPendentes = \App\Models\Tuition::whereMonth('due_date', $currentMonth)
            ->whereYear('due_date', $currentYear)
            ->where('status', 'pending')
            ->sum('amount');

        // Inadimplentes: Propinas pendentes onde a due_date já passou
        $inadimplentes = \App\Models\Tuition::with(['user', 'turma'])
            ->where('status', 'pending')
            ->where('due_date', '<', \Carbon\Carbon::today())
            ->orderBy('due_date', 'asc')
            ->get();

        return view('admin.relatorios', compact('mesEntradas', 'mesSaidas', 'mesPendentes', 'inadimplentes'));
    }
}
