<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom *')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Prénom -->
        <div class="mt-4">
            <x-input-label for="prenom" :value="__('Prénom *')" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="prenom" />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email *')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative mt-4">
            <x-input-label for="password" :value="__('Mot de passe *')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <span class="absolute top-8 right-5 cursor-pointer" onclick="toggleEye1()">
                <img id="eyeIcon1"  src="/images/assets/eyeOff.svg" width="22px" height="22px" alt="eyeOff">
            </span>

            <ul id="password-errors" class="text-sm text-red-500 mt-2 list-disc list-inside hidden"></ul>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="relative mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmez le mot de passe *')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <span class="absolute top-8 right-5 cursor-pointer" onclick="toggleEye2()">
                <img id="eyeIcon2"  src="/images/assets/eyeOff.svg" width="22px" height="22px" alt="eyeOff">
            </span>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Déjà un compte ?') }}
            </a>

            <x-primary-button class="ms-4 disabled:opacity-25 transition ease-in-out duration-150 opacity-50 cursor-not-allowed" id="btnValidate">
                {{ __("S'inscrire") }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sendBtn = document.getElementById('btnValidate')
            const nameInput = document.getElementById('name');
            const prenomInput = document.getElementById('prenom');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordErrorList = document.getElementById('password-errors');

            const requiredFieldsForButton = [
                nameInput,
                prenomInput,
                emailInput,
                passwordInput,
                passwordConfirmationInput
            ];

            // --- Fonctions de validation ---

            // Vérifie le nom/prénom
            function validateName(name) {
                const regex = /^[\p{L} -]+$/u;
                return regex.test(String(name));
            }

            // Vérifie l'email
            function validateEmail(email) {
                const regex = /^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
                return regex.test(String(email));
            }

            // Vérifie la longueur du mot de passe (standard Laravel : 8 minimum)
            function getPasswordErrors(password) {
                let errors = [];
                if (password.length < 8) errors.push("8 caractères minimum");
                if (!/[A-Z]/.test(password)) errors.push("1 majuscule");
                if (!/[a-z]/.test(password)) errors.push("1 minuscule");
                if (!/\d/.test(password)) errors.push("1 chiffre");
                if (!/[^a-zA-Z0-9]/.test(password)) errors.push("1 caractère spécial");
                return errors;
            }

            function toggleButtonState() {
                // On évalue la validité stricte de chaque champ
                const isNameValid = validateName(nameInput.value);
                const isPrenomValid = validateName(prenomInput.value);
                const isEmailValid = validateEmail(emailInput.value);
                const isPasswordValid = getPasswordErrors(passwordInput.value).length === 0;
                const isPasswordConfirmed = (passwordConfirmationInput.value !== '') && (passwordConfirmationInput.value === passwordInput.value);

                // Le formulaire est valide uniquement si TOUTES les conditions sont vraies
                const isFormValid = isNameValid && isPrenomValid && isEmailValid && isPasswordValid && isPasswordConfirmed;

                sendBtn.disabled = !isFormValid;

                // Style visuel pour montrer que le bouton est désactivé
                if (sendBtn.disabled) {
                    sendBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    sendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // Écouteur d'événement pour chaque champ requis afin de changer l'état du bouton
            requiredFieldsForButton.forEach(field => {
                field.addEventListener('input', toggleButtonState);
            });

            // Charge l'état du bouton au chargement de la page
            toggleButtonState();

            // --- Styles dynamiques (blur) ---

            // Name
            nameInput.addEventListener('blur', function () {
                const value = nameInput.value;
                if (!value || !validateName(value)) {
                    nameInput.classList.add('border-red-500');
                    sendBtn.disabled = true;
                } else {
                    nameInput.classList.remove('border-red-500');
                }
            });

            // Prénom
            prenomInput.addEventListener('blur', function () {
                const value = prenomInput.value;
                if (!value || !validateName(value)) {
                    prenomInput.classList.add('border-red-500');
                    sendBtn.disabled = true;
                } else {
                    prenomInput.classList.remove('border-red-500');
                }
            });

            // Email
            emailInput.addEventListener('blur', function () {
                const value = emailInput.value;
                if (!value || !validateEmail(value)) {
                    emailInput.classList.add('border-red-500');
                    sendBtn.disabled = true;
                } else {
                    emailInput.classList.remove('border-red-500');
                }
            });

            // Password
            passwordInput.addEventListener('input', function () {
                const value = this.value;
                const errors = getPasswordErrors(value);

                // S'il y a des erreurs et que le champ n'est pas vide
                if (errors.length > 0 && value.length > 0) {
                    // On affiche la liste à puces
                    passwordErrorList.innerHTML = '<li>' + errors.join('</li><li>') + '</li>';
                    passwordErrorList.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else {
                    // Tout est bon (ou le champ est vide) : on cache la liste
                    passwordErrorList.innerHTML = '';
                    passwordErrorList.classList.add('hidden');
                    this.classList.remove('border-red-500');
                }

                // On revérifie la confirmation au cas où
                if (passwordConfirmationInput.value) {
                    passwordConfirmationInput.dispatchEvent(new Event('blur'));
                }
            });

            // On garde aussi le blur sur le mot de passe pour le cas où l'utilisateur quitte le champ en le laissant vide
            passwordInput.addEventListener('blur', function () {
                if (!this.value) {
                    this.classList.add('border-red-500');
                }
            });

            // Password Confirmation
            passwordConfirmationInput.addEventListener('blur', function () {
                const value = passwordConfirmationInput.value;
                // On vérifie que ce n'est pas vide ET que c'est identique au mot de passe
                if (!value || value !== passwordInput.value) {
                    passwordConfirmationInput.classList.add('border-red-500');
                } else {
                    passwordConfirmationInput.classList.remove('border-red-500');
                }
            });
        });


        function toggleEye1() {
            const passwordInput = document.getElementById('password');
            const eyeIcon1 = document.getElementById('eyeIcon1');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'
                eyeIcon1.src = 'images/assets/eyeOn.svg'
            } else {
                passwordInput.type = 'password'
                eyeIcon1.src = 'images/assets/eyeOff.svg'
            }
        }

        function toggleEye2() {
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const eyeIcon2 = document.getElementById('eyeIcon2');

            if (passwordConfirmInput.type === 'password') {
                passwordConfirmInput.type = 'text'
                eyeIcon2.src = 'images/assets/eyeOn.svg'
            } else {
                passwordConfirmInput.type = 'password'
                eyeIcon2.src = 'images/assets/eyeOff.svg'
            }
        }
    </script>
</x-guest-layout>
