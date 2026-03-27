<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'service'])
            ->orderBy('date_reservation', 'desc')
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['statut' => 'annulee']);

        return redirect('/admin/reservations')->with('success', 'Réservation annulée.');
    }
}
