@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="font-weight-bold text-primary">
        <i class="fas fa-calendar mr-2"></i>Mes réservations
    </h2>
    <a href="/services" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvelle réservation
    </a>
</div>

@if($reservations->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-2"></i>Vous n'avez aucune réservation.
        <a href="/services" class="alert-link">Consulter les services disponibles</a>.
    </div>
@else
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $r)
                    <tr>
                        <td>
                            <strong>{{ $r->service->titre ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ number_format($r->service->prix ?? 0, 0, ',', ' ') }} FCFA</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y') }}</td>
                        <td>{{ $r->heure_reservation }}</td>
                        <td>
                            @php
                                $badges = [
                                    'en_attente' => 'warning',
                                    'confirmee'  => 'success',
                                    'annulee'    => 'danger',
                                    'effectuee'  => 'info',
                                ];
                                $badge = $badges[$r->statut] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $r->statut)) }}</span>
                        </td>
                        <td>
                            @if($r->statut === 'en_attente')
                                <form method="POST" action="/reservation/{{ $r->id }}/cancel"
                                      onsubmit="return confirm('Annuler cette réservation ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Annuler
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
