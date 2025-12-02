<x-app-layout :title="__('VEM | Gestion des utilisateurs')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Session Status -->
            <div class="mb-4">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" x-data="{ show: true }" x-show="show">
                        <strong class="font-bold">Succès !</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
                            <svg class="fill-current h-6 w-6 text-gray-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" x-data="{ show: true }" x-show="show">
                        <strong class="font-bold">Erreur !</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
                            <svg class="fill-current h-6 w-6 text-gray-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>
                @endif
                @if (session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert" x-data="{ show: true }" x-show="show">
                        <strong class="font-bold">Info :</strong>
                        <span class="block sm:inline">{{ session('info') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
                            <svg class="fill-current h-6 w-6 text-gray-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
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
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" form="delete-users-form" class="user-checkbox rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-700">
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
                                                    <select name="role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-700">
                                                        <option value="directeur" @if($user->role == 'directeur') selected @endif>Directeur</option>
                                                        <option value="administrateur" @if($user->role == 'administrateur') selected @endif>Administrateur</option>
                                                        <option value="chefs de site" @if($user->role == 'chefs de site') selected @endif>Chef de site</option>
                                                        <option value="chercheur" @if($user->role == 'chercheur') selected @endif>Chercheur</option>
                                                        <option value="technicien" @if($user->role == 'technicien') selected @endif>Technicien</option>
                                                        <option value="logistique" @if($user->role == 'logistique') selected @endif>Logistique</option>
                                                        <option value="utilisateur" @if($user->role == 'utilisateur') selected @endif>Utilisateur</option>
                                                    </select>
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                        Modifier
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    <form action="{{ route('users.delete') }}" method="POST" id="delete-users-form">
                        @csrf
                        @method('DELETE')

                        <div class="mt-4">
                            <button id="delete-button" type="submit" disabled class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 disabled:opacity-25 transition ease-in-out duration-150">
                                Supprimer
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const deleteButton = document.getElementById('delete-button');

            function updateButtonState() {
                // Vérifie si au moins une case est cochée
                const anyChecked = Array.from(userCheckboxes).some(c => c.checked);
                // Active ou désactive le bouton en conséquence
                deleteButton.disabled = !anyChecked;
            }

            function updateButtonText() {
                // Récupère la longeur du tableau des cases cochées
                const selectedCount = Array.from(userCheckboxes).filter(c => c.checked).length;
                // Met à jour le texte du bouton en conséquence
                if (selectedCount === 1) {
                    deleteButton.textContent = 'Supprimer l\'utilisateur';
                } else if (selectedCount > 1) {
                    deleteButton.textContent = 'Supprimer les utilisateurs';
                } else {
                    deleteButton.textContent = 'Supprimer';
                }
            }

            // Vérifie l'état initial au chargement de la page
            updateButtonText();
            updateButtonState();

            // Met à jour l'état du bouton quand on clique sur "Tout sélectionner"
            selectAllCheckbox.addEventListener('change', function () {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateButtonText();
                updateButtonState();
            });

            // Met à jour l'état du bouton quand on clique sur une case individuelle
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    } else {
                        selectAllCheckbox.checked = Array.from(userCheckboxes).every(c => c.checked);
                    }
                    updateButtonText()
                    updateButtonState();
                });
            });

            deleteButton.addEventListener('click', function (e) {
                e.preventDefault()
                const selectedCount = Array.from(userCheckboxes).filter(c => c.checked).length;
                let message = '';
                if (selectedCount > 1) {
                    message = 'ces utilisateurs'
                } else {
                    message = 'cet utilisateur'
                }
                if (window.confirm(`Êtes-vous sûr de vouloir supprimer ${ message } ?`)) {
                    this.form.submit();
                }
            })
        });
    </script>
</x-app-layout>
