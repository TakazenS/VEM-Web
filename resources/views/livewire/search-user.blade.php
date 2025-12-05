<div>
    {{-- Barre de recherche et indicateur de chargement --}}
    <div class="mb-4 flex items-center justify-between">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Rechercher par nom, email ou ID..."
            class="border p-2 rounded w-full md:w-1/3"
        >
        <div wire:loading class="text-gray-500 ml-2">
            <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    {{-- Messages de session (succès, erreur) --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Tableau des utilisateurs --}}
    <div class="overflow-x-auto shadow-sm sm:rounded-lg border-gray-300 border-2">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-800">
                <tr class="bg-gray-100">
                    <th scope="col" class="px-6 py-3 text-left">
                        {{-- Case pour tout sélectionner sur la page --}}
                        <input type="checkbox" wire:model.live="selectPage" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nom</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rôle</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr wire:key="user-{{ $user->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{-- Case pour la sélection individuelle --}}
                            <input type="checkbox" wire:model.live="selectedUsers" @if($selectPage) checked @endif value="{{ $user->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{-- Menu déroulant pour la mise à jour du rôle --}}
                            <select
                                wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                @if(Auth::id() === $user->id || (Auth::user()->isAdmin() && $user->isAdmin() || $user->isDirecteur())) disabled @endif {{-- On ne peut pas changer son propre rôle --}}
                            >
                                @foreach(['directeur', 'administrateur', 'chefs de site', 'chercheur', 'technicien', 'logistique', 'utilisateur'] as $role)
                                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Aucun résultat trouvé pour "{{ $search }}"</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Bouton de suppression flottant --}}
    @if(count($selectedUsers) > 0)
        <div class="fixed bottom-9 right-10" x-data="{}" x-transition>
            <button
                wire:click.prevent="deleteSelected"
                wire:confirm="Êtes-vous sûr de vouloir supprimer {{ count($selectedUsers) }} utilisateur(s) ?"
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 disabled:opacity-25 transition ease-in-out duration-150"
            >
                Supprimer ({{ count($selectedUsers) }})
            </button>
        </div>
    @endif

    {{-- Liens de pagination --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
