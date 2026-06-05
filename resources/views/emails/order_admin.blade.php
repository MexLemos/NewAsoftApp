<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { background-color: #1e3a8a; color: white; padding: 15px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Novo Pedido Recebido</h2>
        </div>
        <div class="content">
            <p>Olá Equipa Comercial,</p>
            <p>Um novo pedido de compra acabou de ser finalizado através do site.</p>
            <hr>
            <p><strong>Detalhes do Cliente:</strong><br>
            Nome: {{ $lead->name }}<br>
            Email: {{ $lead->email }}<br>
            Telemóvel: {{ $lead->phone }}</p>
            
            <p><strong>Resumo do Pedido:</strong><br>
            {!! nl2br(e($lead->message)) !!}</p>
            
            <p>Para ver o comprovativo e gerir este pedido, aceda à secção de Leads no Painel de Administração.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} ASoftMedia. Este é um email automático.
        </div>
    </div>
</body>
</html>
