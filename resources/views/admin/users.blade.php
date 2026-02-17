<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs - Valtrix Bank Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io11/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io11/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io11/favicon-16x16.png">
  <link rel="manifest" href="/favicon_io11/site.webmanifest">
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

        /* Style pour le tableau */
        .table-row-hover {
            transition: all 0.2s ease;
        }

        .table-row-hover:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: scale(1.01);
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

        /* Style pour la pagination */
        .pagination-btn {
            transition: all 0.3s ease;
        }

        .pagination-btn:hover {
            transform: translateY(-1px);
        }

        @include('components.admin-dashboard-background-styles')
    </style>
</head>
<body class="min-h-screen">
    @include('components.admin-dashboard-background')
    <div class="min-h-screen relative z-10">
        <!-- Navigation améliorée -->
        <nav class="glass-nav sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-2 rounded-lg">
                                    <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}"><img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
                                </div>
                                <div>
                                    <a href="{{ localized_route('admin.dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"><span class="sr-only">Valtrix Bank Admin</span></a>
                                    <div class="text-xs text-gray-500 -mt-1">Gestion des utilisateurs</div>
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
                            <a href="{{ localized_route('admin.users') }}" class="relative text-blue-600 font-semibold transition duration-300 group">
                                <i class="fas fa-users mr-2"></i> Utilisateurs
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600"></span>
                            </a>
                            <a href="{{ localized_route('admin.deposit') }}" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-plus-circle mr-2"></i> Dépôt
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
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
                            <a href="{{ localized_route('admin.users') }}" class="flex items-center px-3 py-3 text-base font-medium text-blue-600 bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-users w-5 mr-3 text-center"></i> Utilisateurs
                            </a>
                            <a href="{{ localized_route('admin.deposit') }}" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
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

            <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <!-- En-tête de la page -->
                <div class="mb-8 fade-in-up">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white drop-shadow-lg text-center">Gestion des utilisateurs</h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center">Gérez les comptes clients et administrateurs</p>
                </div>

                <!-- Flash Messages améliorées -->
                @if(session('status'))
                    <div class="mb-6 glass-card border-l-4 border-l-green-500 rounded-2xl fade-in-up">
                        <div class="px-4 sm:px-6 py-3 sm:py-4">
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
                        <div class="px-4 sm:px-6 py-3 sm:py-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-red-100 p-2 rounded-full">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-semibold text-gray-800 mb-1">Action impossible</p>
                                    <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('login_link'))
                    <div class="mb-6 glass-card border-l-4 border-l-blue-500 rounded-2xl fade-in-up">
                        <div class="px-4 sm:px-6 py-3 sm:py-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Lien de connexion généré</p>
                                    <p class="text-xs text-gray-600">
                                        Client: {{ session('login_link_user') }}
                                        @if(session('login_link_expires_at'))
                                            · Valide jusqu'au {{ session('login_link_expires_at') }}
                                        @endif
                                        · Durée: {{ config('auth.login_link_ttl_days', 90) }} jours
                                    </p>
                                </div>
                                <a href="{{ session('login_link') }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center justify-center bg-blue-50 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-100 transition text-sm font-medium shadow-sm">
                                    <i class="fas fa-arrow-up-right-from-square mr-2"></i>
                                    Ouvrir
                                </a>
                            </div>
                            <div class="mt-3 flex flex-col sm:flex-row gap-2">
                                <input id="login-link-input" type="text" readonly
                                       value="{{ session('login_link') }}"
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm">
                                <button type="button" data-copy-target="login-link-input"
                                        class="inline-flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition text-sm font-semibold shadow-sm">
                                    <i class="fas fa-copy mr-2"></i>
                                    Copier
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Carte principale -->
                <div class="glass-card rounded-2xl overflow-hidden card-hover">
                    <div class="px-4 sm:px-8 py-6 sm:py-8">
                        <!-- En-tête avec statistiques -->
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-3 rounded-2xl mr-4 shadow-lg">
                                        <i class="fas fa-users text-white text-2xl"></i>
                                    </div>
                                    Liste des utilisateurs
                                </h1>
                                <p class="text-gray-600 mt-2">Gérez tous les comptes du système</p>
                            </div>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 rounded-xl border border-blue-200">
                                    <div class="text-sm text-blue-600 font-medium">Total utilisateurs</div>
                                    <div class="text-2xl font-bold text-blue-700">{{ $users->total() }}</div>
                                </div>
                                <a href="{{ localized_route('admin.users.create') }}" 
                                   class="action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-indigo-700 font-semibold shadow-lg transform hover:scale-105 transition duration-300 flex items-center gap-2 w-full sm:w-auto">
                                    <i class="fas fa-plus"></i>
                                    Ajouter un utilisateur
                                </a>
                            </div>
                        </div>

                        <!-- Recherche et Filtres -->
                        <div class="mb-8 stagger-item">
                            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="sm:col-span-2">
                                    <label for="search" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <i class="fas fa-search mr-2 text-blue-500"></i>
                                        Rechercher
                                    </label>
                                    <div class="relative">
                                        <input type="text"
                                               name="search"
                                               id="search"
                                               value="{{ request('search') }}"
                                               placeholder="Nom, email, téléphone..."
                                               class="block w-full px-4 py-3 pl-10 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-field">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="role" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <i class="fas fa-user-tag mr-2 text-purple-500"></i>
                                        Rôle
                                    </label>
                                    <select name="role" id="role" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 input-field">
                                        <option value="">Tous les rôles</option>
                                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Client</option>
                                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <i class="fas fa-circle mr-2 text-green-500"></i>
                                        Statut
                                    </label>
                                    <select name="status" id="status" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 input-field">
                                        <option value="">Tous les statuts</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                                    </select>
                                </div>

                                <div class="flex items-end sm:col-span-2 lg:col-span-1">
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-xl hover:from-gray-700 hover:to-gray-800 font-medium shadow-lg transition duration-300 flex items-center justify-center gap-2">
                                        <i class="fas fa-filter"></i>
                                        Appliquer les filtres
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau des utilisateurs -->
                        <div class="overflow-hidden rounded-xl stagger-item">
                            <div class="overflow-x-auto">
                                <table class="min-w-[900px] w-full divide-y divide-gray-200 text-sm sm:text-base">
                                    <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                        <tr>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex flex-wrap gap-2">
                                                    <i class="fas fa-user text-blue-500"></i>
                                                    Utilisateur
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex flex-wrap gap-2">
                                                    <i class="fas fa-envelope text-purple-500"></i>
                                                    Contact
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex flex-wrap gap-2">
                                                    <i class="fas fa-shield-alt text-green-500"></i>
                                                    Rôle
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex flex-wrap gap-2">
                                                    <i class="fas fa-wallet text-yellow-500"></i>
                                                    Solde
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex flex-wrap gap-2">
                                                    <i class="fas fa-circle text-red-500"></i>
                                                    Statut
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex flex-wrap gap-2">
                                                    <i class="fas fa-calendar text-indigo-500"></i>
                                                    Inscription
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex flex-wrap gap-2">
                                                    <i class="fas fa-cog text-gray-500"></i>
                                                    Actions
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($users as $user)
                                            <tr class="table-row-hover">
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="avatar bg-gradient-to-r from-blue-500 to-purple-500 shadow-lg overflow-hidden">
                                                            @if($user->profile_photo_url)
                                                                <img src="{{ $user->profile_photo_url }}" alt="Photo de {{ $user->first_name }}" class="h-full w-full object-cover">
                                                            @else
                                                                {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-semibold text-gray-900">
                                                                {{ $user->first_name }} {{ $user->last_name }}
                                                            </div>
                                                            <div class="text-xs text-gray-500 font-medium">
                                                                ID: {{ $user->id }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->email }}</div>
                                                    <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                                        <i class="fas fa-phone text-gray-400"></i>
                                                        {{ $user->phone ?? 'Non renseigné' }}
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="badge 
                                                        @if($user->role == 'admin') 
                                                            bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800
                                                        @else 
                                                            bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 
                                                        @endif">
                                                        <i class="fas fa-{{ $user->role == 'admin' ? 'crown' : 'user' }}"></i>
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-gray-900">
                                                        {{ number_format($user->balance, 2) }} €
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    @if($user->status === 'pending')
                                                        <span class="badge bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800">
                                                            <i class="fas fa-hourglass-half"></i>
                                                            En attente de validation
                                                        </span>
                                                    @elseif($user->status == 'active') 
                                                        <span class="badge bg-gradient-to-r from-green-100 to-green-200 text-green-800">
                                                            <i class="fas fa-check-circle"></i>
                                                            {{ ucfirst($user->status) }}
                                                        </span>
                                                    @else 
                                                        <span class="badge bg-gradient-to-r from-red-100 to-red-200 text-red-800">
                                                            <i class="fas fa-ban"></i>
                                                            {{ ucfirst($user->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 font-medium">
                                                        {{ $user->created_at->format('d/m/Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $user->created_at->format('H:i') }}
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="flex flex-wrap gap-2">
                                                        <a href="{{ localized_route('admin.users.edit', $user) }}"
                                                           class="bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:from-blue-100 hover:to-blue-200 transition duration-300 flex items-center gap-2 text-sm font-medium shadow-sm"
                                                           title="Modifier l'utilisateur">
                                                            <i class="fas fa-edit"></i>
                                                            <span class="hidden sm:inline">Modifier</span>
                                                        </a>

                                                        @if($user->role === 'user' && $user->status === 'active')
                                                            <form method="POST" action="{{ localized_route('admin.users.login-link', $user) }}" class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="bg-gradient-to-r from-blue-50 to-indigo-100 text-blue-700 px-3 py-2 rounded-lg hover:from-blue-100 hover:to-indigo-200 transition duration-300 flex items-center gap-2 text-sm font-medium shadow-sm"
                                                                        title="Générer un lien de connexion">
                                                                    <i class="fas fa-link"></i>
                                                                    <span class="hidden sm:inline">Lien</span>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        
                                                        @if($user->status === 'pending' && $user->id !== auth()->id())
                                                            <form method="POST" action="{{ localized_route('admin.users.approve', $user) }}" class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="bg-gradient-to-r from-yellow-50 to-yellow-100 text-yellow-700 px-3 py-2 rounded-lg hover:from-yellow-100 hover:to-yellow-200 transition duration-300 flex items-center gap-2 text-sm font-medium shadow-sm"
                                                                        onclick="return confirm('Êtes-vous sûr de vouloir valider cet utilisateur ?')"
                                                                        title="Valider l'utilisateur">
                                                                    <i class="fas fa-check"></i>
                                                                    <span class="hidden sm:inline">Valider</span>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        
                                                        @if($user->id !== auth()->id() && $user->status !== 'pending')
                                                            <form method="POST" action="{{ localized_route('admin.users.toggle', $user) }}" class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="px-3 py-2 rounded-lg text-sm font-medium shadow-sm transition duration-300 flex items-center gap-2
                                                                        @if($user->status == 'active')
                                                                            bg-gradient-to-r from-red-50 to-red-100 text-red-700 hover:from-red-100 hover:to-red-200
                                                                        @else
                                                                            bg-gradient-to-r from-green-50 to-green-100 text-green-700 hover:from-green-100 hover:to-green-200
                                                                        @endif"
                                                                        onclick="return confirm('Êtes-vous sûr de vouloir {{ $user->status == 'active' ? 'suspendre' : 'activer' }} cet utilisateur ?')"
                                                                        title="{{ $user->status == 'active' ? 'Suspendre' : 'Activer' }} l'utilisateur">
                                                                    @if($user->status == 'active')
                                                                        <i class="fas fa-ban"></i>
                                                                        <span class="hidden sm:inline">Suspendre</span>
                                                                    @else
                                                                        <i class="fas fa-check"></i>
                                                                        <span class="hidden sm:inline">Activer</span>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if($user->status !== 'pending')
                                                            <form method="POST" action="{{ localized_route('admin.users.delete', $user) }}" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="bg-gradient-to-r from-red-50 to-red-100 text-red-700 px-3 py-2 rounded-lg hover:from-red-100 hover:to-red-200 transition duration-300 flex items-center gap-2 text-sm font-medium shadow-sm"
                                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')"
                                                                        title="Supprimer l'utilisateur">
                                                                    <i class="fas fa-trash"></i>
                                                                    <span class="hidden sm:inline">Supprimer</span>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if($user->id === auth()->id())
                                                            <span class="text-gray-400 text-sm font-medium px-3 py-2">
                                                                <i class="fas fa-user-circle mr-1"></i>
                                                                Vous-même
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-4 sm:px-6 py-10 sm:py-12 text-center">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <div class="bg-gray-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                                                            <i class="fas fa-users text-gray-400 text-2xl"></i>
                                                        </div>
                                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun utilisateur trouvé</h3>
                                                        <p class="text-gray-600 mb-4">Aucun utilisateur ne correspond à vos critères de recherche.</p>
                                                        <a href="{{ localized_route('admin.users') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                                            <i class="fas fa-redo mr-1"></i>Réinitialiser les filtres
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($users->hasPages())
                            <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="text-sm text-gray-700">
                                    Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} utilisateurs
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    {{ $users->links('vendor.pagination.tailwind') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
        </div>
    </div>

    <script>
        // Copy login link to clipboard
        document.querySelectorAll('[data-copy-target]').forEach((button) => {
            button.addEventListener('click', async () => {
                const targetId = button.getAttribute('data-copy-target');
                const input = document.getElementById(targetId);
                if (!input) {
                    return;
                }

                const originalHtml = button.innerHTML;

                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(input.value);
                    } else {
                        input.select();
                        input.setSelectionRange(0, input.value.length);
                        document.execCommand('copy');
                        window.getSelection().removeAllRanges();
                    }

                    button.innerHTML = '<i class="fas fa-check mr-2"></i>Copié';
                    setTimeout(() => {
                        button.innerHTML = originalHtml;
                    }, 2000);
                } catch (error) {
                    button.innerHTML = '<i class="fas fa-triangle-exclamation mr-2"></i>Erreur';
                    setTimeout(() => {
                        button.innerHTML = originalHtml;
                    }, 2000);
                }
            });
        });

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

        // Auto-submit form on filter change
        document.getElementById('role').addEventListener('change', function() {
            this.form.submit();
        });

        document.getElementById('status').addEventListener('change', function() {
            this.form.submit();
        });

        // Debounced search
        let searchTimeout;
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    </script>
    @include('components.admin-dashboard-background-script')
    @include('components.admin-chat-widget')
</body>
</html>






