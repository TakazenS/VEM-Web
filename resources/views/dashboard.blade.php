<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté ! Bienvenue " . Auth::user()->name) }}
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->isDirecteur()))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <a href="{{ route('gestion.utilisateurs') }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-200 ease-in-out transform hover:scale-x-105 hover:scale-105">
            <div class="p-6">
                <p>Gestion des utilisateurs</p>
                <p class="text-gray-500">Panel de gestion des utilisateurs et des rôles</p>
            </div>
        </a>
    </div>
    @endif
</x-app-layout>
