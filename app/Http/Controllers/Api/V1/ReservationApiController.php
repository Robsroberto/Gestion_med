<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationApiController extends Controller
{
    /**
     * GET /api/v1/reservations  (patient)
     */
    public function myReservations()
    {
        $reservations = Reservation::with(['service:id,titre,prix,duree'])
            ->where('user_id', Auth::id())
            ->orderBy('date_reservation', 'desc')
            ->get()
            ->map(fn($r) => $this->format($r));

        return response()->json(['data' => $reservations]);
    }

    /**
     * POST /api/v1/reservations  (patient)
     * Body: { service_id, date_reservation, heure_reservation, commentaire? }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'        => 'required|exists:services,id',
            'date_reservation'  => 'required|date|after_or_equal:today',
            'heure_reservation' => 'required',
            'commentaire'       => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['statut']  = 'en_attente';

        $reservation = Reservation::create($validated);
        $reservation->load('service:id,titre');

        return response()->json([
            'message' => 'Réservation créée.',
            'data'    => $this->format($reservation),
        ], 201);
    }

    /**
     * POST /api/v1/reservations/{id}/cancel  (patient)
     */
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        if ($reservation->statut !== 'en_attente') {
            return response()->json(['message' => 'Impossible d\'annuler cette réservation.'], 422);
        }

        $reservation->update(['statut' => 'annulee']);

        return response()->json(['message' => 'Réservation annulée.']);
    }

    /**
     * GET /api/v1/medecin/reservations  (medecin)
     */
    public function medecinReservations()
    {
        $reservations = Reservation::with(['service:id,titre', 'user:id,name,email'])
            ->whereHas('service', fn($q) => $q->where('medecin_id', Auth::id()))
            ->orderBy('date_reservation', 'desc')
            ->get()
            ->map(fn($r) => $this->format($r, true));

        return response()->json(['data' => $reservations]);
    }

    /**
     * POST /api/v1/medecin/reservations/{id}/update-status  (medecin)
     * Body: { statut: "confirmée" | "annulée" | "effectuée" }
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:confirmée,annulée,effectuée',
        ]);

        $reservation = Reservation::with('service')->findOrFail($id);

        if ($reservation->service->medecin_id !== Auth::id()) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $reservation->update(['statut' => $request->statut]);

        return response()->json(['message' => 'Statut mis à jour.']);
    }

    private function format(Reservation $r, bool $withUser = false): array
    {
        $data = [
            'id'                => $r->id,
            'service'           => $r->service ? ['id' => $r->service->id, 'titre' => $r->service->titre] : null,
            'date_reservation'  => $r->date_reservation,
            'heure_reservation' => $r->heure_reservation,
            'statut'            => $r->statut,
            'commentaire'       => $r->commentaire,
        ];

        if ($withUser && $r->user) {
            $data['patient'] = ['id' => $r->user->id, 'name' => $r->user->name, 'email' => $r->user->email];
        }

        return $data;
    }
}
