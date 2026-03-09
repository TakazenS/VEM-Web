<x-app-layout :title="__('VEM | Contact')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    <div class="pt-12 pb-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        @method('POST')

                        <!-- Service -->
                        <div class="mt-4">
                            <x-input-label for="service" :value="__('Service à contacter *')" />
                            <select id="service"
                                    name="service"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            >
                                <option value="administration">Administration</option>
                                <option value="logistique">Logistique</option>
                            </select>
                        </div>

                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nom et Prénom *')" />
                            <x-text-input id="name"
                                          class="block mt-1 w-full"
                                          type="text" name="name"
                                          :value="old('name')"
                                          required
                            />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Votre e-mail *')" />
                            <x-text-input id="email"
                                          class="block mt-1 w-full"
                                          type="email" name="email"
                                          :value="old('email')"
                                          required
                            />
                        </div>

                        <!-- Telephone -->
                        <div class="mt-4">
                            <x-input-label for="tel" :value="__('Votre n° de téléphone')" />
                            <x-text-input id="tel"
                                          class="block mt-1 w-full"
                                          type="text"
                                          name="tel"
                                          maxlength="14"
                                          :value="old('tel')"
                            />
                        </div>

                        <!-- Object -->
                        <div class="mt-4">
                            <x-input-label for="object" :value="__('Objet de votre demande *')" />
                            <x-text-input id="object"
                                          class="block mt-1 w-full"
                                          type="text"
                                          name="object"
                                          :value="old('object')"
                                          maxlength="150"
                                          required
                            />
                        </div>

                        <!-- Message -->
                        <div class="mt-4">
                            <x-input-label for="corps" :value="__('Votre message *')" />
                            <textarea id="corps"
                                      name="corps"
                                      rows="4"
                                      maxlength="1500"
                                      class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      required
                            >{{ old('corps') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button id="send-button" type="submit" disabled class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 transition ease-in-out duration-150">
                                {{ __('Envoyer') }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sendBtn = document.getElementById('send-button');

            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const telInput = document.getElementById('tel');
            const objectInput = document.getElementById('object');
            const corpsInput = document.getElementById('corps');

            // 1. On écoute TOUS les champs pour détecter la moindre modification en direct
            const allFields = [nameInput, emailInput, telInput, objectInput, corpsInput];

            // --- Fonctions de validation ---

            function validateName(name) {
                const regex = /^[\p{L} -]+$/u;
                return regex.test(String(name));
            }

            function validateEmail(email) {
                const regex = /^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
                return regex.test(String(email));
            }

            function validateTel(tel) {
                const regex = /^(\d{10}|\d{2}( \d{2}){4})$/;
                return regex.test(String(tel));
            }

            // --- Gestion du bouton ---

            function toggleButtonState() {
                const isNameValid = validateName(nameInput.value);
                const isEmailValid = validateEmail(emailInput.value);

                // 2. Le téléphone est valide s'il est VIDE ou s'il a un bon format
                const isTelValid = telInput.value.trim() === '' || validateTel(telInput.value);

                // 3. Objet et corps ne doivent pas être vides (trim enlève les espaces inutiles)
                const isObjectValid = objectInput.value.trim() !== '';
                const isCorpsValid = corpsInput.value.trim() !== '';

                // Le formulaire est valide uniquement si TOUTES les conditions sont vraies
                const isFormValid = isNameValid && isEmailValid && isTelValid && isObjectValid && isCorpsValid;

                sendBtn.disabled = !isFormValid;

                // Style visuel du bouton
                if (sendBtn.disabled) {
                    sendBtn.classList.add('opacity-30', 'cursor-not-allowed');
                } else {
                    sendBtn.classList.remove('opacity-30', 'cursor-not-allowed');
                }
            }

            // L'événement 'input' se déclenche à CHAQUE touche pressée (idéal pour la modification)
            allFields.forEach(field => {
                field.addEventListener('input', toggleButtonState);
            });

            // Initialisation au chargement
            toggleButtonState();

            // --- Styles dynamiques (Quand on quitte le champ) ---

            nameInput.addEventListener('blur', function () {
                if (!this.value || !validateName(this.value)) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            emailInput.addEventListener('blur', function () {
                if (!this.value || !validateEmail(this.value)) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            telInput.addEventListener('blur', function () {
                const telValue = this.value;

                // Si le champ est vide (facultatif), on enlève l'erreur et on met à jour le bouton
                if (!telValue.trim()) {
                    this.classList.remove('border-red-500');
                    this.value = ''; // Sécurité au cas où l'utilisateur a juste tapé un espace
                    toggleButtonState();
                    return;
                }

                // S'il est rempli mais invalide
                if (!validateTel(telValue)) {
                    this.classList.add('border-red-500');
                } else {
                    // S'il est valide, on le formate proprement
                    const cleanTel = telValue.replace(/\s+/g, '');
                    this.value = cleanTel.match(/.{1,2}/g)?.join(' ') || "";
                    this.classList.remove('border-red-500');
                }

                // 4. IMPORTANT : On force la vérification du bouton après avoir reformaté le numéro
                toggleButtonState();
            });

            objectInput.addEventListener('blur', function () {
                if (!this.value.trim()) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            corpsInput.addEventListener('blur', function () {
                if (!this.value.trim()) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });
        });
    </script>
</x-app-layout>
