<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceApiController extends Controller
{
    /**
     * GET /api/v1/services
     * Liste des services actifs (public)
     */
    public function index()
    {
        $services = Service::where('statut', 'actif')
            ->with('medecin:id,name')
            ->get()
            ->map(fn($s) => $this->format($s));

        return response()->json(['data' => $services]);
    }

    /**
     * GET /api/v1/services/{id}
     * Détails d'un service (public)
     */
    public function show($id)
    {
        $service = Service::with('medecin:id,name')->findOrFail($id);

        return response()->json(['data' => $this->format($service)]);
    }

    /**
     * GET /api/v1/medecin/services  (role: medecin)
     */
    public function myServices()
    {
        $services = Service::where('medecin_id', Auth::id())
            ->get()
            ->map(fn($s) => $this->format($s));

        return response()->json(['data' => $services]);
    }

    private function format(Service $s): array
    {
        return [
            'id'          => $s->id,
            'titre'       => $s->titre,
            'description' => $s->description,
            'prix'        => $s->prix,
            'duree'       => $s->duree,
            'statut'      => $s->statut,
            'medecin'     => $s->medecin ? ['id' => $s->medecin->id, 'name' => $s->medecin->name] : null,
        ];
    }
}
