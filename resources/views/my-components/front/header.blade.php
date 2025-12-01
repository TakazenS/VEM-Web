<header class="flex flex-row h-16 bg-[#fff] shadow-md">
    <nav class="flex flex-row items-center w-1/2 h-full">
        <a href="{{ route('accueil') }}"
           class="mx-6">
            Accueil
        </a>
        <a href="{{ url('/actus') }}"
           class="mx-6">
            Actualités
        </a>
        <a href="{{ url('/rapports') }}"
           class="mx-6">
            Rapports
        </a>
        <a href="{{ url('/contact') }}"
           class="mx-6">
            Contact
        </a>
    </nav>
    @if (Route::has('login'))
        <nav class="flex flex-row-reverse items-center w-1/2 h-full">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="py-2 px-4 mx-4">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="py-2 px-4 mx-4">
                    Connexion
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="py-2 px-4 mx-4">
                        Inscription
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>
