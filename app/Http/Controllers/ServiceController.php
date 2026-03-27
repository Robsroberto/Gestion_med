<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('statut', 'actif')
            ->with('medecin')
            ->get();
        return view('services.index', compact('services'));
    }

    public function show($id)
    {
        $service = Service::with('medecin')->findOrFail($id);
        return view('services.show', compact('service'));
    }
}
