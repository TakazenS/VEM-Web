<x-app-layout :title="__('VEM | Contact')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    <h1>Contact</h1>

    @include('my-components.front.footer')
</x-app-layout>
