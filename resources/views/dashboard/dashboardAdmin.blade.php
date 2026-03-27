@extends('layouts.admin')

@section('title', 'Tableau de bord Admin')

@section('content')
<!-- Titre -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-tachometer-alt mr-2 text-primary"></i>Tableau de bord
    </h1>
</div>

<!-- Cartes stats -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Services actifs</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_services'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total réservations</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_reservations'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En attente</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['en_attente'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Utilisateurs</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Raccourcis -->
<div class="row mt-2">
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-stethoscope mr-2"></i>Services</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Gérez les services médicaux : créer, modifier, supprimer, assigner un médecin.</p>
                <a href="/admin/services" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-right mr-1"></i>Gérer les services
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-calendar-check mr-2"></i>Réservations</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Consultez toutes les réservations et annulez si nécessaire.</p>
                <a href="/admin/reservations" class="btn btn-success btn-sm">
                    <i class="fas fa-arrow-right mr-1"></i>Voir les réservations
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-users mr-2"></i>Utilisateurs</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Gérez les rôles et activez/désactivez les comptes.</p>
                <a href="/admin/users" class="btn btn-info btn-sm text-white">
                    <i class="fas fa-arrow-right mr-1"></i>Gérer les utilisateurs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
