@extends('layouts.admin')

@section('title', 'Gestion des réservations')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-calendar-check mr-2 text-primary"></i>Toutes les réservations
    </h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Statut</th>
                    <th>Commentaire</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->user->name ?? 'N/A' }}</td>
                    <td>{{ $r->service->titre ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y') }}</td>
                    <td>{{ $r->heure_reservation }}</td>
                    <td>
                        @php
                            $badges = ['en_attente'=>'warning','confirmee'=>'success','annulee'=>'danger','effectuee'=>'info'];
                            $badge = $badges[$r->statut] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $badge }}">{{ ucfirst(str_replace('_',' ',$r->statut)) }}</span>
                    </td>
                    <td>{{ $r->commentaire ? Str::limit($r->commentaire, 40) : '—' }}</td>
                    <td>
                        @if($r->statut !== 'annulee')
                        <form method="POST" action="/admin/reservations/{{ $r->id }}/cancel"
                              onsubmit="return confirm('Annuler cette réservation ?')">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-ban"></i> Annuler
                            </button>
                        </form>
                        @else
                            <span class="text-muted small">Annulée</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Aucune réservation.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
