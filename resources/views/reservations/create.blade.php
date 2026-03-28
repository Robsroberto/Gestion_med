@extends('layouts.admin')

@section('title', 'Réserver — '.$service->titre)

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-calendar-plus mr-2 text-primary"></i>Nouvelle réservation
    </h1>
    <a href="/services" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Retour aux services
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">

        {{-- Card récapitulatif service --}}
        <div class="card border-left-primary shadow mb-4">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                         style="width:50px;height:50px;background:linear-gradient(135deg,#4e73df,#224abe);">
                        <i class="fas fa-stethoscope text-white"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="font-weight-bold text-primary h5 mb-0">{{ $service->titre }}</div>
                        <div class="text-muted small mt-1">
                            <i class="fas fa-clock mr-1"></i>{{ $service->duree }} min
                            @if($service->medecin)
                                &nbsp;•&nbsp;
                                <i class="fas fa-user-md mr-1"></i>Dr. {{ $service->medecin->name }}
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="badge badge-success badge-pill px-3 py-2 font-weight-bold">
                            {{ number_format($service->prix, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire --}}
        <div class="card shadow">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="fas fa-calendar-check mr-2"></i>Choisissez votre créneau</h5>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/reservation/store">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">
                            <i class="fas fa-calendar mr-1 text-primary"></i>Date de réservation
                        </label>
                        <input type="date"
                               name="date_reservation"
                               class="form-control @error('date_reservation') is-invalid @enderror"
                               value="{{ old('date_reservation') }}"
                               min="{{ date('Y-m-d') }}"
                               required>
                        @error('date_reservation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">
                            <i class="fas fa-clock mr-1 text-info"></i>Heure de réservation
                        </label>
                        <input type="time"
                               name="heure_reservation"
                               class="form-control @error('heure_reservation') is-invalid @enderror"
                               value="{{ old('heure_reservation') }}"
                               required>
                        @error('heure_reservation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">
                            <i class="fas fa-comment mr-1 text-warning"></i>Commentaire
                            <small class="text-muted font-weight-normal">(optionnel)</small>
                        </label>
                        <textarea name="commentaire"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Précisez si nécessaire (symptômes, motif, etc.)...">{{ old('commentaire') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/services" class="btn btn-outline-secondary">
                            <i class="fas fa-times mr-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-check mr-2"></i>Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
