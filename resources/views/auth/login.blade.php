<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Bem-vindo de volta</h3>
            <p class="text-muted small">Insira as suas credenciais para aceder à plataforma.</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success small py-2">{{ session('status') }}</div>
        @endif

        <div class="mb-3">
            <label for="email" class="form-label fw-bold small text-muted">E-mail</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold small text-muted">Senha</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label small text-muted" for="remember_me">
                    Lembrar de mim
                </label>
            </div>
            @if (Route::has('password.request'))
                <a class="text-decoration-none small" href="{{ route('password.request') }}" style="color: var(--asoft-primary); font-weight: 600;">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-brand btn-lg">Entrar</button>
        </div>

        <div class="text-center small text-muted">
            Ainda não tem conta? 
            <a href="{{ route('register') }}" class="text-decoration-none" style="color: var(--asoft-primary); font-weight: 700;">Registar-se</a>
        </div>
    </form>
</x-guest-layout>
