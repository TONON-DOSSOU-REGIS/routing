<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur - BankPro Admin</title>
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
                        <a href="{{ route('admin.deposit') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dépôt</a>
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
                        <i class="fas fa-user-edit text-2xl text-blue-600 mr-3"></i>
                        <h1 class="text-2xl font-bold text-gray-900">Modifier l'utilisateur</h1>
                        <span class="ml-4 text-sm text-gray-500">ID: {{ $user->id }}</span>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

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
                                           value="{{ old('first_name', $user->first_name) }}"
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
                                           value="{{ old('last_name', $user->last_name) }}"
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
                                           value="{{ old('email', $user->email) }}"
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
                                           value="{{ old('phone', $user->phone) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">
                                        Date de naissance
                                    </label>
                                    <input type="date"
                                           name="date_naissance"
                                           id="date_naissance"
                                           value="{{ old('date_naissance', $user->date_naissance ? $user->date_naissance->format('Y-m-d') : '') }}"
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
                                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Client</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    </select>
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
                                           value="{{ old('adresse', $user->adresse) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">
                                        Ville
                                    </label>
                                    <input type="text"
                                           name="ville"
                                           id="ville"
                                           value="{{ old('ville', $user->ville) }}"
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
                                        <option value="France" {{ old('pays', $user->pays) == 'France' ? 'selected' : '' }}>France</option>
                                        <option value="Belgique" {{ old('pays', $user->pays) == 'Belgique' ? 'selected' : '' }}>Belgique</option>
                                        <option value="Suisse" {{ old('pays', $user->pays) == 'Suisse' ? 'selected' : '' }}>Suisse</option>
                                        <option value="Canada" {{ old('pays', $user->pays) == 'Canada' ? 'selected' : '' }}>Canada</option>
                                        <option value="Maroc" {{ old('pays', $user->pays) == 'Maroc' ? 'selected' : '' }}>Maroc</option>
                                        <option value="Algérie" {{ old('pays', $user->pays) == 'Algérie' ? 'selected' : '' }}>Algérie</option>
                                        <option value="Tunisie" {{ old('pays', $user->pays) == 'Tunisie' ? 'selected' : '' }}>Tunisie</option>
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
                                        <option value="CNI" {{ old('type_piece', $user->type_piece) == 'CNI' ? 'selected' : '' }}>Carte Nationale d'Identité</option>
                                        <option value="Passeport" {{ old('type_piece', $user->type_piece) == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                                        <option value="Permis" {{ old('type_piece', $user->type_piece) == 'Permis' ? 'selected' : '' }}>Permis de conduire</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="numero_piece" class="block text-sm font-medium text-gray-700 mb-1">
                                        Numéro de pièce
                                    </label>
                                    <input type="text"
                                           name="numero_piece"
                                           id="numero_piece"
                                           value="{{ old('numero_piece', $user->numero_piece) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Informations bancaires -->
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations bancaires</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="iban" class="block text-sm font-medium text-gray-700 mb-1">
                                        IBAN
                                    </label>
                                    <input type="text"
                                           name="iban"
                                           id="iban"
                                           value="{{ old('iban', $user->iban) }}"
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
                                           value="{{ old('bic', $user->bic) }}"
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
                                                   value="{{ old('activation_code', $user->activation_code) }}"
                                                   class="block w-full px-3 py-2 border border-blue-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="Entrez un code d'activation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statut du compte -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-yellow-800 mb-3">Statut du compte</h3>
                            <div class="space-y-3">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-yellow-700 mb-1">
                                        Statut actuel
                                    </label>
                                    <select name="status"
                                            id="status"
                                            class="block w-full px-3 py-2 border border-yellow-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                                    </select>
                                </div>
                                <div class="text-sm text-yellow-700">
                                    <p><strong>Statut actuel :</strong>
                                        <span class="px-2 py-1 rounded text-xs font-medium
                                            {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </p>
                                    <p class="mt-1">Un compte suspendu ne peut pas effectuer de transactions.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Solde -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-blue-800 mb-3">Solde du compte</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="balance" class="block text-sm font-medium text-blue-700 mb-1">
                                        Solde actuel (€)
                                    </label>
                                    <div class="text-2xl font-bold text-blue-600">
                                        {{ number_format($user->balance, 2) }} €
                                    </div>
                                </div>
                                <div>
                                    <label for="balance" class="block text-sm font-medium text-blue-700 mb-1">
                                        Nouveau solde (€) *
                                    </label>
                                    <input type="number"
                                           name="balance"
                                           id="balance"
                                           step="0.01"
                                           value="{{ old('balance', number_format($user->balance, 2, '.', '')) }}"
                                           class="block w-full px-3 py-2 border border-blue-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                    <p class="mt-1 text-xs text-blue-600">
                                        Solde actuel: {{ number_format($user->balance, 2) }} €. Cette modification sera tracée.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.users') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-2"></i>Enregistrer les modifications
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
