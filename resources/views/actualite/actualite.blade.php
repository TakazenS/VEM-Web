<x-app-layout :title="__('VEM | Actualité')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actualité') }}
        </h2>
    </x-slot>

    <h1>Actualité</h1>

    @include('my-components.front.footer')
</x-app-layout>
