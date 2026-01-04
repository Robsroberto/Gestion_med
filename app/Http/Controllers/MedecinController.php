<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
class MedecinController extends Controller
{
    public function services()
    {
        // $services = Service::where('medecin_id', auth()->id())->get();
        $services = Service::where('medecin_id',Auth::id())->get();
        return view('medecin.services', compact('services'));
    }
    
    public function reservations()
    {
        $reservations = Reservation::with(['service','user'])
        ->whereHas('service', function ($q) {
            // $q->where('medecin_id', auth()->id());
            $q->where('medecin_id', Auth::id());
        })
        ->get();
        return view('medecin.reservations', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
        'statut' => 'required|in:confirmée,annulée,effectuée',
        ]);
        $reservation = Reservation::findOrFail($id);
        // if ($reservation->service->medecin_id != auth()->id()) {
        if ($reservation->service->medecin_id !=Auth::id()) {
            abort(403);
        }
        $reservation->update($validated);
        return back()->with('success', 'Statut mis à jour.');
    }
}
