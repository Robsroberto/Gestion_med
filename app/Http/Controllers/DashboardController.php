<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $stats = [
                'total_services'     => Service::count(),
                'total_reservations' => Reservation::count(),
                'total_users'        => User::count(),
                'en_attente'         => Reservation::where('statut', 'en_attente')->count(),
            ];
            return view('dashboard.dashboardAdmin', compact('stats'));
        }

        if ($user->role === 'medecin') {
            $stats = [
                'mes_services'      => Service::where('medecin_id', $user->id)->count(),
                'reservations_total'=> Reservation::whereHas('service', fn($q) => $q->where('medecin_id', $user->id))->count(),
                'en_attente'        => Reservation::whereHas('service', fn($q) => $q->where('medecin_id', $user->id))->where('statut', 'en_attente')->count(),
            ];
            return view('dashboard.dashboardMedecin', compact('stats'));
        }

        // patient
        $stats = [
            'mes_reservations' => Reservation::where('user_id', $user->id)->count(),
            'en_attente'       => Reservation::where('user_id', $user->id)->where('statut', 'en_attente')->count(),
        ];
        return view('dashboard.dashboardPatient', compact('stats'));
    }
}
