@extends('layouts.admin')

@section('title', 'Gestion des services')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-stethoscope mr-2 text-primary"></i>Services médicaux
    </h1>
    <a href="/admin/services/create" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Nouveau service
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Durée</th>
                    <th>Médecin</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $s->titre }}</strong><br>
                        <small class="text-muted">{{ Str::limit($s->description, 50) }}</small>
                    </td>
                    <td>{{ number_format($s->prix, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $s->duree }} min</td>
                    <td>{{ $s->medecin ? 'Dr. '.$s->medecin->name : '<span class="text-muted">—</span>' }}</td>
                    <td>
                        <span class="badge badge-{{ $s->statut === 'actif' ? 'success' : 'secondary' }}">
                            {{ $s->statut }}
                        </span>
                    </td>
                    <td>
                        <a href="/admin/services/{{ $s->id }}/edit" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="/admin/services/{{ $s->id }}/delete" class="d-inline"
                              onsubmit="return confirm('Supprimer ce service ?')">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Aucun service enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
