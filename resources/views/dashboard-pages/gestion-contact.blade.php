<x-app-layout :title="__('VEM | Gestion des demandes de contact')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Gestion des demandes de contact') }}
        </h2>
        </x-slot>

    <div class="mt-4 mb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 mt-8">
            @forelse($contacts as $contact)
            <div class="flex flex-col gap-[5px] p-6 bg-white w-full h-full shadow-md rounded-lg">
                <p>
                    <span class="bg-gray-200 rounded-md pt-1 pb-1 pl-2 pr-2 font-bold text-gray-600 text-sm">From :</span>
                    {{ $contact->email . " " . "(" . $contact->name . ")"}}
                </p>
                <p>
                    <span class="bg-gray-200 rounded-md pt-1 pb-1 pl-2 pr-2 font-bold text-gray-600 text-sm">Tel :</span>
                    @if($contact->tel)
                    {{ $contact->tel }}
                    @else
                    Non fourni
                    @endif
                </p>
                <p class="font-bold">
                    <span>Objet :</span>
                    {{ $contact->object }}
                </p>
                <p>
                    <span class="italic underline">Contenu :</span>
                    <br>
                    {{ Str::limit($contact->corps, 150) }}
                </p>
            </div>
            @empty
            <span>Aucune demande de contact !</span>
            @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
