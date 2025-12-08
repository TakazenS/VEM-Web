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
                            <button id="send-button" type="submit" disabled class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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
            const requiredFieldsForButton = [
                document.getElementById('name'),
                document.getElementById('email'),
                document.getElementById('object'),
                document.getElementById('corps')
            ];

            // Fonction pour mettre à jour l'état du bouton
            function toggleButtonState() {
                const allFilled = requiredFieldsForButton.every(field => field.value.trim() !== '');
                sendBtn.disabled = !allFilled;
            }

            // Écouteur d'événement pour chaque champ requis afin de changer l'état du bouton
            requiredFieldsForButton.forEach(field => {
                field.addEventListener('input', toggleButtonState);
            });

            // Charge l'état du bouton au chargement de la page
            toggleButtonState();

            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const telInput = document.getElementById('tel');
            const objectInput = document.getElementById('object');
            const corpsInput = document.getElementById('corps');

            // Vérifie le champ 'name'
            function validateName(name) {
                const regex = /^[\p{L} -]+$/u;
                return regex.test(String(name));
            }

            // Vérifie le champ 'email'
            function validateEmail(email) {
                const regex = /^[a-zA-Z0-9.-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
                return regex.test(String(email));
            }

            // Vérifie le champ 'tel'
            function validateTel(tel) {
                const regex = /^(\d{10}|\d{2}( \d{2}){4})$/;
                return regex.test(String(tel));
            }

            // L'événement 'blur' se déclenche quand l'utilisateur quitte le champ
            // Style dynamique pour 'name'
            nameInput.addEventListener('blur', function () {
                const nameValue = nameInput.value;

                // Si le champ 'name' est vide ou que la valeur n'est pas valide, on affiche une bordure rouge
                if (!nameValue || !validateName(nameValue)) {
                    nameInput.classList.add('border-red-500');
                    // Sinon, on enlève cette bordure
                } else {
                    nameInput.classList.remove('border-red-500');
                }
            });

            // Style dynamique pour 'email'
            emailInput.addEventListener('blur', function () {
                const emailValue = emailInput.value;

                // Si le champ 'email' est vide ou que la valeur n'est pas valide, on affiche une bordure rouge
                if (!emailValue || !validateEmail(emailValue)) {
                    emailInput.classList.add('border-red-500');
                    // Sinon, on enlève cette bordure
                } else {
                    emailInput.classList.remove('border-red-500');
                }
            });

            // Style dynamique pour 'tel'
            telInput.addEventListener('blur', function () {
                const telValue = telInput.value;

                // Si le champ 'tel' est vide, on enlève la bordure rouge
                if (!telValue) {
                    telInput.classList.remove('border-red-500');
                    return;
                }

                // Si le champ 'tel' n'est pas vide et que la valeur n'est pas valide, on affiche une bordure rouge
                if (telValue && !validateTel(telValue)) {
                    telInput.classList.add('border-red-500');
                    // Sinon, on enlève cette bordure
                } else {
                    telInput.classList.remove('border-red-500');
                }
            });

            // Style dynamique pour 'object'
            objectInput.addEventListener('blur', function () {
                const objectValue = objectInput.value;

                // Si le champ 'object' est vide, on affiche la bordure rouge
                if (!objectValue) {
                    objectInput.classList.add('border-red-500');
                    // Sinon, on enlève cette bordure
                } else {
                    objectInput.classList.remove('border-red-500');
                }
            });

            // Style dynamique pour 'corps'
            corpsInput.addEventListener('blur', function () {
                const corpsValue = corpsInput.value;

                // Si le champ 'corps' est vide, on affiche la bordure rouge
                if (!corpsValue) {
                    corpsInput.classList.add('border-red-500');
                    // Sinon, on enlève cette bordure
                } else {
                    corpsInput.classList.remove('border-red-500');
                }
            });
        });
    </script>
</x-app-layout>
