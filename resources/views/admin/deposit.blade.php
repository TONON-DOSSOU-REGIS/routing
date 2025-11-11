<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt manuel - BankPro Admin</title>
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
                        <i class="fas fa-plus-circle text-2xl text-green-600 mr-3"></i>
                        <h1 class="text-2xl font-bold text-gray-900">Dépôt manuel sur compte client</h1>
                    </div>

                    <p class="text-gray-600 mb-6">
                        Effectuez un dépôt manuel sur le compte d'un client. Cette opération créditera immédiatement le solde du client sélectionné.
                    </p>

                    <form method="POST" action="{{ route('admin.deposit.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Sélectionner un client
                            </label>
                            <select name="user_id"
                                    id="user_id"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                <option value="">Choisir un client...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }} (Solde: {{ number_format($user->balance, 2) }} €)
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-gray-500">
                                Le solde actuel du client sera affiché entre parenthèses.
                            </p>
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Montant du dépôt (€)
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number"
                                       name="amount"
                                       id="amount"
                                       min="0.01"
                                       step="0.01"
                                       value="{{ old('amount') }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="0.00"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Montant minimum: 0.01 €. Utilisez le point comme séparateur décimal.
                            </p>
                        </div>

                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Motif du dépôt
                            </label>
                            <textarea name="reason"
                                      id="reason"
                                      rows="3"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                      placeholder="Motif du dépôt (optionnel)">{{ old('reason') }}</textarea>
                            <p class="mt-2 text-sm text-gray-500">
                                Description optionnelle du motif du dépôt (ex: "Remboursement", "Bonus fidélité", etc.).
                            </p>
                        </div>

                        <!-- Preview Section -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-eye text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Aperçu de l'opération</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p id="preview-text">Sélectionnez un client et un montant pour voir l'aperçu.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Confirmation requise</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>
                                            Cette action créditera immédiatement le compte du client sélectionné.
                                            Le client recevra une notification par email et SMS.
                                            Cette opération ne peut pas être annulée.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                    onclick="return confirm('Êtes-vous sûr de vouloir effectuer ce dépôt ? Cette action est irréversible.')">
                                <i class="fas fa-plus-circle mr-2"></i>Effectuer le dépôt
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Deposits -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dépôts récents</h3>
                    <div class="space-y-3">
                        @forelse($recentDeposits ?? collect() as $deposit)
                            <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $deposit->user->first_name }} {{ $deposit->user->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $deposit->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-green-600">
                                        +{{ number_format($deposit->amount, 2) }} €
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $deposit->reason ?? 'Dépôt manuel' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Aucun dépôt récent</p>
                        @endforelse
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

        // Update preview dynamically
        function updatePreview() {
            const select = document.getElementById('user_id');
            const amount = document.getElementById('amount').value;
            const selectedOption = select.options[select.selectedIndex];

            if (select.value && amount) {
                const userText = selectedOption.text.split(' - ')[0];
                document.getElementById('preview-text').textContent =
                    `Dépôt de ${amount} € sur le compte de ${userText}`;
            } else {
                document.getElementById('preview-text').textContent =
                    'Sélectionnez un client et un montant pour voir l\'aperçu.';
            }
        }

        document.getElementById('user_id').addEventListener('change', updatePreview);
        document.getElementById('amount').addEventListener('input', updatePreview);
    </script>
</body>
</html>
