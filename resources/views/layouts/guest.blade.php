<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Autenticação</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --asoft-primary: #0f172a;
            --asoft-secondary: #1e293b;
            --asoft-accent: #facc15;
            --asoft-light: #f8fafc;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--asoft-light);
        }
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
        }
        .auth-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(15,23,42,0.95) 0%, rgba(30,41,59,0.95) 100%), url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
            padding: 3rem 2.5rem;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .auth-logo {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .form-control {
            padding: 0.8rem 1.2rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s;
        }
        .form-control:focus {
            background-color: white;
            border-color: var(--asoft-primary);
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.1);
        }
        .btn-brand {
            background-color: var(--asoft-primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 700;
            transition: all 0.3s;
        }
        .btn-brand:hover {
            background-color: var(--asoft-accent);
            color: var(--asoft-primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(250, 204, 21, 0.3);
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-bg"></div>
        
        <div class="w-100 d-flex flex-column align-items-center">
            <a href="/" class="text-decoration-none text-white text-center mb-4">
                <div class="auth-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 45px; height: 45px; object-fit: contain;">
                </div>
                <h2 class="fw-bolder tracking-wide m-0" style="letter-spacing: 2px;">ASOFT<span style="color: var(--asoft-accent);">MEDIA</span></h2>
            </a>

            <div class="auth-card">
                {{ $slot }}
            </div>

            <div class="mt-4 text-white-50 small">
                &copy; {{ date('Y') }} Asoftmedia. Todos os direitos reservados.
            </div>
        </div>
    </div>
</body>
</html>
