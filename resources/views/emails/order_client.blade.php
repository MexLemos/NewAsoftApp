<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { background-color: #f59e0b; color: white; padding: 15px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Confirmação do Seu Pedido</h2>
        </div>
        <div class="content">
            <p>Olá <strong>{{ explode(' ', $lead->name)[0] }}</strong>,</p>
            <p>Recebemos o seu pedido com sucesso! O comprovativo de pagamento que enviou está agora a ser analisado pela nossa equipa.</p>
            <p>Assim que o seu pagamento for validado, entraremos em contacto consigo para a entrega dos produtos ou ativação dos serviços solicitados.</p>
            
            <hr>
            <h4>Resumo do seu pedido:</h4>
            <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px;">
                {!! nl2br(e($lead->message)) !!}
            </div>
            
            <p>Se tiver alguma dúvida, por favor não hesite em contactar-nos através do email <strong>info@asoftmedia-ao.com</strong>.</p>
            <p>Obrigado por escolher a ASoftMedia!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} ASoftMedia.<br>
            Sapu 2, Luanda - Angola
        </div>
    </div>
</body>
</html>
