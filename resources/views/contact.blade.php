<x-app-layout :title="__('VEM | Contact')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        @method('POST')

                        <!-- Service -->
                        <div class="mt-4">
                            <x-input-label for="service" :value="__('Service à contacter')" />
                            <select id="service" name="service" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="administration">Administration</option>
                                <option value="logistique">Logistique</option>
                            </select>
                        </div>

                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nom et Prénom *')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Votre e-mail *')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        </div>

                        <!-- Telephone -->
                        <div class="mt-4">
                            <x-input-label for="tel" :value="__('Votre n° de téléphone')" />
                            <x-text-input id="tel" class="block mt-1 w-full" type="text" name="tel" :value="old('tel')" />
                        </div>

                        <!-- Object -->
                        <div class="mt-4">
                            <x-input-label for="object" :value="__('Objet de votre demande *')" />
                            <x-text-input id="object" class="block mt-1 w-full" type="text" name="object" :value="old('object')" required />
                        </div>

                        <!-- Message -->
                        <div class="mt-4">
                            <x-input-label for="corps" :value="__('Votre message *')" />
                            <textarea id="corps" name="corps" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('corps') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Envoyer') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
