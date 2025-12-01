<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="divide-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-800">
                                <tr class="bg-gray-100">
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->email }}
                                        </td>
                                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <select name="role" class="block w-full rounded-md border-gray-700 shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-400 focus:ring-opacity-50">
                                                    {{-- Assurez-vous que ces valeurs correspondent aux rôles dans votre système --}}
                                                    <option value="directeur" @if($user->role == 'directeur') selected @endif>Directeur</option>
                                                    <option value="administrateur" @if($user->role == 'administrateur') selected @endif>Administrateur</option>
                                                    <option value="directeur" @if($user->role == 'chefs de site') selected @endif>Chef de site</option>
                                                    <option value="directeur" @if($user->role == 'chercheur') selected @endif>Chercheur</option>
                                                    <option value="directeur" @if($user->role == 'technicien') selected @endif>Technicien</option>
                                                    <option value="directeur" @if($user->role == 'logistique') selected @endif>Logistique</option>
                                                    <option value="utilisateur" @if($user->role == 'utilisateur') selected @endif>Utilisateur</option>
                                                </select>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-500 focus:ring ring-gray-400 disabled:opacity-25 transition ease-in-out duration-150">
                                                    Modifier
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
