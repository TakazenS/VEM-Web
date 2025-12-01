<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs pour la gestion.
     */
    public function index()
    {
        // On récupère tous les utilisateurs et on les passe à la vue
        $users = User::all();
        return view('gestion-user', ['users' => $users]);
    }

    /**
     * Met à jour le rôle d'un utilisateur spécifique.
     */
    public function updateRole(Request $request, User $user)
    {
        // Valide que le rôle envoyé est bien l'un des rôles autorisés
        $request->validate([
            'role' => ['required', Rule::in(['directeur', 'administrateur', 'chefs de site', 'chercheur', 'technicien', 'logistique', 'utilisateur'])],
        ]);

        // Met à jour le rôle de l'utilisateur
        $user->role = $request->role;
        $user->save();

        // Redirige vers la page de gestion avec un message de succès
        return redirect()->route('gestion.utilisateurs')->with('success', 'Le rôle de l\'utilisateur ' . $user->name . ' a été mis à jour avec succès.');
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

}
