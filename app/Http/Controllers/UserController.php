<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function searchUsers(Request $request): View
    {
        // 1. On récupère la valeur saisie dans le champ de recherche
        $search = $request->input('search');

        // 2. On prépare la requête
        $users = User::query()
            ->when($search, function ($query, $search) {
                // Si $search n'est pas vide, on ajoute la condition
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('id', 'like', "%{$search}%");

            })
            ->orderBy('id')
            ->paginate(8);

        // 3. On retourne la vue avec les résultats
        return view('gestion-user', compact('users', 'search'));
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

        if (!Auth::user()->isDirecteur() && $request->role === 'directeur') {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas ajouter le rôle de directeur');
        }

        if (!Auth::user()->isDirecteur() && $request->role === 'administrateur') {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas ajouter le rôle administrateur');
        }

        if (!Auth::user()->isDirecteur() && $user->isDirecteur()) {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas modifier le rôle de directeur.');
        }

        if (!Auth::user()->isDirecteur() && $user->isAdmin()) {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas modifier le rôle administrateur');
        }

        if (Auth::user()->isDirecteur() && $request->role === 'directeur') {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', "Action non autorisée : il ne peut y avoir qu'un seul directeur.");
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
            if (Auth::id() === $user->id) {
                // Si on essaie de s'auto-supprimer, on arrête tout
                return redirect()->route('gestion.utilisateurs')
                    ->with('error', 'Action non autorisée : vous ne pouvez pas vous supprimer vous-même.');
            }

            if ($user->isDirecteur() && (!Auth::user()->isDirecteur() || Auth::user()->isDirecteur())) {
                // Si on essaie de supprimer un directeur
                return redirect()->route('gestion.utilisateurs')
                    ->with('error', 'Action non autorisée : vous ne pouvez pas supprimer un directeur.');
            }

            if ($user->isAdmin() && !Auth::user()->isDirecteur()) {
                // Si on essaie de supprimer un admin sans être directeur
                return redirect()->route('gestion.utilisateurs')
                    ->with('error', 'Action non autorisée : vous ne pouvez pas supprimer un administrateur.');
            }

            $deletedUserNames[] = $user->name;
            $user->delete();
        }

        if (empty($deletedUserNames)) {
            return redirect()->route('gestion.utilisateurs')
                ->with('info', 'Aucun utilisateur n\'a été sélectionné pour la suppression.');
        }

        $message = 'Utilisateur(s) supprimé(s) avec succès : ' . implode(', ', $deletedUserNames);

        return redirect()->route('gestion.utilisateurs')
            ->with('success', $message);
    }

    /**
     * Fournit les utilisateurs paginés au format JSON pour le "load more" géré en js.
     */
    public function getUsers()
    {
        $users = User::orderBy('id')->paginate(8);
        return response()->json($users);
    }

}
