@extends('layouts.app')

@section('title', 'Services médicaux')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="font-weight-bold text-primary">
            <i class="fas fa-stethoscope mr-2"></i>Services médicaux disponibles
        </h2>
        <p class="text-muted">Consultez nos services et réservez un créneau en ligne.</p>
    </div>
</div>

@if($services->isEmpty())
    <div class="alert alert-info">Aucun service disponible pour le moment.</div>
@else
    <div class="row">
        @foreach($services as $service)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary font-weight-bold">
                        <i class="fas fa-heartbeat mr-1"></i> {{ $service->titre }}
                    </h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($service->description, 100) }}</p>
                    <ul class="list-unstyled small mb-3">
                        <li><i class="fas fa-tag text-success mr-1"></i> <strong>{{ number_format($service->prix, 0, ',', ' ') }} FCFA</strong></li>
                        <li><i class="fas fa-clock text-info mr-1"></i> {{ $service->duree }} minutes</li>
                        @if($service->medecin)
                            <li><i class="fas fa-user-md text-primary mr-1"></i> Dr. {{ $service->medecin->name }}</li>
                        @endif
                    </ul>
                    <div class="mt-auto">
                        <a href="/services/{{ $service->id }}" class="btn btn-outline-primary btn-sm mr-1">
                            <i class="fas fa-eye"></i> Détails
                        </a>
                        @auth
                            @if(auth()->user()->role === 'patient')
                                <a href="/reservation/{{ $service->id }}/create" class="btn btn-primary btn-sm">
                                    <i class="fas fa-calendar-plus"></i> Réserver
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-sign-in-alt"></i> Connexion pour réserver
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
