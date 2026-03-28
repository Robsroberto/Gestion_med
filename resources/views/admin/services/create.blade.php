@extends('layouts.admin')

@section('title', 'Créer un service')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-plus-circle mr-2 text-primary"></i>Nouveau service
    </h1>
    <a href="/admin/services" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
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

                <form method="POST" action="/admin/services/store">
                    @csrf

                    <div class="form-group">
                        <label>Titre <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
                               value="{{ old('titre') }}" placeholder="Ex: Consultation générale" required>
                        @error('titre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="4" required>{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prix (FCFA) <span class="text-danger">*</span></label>
                                <input type="number" name="prix" class="form-control @error('prix') is-invalid @enderror"
                                       value="{{ old('prix') }}" min="0" required>
                                @error('prix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Durée (minutes) <span class="text-danger">*</span></label>
                                <input type="number" name="duree" class="form-control @error('duree') is-invalid @enderror"
                                       value="{{ old('duree', 30) }}" min="1" required>
                                @error('duree') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut</label>
                                <select name="statut" class="form-control">
                                    <option value="actif" {{ old('statut') === 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactif" {{ old('statut') === 'inactif' ? 'selected' : '' }}>Inactif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Médecin assigné</label>
                                <select name="medecin_id" class="form-control">
                                    <option value="">— Aucun —</option>
                                    @foreach($medecins as $m)
                                        <option value="{{ $m->id }}" {{ old('medecin_id') == $m->id ? 'selected' : '' }}>
                                            Dr. {{ $m->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Enregistrer
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
