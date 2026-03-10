<x-app-layout :title="__('VEM | Dashboard')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté ! Bienvenue " . strtoupper(Auth::user()->name) . " " . Auth::user()->prenom ) }}
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user() && (Auth::user()->isAdmin() || Auth::user()->isDirecteur()))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <a href="{{ route('gestion.utilisateurs') }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
            <div class="p-6">
                <p>Gestion des utilisateurs</p>
                <p class="text-gray-500">Panel de gestion des utilisateurs et des rôles</p>
            </div>
        </a>
    </div>
    @endif

    @if(Auth::user() && (Auth::user()->isAdmin() || Auth::user()->isDirecteur() || Auth::user()->isLogistique()))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <a href="{{ route('gestion.contact') }}" class="block bg-white shadow-sm sm:rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                @if($contactCount > 0)
                    <span class="absolute z-10 bg-red-500 text-white pt-1 pb-1 pr-3 pl-3 -right-1 -top-2 rounded-full">
                        {{ $contactCount }}
                    </span>
                @endif
                <div class="p-6">
                    <p>Gestion des demandes de contact</p>
                    <p class="text-gray-500">Panel de gestion des demandes de contact</p>
                </div>
            </a>
        </div>
    @endif
</x-app-layout>
