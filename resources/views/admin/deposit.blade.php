<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt manuel - SG BANK Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* Animations élégantes */
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
        
        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateX(-20px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }
        
        .fade-in-up { 
            animation: fadeInUp 0.6s ease-out forwards; 
        }
        
        .slide-in { 
            animation: slideIn 0.5s ease-out forwards; 
        }
        
        /* Animation d'entrée pour les éléments */
        .stagger-item {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .stagger-item:nth-child(1) { animation-delay: 0.1s; }
        .stagger-item:nth-child(2) { animation-delay: 0.2s; }
        .stagger-item:nth-child(3) { animation-delay: 0.3s; }
        .stagger-item:nth-child(4) { animation-delay: 0.4s; }
        
        /* Effet de survol amélioré */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Effet glassmorphism pour la navigation */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        /* Style pour les boutons d'action */
        .action-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .action-btn:hover::before {
            left: 100%;
        }
        
        /* Style pour les cartes avec effet glass */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        /* Style pour les inputs */
        .input-field {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.7);
        }
        
        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.9);
        }
        
        /* Animation de pulsation pour les indicateurs */
        @keyframes pulse-glow {
            0%, 100% { 
                box-shadow: 0 0 5px rgba(34, 197, 94, 0.5);
            }
            50% { 
                box-shadow: 0 0 20px rgba(34, 197, 94, 0.8);
            }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }
        
        /* Style pour les badges */
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
        }

        /* Style pour l'arrière-plan */
        .background-container {
            background-image: url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        .background-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(139, 92, 246, 0.85) 50%, rgba(14, 165, 233, 0.9) 100%);
            backdrop-filter: blur(2px);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Container avec image de fond -->
    <div class="background-container min-h-screen">
        <div class="min-h-screen relative z-10">
            <!-- Navigation améliorée -->
            <nav class="glass-nav sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-2 rounded-lg">
                                    <img src='{{ asset("images/logobank.png") }}' class="w-9 h-9" alt="">
                                </div>
                                <div>
                                    <a href="{{ localized_route('admin.dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">SG BANK Admin</a>
                                    <div class="text-xs text-gray-500 -mt-1">Gestion des dépôts</div>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-6">
                            <a href="{{ localized_route('admin.dashboard') }}" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="{{ localized_route('admin.settings') }}" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-cog mr-2"></i> Paramètres
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="{{ localized_route('admin.users') }}" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-users mr-2"></i> Utilisateurs
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="{{ localized_route('admin.deposit') }}" class="relative text-blue-600 font-semibold transition duration-300 group">
                                <i class="fas fa-plus-circle mr-2"></i> Dépôt
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600"></span>
                            </a>
                            <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="relative text-gray-700 hover:text-green-600 transition duration-300 font-medium group">
                                <i class="fas fa-arrow-left mr-2"></i> Retour au site
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}">
                                @csrf
                                <button type="submit" class="relative text-gray-700 hover:text-red-600 transition duration-300 font-medium group">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                                </button>
                            </form>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden flex items-center">
                            <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none transition duration-300 p-2 rounded-lg hover:bg-blue-50">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Navigation Menu -->
                    <div class="md:hidden hidden" id="mobile-menu">
                        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white/95 backdrop-blur-lg border border-gray-200 rounded-lg shadow-xl mt-2">
                            <a href="{{ localized_route('admin.dashboard') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i> Dashboard
                            </a>
                            <a href="{{ localized_route('admin.settings') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-cog w-5 mr-3 text-center"></i> Paramètres
                            </a>
                            <a href="{{ localized_route('admin.users') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-users w-5 mr-3 text-center"></i> Utilisateurs
                            </a>
                            <a href="{{ localized_route('admin.deposit') }}" class="flex items-center px-3 py-3 text-base font-medium text-blue-600 bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-plus-circle w-5 mr-3 text-center"></i> Dépôt
                            </a>
                            <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition duration-300">
                                <i class="fas fa-arrow-left w-5 mr-3 text-center"></i> Retour au site
                            </a>
                            <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}" class="block">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-3 py-3 text-base font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition duration-300">
                                    <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- En-tête de la page -->
                <div class="mb-8 fade-in-up">
                    <h1 class="text-3xl font-bold text-white drop-shadow-lg text-center">Dépôt manuel</h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center">Effectuez un dépôt manuel sur le compte d'un client</p>
                </div>

                <!-- Flash Messages améliorées -->
                @if(session('status'))
                    <div class="mb-6 glass-card border-l-4 border-l-green-500 rounded-2xl fade-in-up">
                        <div class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-800">{{ session('status') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 glass-card border-l-4 border-l-red-500 rounded-2xl fade-in-up">
                        <div class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-100 p-2 rounded-full">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Erreurs de validation</h3>
                                    <ul class="text-sm text-gray-700 list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Formulaire principal -->
                    <div class="lg:col-span-2">
                        <div class="glass-card rounded-2xl overflow-hidden card-hover">
                            <div class="px-8 py-8">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-3 rounded-2xl mr-4 shadow-lg">
                                        <i class="fas fa-plus-circle text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">Dépôt manuel</h1>
                                        <p class="text-gray-600 mt-1">Créditez immédiatement le compte d'un client</p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ localized_route('admin.deposit.store') }}" class="space-y-6">
                                    @csrf

                                    <!-- Sélection du client -->
                                    <div class="stagger-item">
                                        <label for="user_id" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-user mr-2 text-blue-500"></i>
                                            Sélectionner un client
                                        </label>
                                        <div class="relative">
                                            <select name="user_id"
                                                    id="user_id"
                                                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm input-field"
                                                    required>
                                                <option value="">Choisir un client...</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}
                                                            data-balance="{{ $user->balance }}">
                                                        {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                        <div id="balance-display" class="mt-2 text-sm text-gray-600 bg-blue-50 px-3 py-2 rounded-lg hidden">
                                            <i class="fas fa-wallet mr-1 text-blue-500"></i>
                                            Solde actuel: <span id="current-balance" class="font-semibold"></span> €
                                        </div>
                                    </div>

                                    <!-- Montant du dépôt -->
                                    <div class="stagger-item">
                                        <label for="amount" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-euro-sign mr-2 text-green-500"></i>
                                            Montant du dépôt
                                        </label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <input type="number"
                                                   name="amount"
                                                   id="amount"
                                                   min="0.01"
                                                   step="0.01"
                                                   value="{{ old('amount') }}"
                                                   class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm input-field"
                                                   placeholder="0.00"
                                                   required>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span id="currency-symbol" class="text-gray-500 font-medium">€</span>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500 flex items-center" id="amount-min-info">
                                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                            Montant minimum: 0.01 €
                                        </p>
                                    </div>
                                    
                                    <!-- Sélection de la devise -->
                                    <div class="stagger-item">
                                        <label for="currency" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-coins mr-2 text-yellow-500"></i>
                                            Sélectionnez la devise
                                        </label>
                                        <div class="relative">
                                            <select name="currency"
                                                    id="currency"
                                                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm input-field"
                                                    required>
                                                <option value="">Choisir une devise...</option>
                                                @foreach(config('currencies.currencies') as $code => $name)
                                                    <option value="{{ $code }}" {{ old('currency') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Motif du dépôt -->
                                    <div class="stagger-item">
                                        <label for="reason" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-comment mr-2 text-purple-500"></i>
                                            Motif du dépôt
                                        </label>
                                        <textarea name="reason"
                                                  id="reason"
                                                  rows="3"
                                                  class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm input-field resize-none"
                                                  placeholder="Décrivez le motif de ce dépôt (optionnel)">{{ old('reason') }}</textarea>
                                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-lightbulb mr-1 text-yellow-500"></i>
                                            Exemples: "Remboursement", "Bonus fidélité", "Ajustement de compte"
                                        </p>
                                    </div>

                                    <!-- Aperçu dynamique -->
                                    <div class="stagger-item">
                                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                                                    <i class="fas fa-eye text-blue-500 text-lg"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Aperçu de l'opération</h3>
                                                    <div class="text-sm text-blue-700">
                                                        <p id="preview-text" class="font-medium">Sélectionnez un client et un montant pour voir l'aperçu.</p>
                                                        <div id="new-balance" class="mt-2 text-xs text-blue-600 hidden">
                                                            Nouveau solde: <span id="new-balance-amount" class="font-bold"></span> €
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Avertissement de confirmation -->
                                    <div class="stagger-item">
                                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-5">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-amber-100 p-2 rounded-lg mr-4">
                                                    <i class="fas fa-exclamation-triangle text-amber-500 text-lg"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="text-sm font-semibold text-amber-800 mb-2">Confirmation requise</h3>
                                                    <div class="text-sm text-amber-700 space-y-1">
                                                        <p class="flex items-center">
                                                            <i class="fas fa-bolt mr-2"></i>
                                                            Cette action créditera immédiatement le compte du client
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i class="fas fa-bell mr-2"></i>
                                                            Le client recevra une notification par email et SMS
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i class="fas fa-ban mr-2"></i>
                                                            Cette opération ne peut pas être annulée
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Boutons d'action -->
                                    <div class="stagger-item flex justify-end space-x-4 pt-4">
                                        <a href="{{ localized_route('admin.dashboard') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition duration-300 font-medium shadow-sm">
                                            <i class="fas fa-arrow-left mr-2"></i>Annuler
                                        </a>
                                        <button type="submit"
                                                class="action-btn bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-3 rounded-xl hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 font-semibold shadow-lg transform hover:scale-105 transition duration-300 pulse-glow"
                                                onclick="return confirm('Êtes-vous sûr de vouloir effectuer ce dépôt ? Cette action est irréversible.')">
                                            <i class="fas fa-plus-circle mr-2"></i>Effectuer le dépôt
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Dépôts récents -->
                    <div class="lg:col-span-1">
                        <div class="glass-card rounded-2xl overflow-hidden card-hover">
                            <div class="px-6 py-6">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-2 rounded-xl mr-3 shadow-lg">
                                        <i class="fas fa-history text-white"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">Dépôts récents</h3>
                                </div>
                                <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                                    @forelse($recentDeposits ?? collect() as $deposit)
                                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border border-gray-200 hover:border-green-200 transition duration-300">
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $deposit->user->first_name }} {{ $deposit->user->last_name }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ $deposit->created_at->format('d/m/Y H:i') }}
                                                </p>
                                                <p class="text-xs text-gray-600 mt-1 truncate">
                                                    {{ $deposit->reason ?? 'Dépôt manuel' }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-bold text-green-600">
                                                    +{{ number_format($deposit->amount, 2) }} €
                                                </p>
                                                <span class="badge bg-green-100 text-green-800">
                                                    <i class="fas fa-check text-xs mr-1"></i>Confirmé
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <div class="bg-gray-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                                                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                            </div>
                                            <p class="text-gray-500 text-sm">Aucun dépôt récent</p>
                                        </div>
                                    @endforelse
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

            // Update preview dynamically
            function updatePreview() {
                const select = document.getElementById('user_id');
                const amount = document.getElementById('amount').value;
                const currencySelect = document.getElementById('currency');
                const selectedOption = select.options[select.selectedIndex];
                const balanceDisplay = document.getElementById('balance-display');
                const currentBalanceSpan = document.getElementById('current-balance');
                const currencySymbolSpan = document.getElementById('currency-symbol');
                const newBalanceDiv = document.getElementById('new-balance');
                const newBalanceAmount = document.getElementById('new-balance-amount');
                const amountMinInfo = document.getElementById('amount-min-info');
    
                if (select.value && amount && currencySelect.value) {
                    const userText = selectedOption.text.split(' - ')[0];
                    const currentBalance = parseFloat(selectedOption.getAttribute('data-balance'));
                    const depositAmount = parseFloat(amount);
                    const newBalance = currentBalance + depositAmount;
                    const selectedCurrencyCode = currencySelect.value;
                    const currencies = @json(config('currencies.currencies'));
    
                    const currencyName = currencies[selectedCurrencyCode] || '';
                    const currencySymbolMatch = currencyName.match(/\(([^)]+)\)/);
                    const currencySymbol = currencySymbolMatch ? currencySymbolMatch[1] : selectedCurrencyCode;
    
                    document.getElementById('preview-text').textContent =
                        `Dépôt de ${depositAmount.toFixed(2)} ${currencySymbol} sur le compte de ${userText}`;
                    
                    // Afficher le solde actuel avec devise
                    balanceDisplay.classList.remove('hidden');
                    currentBalanceSpan.textContent = currentBalance.toFixed(2);
                    currencySymbolSpan.textContent = currencySymbol;
                    
                    // Afficher le nouveau solde avec devise
                    newBalanceDiv.classList.remove('hidden');
                    newBalanceAmount.textContent = newBalance.toFixed(2);

                    // Update amount minimum info with the selected currency symbol
                    if (amountMinInfo) {
                        amountMinInfo.innerHTML = `<i class="fas fa-info-circle mr-1 text-blue-500"></i>Montant minimum: 0.01 ${currencySymbol}`;
                    }
                } else {
                    document.getElementById('preview-text').textContent =
                        'Sélectionnez un client, un montant et une devise pour voir l\'aperçu.';
                    balanceDisplay.classList.add('hidden');
                    newBalanceDiv.classList.add('hidden');
                    if (amountMinInfo) {
                        amountMinInfo.innerHTML = `<i class="fas fa-info-circle mr-1 text-blue-500"></i>Montant minimum: 0.01 €`;
                    }
                }
            }
    
            document.getElementById('user_id').addEventListener('change', updatePreview);
            document.getElementById('amount').addEventListener('input', updatePreview);
            document.getElementById('currency').addEventListener('change', updatePreview);
    
            // Initialiser l'aperçu si des valeurs existent déjà
            document.addEventListener('DOMContentLoaded', function() {
                if (document.getElementById('user_id').value || document.getElementById('amount').value) {
                    updatePreview();
                }
            });
    </script>
    @include('components.admin-chat-widget')
</body>
</html>

