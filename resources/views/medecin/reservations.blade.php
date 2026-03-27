@extends('layouts.admin')

@section('title', 'Mes réservations')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-calendar-check mr-2 text-primary"></i>Réservations de mes services
    </h1>
</div>

@if($reservations->isEmpty())
    <div class="alert alert-info">Aucune réservation sur vos services.</div>
@else
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Patient</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Statut actuel</th>
                        <th>Changer statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $r)
                    <tr>
                        <td>{{ $r->user->name ?? 'N/A' }}</td>
                        <td>{{ $r->service->titre ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y') }}</td>
                        <td>{{ $r->heure_reservation }}</td>
                        <td>
                            @php
                                $badges = ['en_attente'=>'warning','confirmee'=>'success','annulee'=>'danger','effectuee'=>'info'];
                                $badge  = $badges[$r->statut] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $badge }}">{{ ucfirst(str_replace('_',' ',$r->statut)) }}</span>
                        </td>
                        <td>
                            @if($r->statut !== 'annulee' && $r->statut !== 'effectuee')
                            <form method="POST" action="/medecin/reservations/{{ $r->id }}/update-status" class="d-flex gap-1">
                                @csrf
                                <select name="statut" class="form-control form-control-sm mr-1" style="width:auto">
                                    <option value="confirmée" {{ $r->statut === 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                                    <option value="annulée"   {{ $r->statut === 'annulee'   ? 'selected' : '' }}>Annulée</option>
                                    <option value="effectuée" {{ $r->statut === 'effectuee' ? 'selected' : '' }}>Effectuée</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">OK</button>
                            </form>
                            @else
                                <span class="text-muted small">Terminé</span>
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
