<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs pour la gestion.
     */
    public function index(): View
    {
        // On récupère les 8 premiers utilisateurs et on passe le paginateur à la vue
        $users = User::orderBy('id')->paginate(8);
        return view('gestion-user', ['users' => $users]);
    }

    /**
     * Met à jour le rôle d'un utilisateur spécifique.
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        // Valide que le rôle envoyé est bien l'un des rôles autorisés
        $request->validate([
            'role' => ['required', Rule::in(['directeur', 'administrateur', 'chefs de site', 'chercheur', 'technicien', 'logistique', 'utilisateur'])],
        ]);

        if (!auth()->user()->isDirecteur() && ($request->role === 'directeur' || $user->isDirecteur())) {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas modifier le rôle de directeur');
        }

        if (!auth()->user()->isDirecteur() && ($request->role === 'administrateur' || $user->isAdmin())) {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas modifier le rôle de administrateur');
        }

        // Met à jour le rôle de l'utilisateur
        $user->role = $request->role;
        $user->save();

        // Redirige vers la page de gestion avec un message de succès
        return redirect()->route('gestion.utilisateurs')
            ->with('success', 'Le rôle de l\'utilisateur ' . $user->name . ' a été mis à jour avec succès.');
    }

    public function deleteUser(Request $request): RedirectResponse
    {
        // 1. Valider que nous recevons bien un tableau d'IDs
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id', // S'assure que chaque ID existe bien
        ]);

        $userIds = $validated['user_ids'];
        $users = User::whereIn('id', $userIds)->get(); // Récupérer les modèles User

        $deletedUserNames = [];

        foreach ($users as $user) {
            if (auth()->id() === $user->id) {
                // Si on essaie de s'auto-supprimer, on arrête tout
                return redirect()->route('gestion.utilisateurs')
                    ->with('error', 'Action non autorisée : vous ne pouvez pas vous supprimer vous-même.');
            }

            if ($user->isDirecteur() && (!auth()->user()->isDirecteur() || auth()->user()->isDirecteur())) {
                // Si on essaie de supprimer un directeur
                return redirect()->route('gestion.utilisateurs')
                    ->with('error', 'Action non autorisée : vous ne pouvez pas supprimer un directeur.');
            }

            if ($user->isAdmin() && !auth()->user()->isDirecteur()) {
                // Si on essaie de supprimer un admin sans être directeur
                return redirect()->route('gestion.utilisateurs')->with('error', 'Action non autorisée : vous ne pouvez pas supprimer un administrateur.');
            }

            $deletedUserNames[] = $user->name;
            $user->delete();
        }

        if (empty($deletedUserNames)) {
            return redirect()->route('gestion.utilisateurs')->with('info', 'Aucun utilisateur n\'a été sélectionné pour la suppression.');
        }

        $message = 'Utilisateur(s) supprimé(s) avec succès : ' . implode(', ', $deletedUserNames);

        return redirect()->route('gestion.utilisateurs')
            ->with('success', $message);
    }

    /**
     * Fournit les utilisateurs paginés au format JSON pour le "load more".
     */
    public function getUsers()
    {
        $users = User::orderBy('id')->paginate(8);
        return response()->json($users);
    }
}
