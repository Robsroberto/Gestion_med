@extends('layouts.admin')

@section('title', 'Mon espace')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user mr-2 text-primary"></i>Bonjour, {{ auth()->user()->name }}
    </h1>
</div>

<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mes réservations</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['mes_reservations'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
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
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list-alt mr-2"></i>Services disponibles</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Consultez nos services médicaux et réservez un créneau.</p>
                <a href="/services" class="btn btn-primary btn-sm">Voir les services</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-calendar mr-2"></i>Mes réservations</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Consultez l'historique de vos réservations et annulez si nécessaire.</p>
                <a href="/mes-reservations" class="btn btn-success btn-sm">Mes réservations</a>
            </div>
        </div>
    </div>
</div>
@endsection
