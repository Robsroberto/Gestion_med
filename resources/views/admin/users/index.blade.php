@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-users mr-2 text-primary"></i>Utilisateurs
    </h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle actuel</th>
                    <th>Réservations</th>
                    <th>Changer rôle</th>
                    <th>Activer / Désactiver</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $u->name }}</strong></td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @php
                            $roleBadges = ['admin'=>'danger','medecin'=>'primary','patient'=>'success'];
                            $rb = $roleBadges[$u->role] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $rb }}">{{ $u->role }}</span>
                    </td>
                    <td class="text-center">{{ $u->reservations_count }}</td>
                    <td>
                        <form method="POST" action="/admin/users/{{ $u->id }}/set-role" class="d-flex">
                            @csrf
                            <select name="role" class="form-control form-control-sm mr-1" style="width:auto">
                                <option value="admin"   {{ $u->role === 'admin'   ? 'selected' : '' }}>admin</option>
                                <option value="medecin" {{ $u->role === 'medecin' ? 'selected' : '' }}>medecin</option>
                                <option value="patient" {{ $u->role === 'patient' ? 'selected' : '' }}>patient</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">OK</button>
                        </form>
                    </td>
                    <td>
                        @if(auth()->id() !== $u->id)
                        <form method="POST" action="/admin/users/{{ $u->id }}/toggle">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-{{ $u->email_verified_at ? 'warning' : 'success' }}">
                                @if($u->email_verified_at)
                                    <i class="fas fa-ban"></i> Désactiver
                                @else
                                    <i class="fas fa-check"></i> Activer
                                @endif
                            </button>
                        </form>
                        @else
                            <span class="text-muted small">Vous-même</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Aucun utilisateur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
