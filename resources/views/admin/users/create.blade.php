<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un utilisateur - BankPro Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold text-gray-900">BankPro Admin</a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                        <a href="{{ route('admin.settings') }}" class="text-gray-700 hover:text-gray-900">Paramètres</a>
                        <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-gray-900">Utilisateurs</a>
                        <a href="{{ route('admin.deposit') }}" class="text-gray-700 hover:text-gray-900">Dépôt</a>
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Retour au site</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900">Déconnexion</button>
                        </form>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dashboard</a>
                        <a href="{{ route('admin.settings') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Paramètres</a>
                        <a href="{{ route('admin.users') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Utilisateurs</a>
                        <a href="{{ route('admin.deposit') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-50">Dépôt</a>
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Retour au site</a>
                        <form method="POST" action="{{ route('logout') }}" class="block px-3 py-2">
                            @csrf
                            <button type="submit" class="text-base font-medium text-gray-700 hover:text-gray-900 w-full text-left">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="ml-3">
                            <ul class="text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-user-plus text-2xl text-blue-600 mr-3"></i>
                        <h1 class="text-2xl font-bold text-gray-900">Créer un nouvel utilisateur</h1>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        <!-- Informations personnelles -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations personnelles</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Prénom *
                                    </label>
                                    <input type="text"
                                           name="first_name"
                                           id="first_name"
                                           value="{{ old('first_name') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nom *
                                    </label>
                                    <input type="text"
                                           name="last_name"
                                           id="last_name"
                                           value="{{ old('last_name') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email *
                                    </label>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           value="{{ old('email') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Téléphone
                                    </label>
                                    <input type="tel"
                                           name="phone"
                                           id="phone"
                                           value="{{ old('phone') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">
                                        Date de naissance
                                    </label>
                                    <input type="date"
                                           name="date_naissance"
                                           id="date_naissance"
                                           value="{{ old('date_naissance') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                        Rôle *
                                    </label>
                                    <select name="role"
                                            id="role"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Client</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Mot de passe *
                                    </label>
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Confirmer le mot de passe *
                                    </label>
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Adresse</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">
                                        Adresse
                                    </label>
                                    <input type="text"
                                           name="adresse"
                                           id="adresse"
                                           value="{{ old('adresse') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">
                                        Ville
                                    </label>
                                    <input type="text"
                                           name="ville"
                                           id="ville"
                                           value="{{ old('ville') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="pays" class="block text-sm font-medium text-gray-700 mb-1">
                                        Pays
                                    </label>
                                    <select name="pays"
                                            id="pays"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Sélectionner un pays</option>
                                        <option value="Allemagne" {{ old('pays') == 'Allemagne' ? 'selected' : '' }}>(DE) Allemagne</option>
                                        <option value="Autriche" {{ old('pays') == 'Autriche' ? 'selected' : '' }}>(AT) Autriche</option>
                                        <option value="Belgique" {{ old('pays') == 'Belgique' ? 'selected' : '' }}>(BE) Belgique</option>
                                        <option value="Bulgarie" {{ old('pays') == 'Bulgarie' ? 'selected' : '' }}>(BG) Bulgarie</option>
                                        <option value="Chypre" {{ old('pays') == 'Chypre' ? 'selected' : '' }}>(CY) Chypre</option>
                                        <option value="Croatie" {{ old('pays') == 'Croatie' ? 'selected' : '' }}>(HR) Croatie</option>
                                        <option value="Danemark" {{ old('pays') == 'Danemark' ? 'selected' : '' }}>(DK) Danemark</option>
                                        <option value="Espagne" {{ old('pays') == 'Espagne' ? 'selected' : '' }}>(ES) Espagne</option>
                                        <option value="Estonie" {{ old('pays') == 'Estonie' ? 'selected' : '' }}>(EE) Estonie</option>
                                        <option value="Finlande" {{ old('pays') == 'Finlande' ? 'selected' : '' }}>(FI) Finlande</option>
                                        <option value="France" {{ old('pays') == 'France' ? 'selected' : '' }}>(FR) France</option>
                                        <option value="Grèce" {{ old('pays') == 'Grèce' ? 'selected' : '' }}>(GR) Grèce</option>
                                        <option value="Hongrie" {{ old('pays') == 'Hongrie' ? 'selected' : '' }}>(HU) Hongrie</option>
                                        <option value="Irlande" {{ old('pays') == 'Irlande' ? 'selected' : '' }}>(IE) Irlande</option>
                                        <option value="Italie" {{ old('pays') == 'Italie' ? 'selected' : '' }}>(IT) Italie</option>
                                        <option value="Lettonie" {{ old('pays') == 'Lettonie' ? 'selected' : '' }}>(LV) Lettonie</option>
                                        <option value="Lituanie" {{ old('pays') == 'Lituanie' ? 'selected' : '' }}>(LT) Lituanie</option>
                                        <option value="Luxembourg" {{ old('pays') == 'Luxembourg' ? 'selected' : '' }}>(LU) Luxembourg</option>
                                        <option value="Malte" {{ old('pays') == 'Malte' ? 'selected' : '' }}>(MT) Malte</option>
                                        <option value="Pays-Bas" {{ old('pays') == 'Pays-Bas' ? 'selected' : '' }}>(NL) Pays-Bas</option>
                                        <option value="Pologne" {{ old('pays') == 'Pologne' ? 'selected' : '' }}>(PL) Pologne</option>
                                        <option value="Portugal" {{ old('pays') == 'Portugal' ? 'selected' : '' }}>(PT) Portugal</option>
                                        <option value="République Tchèque" {{ old('pays') == 'République Tchèque' ? 'selected' : '' }}>(CZ) République Tchèque</option>
                                        <option value="Roumanie" {{ old('pays') == 'Roumanie' ? 'selected' : '' }}>(RO) Roumanie</option>
                                        <option value="Slovaquie" {{ old('pays') == 'Slovaquie' ? 'selected' : '' }}>(SK) Slovaquie</option>
                                        <option value="Slovénie" {{ old('pays') == 'Slovénie' ? 'selected' : '' }}>(SI) Slovénie</option>
                                        <option value="Suède" {{ old('pays') == 'Suède' ? 'selected' : '' }}>(SE) Suède</option>
                                        <option value="Suisse" {{ old('pays') == 'Suisse' ? 'selected' : '' }}>(CH) Suisse</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Pièce d'identité -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Pièce d'identité</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="type_piece" class="block text-sm font-medium text-gray-700 mb-1">
                                        Type de pièce
                                    </label>
                                    <select name="type_piece"
                                            id="type_piece"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Sélectionner</option>
                                        <option value="CNI" {{ old('type_piece') == 'CNI' ? 'selected' : '' }}>Carte Nationale d'Identité</option>
                                        <option value="Passeport" {{ old('type_piece') == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                                        <option value="Permis" {{ old('type_piece') == 'Permis' ? 'selected' : '' }}>Permis de conduire</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="numero_piece" class="block text-sm font-medium text-gray-700 mb-1">
                                        Numéro de pièce
                                    </label>
                                    <input type="text"
                                           name="numero_piece"
                                           id="numero_piece"
                                           value="{{ old('numero_piece') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Informations bancaires -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations bancaires (optionnelles)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="iban" class="block text-sm font-medium text-gray-700 mb-1">
                                        IBAN
                                    </label>
                                    <input type="text"
                                           name="iban"
                                           id="iban"
                                           value="{{ old('iban') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="FR76 1234 5678 9012 3456 7890 123">
                                </div>

                                <div>
                                    <label for="bic" class="block text-sm font-medium text-gray-700 mb-1">
                                        BIC
                                    </label>
                                    <input type="text"
                                           name="bic"
                                           id="bic"
                                           value="{{ old('bic') }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="BNPAFRPP">
                                </div>
                            </div>
                        </div>

                        <!-- Code d'activation -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-key text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Code d'activation</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>
                                            Le code d'activation est défini par l'administrateur et est requis pour certains scénarios de virement.
                                            Vous pouvez le définir maintenant ou le laisser vide.
                                        </p>
                                        <div class="mt-2">
                                            <label for="activation_code" class="block text-sm font-medium text-blue-800 mb-1">
                                                Code d'activation (optionnel)
                                            </label>
                                            <input type="text"
                                                   name="activation_code"
                                                   id="activation_code"
                                                   value="{{ old('activation_code') }}"
                                                   class="block w-full px-3 py-2 border border-blue-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="Entrez un code d'activation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.users') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-user-plus mr-2"></i>Créer l'utilisateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
