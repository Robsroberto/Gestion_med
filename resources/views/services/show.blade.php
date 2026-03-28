@extends('layouts.app')

@section('title', $service->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/services">Services</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($service->titre, 30) }}</li>
            </ol>
        </nav>

        <div class="card border-0 shadow rounded-4 overflow-hidden">
            {{-- Header --}}
            <div class="card-header border-0 py-4 px-4"
                 style="background:linear-gradient(135deg,#4e73df,#36b9cc);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:56px;height:56px;background:rgba(255,255,255,0.2);">
                        <i class="fas fa-stethoscope fa-lg text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-white fw-bold">{{ $service->titre }}</h4>
                        <span class="text-white opacity-75 small">Détails du service</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                {{-- Description --}}
                <p class="lead text-muted mb-4">{{ $service->description }}</p>

                {{-- Infos clés --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 text-center rounded-4" style="background:#f0f7f0;">
                            <i class="fas fa-tag fa-2x mb-2" style="color:#1cc88a;"></i>
                            <div class="fw-bold fs-5">{{ number_format($service->prix, 0, ',', ' ') }} FCFA</div>
                            <small class="text-muted">Tarif</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 text-center rounded-4" style="background:#e8f6fd;">
                            <i class="fas fa-clock fa-2x mb-2" style="color:#36b9cc;"></i>
                            <div class="fw-bold fs-5">{{ $service->duree }} min</div>
                            <small class="text-muted">Durée</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 text-center rounded-4" style="background:#eef2ff;">
                            <i class="fas fa-user-md fa-2x mb-2" style="color:#4e73df;"></i>
                            <div class="fw-bold">
                                {{ $service->medecin ? 'Dr. '.$service->medecin->name : 'Non assigné' }}
                            </div>
                            <small class="text-muted">Médecin</small>
                        </div>
                    </div>
                </div>

                {{-- Statut --}}
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="badge rounded-pill px-3 py-2 fw-semibold
                        {{ $service->statut === 'actif' ? 'bg-success' : 'bg-secondary' }}">
                        <i class="fas fa-circle me-1" style="font-size:.6rem;"></i>
                        {{ ucfirst($service->statut) }}
                    </span>
                </div>
            </div>

            <div class="card-footer bg-light border-0 px-4 py-3 d-flex justify-content-between align-items-center">
                <a href="/services" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                @if($service->statut === 'actif')
                    @auth
                        @if(auth()->user()->role === 'patient')
                            <a href="/reservation/{{ $service->id }}/create" class="btn btn-primary rounded-pill px-4 fw-bold">
                                <i class="fas fa-calendar-plus me-2"></i>Réserver ce service
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Connexion pour réserver
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
