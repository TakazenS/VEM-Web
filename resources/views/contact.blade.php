<x-app-layout :title="__('VEM | Contact')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('contact.send') }}" method="POST" class="flex flex-col ">
            <label for="service">Je souhaite contacter le service</label>
            <select name="service">
                <option value="administration">Administration</option>
                <option value="logistique">Logistique</option>
            </select>

            <input
                type="text"
                name="name"
                placeholder="Nom et Prénom *"
                required
            >

            <input
                type="email"
                name="email"
                placeholder="Votre e-mail *"
                required
            >

            <input
                type="text"
                name="tel"
                placeholder="Votre n° de téléphone *"
            >

            <input
                type="text"
                name="object"
                placeholder="L'objet de votre demande *"
                required
            >

            <input
                type="text"
                name="corps"
                placeholder="Votre message *"
                required
            >

            <button type="submit">
                Envoyer
            </button>
        </form>
    </section>

    @include('my-components.front.footer')
</x-app-layout>
