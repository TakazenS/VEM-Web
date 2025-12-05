<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class SearchUser extends Component
{
    use WithPagination;

    public $search = '';
    public $selectPage = false;
    public $selectedUsers = [];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPage(): void
    {
        $this->selectPage = false;
        $this->selectedUsers = [];
    }

    public function updatedSelectPage($value): void
    {
        if ($value) {
            $this->selectedUsers = $this->users->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function updatedSelectedUsers(): void
    {
        // Si le nombre d'utilisateurs sélectionnés est égal au nombre d'utilisateurs sur la page,
        // on coche la case "Tout sélectionner". Sinon, on la décoche.
        $this->selectPage = count($this->selectedUsers) === $this->users->count();
    }

    public function getUsersProperty()
    {
        return User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orderBy('id')
            ->paginate(8);
    }

    public function updateRole($userId, $newRole)
    {
        $user = User::find($userId);

        if (!auth()->user()->isDirecteur() && ($user->isDirecteur())) {
            session()->flash('error', 'Action non autorisée : vous ne pouvez pas modifier le rôle de directeur');
            return;
        }

        if (!auth()->user()->isDirecteur() && ($newRole === 'directeur')) {
            session()->flash('error', 'Action non autorisée : vous ne pouvez pas ajouter le rôle de directeur');
            return;
        }

        if (!auth()->user()->isDirecteur() && ($user->isAdmin())) {
            session()->flash('error', 'Action non autorisée : vous ne pouvez pas modifier le rôle de administrateur');
            return;
        }

        if (!auth()->user()->isDirecteur() && ($newRole === 'administrateur')) {
            session()->flash('error', 'Action non autorisée : vous ne pouvez pas ajouter le rôle d' . "'" . 'administrateur');
            return;
        }

        $user->role = $newRole;
        $user->save();
        session()->flash('success', 'Le rôle de ' . $user->name . ' a été mis à jour.');
    }

    public function deleteSelected(): void
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isDirecteur()) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
            return;
        }

        $usersToDelete = User::whereIn('id', $this->selectedUsers)->get();
        $deletedUserNames = [];

        foreach ($usersToDelete as $user) {
            if (Auth::id() === $user->id) {
                session()->flash('error', 'Action non autorisée : vous ne pouvez pas vous supprimer vous-même.');
                $this->selectedUsers = [];
                $this->selectPage = false;
                return;
            }
            if ($user->isAdmin() && !Auth::user()->isDirecteur()) {
                session()->flash('error', 'Action non autorisée : vous ne pouvez pas supprimer un administrateur.');
                $this->selectedUsers = [];
                $this->selectPage = false;
                return;
            }
            $deletedUserNames[] = $user->name;
            $user->delete();
        }

        if (!empty($deletedUserNames)) {
            session()->flash('success', 'Utilisateur(s) supprimé(s) avec succès : ' . implode(', ', $deletedUserNames));
        }

        $this->selectedUsers = [];
        $this->selectPage = false;
    }

    public function render(): Factory|View
    {
        return view('livewire.search-user', [
            'users' => $this->users,
        ]);
    }
}
