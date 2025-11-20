<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur - BankPro Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        success: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                        },
                        warning: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        danger: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            500: '#ef4444',
                            600: '#dc2626',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
                }
            }
        }
    </script>
    <style>
        .section-card {
            transition: all 0.3s ease;
        }
        .section-card:hover {
            transform: translateY(-2px);
        }
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .nav-link {
            position: relative;
            transition: all 0.2s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .nav-link.active::after {
            width: 100%;
        }
        
        /* Background professionnel avec overlay */
        .professional-bg {
            background-image: linear-gradient(rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.98)), 
                            url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="%23f8fafc"/><path d="M0 50 L100 50 M50 0 L50 100" stroke="%23e2e8f0" stroke-width="0.5"/><circle cx="20" cy="20" r="2" fill="%23e2e8f0" opacity="0.5"/><circle cx="80" cy="80" r="2" fill="%23e2e8f0" opacity="0.5"/><circle cx="80" cy="20" r="2" fill="%23e2e8f0" opacity="0.5"/><circle cx="20" cy="80" r="2" fill="%23e2e8f0" opacity="0.5"/></svg>');
            background-size: 300px 300px;
            background-position: 0 0;
        }
        
        /* Alternative avec un motif géométrique plus élaboré */
        .geometric-pattern {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 40% 20%, rgba(59, 130, 246, 0.05) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(139, 92, 246, 0.05) 0px, transparent 50%),
                radial-gradient(at 0% 50%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 80% 50%, rgba(245, 158, 11, 0.05) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(59, 130, 246, 0.05) 0px, transparent 50%),
                radial-gradient(at 80% 100%, rgba(139, 92, 246, 0.05) 0px, transparent 50%),
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
        }
        
        /* Style avec des lignes diagonales subtiles */
        .diagonal-lines {
            background-color: #f8fafc;
            background-image: 
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 10px,
                    rgba(59, 130, 246, 0.02) 10px,
                    rgba(59, 130, 246, 0.02) 20px
                );
        }
        
        /* Style avec des points subtils */
        .dot-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="font-sans geometric-pattern">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation avec effet glass -->
        <nav class="glass-effect shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-xl font-bold text-gray-900">
                            <i class="fas fa-university text-primary-500 mr-2"></i>
                            BankPro <span class="text-primary-500 ml-1">Admin</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-gray-600 hover:text-gray-900">Dashboard</a>
                        <a href="{{ route('admin.settings') }}" class="nav-link text-gray-600 hover:text-gray-900">Paramètres</a>
                        <a href="{{ route('admin.users') }}" class="nav-link text-gray-600 hover:text-gray-900 active">Utilisateurs</a>
                        <a href="{{ route('admin.deposit') }}" class="nav-link text-gray-600 hover:text-gray-900">Dépôt</a>
                        <a href="{{ route('dashboard') }}" class="nav-link text-gray-600 hover:text-gray-900">Retour au site</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                                <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                            </button>
                        </form>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" id="mobile-menu-button" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 glass-effect border-t border-gray-200 rounded-b-lg">
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">Dashboard</a>
                        <a href="{{ route('admin.settings') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">Paramètres</a>
                        <a href="{{ route('admin.users') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">Utilisateurs</a>
                        <a href="{{ route('admin.deposit') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">Dépôt</a>
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">Retour au site</a>
                        <form method="POST" action="{{ route('logout') }}" class="block px-3 py-2">
                            @csrf
                            <button type="submit" class="text-base font-medium text-gray-600 hover:text-gray-900 w-full text-left transition-colors">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8 flex-grow">
            <!-- Flash Messages -->
            @if(session('status'))
                <div class="mb-6 bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg shadow-soft glass-effect">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-success-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-danger-50 border border-danger-200 text-danger-700 px-4 py-3 rounded-lg shadow-soft glass-effect">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-danger-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium">Des erreurs sont présentes dans le formulaire</h3>
                            <ul class="mt-1 text-sm list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="glass-effect p-3 rounded-xl shadow-soft mr-4">
                            <i class="fas fa-user-edit text-2xl text-primary-500"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Modifier l'utilisateur</h1>
                            <div class="flex items-center mt-1">
                                <span class="text-sm text-gray-500">ID: {{ $user->id }}</span>
                                <span class="mx-2 text-gray-300">•</span>
                                <span class="status-badge {{ $user->status == 'active' ? 'bg-success-100 text-success-800' : 'bg-danger-100 text-danger-800' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users') }}" class="flex items-center glass-effect text-gray-700 px-4 py-2 rounded-lg hover:bg-white/70 shadow-sm transition-all border border-gray-200/50">
                            <i class="fas fa-arrow-left mr-2"></i> Retour
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Informations personnelles -->
                        <div class="glass-effect rounded-xl shadow-soft section-card overflow-hidden">
                            <div class="bg-gradient-to-r from-primary-50/80 to-blue-50/80 px-6 py-4 border-b border-primary-100/50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-user-circle text-primary-500 mr-2"></i>
                                    Informations personnelles
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Prénom <span class="text-danger-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="first_name"
                                               id="first_name"
                                               value="{{ old('first_name', $user->first_name) }}"
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80"
                                               required>
                                    </div>

                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Nom <span class="text-danger-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="last_name"
                                               id="last_name"
                                               value="{{ old('last_name', $user->last_name) }}"
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80"
                                               required>
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email <span class="text-danger-500">*</span>
                                        </label>
                                        <input type="email"
                                               name="email"
                                               id="email"
                                               value="{{ old('email', $user->email) }}"
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80"
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
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80">
                                    </div>

                                    <div>
                                        <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">
                                            Date de naissance
                                        </label>
                                        <input type="date"
                                               name="date_naissance"
                                               id="date_naissance"
                                               value="{{ old('date_naissance', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}"
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80">
                                    </div>

                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                            Rôle <span class="text-danger-500">*</span>
                                        </label>
                                        <select name="role"
                                                id="role"
                                                class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80"
                                                required>
                                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Client</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="glass-effect rounded-xl shadow-soft section-card overflow-hidden">
                            <div class="bg-gradient-to-r from-primary-50/80 to-blue-50/80 px-6 py-4 border-b border-primary-100/50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-map-marker-alt text-primary-500 mr-2"></i>
                                    Adresse
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">
                                            Adresse
                                        </label>
                                        <input type="text"
                                               name="adresse"
                                               id="adresse"
                                               value="{{ old('adresse', $user->address) }}"
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80">
                                    </div>

                                    <div>
                                        <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">
                                            Ville
                                        </label>
                                        <input type="text"
                                               name="ville"
                                               id="ville"
                                               value="{{ old('ville', $user->city) }}"
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80">
                                    </div>

                                    <div>
                                        <label for="pays" class="block text-sm font-medium text-gray-700 mb-1">
                                            Pays
                                        </label>
                                        <select name="pays"
                                                id="pays"
                                                class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80">
                                            <option value="">Sélectionner un pays</option>
                                            <option value="Allemagne" {{ old('pays', $user->country) == 'Allemagne' ? 'selected' : '' }}>(DE) Allemagne</option>
                                            <option value="Autriche" {{ old('pays', $user->country) == 'Autriche' ? 'selected' : '' }}>(AT) Autriche</option>
                                            <option value="Belgique" {{ old('pays', $user->country) == 'Belgique' ? 'selected' : '' }}>(BE) Belgique</option>
                                            <option value="Bulgarie" {{ old('pays', $user->country) == 'Bulgarie' ? 'selected' : '' }}>(BG) Bulgarie</option>
                                            <option value="Chypre" {{ old('pays', $user->country) == 'Chypre' ? 'selected' : '' }}>(CY) Chypre</option>
                                            <option value="Croatie" {{ old('pays', $user->country) == 'Croatie' ? 'selected' : '' }}>(HR) Croatie</option>
                                            <option value="Danemark" {{ old('pays', $user->country) == 'Danemark' ? 'selected' : '' }}>(DK) Danemark</option>
                                            <option value="Espagne" {{ old('pays', $user->country) == 'Espagne' ? 'selected' : '' }}>(ES) Espagne</option>
                                            <option value="Estonie" {{ old('pays', $user->country) == 'Estonie' ? 'selected' : '' }}>(EE) Estonie</option>
                                            <option value="Finlande" {{ old('pays', $user->country) == 'Finlande' ? 'selected' : '' }}>(FI) Finlande</option>
                                            <option value="France" {{ old('pays', $user->country) == 'France' ? 'selected' : '' }}>(FR) France</option>
                                            <option value="Grèce" {{ old('pays', $user->country) == 'Grèce' ? 'selected' : '' }}>(GR) Grèce</option>
                                            <option value="Hongrie" {{ old('pays', $user->country) == 'Hongrie' ? 'selected' : '' }}>(HU) Hongrie</option>
                                            <option value="Irlande" {{ old('pays', $user->country) == 'Irlande' ? 'selected' : '' }}>(IE) Irlande</option>
                                            <option value="Italie" {{ old('pays', $user->country) == 'Italie' ? 'selected' : '' }}>(IT) Italie</option>
                                            <option value="Lettonie" {{ old('pays', $user->country) == 'Lettonie' ? 'selected' : '' }}>(LV) Lettonie</option>
                                            <option value="Lituanie" {{ old('pays', $user->country) == 'Lituanie' ? 'selected' : '' }}>(LT) Lituanie</option>
                                            <option value="Luxembourg" {{ old('pays', $user->country) == 'Luxembourg' ? 'selected' : '' }}>(LU) Luxembourg</option>
                                            <option value="Malte" {{ old('pays', $user->country) == 'Malte' ? 'selected' : '' }}>(MT) Malte</option>
                                            <option value="Pays-Bas" {{ old('pays', $user->country) == 'Pays-Bas' ? 'selected' : '' }}>(NL) Pays-Bas</option>
                                            <option value="Pologne" {{ old('pays', $user->country) == 'Pologne' ? 'selected' : '' }}>(PL) Pologne</option>
                                            <option value="Portugal" {{ old('pays', $user->country) == 'Portugal' ? 'selected' : '' }}>(PT) Portugal</option>
                                            <option value="République Tchèque" {{ old('pays', $user->country) == 'République Tchèque' ? 'selected' : '' }}>(CZ) République Tchèque</option>
                                            <option value="Roumanie" {{ old('pays', $user->country) == 'Roumanie' ? 'selected' : '' }}>(RO) Roumanie</option>
                                            <option value="Slovaquie" {{ old('pays', $user->country) == 'Slovaquie' ? 'selected' : '' }}>(SK) Slovaquie</option>
                                            <option value="Slovénie" {{ old('pays', $user->country) == 'Slovénie' ? 'selected' : '' }}>(SI) Slovénie</option>
                                            <option value="Suède" {{ old('pays', $user->country) == 'Suède' ? 'selected' : '' }}>(SE) Suède</option>
                                            <option value="Suisse" {{ old('pays', $user->country) == 'Suisse' ? 'selected' : '' }}>(CH) Suisse</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pièce d'identité -->
                        <div class="glass-effect rounded-xl shadow-soft section-card overflow-hidden">
                            <div class="bg-gradient-to-r from-primary-50/80 to-blue-50/80 px-6 py-4 border-b border-primary-100/50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-id-card text-primary-500 mr-2"></i>
                                    Pièce d'identité
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="type_piece" class="block text-sm font-medium text-gray-700 mb-1">
                                            Type de pièce
                                        </label>
                                        <select name="type_piece"
                                                id="type_piece"
                                                class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80">
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
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations bancaires -->
                        <div class="glass-effect rounded-xl shadow-soft section-card overflow-hidden">
                            <div class="bg-gradient-to-r from-primary-50/80 to-blue-50/80 px-6 py-4 border-b border-primary-100/50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-university text-primary-500 mr-2"></i>
                                    Informations bancaires
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="iban" class="block text-sm font-medium text-gray-700 mb-1">
                                            IBAN
                                        </label>
                                        <input type="text"
                                               name="iban"
                                               id="iban"
                                               value="{{ old('iban', $user->iban) }}"
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80"
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
                                               class="form-input block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white/80"
                                               placeholder="BNPAFRPP">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Code d'activation -->
                        <div class="glass-effect border border-blue-200/50 rounded-xl p-5 shadow-soft">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-blue-100/80 p-3 rounded-lg">
                                        <i class="fas fa-key text-blue-500 text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-base font-semibold text-blue-800">Code d'activation</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p class="mb-3">
                                            Le code d'activation est défini par l'administrateur et est requis pour certains scénarios de virement.
                                        </p>
                                        <div>
                                            <label for="activation_code" class="block text-sm font-medium text-blue-800 mb-1">
                                                Code d'activation (optionnel)
                                            </label>
                                            <input type="text"
                                                   name="activation_code"
                                                   id="activation_code"
                                                   value="{{ old('activation_code', $user->activation_code) }}"
                                                   class="form-input block w-full px-3 py-2 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white/80"
                                                   placeholder="Entrez un code d'activation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statut du compte -->
                        <div class="glass-effect border border-warning-200/50 rounded-xl p-5 shadow-soft">
                            <h3 class="text-base font-semibold text-warning-800 mb-3 flex items-center">
                                <i class="fas fa-user-shield text-warning-500 mr-2"></i>
                                Statut du compte
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-warning-700 mb-1">
                                        Statut actuel
                                    </label>
                                    <select name="status"
                                            id="status"
                                            class="form-input block w-full px-3 py-2 border border-warning-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-warning-500 focus:border-warning-500 transition-colors bg-white/80">
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                                    </select>
                                </div>
                                <div class="text-sm text-warning-700">
                                    <p class="flex items-center"><strong class="mr-2">Statut actuel :</strong>
                                        <span class="status-badge {{ $user->status == 'active' ? 'bg-success-100 text-success-800' : 'bg-danger-100 text-danger-800' }}">
                                            <i class="fas {{ $user->status == 'active' ? 'fa-check-circle' : 'fa-ban' }} mr-1"></i>
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </p>
                                    <p class="mt-2 text-xs">Un compte suspendu ne peut pas effectuer de transactions.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Solde -->
                        <div class="glass-effect border border-green-200/50 rounded-xl p-5 shadow-soft">
                            <h3 class="text-base font-semibold text-green-800 mb-3 flex items-center">
                                <i class="fas fa-wallet text-green-500 mr-2"></i>
                                Solde du compte
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-green-700 mb-1">
                                        Solde actuel
                                    </label>
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ number_format($user->balance, 2) }} €
                                    </div>
                                </div>
                                <div>
                                    <label for="balance" class="block text-sm font-medium text-green-700 mb-1">
                                        Nouveau solde (€) <span class="text-danger-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="balance"
                                           id="balance"
                                           value="{{ old('balance', number_format($user->balance, 2, ',', '')) }}"
                                           class="form-input block w-full px-3 py-2 border border-green-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors bg-white/80"
                                           placeholder="0,00"
                                           required>
                                    <p class="mt-1 text-xs text-green-600">
                                        <i class="fas fa-info-circle mr-1"></i> Solde actuel: {{ number_format($user->balance, 2) }} €. Cette modification sera tracée.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="glass-effect rounded-xl p-5 shadow-soft border border-gray-200/50">
                            <h3 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-cogs text-gray-500 mr-2"></i>
                                Actions
                            </h3>
                            <div class="space-y-3">
                                <button type="submit" class="w-full flex justify-center items-center bg-primary-600 text-white px-4 py-3 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all shadow-md hover:shadow-lg">
                                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                                </button>
                                <a href="{{ route('admin.users') }}" class="w-full flex justify-center items-center bg-gray-200/80 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300/80 transition-colors">
                                    <i class="fas fa-times mr-2"></i>Annuler
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Réinitialisation du mot de passe -->
            <div class="mt-8 glass-effect border border-danger-200/50 rounded-xl p-5 shadow-soft">
                <h3 class="text-lg font-semibold text-danger-800 mb-3 flex items-center">
                    <i class="fas fa-key text-danger-500 mr-2"></i>
                    Réinitialisation du mot de passe
                </h3>
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <p class="text-sm text-danger-700 mb-2">
                            Réinitialiser le mot de passe de cet utilisateur. Un nouveau mot de passe aléatoire sera généré et envoyé par email.
                        </p>
                        <p class="text-xs text-danger-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <strong>Attention :</strong> Cette action est irréversible et l'utilisateur devra utiliser le nouveau mot de passe pour se connecter.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" class="md:ml-4">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="w-full md:w-auto flex items-center justify-center bg-danger-600 text-white px-4 py-2.5 rounded-lg hover:bg-danger-700 focus:outline-none focus:ring-2 focus:ring-danger-500 focus:ring-offset-2 transition-colors shadow-sm"
                                onclick="return confirm('Êtes-vous sûr de vouloir réinitialiser le mot de passe de cet utilisateur ? Un email sera envoyé avec le nouveau mot de passe.')">
                            <i class="fas fa-key mr-2"></i>Réinitialiser le mot de passe
                        </button>
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

        // Format balance input
        document.getElementById('balance').addEventListener('blur', function(e) {
            let value = e.target.value.replace(',', '.');
            if (!isNaN(value) && value.trim() !== '') {
                e.target.value = parseFloat(value).toFixed(2).replace('.', ',');
            }
        });
    </script>
</body>
</html>