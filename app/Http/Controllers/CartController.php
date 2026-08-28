<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('pages.carrinho');
    }

    public function checkout()
    {
        return view('pages.checkout');
    }

    public function add(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $request->name,
                "quantity" => 1,
                "price" => $request->price,
                "image" => $request->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produto adicionado ao carrinho com sucesso!');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Produto removido com sucesso.');
        }
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = max(1, intval($request->quantity));
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Quantidade atualizada!');
        }
        return redirect()->back();
    }

    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'payment_method' => 'required',
            'proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        $proofPath = $request->file('proof')->store('comprovativos', 'public');
        
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('produtos')->with('error', 'O carrinho está vazio.');
        }

        $total = 0;
        $hasProducts = false;
        $itemsList = "";
        $hasPlan = false;
        
        foreach($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
            $itemsList .= "- " . $item['quantity'] . "x " . $item['name'] . " (Kz " . number_format($item['price'], 2, ',', '.') . ")\n";
            if (!str_starts_with((string)$id, 'course_') && !str_starts_with((string)$id, 'plan_')) {
                $hasProducts = true;
            } else {
                if (auth()->check()) {
                    if (str_starts_with((string)$id, 'course_')) {
                        $courseId = str_replace('course_', '', (string)$id);
                        \App\Models\Enrollment::firstOrCreate(
                            ['user_id' => auth()->id(), 'course_id' => $courseId],
                            ['status' => 'pending', 'progress_percent' => 0]
                        );
                    } elseif (str_starts_with((string)$id, 'plan_')) {
                        $hasPlan = true;
                    }
                }
            }
        }

        // Se o utilizador comprou um plano de assinatura, adicioná-lo a TODOS os cursos publicados
        if ($hasPlan && auth()->check()) {
            // Find which plan duration was purchased
            $durationMonths = 12; // Default to Anual
            foreach($cart as $id => $item) {
                if ($id === 'plan_pro_trimestral') {
                    $durationMonths = 3;
                }
            }

            $allCourses = \App\Models\Course::where('is_published', true)->get();
            foreach($allCourses as $c) {
                $enrollment = \App\Models\Enrollment::firstOrNew(
                    ['user_id' => auth()->id(), 'course_id' => $c->id]
                );
                $enrollment->status = 'pending';
                $enrollment->progress_percent = $enrollment->progress_percent ?? 0;
                $enrollment->expires_at = now()->addMonths($durationMonths);
                $enrollment->save();
            }
        }
        
        $tax = 0;
        $deliveryText = "N/A (Apenas produtos digitais)";
        if ($hasProducts) {
            $deliveryMode = $request->input('delivery_mode', 'delivery');
            if ($deliveryMode === 'delivery') {
                $tax = 3000;
                $deliveryText = "Entrega ao Domicílio";
            } else {
                $deliveryText = "Levantamento Presencial (Loja)";
            }
        }
        
        $grandTotal = $total + $tax;

        $fullName = $request->first_name . ' ' . $request->last_name;

        $msg = "--- NOVO PEDIDO DE COMPRA ---\n";
        $msg .= "Cliente: " . $fullName . " (NIF: " . ($request->nif ?? 'N/A') . ")\n";
        $msg .= "Morada: " . $request->address . "\n";
        $msg .= "Modo de Entrega: " . $deliveryText . "\n";
        $msg .= "Forma de Pagamento: " . $request->payment_method . "\n";
        $msg .= "\nITENS:\n" . $itemsList;
        $msg .= "\nRESUMO:\n";
        $msg .= "Subtotal: Kz " . number_format($total, 2, ',', '.') . "\n";
        $msg .= "Taxa Entrega: Kz " . number_format($tax, 2, ',', '.') . "\n";
        $msg .= "TOTAL: Kz " . number_format($grandTotal, 2, ',', '.') . "\n";
        $msg .= "\nCOMPROVATIVO:\n" . asset('storage/' . $proofPath) . "\n";
        
        $lead = \App\Models\Lead::create([
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $msg,
            'status' => 'new'
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to('info@softmedia-ao.com')->send(new \App\Mail\OrderAdminNotification($lead));
            \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\OrderClientNotification($lead));
        } catch (\Exception $e) {
            // Se falhar o email, a compra continua guardada nos leads
        }

        session()->forget('cart');

        return redirect()->route('produtos')->with('success', 'Pedido efetuado com sucesso! Receberá um e-mail de confirmação.');
    }
}
