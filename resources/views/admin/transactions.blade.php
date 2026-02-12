<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Virements - SG BANK Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @keyframes fadeInUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        .fade-in-up { 
            animation: fadeInUp 0.6s ease-out forwards; 
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        @include('components.admin-dashboard-background-styles')
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    @include('components.admin-dashboard-background')
    <div class="min-h-screen relative z-10">
    <!-- Navigation -->
    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
                        </div>
                        <span class="sr-only">SG BANK Admin</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ localized_route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-chart-line mr-2"></i>Dashboard
                    </a>
                    <a href="{{ localized_route('admin.users') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-users mr-2"></i>Utilisateurs
                    </a>
                    <a href="{{ localized_route('admin.transactions') }}" class="text-blue-600 font-semibold">
                        <i class="fas fa-exchange-alt mr-2"></i>Virements
                    </a>
                    <a href="{{ localized_route('admin.settings') }}" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-cog mr-2"></i>Paramètres
                    </a>
                    <form action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                        </button>
                    </form>
                </div>

                <button id="mobile-menu-button" class="md:hidden text-gray-600">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 py-3 space-y-3">
                <a href="{{ localized_route('admin.dashboard') }}" class="block text-gray-600 hover:text-blue-600">
                    <i class="fas fa-chart-line mr-2"></i>Dashboard
                </a>
                <a href="{{ localized_route('admin.users') }}" class="block text-gray-600 hover:text-blue-600">
                    <i class="fas fa-users mr-2"></i>Utilisateurs
                </a>
                <a href="{{ localized_route('admin.transactions') }}" class="block text-blue-600 font-semibold">
                    <i class="fas fa-exchange-alt mr-2"></i>Virements
                </a>
                <a href="{{ localized_route('admin.settings') }}" class="block text-gray-600 hover:text-blue-600">
                    <i class="fas fa-cog mr-2"></i>Paramètres
                </a>
                <form action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left text-red-600 hover:text-red-700">
                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 fade-in-up">
            <h1 class="text-2xl sm:text-4xl font-bold text-white mb-2">
                <i class="fas fa-exchange-alt text-blue-600 mr-3"></i>
                Gestion des Virements
            </h1>
            <p class="text-white">Gérez tous les virements et effectuez des remboursements</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('status'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg fade-in-up">
                <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg fade-in-up">
                <i class="fas fa-exclamation-circle mr-2"></i>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-8 fade-in-up card-hover">
            <h2 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-filter text-blue-600 mr-2"></i>Filtres
            </h2>
            
            <form method="GET" action="{{ localized_route('admin.transactions') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="ID, nom, email..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les types</option>
                        <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>Virement</option>
                        <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>Dépôt</option>
                        <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>Retrait</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Réussi</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>En suspens</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Remboursé</option>
                    </select>
                </div>

                <!-- User Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Utilisateur</label>
                    <select name="user_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les utilisateurs</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->first_name }} {{ $u->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row sm:items-end gap-2 md:col-span-2">
                    <button type="submit" class="w-full sm:flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition">
                        <i class="fas fa-search mr-2"></i>Filtrer
                    </button>
                    <a href="{{ localized_route('admin.transactions') }}" class="w-full sm:flex-1 bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition text-center">
                        <i class="fas fa-redo mr-2"></i>Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden fade-in-up">
            <div class="overflow-x-auto">
                <table class="min-w-[900px] w-full text-sm sm:text-base">
                    <thead class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-sm font-semibold">ID</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-sm font-semibold">Utilisateur</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-sm font-semibold">Type</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-sm font-semibold">Montant</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-sm font-semibold">Bénéficiaire</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-sm font-semibold">Statut</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-sm font-semibold">Date</th>
                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm font-medium text-gray-900">#{{ $transaction->id }}</td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-900">
                                    <div class="font-medium">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</div>
                                    <div class="text-gray-500 text-xs">{{ $transaction->user->email }}</div>
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm">
                                    @if($transaction->type === 'transfer')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-exchange-alt mr-1"></i>Virement
                                        </span>
                                    @elseif($transaction->type === 'deposit')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-plus-circle mr-1"></i>Dépôt
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-minus-circle mr-1"></i>Retrait
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm font-bold text-gray-900">
                                    {{ \App\Helpers\CurrencyHelper::format($transaction->amount, $transaction->user->default_currency ?? 'EUR') }}
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-900">
                                    @if($transaction->recipient_name)
                                        <div class="font-medium">{{ $transaction->recipient_name }}</div>
                                        <div class="text-gray-500 text-xs">{{ $transaction->bank_name ?? 'N/A' }}</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm">
                                    @if($transaction->status === 'success')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i>Réussi
                                        </span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-clock mr-1"></i>En attente
                                        </span>
                                    @elseif($transaction->status === 'on_hold')
                                        <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-pause-circle mr-1"></i>En suspens
                                        </span>
                                    @elseif($transaction->status === 'refunded')
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-undo mr-1"></i>Remboursé
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-500">
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm">
                                    @if($transaction->status === 'success' && $transaction->type === 'transfer')
                                        <button onclick="openRefundModal({{ $transaction->id }}, '{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}', {{ $transaction->amount }}, '{{ $transaction->user->default_currency ?? 'EUR' }}')" 
                                                class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition text-xs font-semibold">
                                            <i class="fas fa-undo mr-1"></i>Rembourser
                                        </button>
                                    @elseif($transaction->status === 'refunded')
                                        @if($transaction->refunded_at)
                                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                                <i class="fas fa-undo mr-1"></i>Remboursé le {{ $transaction->refunded_at->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                                <i class="fas fa-undo mr-1"></i>Remboursé
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 sm:px-6 py-10 sm:py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium">Aucune transaction trouvée</p>
                                    <p class="text-sm">Essayez de modifier vos filtres</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Refund Modal -->
    <div id="refundModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-5 sm:p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">
                <i class="fas fa-undo text-green-600 mr-2"></i>Confirmer le remboursement
            </h3>
            
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-700 mb-2"><strong>Utilisateur:</strong> <span id="modalUserName"></span></p>
                <p class="text-sm text-gray-700"><strong>Montant:</strong> <span id="modalAmount"></span></p>
            </div>

            <form id="refundForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motif du remboursement (optionnel)</label>
                    <textarea name="refund_reason" rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                              placeholder="Ex: Erreur de transaction, demande du client..."></textarea>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" onclick="closeRefundModal()" 
                            class="flex-1 w-full bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="flex-1 w-full bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition font-semibold">
                        <i class="fas fa-check mr-2"></i>Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Refund Modal Functions
        function openRefundModal(transactionId, userName, amount, currency = 'EUR') {
            const currencySymbols = {
                'EUR': '€', 'USD': '$', 'GBP': '£', 'JPY': '¥', 'CHF': 'CHF',
                'CAD': 'C$', 'AUD': 'A$', 'CNY': '¥', 'INR': '₹', 'BRL': 'R$',
                'ZAR': 'R', 'RUB': '₽', 'KRW': '₩', 'MXN': 'MX$', 'SGD': 'S$',
                'HKD': 'HK$', 'NOK': 'kr', 'SEK': 'kr', 'DKK': 'kr', 'PLN': 'zł',
                'THB': '฿', 'IDR': 'Rp', 'HUF': 'Ft', 'CZK': 'Kč', 'ILS': '₪',
                'CLP': 'CLP$', 'PHP': '₱', 'AED': 'د.إ', 'COP': 'COL$', 'SAR': 'ر.س',
                'MYR': 'RM', 'RON': 'lei', 'TRY': '₺', 'NZD': 'NZ$', 'TWD': 'NT$',
                'VND': '₫', 'ARS': 'ARS$', 'EGP': 'E£', 'PKR': '₨', 'BDT': '৳',
                'NGN': '₦', 'UAH': '₴', 'KES': 'KSh', 'MAD': 'د.م.', 'XOF': 'CFA'
            };

            const symbol = currencySymbols[currency] || currency;
            const locale = document.documentElement.lang || '{{ app()->getLocale() }}';
            const formattedAmount = new Intl.NumberFormat(locale, { minimumFractionDigits: 2 }).format(amount);

            // Currencies that go before the amount
            const prefixCurrencies = ['USD', 'GBP', 'CAD', 'AUD', 'HKD', 'SGD', 'MXN', 'NZD', 'ARS', 'CLP', 'COP', 'EGP'];

            const displayAmount = prefixCurrencies.includes(currency)
                ? symbol + formattedAmount
                : formattedAmount + ' ' + symbol;

            document.getElementById('modalUserName').textContent = userName;
            document.getElementById('modalAmount').textContent = displayAmount;
            document.getElementById('refundForm').action = `/${locale}/admin/transactions/${transactionId}/refund`;
            document.getElementById('refundModal').classList.remove('hidden');
        }

        function closeRefundModal() {
            document.getElementById('refundModal').classList.add('hidden');
        }

        // Close modal on outside click
        document.getElementById('refundModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRefundModal();
            }
        });
    </script>
    @include('components.admin-dashboard-background-script')
    </div>
</body>
</html>






