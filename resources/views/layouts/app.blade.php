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

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
