<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - SG BANK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Animation de pulsation pour les indicateurs */
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
            }
            50% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.8);
            }
        }

        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }

        /* Style pour l'arrière-plan */
        .background-container {
            background-image: url('https://images.unsplash.com/photo-1601597111158-2fceff292cdc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
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

        /* Style pour les badges */
        .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Style pour les avatars */
        .avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            color: white;
        }

        /* Style pour les cartes de statistiques */
        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 8rem;
            height: 8rem;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translate(30%, -30%) rotate(45deg);
        }

        /* Style pour les informations de profil */
        .profile-info {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .profile-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
    </style>

    @php
        $currencyCode = $user->default_currency ?? 'EUR';
        $currencies = config('currencies.currencies');
        $currencySymbol = '€';
        if (isset($currencies[$currencyCode])) {
            preg_match('/\((.*?)\)/', $currencies[$currencyCode], $matches);
            if (isset($matches[1])) {
                $currencySymbol = $matches[1];
            }
        }
    @endphp
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
                                    <i class="fas fa-building-columns text-white text-xl"></i>
                                </div>
                                <div>
                                    <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">SG BANK</a>
                                    <div class="text-xs text-gray-500 -mt-1">Mon Profil</div>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-6">
                            <div class="flex items-center space-x-3 bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-2 rounded-xl">
                                <div class="avatar bg-gradient-to-r from-blue-500 to-purple-500">
                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="text-xs text-gray-600">Compte N° {{ $user->id }}</div>
                                </div>
                            </div>
                            <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Retour au tableau de bord
                            </a>
                            <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}">
                                @csrf
                                <button type="submit" class="relative text-gray-700 hover:text-red-600 transition duration-300 font-medium group flex items-center gap-2">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Déconnexion
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                                </button>
                            </form>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden flex items-center">
                            <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none transition duration-300 p-2 rounded-lg hover:bg-blue-50">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile menu -->
                    <div id="mobile-menu" class="hidden pb-4">
                        <div class="px-2 pt-2 pb-3 space-y-2 bg-white/95 backdrop-blur-lg border border-gray-200 rounded-lg shadow-xl mt-2">
                            <div class="flex items-center space-x-3 px-3 py-2">
                                <div class="avatar bg-gradient-to-r from-blue-500 to-purple-500">
                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="text-xs text-gray-600">Compte N° {{ $user->id }}</div>
                                </div>
                            </div>
                            <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="flex items-center w-full px-3 py-2 text-base font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-arrow-left w-5 mr-3 text-center"></i>
                                Retour au tableau de bord
                            </a>
                            <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition duration-300">
                                    <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- En-tête de bienvenue -->
                <div class="mb-8 fade-in-up">
                    <h1 class="text-3xl font-bold text-white drop-shadow-lg text-center">Mon Profil</h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center">Gérez vos informations personnelles et bancaires</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Informations personnelles -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Informations de base -->
                        <div class="glass-card rounded-2xl overflow-hidden card-hover fade-in-up">
                            <div class="px-8 py-8">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                        <i class="fas fa-user text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Informations personnelles</h3>
                                        <p class="text-gray-600 mt-1">Vos données d'identification</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-user-circle text-blue-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Nom complet</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                                    </div>

                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-envelope text-green-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Adresse email</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->email }}</p>
                                    </div>

                                    @if($user->phone)
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-phone text-purple-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Téléphone</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->phone }}</p>
                                    </div>
                                    @endif

                                    @if($user->date_of_birth)
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-calendar text-orange-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Date de naissance</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->date_of_birth ? $user->date_of_birth->format('d/m/Y') : 'Non spécifiée' }}</p>
                                    </div>
                                    @endif

                                    @if($user->address)
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-home text-red-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Adresse complète</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->address }}</p>
                                    </div>
                                    @endif

                                    @if($user->city)
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-city text-pink-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Ville</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->city }}</p>
                                    </div>
                                    @endif

                                    @if($user->country)
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-globe text-teal-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Pays</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->country }}</p>
                                    </div>
                                    @endif

                                    @if($user->id_type)
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-id-badge text-indigo-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Type de pièce d'identité</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->id_type }}</p>
                                    </div>
                                    @endif

                                    @if($user->id_number)
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-hashtag text-indigo-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Numéro de pièce</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $user->id_number }}</p>
                                    </div>
                                    @endif

                                    @if($user->default_currency)
                                    <div class="profile-info">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-money-bill-wave text-emerald-500 mr-3"></i>
                                            <span class="text-sm font-semibold text-gray-600">Devise par défaut</span>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ $user->default_currency }}
                                            @php
                                                $currencies = config('currencies.currencies');
                                                if (isset($currencies[$user->default_currency])) {
                                                    echo ' - ' . $currencies[$user->default_currency];
                                                }
                                            @endphp
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Historique des transactions récentes -->
                        <div class="glass-card rounded-2xl overflow-hidden card-hover fade-in-up">
                            <div class="px-8 py-8">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center">
                                        <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                            <i class="fas fa-history text-white text-2xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">Activité récente</h3>
                                            <p class="text-gray-600 mt-1">Vos dernières transactions</p>
                                        </div>
                                    </div>
                                    <a href="{{ localized_route('transactions.history', ['locale' => app()->getLocale()]) }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
                                        <span>Voir tout</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>

                                <div class="space-y-4">
                                    @forelse($user->transactions()->latest()->take(3)->get() as $transaction)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition duration-200">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4
                                                    @if($transaction->type == 'deposit') bg-green-100 text-green-600
                                                    @elseif($transaction->type == 'withdrawal') bg-red-100 text-red-600
                                                    @else bg-blue-100 text-blue-600 @endif">
                                                    <i class="fas fa-@if($transaction->type == 'deposit') arrow-down @elseif($transaction->type == 'withdrawal') arrow-up @else paper-plane @endif text-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900 capitalize">{{ $transaction->type }}</div>
                                                    <div class="text-xs text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-bold @if($transaction->type == 'deposit') text-green-600 @elseif($transaction->type == 'withdrawal') text-red-600 @else text-gray-900 @endif">
                                                    {{ $transaction->type == 'withdrawal' ? '-' : '' }}{{ number_format($transaction->amount, 2) }} {{ $currencySymbol }}
                                                </div>
                                                <span class="badge text-xs
                                                    @if($transaction->status == 'success') bg-green-100 text-green-800
                                                    @elseif($transaction->status == 'on_hold') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <div class="bg-gray-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-exchange-alt text-gray-400 text-2xl"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune transaction</h3>
                                            <p class="text-gray-600">Vous n'avez effectué aucune transaction pour le moment.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Informations bancaires -->
                        <div class="space-y-6">

                            <!-- Solde et compte -->
                            <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card stagger-item">
                                <div class="p-6 relative z-10">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-600 mb-1">Solde actuel</p>
                                            @php
                                                $currencyCode = $user->default_currency ?? 'EUR';
                                                $currencies = config('currencies.currencies');
                                                $currencySymbol = '€';
                                                if (isset($currencies[$currencyCode])) {
                                                    preg_match('/\((.*?)\)/', $currencies[$currencyCode], $matches);
                                                    if (isset($matches[1])) {
                                                        $currencySymbol = $matches[1];
                                                    }
                                                }
                                            @endphp
                                            <p class="text-2xl font-bold text-gray-900">{{ number_format($user->balance, 2) }} {{ $currencySymbol }}</p>
                                        </div>
                                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-4 rounded-2xl shadow-lg">
                                            <i class="fas fa-euro-sign text-white text-2xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-xs text-green-600">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        <span>Solde disponible</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations du compte -->
                            <div class="glass-card rounded-2xl overflow-hidden card-hover stagger-item">
                                <div class="p-6">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-3 rounded-2xl mr-4 shadow-lg">
                                            <i class="fas fa-credit-card text-white text-2xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">Informations bancaires</h3>
                                            <p class="text-gray-600 text-sm mt-1">Détails de votre compte</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Numéro de compte</span>
                                            <span class="text-sm font-bold text-gray-900">{{ $user->id }}</span>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Statut du compte</span>
                                            <span class="badge bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle"></i>
                                                Actif
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Type de compte</span>
                                            <span class="text-sm font-bold text-gray-900">
                                                @if($user->isAdmin())
                                                    Administrateur
                                                @else
                                                    Client
                                                @endif
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Date d'inscription</span>
                                            <span class="text-sm font-bold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Informations bancaires détaillées -->
                            <div class="glass-card rounded-2xl overflow-hidden card-hover stagger-item mt-6">
                                <div class="p-6">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-r from-cyan-500 to-blue-500 p-3 rounded-2xl mr-4 shadow-lg">
                                            <i class="fas fa-university text-white text-2xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">Coordonnées bancaires</h3>
                                            <p class="text-gray-600 text-sm mt-1">Vos informations bancaires</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        @if($user->iban)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">IBAN</span>
                                            <span class="text-sm font-bold text-gray-900">{{ $user->iban }}</span>
                                        </div>
                                        @endif

                                        @if($user->bic)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">BIC</span>
                                            <span class="text-sm font-bold text-gray-900">{{ $user->bic }}</span>
                                        </div>
                                        @endif

                                        @if(!$user->iban && !$user->bic)
                                        <p class="text-gray-600 italic text-sm">Aucune coordonnée bancaire renseignée.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Nouvelle section Carte de crédit -->
                            <div class="glass-card rounded-2xl overflow-hidden card-hover stagger-item mt-6">
                                <div class="p-6">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-3 rounded-2xl mr-4 shadow-lg">
                                            <i class="fas fa-credit-card text-white text-2xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">Carte de crédit</h3>
                                            <p class="text-gray-600 text-sm mt-1">Informations sur votre carte de crédit</p>
                                        </div>
                                    </div>

                                    @if($user->creditCard)
                                    <div class="space-y-4 text-gray-900">
                                        <div class="flex justify-between">
                                            <span class="font-semibold text-sm text-gray-600">Nom du titulaire</span>
                                            <span class="text-sm font-bold">{{ $user->creditCard->card_holder_name }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-semibold text-sm text-gray-600">Numéro de carte</span>
                                            <span class="text-sm font-bold">{{ $user->creditCard->masked_card_number }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-semibold text-sm text-gray-600">Type de carte</span>
                                            <span class="text-sm font-bold">{{ $user->creditCard->card_type ?? 'Non spécifié' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-semibold text-sm text-gray-600">Date d'expiration</span>
                                            <span class="text-sm font-bold">{{ $user->creditCard->expiry_date->format('m/Y') }}</span>
                                        </div>
                                    </div>
                                    @else
                                    <p class="text-gray-600 italic text-sm">Pas de carte de crédit associée.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Section Sécurité -->
                            <div class="glass-card rounded-2xl overflow-hidden card-hover stagger-item mt-6">
                                <div class="p-6">
                                    <div class="flex items-center mb-6">
                                        <div class="bg-gradient-to-r from-red-500 to-pink-500 p-3 rounded-2xl mr-4 shadow-lg">
                                            <i class="fas fa-shield-alt text-white text-2xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">Sécurité</h3>
                                            <p class="text-gray-600 text-sm mt-1">Paramètres de sécurité</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        @if($user->activation_code)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Code d'activation</span>
                                            <span class="text-sm font-bold text-gray-900">
                                                <span class="bg-gray-100 px-3 py-1 rounded-lg">
                                                    <i class="fas fa-lock mr-1"></i>
                                                    {{ str_repeat('•', 8) }}
                                                </span>
                                            </span>
                                        </div>
                                        @endif

                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Statut du compte</span>
                                            <span class="badge 
                                                @if($user->status == 'active') bg-green-100 text-green-800
                                                @elseif($user->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($user->status == 'suspended') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                <i class="fas fa-circle text-xs"></i>
                                                {{ ucfirst($user->status ?? 'active') }}
                                            </span>
                                        </div>

                                        @if(!$user->activation_code)
                                        <p class="text-gray-600 italic text-sm">Aucun code d'activation défini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        <!-- Actions rapides -->
                        <div class="glass-card rounded-2xl overflow-hidden card-hover stagger-item">
                            <div class="p-6">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                        <i class="fas fa-bolt text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Actions rapides</h3>
                                        <p class="text-gray-600 text-sm mt-1">Opérations courantes</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <a href="{{ localized_route('transfer.create', ['locale' => app()->getLocale()]) }}" class="action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4 rounded-xl hover:from-blue-600 hover:to-indigo-700 text-center transition duration-300 transform hover:scale-105 shadow-lg block">
                                        <div class="bg-white/20 p-2 rounded-full w-10 h-10 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-paper-plane text-lg"></i>
                                        </div>
                                        <div class="font-bold text-sm">Nouveau virement</div>
                                    </a>

                                    <a href="{{ localized_route('transactions.history', ['locale' => app()->getLocale()]) }}" class="action-btn bg-gradient-to-r from-gray-600 to-gray-700 text-white p-4 rounded-xl hover:from-gray-700 hover:to-gray-800 text-center transition duration-300 transform hover:scale-105 shadow-lg block">
                                        <div class="bg-white/20 p-2 rounded-full w-10 h-10 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-history text-lg"></i>
                                        </div>
                                        <div class="font-bold text-sm">Historique</div>
                                    </a>
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
    </script>
    {{-- Include Chat Widget --}}
    @include('components.chat-widget-with-files')
</body>
</html>


