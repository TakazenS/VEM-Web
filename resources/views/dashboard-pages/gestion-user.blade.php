<x-app-layout :title="__('VEM | Gestion des utilisateurs')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des utilisateurs') }}
        </h2>
    </x-slot>

    <div class="mt-4 mb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex w-full mt-4 justify-between items-center">
                <form action="{{ route('users.search') }}" method="GET" class="flex flex-row items-center">
                    @csrf
                    @method('GET')

                    <div class="relative flex items-center" style="width: 400px;">
                        <input
                            id="search-input"
                            type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Recherche par prénom, nom, email ou ID..."
                            class="border rounded-lg w-full pr-10"
                        >
                        <button id="supBtn" type="button" class="absolute right-2">
                            <img src="{{ asset('images/assets/cross.svg') }}" alt="Supprimer" class="h-4 w-4 cursor-pointer">
                        </button>
                    </div>
                    <button type="submit" class="bg-gray-800 ml-2 text-white text-xs flex-grow-0 py-2 px-4 rounded-lg font-semibold uppercase hover:bg-gray-700 transition ease-in-out duration-150">
                        Chercher
                    </button>
                    <a href="{{ route('gestion.utilisateurs') }}" class="pl-2 hover:underline">Rafraichir</a>
                </form>

                <form action="{{ route('users.delete') }}" method="POST" id="delete-users-form" class="m-0">
                    @csrf
                    @method('DELETE')

                    <button id="delete-button" type="submit" disabled class="m-0 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 disabled:opacity-25 transition ease-in-out duration-150">
                        Supprimer
                    </button>
                </form>

            </div>

            <!-- Session Status -->
            <div class="my-4">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" x-data="{ show: true }" x-show="show">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-4" @click="show = false">
                            <img src="{{ asset('images/assets/cross.svg') }}" alt="Fermer" class="h-5 w-5 cursor-pointer">
                        </span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" x-data="{ show: true }" x-show="show">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-4" @click="show = false">
                            <img src="{{ asset('images/assets/cross.svg') }}" alt="Fermer" class="h-5 w-5 cursor-pointer">
                        </span>
                    </div>
                @endif
                @if (session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert" x-data="{ show: true }" x-show="show">
                        <span class="block sm:inline">{{ session('info') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-4" @click="show = false">
                            <img src="{{ asset('images/assets/cross.svg') }}" alt="Fermer" class="h-5 w-5 cursor-pointer">
                        </span>
                    </div>
                @endif
            </div>

            <div class="divide-gray-800 overflow-hidden">
                <div class="text-gray-900">
                    <div class="overflow-x-auto shadow-sm sm:rounded-lg border-gray-300 border-2">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-800">
                                <tr class="bg-gray-100">
                                    <th scope="col" class="px-6 py-3 text-left">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-700">
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Nom
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Rôle
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="user-table-body" class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" form="delete-users-form" @if (Auth::id() === $user->id || (Auth::user()->isAdmin() && $user->isAdmin() || $user->isDirecteur())) disabled style="cursor: not-allowed; opacity: 50%" @endif class="user-checkbox rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-700">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="flex items-center flex-nowrap space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" @if (Auth::id() === $user->id || (Auth::user()->isAdmin() && $user->isAdmin() || $user->isDirecteur())) disabled style="cursor: not-allowed;" @endif class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-700">
                                                    <option value="directeur" @if($user->role == 'directeur') selected @endif>Directeur</option>
                                                    <option value="administrateur" @if($user->role == 'administrateur') selected @endif>Administrateur</option>
                                                    <option value="chefs de site" @if($user->role == 'chefs de site') selected @endif>Chef de site</option>
                                                    <option value="chercheur" @if($user->role == 'chercheur') selected @endif>Chercheur</option>
                                                    <option value="technicien" @if($user->role == 'technicien') selected @endif>Technicien</option>
                                                    <option value="logistique" @if($user->role == 'logistique') selected @endif>Logistique</option>
                                                    <option value="utilisateur" @if($user->role == 'utilisateur') selected @endif>Utilisateur</option>
                                                </select>
                                                <button type="submit" @if (Auth::id() === $user->id || (Auth::user()->isAdmin() && $user->isAdmin() || $user->isDirecteur())) disabled style="cursor: not-allowed" @endif class="inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                    OK
                                                </button>
                                            </form>
                                        </td>
                                        @empty
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-900">
                                            Aucun résultat trouvé pour "{{ $search }}"
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($users->hasMorePages())
                        <div class="w-full flex justify-center mt-4">
                            <button type="button" id="load-more-button" class="w-80 text-center items-center px-4 py-2 bg-gray-200 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 border-gray-400 border-2 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Afficher plus
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DEBUT DU SCRIPT DE PAGINATION
            const loadMoreButton = document.getElementById('load-more-button');
            const tableBody = document.getElementById('user-table-body');
            let currentPage = {{ $users->currentPage() }};

            const searchInput = document.getElementById('search-input');
            const supBtn = document.getElementById('supBtn');

            supBtn.addEventListener('click', function () {
                searchInput.value = '';
            });

            if (loadMoreButton) {
                loadMoreButton.addEventListener('click', function () {
                    currentPage++;
                    this.disabled = true;
                    this.textContent = 'Chargement...';

                    fetch(`{{ route('users.get') }}?page=${ currentPage }`)
                        .then(response => response.json())
                        .then(data => {
                            let rowsHtml = '';
                            data.data.forEach(user => {
                                // Construire la chaîne HTML pour chaque nouvelle ligne
                                rowsHtml += `
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="user_ids[]" value="${user.id}" form="delete-users-form" class="user-checkbox rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-700">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${user.id}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${user.name}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${user.email}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <form action="/users/${user.id}/update-role" method="POST" class="flex items-center flex-nowrap space-x-2">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <select name="role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-700">
                                                    <option value="directeur" ${user.role === 'directeur' ? 'selected' : ''}>Directeur</option>
                                                    <option value="administrateur" ${user.role === 'administrateur' ? 'selected' : ''}>Administrateur</option>
                                                    <option value="chefs de site" ${user.role === 'chefs de site' ? 'selected' : ''}>Chef de site</option>
                                                    <option value="chercheur" ${user.role === 'chercheur' ? 'selected' : ''}>Chercheur</option>
                                                    <option value="technicien" ${user.role === 'technicien' ? 'selected' : ''}>Technicien</option>
                                                    <option value="logistique" ${user.role === 'logistique' ? 'selected' : ''}>Logistique</option>
                                                    <option value="utilisateur" ${user.role === 'utilisateur' ? 'selected' : ''}>Utilisateur</option>
                                                </select>
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Modifier</button>
                                            </form>
                                        </td>
                                    </tr>
                                `;
                            });
                            // Ajouter toutes les nouvelles lignes en une seule fois pour de meilleures performances
                            tableBody.insertAdjacentHTML('beforeend', rowsHtml);

                            // Mettre à jour les listeners pour les nouvelles checkboxes
                            initializeCheckboxLogic();

                            // Gérer le bouton "Afficher plus"
                            if (data.next_page_url) {
                                this.disabled = false;
                                this.textContent = 'Afficher plus';
                            } else {
                                this.disabled = true; // Désactiver le bouton s'il n'y a plus de pages
                                this.textContent = 'Affichage terminé'
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors du chargement des utilisateurs : ', error);
                            this.disabled = false;
                            this.textContent = 'Erreur - Réessayer';
                        });
                });
            }

            function initializeCheckboxLogic()
            {
                const selectAllCheckbox = document.getElementById('select-all');
                const userCheckboxes = document.querySelectorAll('.user-checkbox');
                const deleteButton = document.getElementById('delete-button');

                function updateButtonState()
                {
                    const anyChecked = Array.from(userCheckboxes).some(c => c.checked);
                    deleteButton.disabled = !anyChecked;
                    deleteButton.style.cursor = anyChecked ? 'pointer' : 'not-allowed';
                }

                function updateButtonText()
                {
                    const selectedCount = Array.from(userCheckboxes).filter(c => c.checked).length;
                    if (selectedCount >= 1) {
                        deleteButton.disabled = false;
                        deleteButton.textContent = `Supprimer (${ selectedCount })`;
                    } else {
                        deleteButton.disabled = true;
                        deleteButton.textContent = 'Supprimer';
                    }
                }

                updateButtonText();
                updateButtonState();

                selectAllCheckbox.addEventListener('change', function () {
                    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                        if (!checkbox.disabled) {
                            checkbox.checked = this.checked;
                        }
                    });
                    updateButtonText();
                    updateButtonState();
                });

                document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        if (!this.checked) {
                            selectAllCheckbox.checked = false;
                        } else {
                            selectAllCheckbox.checked = Array.from(document.querySelectorAll('.user-checkbox')).every(c => c.checked);
                        }
                        updateButtonText();
                        updateButtonState();
                    });
                });

                deleteButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    const selectedCount = Array.from(document.querySelectorAll('.user-checkbox')).filter(c => c.checked).length;
                    let message = selectedCount > 1 ? `${ selectedCount } utilisateurs` : 'cet utilisateur';
                    if (window.confirm(`Êtes-vous sûr de vouloir supprimer ${ message } ?`)) {
                        this.form.submit();
                    }
                });
            }

            initializeCheckboxLogic();
        });
    </script>
</x-app-layout>
