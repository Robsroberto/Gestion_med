<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('reservations')->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function setRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,medecin,patient',
        ]);

        User::findOrFail($id)->update($validated);

        return redirect('/admin/users')->with('success', 'Rôle mis à jour.');
    }

    public function toggle($id)
    {
        $user = User::findOrFail($id);

        // On utilise email_verified_at comme indicateur d'activation
        // null = actif, valeur passée = désactivé (simple et sans migration)
        if ($user->email_verified_at === null) {
            $user->update(['email_verified_at' => now()]);
            $msg = 'Utilisateur activé.';
        } else {
            $user->update(['email_verified_at' => null]);
            $msg = 'Utilisateur désactivé.';
        }

        return redirect('/admin/users')->with('success', $msg);
    }
}
