@extends('layouts.app')

@section('title', 'Réserver — '.$service->titre)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card shadow mb-3">
            <div class="card-body py-2 px-3 bg-light">
                <strong><i class="fas fa-stethoscope text-primary mr-1"></i>{{ $service->titre }}</strong>
                <span class="ml-3 text-muted small">{{ $service->duree }} min</span>
                <span class="ml-3 font-weight-bold text-success">{{ number_format($service->prix, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-plus mr-2"></i>Réserver ce service</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/reservation/store">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <div class="form-group">
                        <label><i class="fas fa-calendar mr-1"></i>Date de réservation</label>
                        <input type="date" name="date_reservation" class="form-control @error('date_reservation') is-invalid @enderror"
                               value="{{ old('date_reservation') }}" min="{{ date('Y-m-d') }}" required>
                        @error('date_reservation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-clock mr-1"></i>Heure de réservation</label>
                        <input type="time" name="heure_reservation" class="form-control @error('heure_reservation') is-invalid @enderror"
                               value="{{ old('heure_reservation') }}" required>
                        @error('heure_reservation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-comment mr-1"></i>Commentaire <small class="text-muted">(optionnel)</small></label>
                        <textarea name="commentaire" class="form-control" rows="3" placeholder="Précisez si nécessaire...">{{ old('commentaire') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/services" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Confirmer la réservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
