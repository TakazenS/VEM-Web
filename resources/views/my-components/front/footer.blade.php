<footer class="flex flex-col justify-center w-full bg-gray-900 py-10">
    <div class="flex justify-between">
        <div>
            <a href="{{ route('accueil') }}"
               class="text-[#FFF] mx-4">
                Accueil
            </a>
            <a href="{{ route('actualite') }}"
               class="text-[#FFF] mx-4">
                Actualité
            </a>
            <a href="{{ route('rapports') }}"
               class="text-[#FFF] mx-4">
                Rapports
            </a>
            <a href="{{ route('contact') }}"
               class="text-[#FFF] mx-4">
                Contact
            </a>
        </div>
        <div>
            <a href="https://github.com/TakazenS?tab=repositories" class="text-[#FFF] mx-4">Github</a>
        </div>
    </div>
    <div>
        <p class="text-[#FFF] mx-4">© {{ date('Y') }} VEM. Tous droits réservés.</p>
    </div>
</footer>
