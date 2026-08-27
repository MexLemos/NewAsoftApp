@extends('layouts.lms')

@section('title', 'O Meu Perfil')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 fw-bold">O Meu Perfil</h2>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold mb-0">Informações Pessoais</h5>
                        <p class="text-muted small">Atualize as informações da sua conta e endereço de email.</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            
                            <div class="d-flex align-items-center mb-4">
                                <div class="me-4 position-relative">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de perfil" class="rounded-circle object-fit-cover shadow-sm" style="width: 100px; height: 100px;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                                            <i class="fa-solid fa-user fs-1"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-1">Alterar Foto</label>
                                    <input type="file" name="photo" class="form-control form-control-sm w-auto" accept="image/*">
                                    <div class="text-muted small mt-1">JPG, GIF ou PNG. Máximo de 5MB.</div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nome Completo</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">E-mail</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Telemóvel (Opcional)</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+244 ...">
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary fw-bold" style="background-color: var(--asoft-primary); border: none;">Guardar Alterações</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold mb-0">Atalho de Pagamentos</h5>
                        <p class="text-muted small">Os seus dados facilitarão o preenchimento no momento da compra.</p>
                    </div>
                    <div class="card-body p-4 text-center">
                        <i class="fa-solid fa-shield-halved text-success mb-3" style="font-size: 3rem;"></i>
                        <h6 class="fw-bold">Privacidade Garantida</h6>
                        <p class="text-muted small mb-0">Os seus dados são utilizados apenas para faturação e comunicações essenciais sobre os seus cursos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
