@extends('layouts.admin')

@section('title', 'Mon tableau de bord')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-md mr-2 text-primary"></i>Bonjour, Dr. {{ auth()->user()->name }}
    </h1>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mes services</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['mes_services'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-stethoscope fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total réservations</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['reservations_total'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-check fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En attente</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['en_attente'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-stethoscope mr-2"></i>Mes services</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Consultez les services médicaux qui vous sont assignés.</p>
                <a href="/medecin/services" class="btn btn-primary btn-sm">Voir mes services</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-calendar-check mr-2"></i>Réservations</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Gérez les réservations de vos patients et mettez à jour les statuts.</p>
                <a href="/medecin/reservations" class="btn btn-success btn-sm">Voir les réservations</a>
            </div>
        </div>
    </div>
</div>
@endsection
