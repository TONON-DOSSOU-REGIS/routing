<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres de progression - SG BANK Admin</title>
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

        /* Style pour les boutons radio personnalisés */
        .custom-radio {
            position: relative;
            cursor: pointer;
        }

        .custom-radio input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .radio-checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 1.25rem;
            width: 1.25rem;
            background-color: #fff;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .custom-radio:hover input ~ .radio-checkmark {
            border-color: #3b82f6;
        }

        .custom-radio input:checked ~ .radio-checkmark {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .radio-checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-radio input:checked ~ .radio-checkmark:after {
            display: block;
        }

        .custom-radio .radio-checkmark:after {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background: white;
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
                                    <img src='<?php echo e(asset("images/logobank.png")); ?>' class="w-9 h-9" alt="">
                                </div>
                                <div>
                                    <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">SG BANK Admin</a>
                                    <div class="text-xs text-gray-500 -mt-1">Paramètres système</div>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-6">
                            <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="<?php echo e(localized_route('admin.settings')); ?>" class="relative text-blue-600 font-semibold transition duration-300 group">
                                <i class="fas fa-cog mr-2"></i> Paramètres
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600"></span>
                            </a>
                            <a href="<?php echo e(localized_route('admin.users')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-users mr-2"></i> Utilisateurs
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
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
                            <a href="<?php echo e(localized_route('admin.settings')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-blue-600 bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-cog w-5 mr-3 text-center"></i> Paramètres
                            </a>
                            <a href="<?php echo e(localized_route('admin.users')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
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

            <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- En-tête de la page -->
                <div class="mb-8 fade-in-up">
                    <h1 class="text-3xl font-bold text-white drop-shadow-lg text-center">Paramètres de progression</h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center">Configurez le comportement des virements en cours</p>
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

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Formulaire principal -->
                    <div class="lg:col-span-2">
                        <div class="glass-card rounded-2xl overflow-hidden card-hover">
                            <div class="px-8 py-8">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                        <i class="fas fa-cog text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">Paramètres des virements</h1>
                                        <p class="text-gray-600 mt-1">Configurez le pourcentage d'arrêt et le message de suspension</p>
                                    </div>
                                </div>

                                <form method="POST" action="<?php echo e(localized_route('admin.settings.save')); ?>" class="space-y-6">
                                    <?php echo csrf_field(); ?>

                                    <!-- Pourcentage d'arrêt -->
                                    <div class="stagger-item">
                                        <label for="stop_percentage" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-percentage mr-2 text-blue-500"></i>
                                            Pourcentage d'arrêt automatique
                                        </label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <input type="number"
                                                   name="stop_percentage"
                                                   id="stop_percentage"
                                                   min="1"
                                                   max="100"
                                                   value="<?php echo e(old('stop_percentage', $settings->stop_percentage ?? 70)); ?>"
                                                   class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm input-field"
                                                   required>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 font-medium">%</span>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                                <span>0%</span>
                                                <span id="percentage-value"><?php echo e(old('stop_percentage', $settings->stop_percentage ?? 70)); ?>%</span>
                                                <span>100%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div id="percentage-bar" class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-300" 
                                                     style="width: <?php echo e(old('stop_percentage', $settings->stop_percentage ?? 70)); ?>%"></div>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                            Le virement s'arrêtera automatiquement à ce pourcentage (ex: 70 = arrêt à 70%)
                                        </p>
                                    </div>

                                    <!-- Portée des paramètres -->
                                    <div class="stagger-item">
                                        <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-globe mr-2 text-purple-500"></i>
                                            Portée des paramètres
                                        </label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <label class="custom-radio bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 cursor-pointer transition duration-300 hover:border-blue-300">
                                                <input type="radio"
                                                       name="is_global"
                                                       value="1"
                                                       <?php echo e(old('is_global', $settings->is_global ?? true) ? 'checked' : ''); ?>

                                                       class="form-radio">
                                                <span class="radio-checkmark"></span>
                                                <div class="ml-6">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-globe-americas text-blue-500 text-lg mr-2"></i>
                                                        <span class="font-medium text-gray-800">Global</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 mt-1">Tous les utilisateurs</p>
                                                </div>
                                            </label>
                                            <label class="custom-radio bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-xl p-4 cursor-pointer transition duration-300 hover:border-purple-300">
                                                <input type="radio"
                                                       name="is_global"
                                                       value="0"
                                                       <?php echo e(old('is_global', $settings->is_global ?? true) ? '' : 'checked'); ?>

                                                       class="form-radio">
                                                <span class="radio-checkmark"></span>
                                                <div class="ml-6">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-user text-purple-500 text-lg mr-2"></i>
                                                        <span class="font-medium text-gray-800">Spécifique</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 mt-1">Un utilisateur</p>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Sélection utilisateur spécifique -->
                                    <div id="target_user_container" class="stagger-item hidden">
                                        <label for="target_user_id" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-user-circle mr-2 text-green-500"></i>
                                            Sélectionner un client
                                        </label>
                                        <div class="relative">
                                            <select name="target_user_id"
                                                    id="target_user_id"
                                                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm input-field">
                                                <option value="">Choisir un client...</option>
                                                <?php $__currentLoopData = \App\Models\User::where('role', 'user')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($user->id); ?>" <?php echo e(old('target_user_id', $settings->target_user_id ?? '') == $user->id ? 'selected' : ''); ?>>
                                                        <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?> (<?php echo e($user->email); ?>)
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-lightbulb mr-1 text-yellow-500"></i>
                                            Ces paramètres s'appliqueront uniquement aux virements de ce client
                                        </p>
                                    </div>

                                    <!-- Message de suspension -->
                                    <div class="stagger-item">
                                        <label for="stop_message" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-comment-alt mr-2 text-orange-500"></i>
                                            Message de suspension
                                        </label>
                                        <textarea name="stop_message"
                                                  id="stop_message"
                                                  rows="3"
                                                  class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 sm:text-sm input-field resize-none"
                                                  placeholder="Message affiché lors de la suspension..."
                                                  required><?php echo e(old('stop_message', $settings->stop_message ?? 'Transaction suspendue pour vérification de sécurité.')); ?></textarea>
                                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                            Ce message sera affiché à l'utilisateur lorsque le virement sera suspendu
                                        </p>
                                    </div>

                                    <!-- Information actuelle -->
                                    <div class="stagger-item">
                                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                                                    <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Configuration actuelle</h3>
                                                    <div class="text-sm text-blue-700 space-y-2">
                                                        <p class="flex items-center">
                                                            <i class="fas fa-percentage w-4 mr-2"></i>
                                                            <strong>Pourcentage :</strong> 
                                                            <span class="ml-1"><?php echo e($settings->stop_percentage ?? 70); ?>%</span>
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i class="fas fa-comment w-4 mr-2"></i>
                                                            <strong>Message :</strong> 
                                                            <span class="ml-1"><?php echo e($settings->stop_message ?? 'Transaction suspendue pour vérification de sécurité.'); ?></span>
                                                        </p>
                                                        <p class="flex items-center">
                                                            <i class="fas fa-globe w-4 mr-2"></i>
                                                            <strong>Portée :</strong> 
                                                            <span class="ml-1"><?php echo e(($settings->is_global ?? true) ? 'Globale' : 'Spécifique'); ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Boutons d'action -->
                                    <div class="stagger-item flex justify-end space-x-4 pt-4">
                                        <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition duration-300 font-medium shadow-sm">
                                            <i class="fas fa-arrow-left mr-2"></i>Annuler
                                        </a>
                                        <button type="submit"
                                                class="action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-3 rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-semibold shadow-lg transform hover:scale-105 transition duration-300 pulse-glow">
                                            <i class="fas fa-save mr-2"></i>Enregistrer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Aperçu du message -->
                    <div class="lg:col-span-1">
                        <div class="glass-card rounded-2xl overflow-hidden card-hover">
                            <div class="px-6 py-6">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-2 rounded-xl mr-3 shadow-lg">
                                        <i class="fas fa-eye text-white"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">Aperçu du message</h3>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-amber-100 p-2 rounded-lg mr-3">
                                                <i class="fas fa-exclamation-triangle text-amber-500"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-sm font-semibold text-amber-800 mb-1">Transaction suspendue</h4>
                                                <p id="preview-message" class="text-sm text-amber-700">
                                                    <?php echo e(old('stop_message', $settings->stop_message ?? 'Transaction suspendue pour vérification de sécurité.')); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-xl p-4">
                                        <div class="text-center">
                                            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-3">
                                                <i class="fas fa-cog text-blue-500 text-xl"></i>
                                            </div>
                                            <h4 class="text-sm font-semibold text-gray-800 mb-1">Simulation</h4>
                                            <p class="text-xs text-gray-600">
                                                Le virement s'arrêtera à <span id="preview-percentage" class="font-bold"><?php echo e(old('stop_percentage', $settings->stop_percentage ?? 70)); ?>%</span>
                                            </p>
                                        </div>
                                    </div>
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

        // Update percentage bar and value
        document.getElementById('stop_percentage').addEventListener('input', function() {
            const value = this.value;
            document.getElementById('percentage-value').textContent = value + '%';
            document.getElementById('percentage-bar').style.width = value + '%';
            document.getElementById('preview-percentage').textContent = value + '%';
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
    <?php echo $__env->make('components.admin-chat-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/admin/settings.blade.php ENDPATH**/ ?>