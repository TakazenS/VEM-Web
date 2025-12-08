<footer class="bg-gray-900 py-10 px-4">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center text-center md:text-left">
        <div class="flex flex-wrap justify-center mb-4 md:mb-0">
            <a href="{{ route('accueil') }}" class="relative text-[#FFF] mx-4 my-2 md:my-0 after:absolute after:bottom-0 after:left-0 after:h-[1px] after:w-0 after:bg-white after:transition-all after:duration-300 hover:after:w-full">
                Accueil
            </a>
            <a href="{{ route('actualite') }}" class="relative text-[#FFF] mx-4 my-2 md:my-0 after:absolute after:bottom-0 after:left-0 after:h-[1px] after:w-0 after:bg-white after:transition-all after:duration-300 hover:after:w-full">
                Actualité
            </a>
            <a href="{{ route('rapports') }}" class="relative text-[#FFF] mx-4 my-2 md:my-0 after:absolute after:bottom-0 after:left-0 after:h-[1px] after:w-0 after:bg-white after:transition-all after:duration-300 hover:after:w-full">
                Rapports
            </a>
            <a href="{{ route('contact') }}" class="relative text-[#FFF] mx-4 my-2 md:my-0 after:absolute after:bottom-0 after:left-0 after:h-[1px] after:w-0 after:bg-white after:transition-all after:duration-300 hover:after:w-full">
                Contact
            </a>
        </div>
        <div class="flex flex-row items-center mb-4 mx-4 md:mb-0">
            <a href="https://github.com/TakazenS?tab=repositories" class="relative text-[#FFF] mr-2 my-2 md:my-0 after:absolute after:bottom-0 after:left-0 after:h-[1px] after:w-0 after:bg-white after:transition-all after:duration-300 hover:after:w-full">Github</a>
            <img src="{{ asset('images/assets/github-logo.svg') }}" alt="github" class="w-6 h-6">
        </div>
    </div>
    <div class="container mx-auto text-center mt-4 lg:text-left md:text-left">
        <p class="text-[#FFF] mx-4">© {{ date('Y') }} VEM. Tous droits réservés.</p>
    </div>
</footer>
