<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BankPro</title>
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

        /* Style pour le tableau */
        .table-row-hover {
            transition: all 0.2s ease;
        }

        .table-row-hover:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: scale(1.01);
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
                                    <i class="fas fa-building-columns text-white text-xl"></i>
                                </div>
                                <div>
                                    <a href="{{ route('home') }}" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">BankPro</a>
                                    <div class="text-xs text-gray-500 -mt-1">Tableau de bord client</div>
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
                            <form method="POST" action="{{ route('logout') }}">
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
                            <form method="POST" action="{{ route('logout') }}" class="inline">
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
                    <h1 class="text-3xl font-bold text-white drop-shadow-lg text-center">Bonjour, {{ $user->first_name }} 👋</h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center">Voici votre tableau de bord personnel et officiel</p>
                </div>

                <!-- Cartes de statistiques améliorées -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Solde actuel -->
                    <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card stagger-item">
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 mb-1">Solde actuel</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($user->balance, 2) }} €</p>
                                    <div class="flex items-center mt-2 text-xs text-green-600">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        <span>Solde disponible</span>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-4 rounded-2xl shadow-lg">
                                    <i class="fas fa-euro-sign text-white text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Virements -->
                    <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card stagger-item">
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 mb-1">Virements</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $user->transactions()->where('type', 'transfer')->count() }}</p>
                                    <div class="flex items-center mt-2 text-xs text-blue-600">
                                        <i class="fas fa-exchange-alt mr-1"></i>
                                        <span>Transactions</span>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-4 rounded-2xl shadow-lg">
                                    <i class="fas fa-paper-plane text-white text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dépôts -->
                    <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card stagger-item">
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 mb-1">Dépôts</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $user->transactions()->where('type', 'deposit')->count() }}</p>
                                    <div class="flex items-center mt-2 text-xs text-purple-600">
                                        <i class="fas fa-arrow-down mr-1"></i>
                                        <span>Entrées</span>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-4 rounded-2xl shadow-lg">
                                    <i class="fas fa-plus-circle text-white text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Retraits -->
                    <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card stagger-item">
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 mb-1">Retraits</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $user->transactions()->where('type', 'withdrawal')->count() }}</p>
                                    <div class="flex items-center mt-2 text-xs text-red-600">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        <span>Sorties</span>
                                    </div>
                                </div>
                                <div class="bg-gradient-to-r from-red-500 to-orange-500 p-4 rounded-2xl shadow-lg">
                                    <i class="fas fa-minus-circle text-white text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides améliorées -->
                <div class="glass-card rounded-2xl overflow-hidden card-hover mb-8 fade-in-up">
                    <div class="px-8 py-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                <i class="fas fa-bolt text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Actions rapides</h3>
                                <p class="text-gray-600 mt-1">Accédez rapidement aux fonctionnalités principales</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('transfer.create') }}" 
                               class="action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-xl hover:from-blue-600 hover:to-indigo-700 text-center transition duration-300 transform hover:scale-105 shadow-lg">
                                <div class="bg-white/20 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-paper-plane text-2xl"></i>
                                </div>
                                <div class="font-bold text-lg">Nouveau virement</div>
                                <p class="text-sm opacity-90 mt-2">Effectuer un transfert</p>
                            </a>
                            
                            <a href="{{ route('transactions.history') }}" 
                               class="action-btn bg-gradient-to-r from-gray-600 to-gray-700 text-white p-6 rounded-xl hover:from-gray-700 hover:to-gray-800 text-center transition duration-300 transform hover:scale-105 shadow-lg">
                                <div class="bg-white/20 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-history text-2xl"></i>
                                </div>
                                <div class="font-bold text-lg">Historique</div>
                                <p class="text-sm opacity-90 mt-2">Voir mes transactions</p>
                            </a>
                            
                            @if($user->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="action-btn bg-gradient-to-r from-red-500 to-pink-600 text-white p-6 rounded-xl hover:from-red-600 hover:to-pink-700 text-center transition duration-300 transform hover:scale-105 shadow-lg">
                                    <div class="bg-white/20 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-cog text-2xl"></i>
                                    </div>
                                    <div class="font-bold text-lg">Administration</div>
                                    <p class="text-sm opacity-90 mt-2">Panel administrateur</p>
                                </a>
                            @else
                                <a href="{{ route('profile') }}"
                                   class="action-btn bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6 rounded-xl hover:from-green-600 hover:to-emerald-700 text-center transition duration-300 transform hover:scale-105 shadow-lg">
                                    <div class="bg-white/20 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-user text-2xl"></i>
                                    </div>
                                    <div class="font-bold text-lg">Mon profil</div>
                                    <p class="text-sm opacity-90 mt-2">Gérer mon compte</p>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Transactions récentes améliorées -->
                <div class="glass-card rounded-2xl overflow-hidden card-hover fade-in-up">
                    <div class="px-8 py-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                    <i class="fas fa-exchange-alt text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Transactions récentes</h3>
                                    <p class="text-gray-600 mt-1">Vos dernières opérations</p>
                                </div>
                            </div>
                            <a href="{{ route('transactions.history') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
                                <span>Voir tout</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                        <div class="overflow-hidden rounded-xl">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-receipt text-blue-500"></i>
                                                    Type
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-euro-sign text-green-500"></i>
                                                    Montant
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-circle text-yellow-500"></i>
                                                    Statut
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-calendar text-purple-500"></i>
                                                    Date
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($transactions as $transaction)
                                            <tr class="table-row-hover">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3
                                                            @if($transaction->type == 'deposit') bg-green-100 text-green-600
                                                            @elseif($transaction->type == 'withdrawal') bg-red-100 text-red-600
                                                            @else bg-blue-100 text-blue-600 @endif">
                                                            <i class="fas fa-@if($transaction->type == 'deposit') arrow-down @elseif($transaction->type == 'withdrawal') arrow-up @else paper-plane @endif text-sm"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-semibold text-gray-900 capitalize">
                                                                {{ $transaction->type }}
                                                            </div>
                                                            @if($transaction->description)
                                                                <div class="text-xs text-gray-500">{{ $transaction->description }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold @if($transaction->type == 'deposit') text-green-600 @elseif($transaction->type == 'withdrawal') text-red-600 @else text-gray-900 @endif">
                                                        {{ $transaction->type == 'withdrawal' ? '-' : '' }}{{ number_format($transaction->amount, 2) }} €
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="badge 
                                                        @if($transaction->status == 'success') 
                                                            bg-gradient-to-r from-green-100 to-green-200 text-green-800
                                                        @elseif($transaction->status == 'on_hold')
                                                            bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800
                                                        @else 
                                                            bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 
                                                        @endif">
                                                        <i class="fas fa-@if($transaction->status == 'success') check-circle @elseif($transaction->status == 'on_hold') clock @else ban @endif"></i>
                                                        {{ ucfirst($transaction->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 font-medium">
                                                        {{ $transaction->created_at->format('d/m/Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $transaction->created_at->format('H:i') }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-12 text-center">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <div class="bg-gray-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                                                            <i class="fas fa-exchange-alt text-gray-400 text-2xl"></i>
                                                        </div>
                                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune transaction</h3>
                                                        <p class="text-gray-600">Vous n'avez effectué aucune transaction pour le moment.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($transactions->count() > 0)
                            <div class="mt-6 text-center">
                                <a href="{{ route('transactions.history') }}" 
                                   class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                                    <span>Voir toutes les transactions</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endif
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

        // Chart.js implementation for transaction statistics
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.createElement('canvas');
            ctx.id = 'transactionChart';
            document.querySelector('.glass-card').appendChild(ctx);
            
            const transactionChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Dépôts', 'Retraits', 'Virements'],
                    datasets: [{
                        data: [
                            {{ $user->transactions()->where('type', 'deposit')->count() }},
                            {{ $user->transactions()->where('type', 'withdrawal')->count() }},
                            {{ $user->transactions()->where('type', 'transfer')->count() }}
                        ],
                        backgroundColor: [
                            '#10b981',
                            '#ef4444',
                            '#3b82f6'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>