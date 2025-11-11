<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres de progression - BankPro Admin</title>
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

        <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
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
                        <i class="fas fa-cog text-2xl text-blue-600 mr-3"></i>
                        <h1 class="text-2xl font-bold text-gray-900">Paramètres de progression des virements</h1>
                    </div>

                    <p class="text-gray-600 mb-6">
                        Configurez le pourcentage d'arrêt automatique et le message affiché lors de la suspension des virements.
                        Ces paramètres s'appliquent à tous les nouveaux virements en cours de traitement.
                    </p>

                    <form method="POST" action="{{ route('admin.settings.save') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="stop_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                                Pourcentage d'arrêt automatique (%)
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number"
                                       name="stop_percentage"
                                       id="stop_percentage"
                                       min="1"
                                       max="99"
                                       value="{{ old('stop_percentage', $settings->stop_percentage ?? 70) }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">%</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Le virement s'arrêtera automatiquement à ce pourcentage (ex: 70 = arrêt à 70%).
                            </p>
                        </div>

                        <div>
                            <label for="is_global" class="block text-sm font-medium text-gray-700 mb-2">
                                Portée des paramètres
                            </label>
                            <div class="mt-1">
                                <label class="inline-flex items-center">
                                    <input type="radio"
                                           name="is_global"
                                           value="1"
                                           {{ old('is_global', $settings->is_global ?? true) ? 'checked' : '' }}
                                           class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2">Global (tous les utilisateurs)</span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input type="radio"
                                           name="is_global"
                                           value="0"
                                           {{ old('is_global', $settings->is_global ?? true) ? '' : 'checked' }}
                                           class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2">Spécifique à un utilisateur</span>
                                </label>
                            </div>
                        </div>

                        <div id="target_user_container" class="hidden">
                            <label for="target_user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Sélectionner un client
                            </label>
                            <select name="target_user_id"
                                    id="target_user_id"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Choisir un client...</option>
                                @foreach(\App\Models\User::where('role', 'user')->get() as $user)
                                    <option value="{{ $user->id }}" {{ old('target_user_id', $settings->target_user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-gray-500">
                                Ces paramètres s'appliqueront uniquement aux virements de ce client.
                            </p>
                        </div>

                        <div>
                            <label for="stop_message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message de suspension
                            </label>
                            <textarea name="stop_message"
                                      id="stop_message"
                                      rows="3"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                      placeholder="Message affiché lors de la suspension..."
                                      required>{{ old('stop_message', $settings->stop_message ?? 'Transaction suspendue pour vérification de sécurité.') }}</textarea>
                            <p class="mt-2 text-sm text-gray-500">
                                Ce message sera affiché à l'utilisateur lorsque le virement sera suspendu.
                            </p>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Information</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>
                                            <strong>Pourcentage actuel :</strong> {{ $settings->stop_percentage ?? 70 }}%<br>
                                            <strong>Message actuel :</strong> {{ $settings->stop_message ?? 'Transaction suspendue pour vérification de sécurité.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-2"></i>Enregistrer les paramètres
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aperçu du message de suspension</h3>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Transaction suspendue</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p id="preview-message">{{ old('stop_message', $settings->stop_message ?? 'Transaction suspendue pour vérification de sécurité.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
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

        // Update preview in real-time
        document.getElementById('stop_message').addEventListener('input', function() {
            document.getElementById('preview-message').textContent = this.value;
        });

        // Show/hide target user selection based on scope
        document.querySelectorAll('input[name="is_global"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const targetUserContainer = document.getElementById('target_user_container');
                if (this.value === '0') {
                    targetUserContainer.classList.remove('hidden');
                } else {
                    targetUserContainer.classList.add('hidden');
                }
            });
        });

        // Initialize visibility on page load
        document.addEventListener('DOMContentLoaded', function() {
            const selectedRadio = document.querySelector('input[name="is_global"]:checked');
            if (selectedRadio && selectedRadio.value === '0') {
                document.getElementById('target_user_container').classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
