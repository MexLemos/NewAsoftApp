<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Criar uma Conta</h3>
            <p class="text-muted small">Preencha os dados abaixo para se registar na plataforma.</p>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label fw-bold small text-muted">Nome Completo</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold small text-muted">E-mail</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold small text-muted">Senha</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-bold small text-muted">Confirmar Senha</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-brand btn-lg">Registar</button>
        </div>

        <div class="text-center small text-muted">
            Já tem uma conta? 
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--asoft-primary); font-weight: 700;">Entrar</a>
        </div>
    </form>
</x-guest-layout>
