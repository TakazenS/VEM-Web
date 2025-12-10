<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:title" content="@yield('og_title', 'VEM')" />
        <meta property="og:description" content="@yield('og_description', 'VEM, l\'avenir dans la roche.')" />
        <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="@yield('og_title', 'VEM')" />
        <meta name="twitter:description" content="@yield('og_description', 'VEM, l\'avenir dans la roche.')" />
        <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))" />

        <meta http-equiv="refresh" content="10;url={{ route('accueil') }}">

        <title>VEM | Message envoyé !</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="h-screen">
        <div class="bg-gray-100 h-full">
            <div class="w-full h-full flex items-center justify-center">
                <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8">

                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                        <div class="flex flex-col items-center p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <h2 class="mt-4 max-w-md text-2xl font-semibold text-gray-900">Votre demande de contact a été envoyée avec succès.</h2>
                            <p class="mt-2 max-w-md text-gray-600">Nos équipes vous recontacteront par email dès que votre demande aura été traitée.</p>
                            <p class="mt-4 max-w-md text-gray-600">Vous serez automatiquement redirigé vers la page d'accueil dans 10 secondes.</p>
                            <div class="mt-6">
                                <a href="{{ route('accueil') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Retour à l'accueil
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>
