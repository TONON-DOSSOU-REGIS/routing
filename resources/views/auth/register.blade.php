<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - BankPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">BankPro</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Accueil</a>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Connexion</a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none focus:text-blue-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <a href="{{ route('home') }}" class="block px-2 py-1 text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="{{ route('login') }}" class="block px-2 py-1 bg-blue-600 text-white rounded-lg mt-2">Connexion</a>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Créer votre compte</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Déjà un compte ? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Connectez-vous</a>
                </p>
            </div>
            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input id="first_name" name="first_name" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('first_name') }}">
                        @error('first_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input id="last_name" name="last_name" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('last_name') }}">
                        @error('last_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                    <input id="email" name="email" type="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('email') }}">
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input id="phone" name="phone" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('phone') }}">
                    @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <input id="address" name="address" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('address') }}">
                    @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700">Pays</label>
                            <select id="country" name="country" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sélectionner un pays</option>
                            <option value="Allemagne" {{ old('country') == 'Allemagne' ? 'selected' : '' }}>(DE) Allemagne</option>
                            <option value="Autriche" {{ old('country') == 'Autriche' ? 'selected' : '' }}>(AT) Autriche</option>
                            <option value="Belgique" {{ old('country') == 'Belgique' ? 'selected' : '' }}>(BE) Belgique</option>
                            <option value="Bulgarie" {{ old('country') == 'Bulgarie' ? 'selected' : '' }}>(BG) Bulgarie</option>
                            <option value="Chypre" {{ old('country') == 'Chypre' ? 'selected' : '' }}>(CY) Chypre</option>
                            <option value="Croatie" {{ old('country') == 'Croatie' ? 'selected' : '' }}>(HR) Croatie</option>
                            <option value="Danemark" {{ old('country') == 'Danemark' ? 'selected' : '' }}>(DK) Danemark</option>
                            <option value="Espagne" {{ old('country') == 'Espagne' ? 'selected' : '' }}>(ES) Espagne</option>
                            <option value="Estonie" {{ old('country') == 'Estonie' ? 'selected' : '' }}>(EE) Estonie</option>
                            <option value="Finlande" {{ old('country') == 'Finlande' ? 'selected' : '' }}>(FI) Finlande</option>
                            <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>(FR) France</option>
                            <option value="Grèce" {{ old('country') == 'Grèce' ? 'selected' : '' }}>(GR) Grèce</option>
                            <option value="Hongrie" {{ old('country') == 'Hongrie' ? 'selected' : '' }}>(HU) Hongrie</option>
                            <option value="Irlande" {{ old('country') == 'Irlande' ? 'selected' : '' }}>(IE) Irlande</option>
                            <option value="Italie" {{ old('country') == 'Italie' ? 'selected' : '' }}>(IT) Italie</option>
                            <option value="Lettonie" {{ old('country') == 'Lettonie' ? 'selected' : '' }}>(LV) Lettonie</option>
                            <option value="Lituanie" {{ old('country') == 'Lituanie' ? 'selected' : '' }}>(LT) Lituanie</option>
                            <option value="Luxembourg" {{ old('country') == 'Luxembourg' ? 'selected' : '' }}>(LU) Luxembourg</option>
                            <option value="Malte" {{ old('country') == 'Malte' ? 'selected' : '' }}>(MT) Malte</option>
                            <option value="Pays-Bas" {{ old('country') == 'Pays-Bas' ? 'selected' : '' }}>(NL) Pays-Bas</option>
                            <option value="Pologne" {{ old('country') == 'Pologne' ? 'selected' : '' }}>(PL) Pologne</option>
                            <option value="Portugal" {{ old('country') == 'Portugal' ? 'selected' : '' }}>(PT) Portugal</option>
                            <option value="République Tchèque" {{ old('country') == 'République Tchèque' ? 'selected' : '' }}>(CZ) République Tchèque</option>
                            <option value="Roumanie" {{ old('country') == 'Roumanie' ? 'selected' : '' }}>(RO) Roumanie</option>
                            <option value="Slovaquie" {{ old('country') == 'Slovaquie' ? 'selected' : '' }}>(SK) Slovaquie</option>
                            <option value="Slovénie" {{ old('country') == 'Slovénie' ? 'selected' : '' }}>(SI) Slovénie</option>
                            <option value="Suède" {{ old('country') == 'Suède' ? 'selected' : '' }}>(SE) Suède</option>
                            <option value="Suisse" {{ old('country') == 'Suisse' ? 'selected' : '' }}>(CH) Suisse</option>
                        </select>
                        @error('country') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                        <input id="city" name="city" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('city') }}">
                        @error('city') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="id_type" class="block text-sm font-medium text-gray-700">Type de pièce</label>
                        <select id="id_type" name="id_type" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sélectionner</option>
                            <option value="CNI" {{ old('id_type') == 'CNI' ? 'selected' : '' }}>CNI</option>
                            <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passeport</option>
                            <option value="Permis" {{ old('id_type') == 'Permis' ? 'selected' : '' }}>Permis de conduire</option>
                        </select>
                        @error('id_type') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="id_number" class="block text-sm font-medium text-gray-700">Numéro de pièce</label>
                        <input id="id_number" name="id_number" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('id_number') }}">
                        @error('id_number') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="iban" class="block text-sm font-medium text-gray-700">IBAN (optionnel)</label>
                        <input id="iban" name="iban" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('iban') }}">
                        @error('iban') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="bic" class="block text-sm font-medium text-gray-700">BIC (optionnel)</label>
                        <input id="bic" name="bic" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ old('bic') }}">
                        @error('bic') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input id="password" name="password" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
