@extends('layouts.admin')

@section('title', 'Mes réservations')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-calendar-alt mr-2 text-primary"></i>Mes réservations
    </h1>
    <a href="/services" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Nouvelle réservation
    </a>
</div>

@if($reservations->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-calendar-times fa-4x text-gray-300 mb-3 d-block"></i>
        <h5 class="text-muted">Vous n'avez aucune réservation</h5>
        <p class="text-muted small">Consultez nos services pour prendre votre premier rendez-vous.</p>
        <a href="/services" class="btn btn-primary mt-2">
            <i class="fas fa-stethoscope mr-2"></i>Voir les services
        </a>
    </div>
@else
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list-alt mr-2"></i>Historique de vos réservations
            </h6>
            <span class="badge badge-primary badge-pill">{{ $reservations->count() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="pl-4">Service</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Statut</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $r)
                        <tr>
                            <td class="pl-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                                         style="width:40px;height:40px;background:linear-gradient(135deg,#4e73df,#224abe);">
                                        <i class="fas fa-stethoscope text-white" style="font-size:.75rem;"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $r->service->titre ?? 'N/A' }}</div>
                                        <small class="text-muted">
                                            {{ number_format($r->service->prix ?? 0, 0, ',', ' ') }} FCFA
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-calendar text-primary mr-1"></i>
                                {{ \Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y') }}
                            </td>
                            <td>
                                <i class="fas fa-clock text-info mr-1"></i>
                                {{ $r->heure_reservation }}
                            </td>
                            <td>
                                @php
                                    $badges = [
                                        'en_attente' => 'warning',
                                        'confirmee'  => 'success',
                                        'annulee'    => 'danger',
                                        'effectuee'  => 'info',
                                    ];
                                    $labels = [
                                        'en_attente' => 'En attente',
                                        'confirmee'  => 'Confirmée',
                                        'annulee'    => 'Annulée',
                                        'effectuee'  => 'Effectuée',
                                    ];
                                    $badge = $badges[$r->statut] ?? 'secondary';
                                    $label = $labels[$r->statut] ?? ucfirst($r->statut);
                                @endphp
                                <span class="badge badge-{{ $badge }} badge-pill px-3 py-2">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($r->statut === 'en_attente')
                                    <form method="POST" action="/reservation/{{ $r->id }}/cancel"
                                          onsubmit="return confirm('Annuler cette réservation ?')">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-times mr-1"></i>Annuler
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
    </div>
@endif
@endsection
