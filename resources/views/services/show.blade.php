@extends('layouts.app')

@section('title', $service->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-stethoscope mr-2"></i>{{ $service->titre }}</h4>
            </div>
            <div class="card-body">
                <p class="lead">{{ $service->description }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <div class="p-3 bg-light rounded">
                            <i class="fas fa-tag fa-2x text-success mb-2"></i>
                            <p class="mb-0 font-weight-bold">{{ number_format($service->prix, 0, ',', ' ') }} FCFA</p>
                            <small class="text-muted">Tarif</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="p-3 bg-light rounded">
                            <i class="fas fa-clock fa-2x text-info mb-2"></i>
                            <p class="mb-0 font-weight-bold">{{ $service->duree }} minutes</p>
                            <small class="text-muted">Durée</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="p-3 bg-light rounded">
                            <i class="fas fa-user-md fa-2x text-primary mb-2"></i>
                            <p class="mb-0 font-weight-bold">
                                {{ $service->medecin ? 'Dr. '.$service->medecin->name : 'Non assigné' }}
                            </p>
                            <small class="text-muted">Médecin</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="/services" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
                @auth
                    @if(auth()->user()->role === 'patient')
                        <a href="/reservation/{{ $service->id }}/create" class="btn btn-primary">
                            <i class="fas fa-calendar-plus"></i> Réserver ce service
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Connexion pour réserver
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
