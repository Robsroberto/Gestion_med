@extends('layouts.admin')

@section('title', 'Mes services')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-stethoscope mr-2 text-primary"></i>Mes services
    </h1>
</div>

@if($services->isEmpty())
    <div class="alert alert-info">Aucun service ne vous est assigné pour le moment.</div>
@else
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Durée</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $s->titre }}</strong></td>
                        <td>{{ Str::limit($s->description, 60) }}</td>
                        <td>{{ number_format($s->prix, 0, ',', ' ') }} FCFA</td>
                        <td>{{ $s->duree }} min</td>
                        <td>
                            <span class="badge badge-{{ $s->statut === 'actif' ? 'success' : 'secondary' }}">
                                {{ $s->statut }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
