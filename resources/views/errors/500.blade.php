<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro Interno - ASoftMedia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .error-card { background: white; border-radius: 20px; padding: 3rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; max-width: 500px; width: 100%; }
        .error-code { font-size: 6rem; font-weight: 800; color: #020617; line-height: 1; margin-bottom: 1rem; }
        .error-icon { font-size: 4rem; color: #f59e0b; margin-bottom: 1rem; }
        .btn-brand { background-color: #020617; color: white; transition: all 0.3s; }
        .btn-brand:hover { background-color: #f59e0b; color: white; }
    </style>
</head>
<body>
    <div class="error-card">
        <i class="fa-solid fa-triangle-exclamation error-icon"></i>
        <div class="error-code">500</div>
        <h3 class="fw-bold mb-3">Oops! Erro Interno</h3>
        <p class="text-muted mb-4">Pedimos desculpa, mas ocorreu um problema inesperado nos nossos servidores. A nossa equipa técnica já foi notificada e está a trabalhar nisso.</p>
        <a href="/" class="btn btn-brand rounded-pill px-4 py-2 fw-bold"><i class="fa-solid fa-house me-2"></i> Voltar à Página Inicial</a>
    </div>
</body>
</html>
