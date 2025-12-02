<x-app-layout :title="__('VEM | Accueil')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accueil') }}
        </h2>
    </x-slot>

    <h1>Accueil</h1>

    @include('my-components.front.footer')
</x-app-layout>
