@extends('layouts.app')

@section('title', 'Services médicaux')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="fw-bold text-primary mb-1">
            <i class="fas fa-stethoscope me-2"></i>Services médicaux disponibles
        </h2>
        <p class="text-muted mb-0">Consultez nos services et réservez un créneau en ligne.</p>
    </div>
</div>

@if($services->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>Aucun service disponible pour le moment.
    </div>
@else
    <div class="row g-4">
        @php
            $icons = ['heartbeat','user-md','pills','microscope','tooth','brain','lungs','stethoscope'];
        @endphp
        @foreach($services as $service)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4" style="transition:transform .25s,box-shadow .25s;"
                 onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 12px 30px rgba(78,115,223,0.18)'"
                 onmouseout="this.style.transform='';this.style.boxShadow=''">
                <div class="card-header border-0 text-center py-4 rounded-top-4"
                     style="background: linear-gradient(135deg,#4e73df,#36b9cc);">
                    <i class="fas fa-{{ $icons[$loop->index % count($icons)] }} fa-2x text-white opacity-75"></i>
                </div>
                <div class="card-body d-flex flex-column p-4">
                    <h5 class="fw-bold text-dark mb-1">{{ $service->titre }}</h5>
                    <p class="text-muted small flex-grow-1">{{ Str::limit($service->description, 100) }}</p>

                    @if($service->medecin)
                    <div class="d-flex align-items-center p-2 bg-light rounded-3 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                             style="width:36px;height:36px;background:linear-gradient(135deg,#4e73df,#224abe);">
                            <i class="fas fa-user-md text-white" style="font-size:.75rem;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size:.85rem;">Dr. {{ $service->medecin->name }}</div>
                            <div class="text-muted" style="font-size:.75rem;">Médecin assigné</div>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge rounded-pill px-3 py-2 fw-bold"
                              style="background:linear-gradient(135deg,#1cc88a,#13855c);color:#fff;">
                            {{ number_format($service->prix, 0, ',', ' ') }} FCFA
                        </span>
                        <span class="badge rounded-pill px-3 py-2 fw-semibold"
                              style="background:#e8f6fd;color:#36b9cc;">
                            <i class="fas fa-clock me-1"></i>{{ $service->duree }} min
                        </span>
                    </div>

                    <div class="d-flex gap-2 mt-auto">
                        <a href="/services/{{ $service->id }}" class="btn btn-outline-primary btn-sm flex-fill rounded-pill">
                            <i class="fas fa-eye me-1"></i>Détails
                        </a>
                        @auth
                            @if(auth()->user()->role === 'patient')
                                <a href="/reservation/{{ $service->id }}/create" class="btn btn-primary btn-sm flex-fill rounded-pill">
                                    <i class="fas fa-calendar-plus me-1"></i>Réserver
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm flex-fill rounded-pill">
                                <i class="fas fa-sign-in-alt me-1"></i>Réserver
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
