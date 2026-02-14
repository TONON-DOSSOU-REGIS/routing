<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un utilisateur - SG BANK Admin</title>
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
        .stagger-item:nth-child(5) { animation-delay: 0.5s; }
        
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

        /* Style pour les sections de formulaire */
        .form-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        /* Style pour les indicateurs de force du mot de passe */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
            margin-top: 8px;
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

        <?php echo $__env->make('components.admin-dashboard-background-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </style>
</head>
<body class="min-h-screen">
    <?php echo $__env->make('components.admin-dashboard-background', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="min-h-screen relative z-10">
        <!-- Navigation améliorée -->
        <nav class="glass-nav sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-2 rounded-lg">
                                    <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>"><img src='<?php echo e(asset("images/Logosite.png")); ?>' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
                                </div>
                                <div>
                                    <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"><span class="sr-only">SG BANK Admin</span></a>
                                    <div class="text-xs text-gray-500 -mt-1">Création d'utilisateur</div>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-6">
                            <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="<?php echo e(localized_route('admin.settings')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-cog mr-2"></i> Paramètres
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="<?php echo e(localized_route('admin.users')); ?>" class="relative text-blue-600 font-semibold transition duration-300 group">
                                <i class="fas fa-users mr-2"></i> Utilisateurs
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600"></span>
                            </a>
                            <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-plus-circle mr-2"></i> Dépôt
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="<?php echo e(localized_route('dashboard', ['locale' => app()->getLocale()])); ?>" class="relative text-gray-700 hover:text-green-600 transition duration-300 font-medium group">
                                <i class="fas fa-arrow-left mr-2"></i> Retour au site
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <form method="POST" action="<?php echo e(localized_route('logout', ['locale' => app()->getLocale()])); ?>">
                                <?php echo csrf_field(); ?>
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
                            <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i> Dashboard
                            </a>
                            <a href="<?php echo e(localized_route('admin.settings')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-cog w-5 mr-3 text-center"></i> Paramètres
                            </a>
                            <a href="<?php echo e(localized_route('admin.users')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-blue-600 bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-users w-5 mr-3 text-center"></i> Utilisateurs
                            </a>
                            <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-plus-circle w-5 mr-3 text-center"></i> Dépôt
                            </a>
                            <a href="<?php echo e(localized_route('dashboard', ['locale' => app()->getLocale()])); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition duration-300">
                                <i class="fas fa-arrow-left w-5 mr-3 text-center"></i> Retour au site
                            </a>
                            <form method="POST" action="<?php echo e(localized_route('logout', ['locale' => app()->getLocale()])); ?>" class="block">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="flex items-center w-full px-3 py-3 text-base font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition duration-300">
                                    <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- En-tête de la page -->
                <div class="mb-8 fade-in-up">
                    <h1 class="text-3xl font-bold text-white drop-shadow-lg text-center">Créer un nouvel utilisateur</h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center">Ajoutez un nouveau client ou administrateur au système</p>
                </div>

                <!-- Flash Messages améliorées -->
                <?php if(session('status')): ?>
                    <div class="mb-6 glass-card border-l-4 border-l-green-500 rounded-2xl fade-in-up">
                        <div class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 p-2 rounded-full">
                                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-800"><?php echo e(session('status')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="mb-6 glass-card border-l-4 border-l-red-500 rounded-2xl fade-in-up">
                        <div class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-100 p-2 rounded-full">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-semibold text-gray-800 mb-1">Erreurs de validation</h3>
                                    <ul class="text-sm text-gray-700 list-disc list-inside">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Formulaire principal -->
                <div class="glass-card rounded-2xl overflow-hidden card-hover">
                    <div class="px-8 py-8">
                        <!-- En-tête du formulaire -->
                        <div class="flex items-center mb-8">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                <i class="fas fa-user-plus text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Nouvel utilisateur</h1>
                                <p class="text-gray-600 mt-1">Renseignez les informations du nouvel utilisateur</p>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(localized_route('admin.users.store')); ?>" class="space-y-8" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <!-- Informations personnelles -->
                            <div class="form-section stagger-item">
                                <div class="flex items-center mb-6">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-user text-blue-500"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900">Informations personnelles</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="first_name" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-signature mr-2 text-blue-500"></i>
                                            Prénom *
                                        </label>
                                        <input type="text"
                                               name="first_name"
                                               id="first_name"
                                               value="<?php echo e(old('first_name')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-field"
                                               placeholder="Jean"
                                               required>
                                    </div>

                                    <div>
                                        <label for="last_name" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-signature mr-2 text-blue-500"></i>
                                            Nom *
                                        </label>
                                        <input type="text"
                                               name="last_name"
                                               id="last_name"
                                               value="<?php echo e(old('last_name')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-field"
                                               placeholder="Dupont"
                                               required>
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-envelope mr-2 text-purple-500"></i>
                                            Email *
                                        </label>
                                        <input type="email"
                                               name="email"
                                               id="email"
                                               value="<?php echo e(old('email')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 input-field"
                                               placeholder="jean.dupont@email.com"
                                               required>
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-phone mr-2 text-green-500"></i>
                                            Téléphone
                                        </label>
                                        <input type="tel"
                                               name="phone"
                                               id="phone"
                                               value="<?php echo e(old('phone')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 input-field"
                                               placeholder="+33 6 12 34 56 78">
                                    </div>

                                    <div>
                                        <label for="date_naissance" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-calendar mr-2 text-orange-500"></i>
                                            Date de naissance
                                        </label>
                                        <input type="date"
                                               name="date_naissance"
                                               id="date_naissance"
                                               value="<?php echo e(old('date_naissance')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 input-field">
                                    </div>

                                    <div>
                                        <label for="role" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-user-tag mr-2 text-red-500"></i>
                                            Rôle *
                                        </label>
                                        <select name="role"
                                                id="role"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 input-field"
                                                required>
                                            <option value="user" <?php echo e(old('role') == 'user' ? 'selected' : ''); ?>>Client</option>
                                            <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Administrateur</option>
                                        </select>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="profile_photo" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-camera mr-2 text-indigo-500"></i>
                                            Photo du client
                                        </label>
                                        <input type="file"
                                               name="profile_photo"
                                               id="profile_photo"
                                               accept="image/png,image/jpeg,image/webp"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-field">
                                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                            Formats acceptés: JPG, PNG, WebP (2 Mo max).
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sécurité -->
                            <div class="form-section stagger-item">
                                <div class="flex items-center mb-6">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-shield-alt text-green-500"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900">Sécurité et authentification</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="password" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-lock mr-2 text-green-500"></i>
                                            Mot de passe *
                                        </label>
                                        <input type="password"
                                               name="password"
                                               id="password"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 input-field"
                                               placeholder="••••••••"
                                               required>
                                        <div id="password-strength" class="mt-2">
                                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                                <span>Force du mot de passe</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div id="password-strength-bar" class="password-strength h-2 rounded-full bg-red-500 w-0"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-lock mr-2 text-green-500"></i>
                                            Confirmer le mot de passe *
                                        </label>
                                        <input type="password"
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 input-field"
                                               placeholder="••••••••"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="form-section stagger-item">
                                <div class="flex items-center mb-6">
                                    <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-home text-purple-500"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900">Adresse</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label for="adresse" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2 text-purple-500"></i>
                                            Adresse
                                        </label>
                                        <input type="text"
                                               name="adresse"
                                               id="adresse"
                                               value="<?php echo e(old('adresse')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 input-field"
                                               placeholder="123 Avenue des Champs-Élysées">
                                    </div>

                                    <div>
                                        <label for="ville" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-city mr-2 text-purple-500"></i>
                                            Ville
                                        </label>
                                        <input type="text"
                                               name="ville"
                                               id="ville"
                                               value="<?php echo e(old('ville')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 input-field"
                                               placeholder="Paris">
                                    </div>

                                    <div>
                                        <label for="pays" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-globe mr-2 text-purple-500"></i>
                                            Pays
                                        </label>
                                        <select name="pays"
                                                id="pays"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 input-field">
                                            <option value="">Sélectionner un pays</option>
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($country['name']); ?>" <?php echo e(old('pays') == $country['name'] ? 'selected' : ''); ?>>
                                                    (<?php echo e($country['code']); ?>) <?php echo e($country['name']); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Pièce d'identité -->
                            <div class="form-section stagger-item">
                                <div class="flex items-center mb-6">
                                    <div class="bg-orange-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-id-card text-orange-500"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900">Pièce d'identité</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="type_piece" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-id-badge mr-2 text-orange-500"></i>
                                            Type de pièce
                                        </label>
                                        <select name="type_piece"
                                                id="type_piece"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 input-field">
                                            <option value="">Sélectionner</option>
                                            <option value="CNI" <?php echo e(old('type_piece') == 'CNI' ? 'selected' : ''); ?>>Carte Nationale d'Identité</option>
                                            <option value="Passeport" <?php echo e(old('type_piece') == 'Passeport' ? 'selected' : ''); ?>>Passeport</option>
                                            <option value="Permis" <?php echo e(old('type_piece') == 'Permis' ? 'selected' : ''); ?>>Permis de conduire</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="numero_piece" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-hashtag mr-2 text-orange-500"></i>
                                            Numéro de pièce
                                        </label>
                                        <input type="text"
                                               name="numero_piece"
                                               id="numero_piece"
                                               value="<?php echo e(old('numero_piece')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 input-field"
                                               placeholder="12AB34567">
                                    </div>
                                </div>
                            </div>

                            <!-- Informations bancaires -->
                            <div class="form-section stagger-item">
                                <div class="flex items-center mb-6">
                                    <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-university text-indigo-500"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900">Informations bancaires (optionnelles)</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="iban" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-credit-card mr-2 text-indigo-500"></i>
                                            IBAN
                                        </label>
                                        <input type="text"
                                               name="iban"
                                               id="iban"
                                               value="<?php echo e(old('iban')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-field"
                                               placeholder="FR76 1234 5678 9012 3456 7890 123">
                                    </div>

                                    <div>
                                        <label for="bic" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-code mr-2 text-indigo-500"></i>
                                            BIC
                                        </label>
                                        <input type="text"
                                               name="bic"
                                               id="bic"
                                               value="<?php echo e(old('bic')); ?>"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-field"
                                               placeholder="BNPAFRPP">
                                    </div>
                                </div>
                            </div>

                            <!-- Code d'activation -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6 stagger-item">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg mr-4">
                                        <i class="fas fa-key text-blue-500 text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-blue-800 mb-3">Code d'activation</h3>
                                        <div class="text-sm text-blue-700 mb-4">
                                            <p>Le code d'activation est défini par l'administrateur et est requis pour certains scénarios de virement.</p>
                                            <p class="mt-1">Vous pouvez le définir maintenant ou le laisser vide.</p>
                                        </div>
                                        <div class="max-w-md">
                                            <label for="activation_code" class="block text-sm font-semibold text-blue-800 mb-2">
                                                Code d'activation (optionnel)
                                            </label>
                                            <input type="text"
                                                   name="activation_code"
                                                   id="activation_code"
                                                   value="<?php echo e(old('activation_code')); ?>"
                                                   class="block w-full px-4 py-3 border border-blue-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-field"
                                                   placeholder="Entrez un code d'activation sécurisé">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="stagger-item flex justify-end space-x-4 pt-6">
                                <a href="<?php echo e(localized_route('admin.users')); ?>" 
                                   class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition duration-300 font-medium shadow-sm flex items-center gap-2">
                                    <i class="fas fa-arrow-left"></i>
                                    Annuler
                                </a>
                                <button type="submit" 
                                        class="action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-3 rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-semibold shadow-lg transform hover:scale-105 transition duration-300 pulse-glow flex items-center gap-2">
                                    <i class="fas fa-user-plus"></i>
                                    Créer l'utilisateur
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

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength-bar');
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            if (/[^A-Za-z0-9]/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.backgroundColor = '#ef4444'; // red
            } else if (strength < 75) {
                strengthBar.style.backgroundColor = '#f59e0b'; // amber
            } else {
                strengthBar.style.backgroundColor = '#10b981'; // green
            }
        });

        // Real-time validation feedback
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('border-red-300');
                    this.classList.add('border-green-300');
                } else {
                    this.classList.remove('border-green-300');
                }
            });
        });

        // Auto-format phone number
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('33')) {
                value = value.replace(/^33/, '0');
            }
            if (value.length > 0) {
                value = value.match(/.{1,2}/g).join(' ');
            }
            e.target.value = value;
        });
    </script>
    <?php echo $__env->make('components.admin-dashboard-background-script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>




<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/admin/users/create.blade.php ENDPATH**/ ?>