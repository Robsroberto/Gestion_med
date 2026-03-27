<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{
    /* =============================================
     |  SERVICES
     ============================================= */

    /** GET /api/v1/admin/services */
    public function servicesIndex()
    {
        $services = Service::with('medecin:id,name')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $services]);
    }

    /** POST /api/v1/admin/services */
    public function servicesStore(Request $request)
    {
        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'prix'        => 'required|numeric|min:0',
            'duree'       => 'required|integer|min:1',
            'statut'      => 'required|in:actif,inactif',
            'medecin_id'  => 'nullable|exists:users,id',
        ]);

        $service = Service::create($validated);

        return response()->json(['message' => 'Service créé.', 'data' => $service], 201);
    }

    /** PUT /api/v1/admin/services/{id} */
    public function servicesUpdate(Request $request, $id)
    {
        $service   = Service::findOrFail($id);
        $validated = $request->validate([
            'titre'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'prix'        => 'sometimes|numeric|min:0',
            'duree'       => 'sometimes|integer|min:1',
            'statut'      => 'sometimes|in:actif,inactif',
            'medecin_id'  => 'nullable|exists:users,id',
        ]);

        $service->update($validated);

        return response()->json(['message' => 'Service mis à jour.', 'data' => $service]);
    }

    /** DELETE /api/v1/admin/services/{id} */
    public function servicesDestroy($id)
    {
        Service::findOrFail($id)->delete();

        return response()->json(['message' => 'Service supprimé.']);
    }

    /** POST /api/v1/admin/services/{id}/assign */
    public function servicesAssign(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $request->validate(['medecin_id' => 'nullable|exists:users,id']);
        $service->update(['medecin_id' => $request->medecin_id]);

        return response()->json(['message' => 'Médecin assigné.']);
    }

    /* =============================================
     |  RESERVATIONS
     ============================================= */

    /** GET /api/v1/admin/reservations */
    public function reservationsIndex()
    {
        $reservations = Reservation::with(['user:id,name,email', 'service:id,titre'])
            ->orderBy('date_reservation', 'desc')
            ->get();

        return response()->json(['data' => $reservations]);
    }

    /** POST /api/v1/admin/reservations/{id}/cancel */
    public function reservationsCancel($id)
    {
        Reservation::findOrFail($id)->update(['statut' => 'annulee']);

        return response()->json(['message' => 'Réservation annulée.']);
    }

    /* =============================================
     |  USERS
     ============================================= */

    /** GET /api/v1/admin/users */
    public function usersIndex()
    {
        $users = User::withCount('reservations')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($u) => [
                'id'                  => $u->id,
                'name'                => $u->name,
                'email'               => $u->email,
                'role'                => $u->role,
                'actif'               => $u->email_verified_at !== null,
                'reservations_count'  => $u->reservations_count,
            ]);

        return response()->json(['data' => $users]);
    }

    /** POST /api/v1/admin/users/{id}/set-role */
    public function usersSetRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|in:admin,medecin,patient']);
        User::findOrFail($id)->update(['role' => $request->role]);

        return response()->json(['message' => 'Rôle mis à jour.']);
    }

    /** POST /api/v1/admin/users/{id}/toggle */
    public function usersToggle($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'email_verified_at' => $user->email_verified_at ? null : now(),
        ]);

        return response()->json([
            'message' => $user->email_verified_at ? 'Utilisateur désactivé.' : 'Utilisateur activé.',
        ]);
    }
}
