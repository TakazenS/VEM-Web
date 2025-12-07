<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Affiche la page principale de gestion des utilisateurs.
     * Cette méthode est appelée lorsque vous accédez à l'URL de gestion des utilisateurs.
     *
     * @return View La vue Blade 'gestion-user' avec les données des utilisateurs.
     */
    public function index(): View
    {
        // On récupère les 8 premiers utilisateurs et on passe le paginateur à la vue
        $users = User::orderBy('id')->paginate(8);
        return view('gestion-user', ['users' => $users]);
    }

    /**
     * Recherche des utilisateurs en fonction d'un critère.
     * Cette méthode est déclenchée par le formulaire de recherche.
     *
     * @param Request $request L'objet de la requête HTTP, qui contient la valeur du champ de recherche.
     * @return View La vue 'gestion-user' avec les résultats de la recherche.
     */
    public function searchUsers(Request $request): View
    {
        // Récupère la valeur du champ 'search' envoyé dans la requête.
        $search = $request->input('search');

        // Construit une requête vers la base de données sur le modèle User.
        $users = User::query()
            // La méthode 'when' exécute la fonction de callback uniquement si le premier argument ($search) est "vrai" (non nul, non vide).
            ->when($search, function ($query, $search) {
                // Convertit le terme de recherche en minuscules une seule fois
                $searchTerm = strtolower($search);

                // Groupe les conditions de recherche pour éviter les conflits avec d'autres clauses WHERE
                return $query->where(function ($q) use ($searchTerm) {
                    // Recherche insensible à la casse sur le nom et l'email
                    $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])
                      ->orWhereRaw('LOWER(email) LIKE ?', ["%{$searchTerm}%"])
                      // La recherche sur l'ID reste une recherche normale
                      ->orWhere('id', 'like', "%{$searchTerm}%");
                });
            })
            ->orderBy('id')
            ->paginate(8);

        // Retourne la même vue 'gestion-user' et la variable 'search' pour pouvoir l'afficher à nouveau
        // dans le champ de recherche.
        return view('gestion-user', compact('users', 'search'));
    }

    /**
     * Met à jour le rôle d'un utilisateur spécifique.
     * Cette méthode est appelée par le formulaire de modification de rôle pour chaque utilisateur.
     *
     * @param Request $request L'objet de la requête HTTP, contenant le nouveau rôle.
     * @param User $user Le modèle de l'utilisateur à modifier, injecté automatiquement par Laravel grâce au "Route Model Binding".
     * @return RedirectResponse Une redirection vers la page de gestion avec un message de statut.
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        // Si le nouveau rôle est le même que le rôle actuel de l'utilisateur, on renvoie uniquement la page.
        if ($request->role === $user->role) {
            return redirect()->route('gestion.utilisateurs');
        }

        // On s'assure que le champ 'role' est bien présent dans la requête et que sa valeur
        // fait partie de la liste des rôles autorisés.
        $request->validate([
            'role' => ['required', Rule::in(['directeur', 'administrateur', 'chefs de site', 'chercheur', 'technicien', 'logistique', 'utilisateur'])],
        ]);

        // Vérifications des autorisations (logique métier).
        // On vérifie si l'utilisateur actuellement connecté a le droit d'effectuer cette action.

        // Si l'utilisateur connecté n'est PAS directeur ET qu'il essaie d'assigner le rôle 'directeur'.
        if (!Auth::user()->isDirecteur() && $request->role === 'directeur') {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas ajouter le rôle de directeur');
        }

        // Si l'utilisateur connecté n'est PAS directeur ET qu'il essaie d'assigner le rôle 'administrateur'.
        if (!Auth::user()->isDirecteur() && $request->role === 'administrateur') {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas ajouter le rôle administrateur');
        }

        // Si l'utilisateur connecté n'est PAS directeur ET qu'il essaie de modifier le rôle d'un directeur existant.
        if (!Auth::user()->isDirecteur() && $user->isDirecteur()) {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas modifier le rôle de directeur.');
        }

        // Si l'utilisateur connecté n'est PAS directeur ET qu'il essaie de modifier le rôle d'un administrateur existant.
        if (!Auth::user()->isDirecteur() && $user->isAdmin()) {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', 'Action non autorisée : vous ne pouvez pas modifier le rôle administrateur');
        }

        // Si l'utilisateur connecté EST directeur ET qu'il essaie d'assigner le rôle 'directeur' à quelqu'un d'autre.
        // (Règle métier : un seul directeur autorisé).
        if (Auth::user()->isDirecteur() && $request->role === 'directeur') {
            return redirect()->route('gestion.utilisateurs')
                ->with('error', "Action non autorisée : il ne peut y avoir qu'un seul directeur.");
        }

        // Si toutes les vérifications sont passées, on met à jour le rôle de l'utilisateur cible.
        // Puis on sauvegarde les modifications en base.
        $user->role = $request->role;
        $user->save();

        // On redirige l'utilisateur vers la page de gestion avec un message flash pour confirmer que l'opération a réussi.
        return redirect()->route('gestion.utilisateurs')
            ->with('success', 'Le rôle de l\'utilisateur ' . $user->name . ' a été mis à jour avec succès.');
    }

    /**
     * Supprime un ou plusieurs utilisateurs sélectionnés.
     *
     * @param Request $request La requête HTTP, contenant les IDs des utilisateurs à supprimer.
     * @return RedirectResponse Une redirection vers la page de gestion avec un message de statut.
     */
    public function deleteUser(Request $request): RedirectResponse
    {
        // Valide que la requête contient bien un tableau 'user_ids' et que chaque ID correspond à un utilisateur existant.
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $userIds = $validated['user_ids'];
        $users = User::whereIn('id', $userIds)->get(); // Récupère les objets User correspondants aux IDs.

        $deletedUserNames = []; // Un tableau pour stocker les noms des utilisateurs supprimés.

        foreach ($users as $user) {
            // Un utilisateur ne peut pas se supprimer lui-même.
            if (Auth::id() === $user->id) {
                return redirect()->route('gestion.utilisateurs')
                    ->with('error', 'Action non autorisée : vous ne pouvez pas vous supprimer vous-même.');
            }

            // Personne ne peut supprimer un directeur.
            if ($user->isDirecteur()) {
                return redirect()->route('gestion.utilisateurs')
                    ->with('error', 'Action non autorisée : vous ne pouvez pas supprimer un directeur.');
            }

            // Seul un directeur peut supprimer un administrateur.
            if ($user->isAdmin() && !Auth::user()->isDirecteur()) {
                return redirect()->route('gestion.utilisateurs')
                    ->with('error', 'Action non autorisée : vous ne pouvez pas supprimer un administrateur.');
            }

            // Si toutes les vérifications sont respectées, on ajoute le nom à la liste et on supprime l'utilisateur.
            $deletedUserNames[] = $user->name;
            $user->delete();
        }

        // Si le tableau des noms supprimés est vide (par ex. si aucune case n'était cochée), on renvoie un message d'information.
        if (empty($deletedUserNames)) {
            return redirect()->route('gestion.utilisateurs')
                ->with('info', 'Aucun utilisateur n\'a été sélectionné pour la suppression.');
        }

        // Construit un message de succès listant les utilisateurs supprimés.
        $message = 'Utilisateur(s) supprimé(s) avec succès : ' . implode(', ', $deletedUserNames);

        // Redirige avec le message de succès.
        return redirect()->route('gestion.utilisateurs')
            ->with('success', $message);
    }

    /**
     * Fournit les utilisateurs paginés au format JSON.
     * Cette méthode est utilisée par le script JavaScript de la vue pour charger
     * les utilisateurs suivants sans recharger toute la page.
     *
     * @return JsonResponse Une réponse JSON contenant les données des utilisateurs.
     */
    public function getUsers(): JsonResponse
    {
        $users = User::orderBy('id')->paginate(8);
        return response()->json($users);
    }

}
