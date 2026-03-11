<x-app-layout :title="__('VEM | Gestion des demandes de contact')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des demandes de contact') }}
        </h2>
    </x-slot>

    <p>{{ $contact->email . " " . "(" . $contact->name . ")"}}</p>
    @if($contact->tel)
        <p>{{ $contact->tel }}</p>
    @else
        <p>Non fourni</p>
    @endif
    <p>{{ $contact->object }}</p>
    <p>{{ $contact->corps }}</p>
</x-app-layout>
