<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('medecin')->orderBy('created_at', 'desc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $medecins = User::where('role', 'medecin')->get();
        return view('admin.services.create', compact('medecins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'prix'        => 'required|numeric|min:0',
            'duree'       => 'required|integer|min:1',
            'statut'      => 'required|in:actif,inactif',
            'medecin_id'  => 'nullable|exists:users,id',
        ]);

        Service::create($validated);

        return redirect('/admin/services')->with('success', 'Service créé avec succès.');
    }

    public function edit($id)
    {
        $service  = Service::findOrFail($id);
        $medecins = User::where('role', 'medecin')->get();
        return view('admin.services.edit', compact('service', 'medecins'));
    }

    public function update(Request $request, $id)
    {
        $service   = Service::findOrFail($id);
        $validated = $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'prix'        => 'required|numeric|min:0',
            'duree'       => 'required|integer|min:1',
            'statut'      => 'required|in:actif,inactif',
            'medecin_id'  => 'nullable|exists:users,id',
        ]);

        $service->update($validated);

        return redirect('/admin/services')->with('success', 'Service mis à jour.');
    }

    public function destroy($id)
    {
        Service::findOrFail($id)->delete();
        return redirect('/admin/services')->with('success', 'Service supprimé.');
    }

    public function assignMedecin(Request $request, $id)
    {
        $service  = Service::findOrFail($id);
        $validated = $request->validate([
            'medecin_id' => 'nullable|exists:users,id',
        ]);
        $service->update(['medecin_id' => $validated['medecin_id']]);

        return redirect('/admin/services')->with('success', 'Médecin assigné avec succès.');
    }
}
