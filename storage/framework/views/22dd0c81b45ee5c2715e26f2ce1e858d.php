<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - SG BANK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Gradient backgrounds pour les cartes */
        .gradient-card-1 { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        }
        
        .gradient-card-2 { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
        }
        
        .gradient-card-3 { 
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); 
        }
        
        .gradient-card-4 { 
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); 
        }
        
        .gradient-card-5 { 
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); 
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
        
        /* Style pour les cartes */
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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

        /* Background slider */
        .dashboard-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .dashboard-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.35));
            z-index: 2;
        }

        .dashboard-slide {
            position: absolute;
            inset: 0;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0;
            transition: opacity 1.8s ease-in-out;
            z-index: 1;
            filter: saturate(1.05) contrast(1.05);
        }

        .dashboard-slide.active {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-900 via-red-400 to-red-700 min-h-screen">
    <div class="dashboard-bg" aria-hidden="true">
        <div class="dashboard-slide active" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1920&q=80');"></div>
        <div class="dashboard-slide" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1920&q=80');"></div>
        <div class="dashboard-slide" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80');"></div>
        <div class="dashboard-slide" style="background-image: url('https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1920&q=80');"></div>
        <div class="dashboard-slide" style="background-image: url('https://images.unsplash.com/photo-1444653614773-995cb1ef9efa?auto=format&fit=crop&w=1920&q=80');"></div>
        <div class="dashboard-slide" style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=1920&q=80');"></div>
        <div class="dashboard-slide" style="background-image: url('https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1920&q=80');"></div>
        <div class="dashboard-slide" style="background-image: url('https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg');"></div>
        <div class="dashboard-slide" style="background-image: url('https://images.pexels.com/photos/3184360/pexels-photo-3184360.jpeg');"></div>
    </div>
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
                                <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"><span class="sr-only">SB BANK Admin</span></a>
                                <div class="text-xs text-gray-500 -mt-1">Tableau de bord</div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="<?php echo e(localized_route('admin.dashboard')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="<?php echo e(localized_route('admin.users')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                            <i class="fas fa-users mr-2"></i> Utilisateurs
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="<?php echo e(localized_route('admin.transactions')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                            <i class="fas fa-exchange-alt mr-2"></i> Virements
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                            <i class="fas fa-plus-circle mr-2"></i> Dépôt
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="<?php echo e(localized_route('admin.settings')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                            <i class="fas fa-cog mr-2"></i> Paramètres
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="<?php echo e(localized_route('dashboard', ['locale' => app()->getLocale()])); ?>" class="relative text-gray-700 hover:text-green-600 transition duration-300 font-medium group">
                            <i class="fas fa-arrow-left mr-2"></i> Retour au site
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <?php echo $__env->make('components.notification-bell', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                        <a href="<?php echo e(localized_route('admin.users')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                            <i class="fas fa-users w-5 mr-3 text-center"></i> Utilisateurs
                        </a>
                        <a href="<?php echo e(localized_route('admin.transactions')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                            <i class="fas fa-exchange-alt w-5 mr-3 text-center"></i> Virements
                        </a>
                        <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                            <i class="fas fa-plus-circle w-5 mr-3 text-center"></i> Dépôt
                        </a>
                        <a href="<?php echo e(localized_route('admin.settings')); ?>" class="flex items-center px-3 py-3 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                            <i class="fas fa-cog w-5 mr-3 text-center"></i> Paramètres
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

        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <!-- En-tête du tableau de bord -->
            <div class="mb-8 fade-in-up">
                <h1 class="text-2xl sm:text-3xl font-bold text-white text-center">Tableau de bord administrateur</h1>
                <p class="text-white/80 mt-2 text-center">Vue d'ensemble des performances et activités du système</p>
            </div>

            <!-- Stats Cards améliorées -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
                <div class="gradient-card-1 text-white overflow-hidden shadow-2xl rounded-2xl card-hover stagger-item relative">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 bg-white/20 w-20 h-20 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 bg-white/10 w-16 h-16 rounded-full"></div>
                    <div class="p-4 sm:p-6 relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-white/80">Total Clients</p>
                                <p class="text-3xl font-bold mt-2"><?php echo e($totalUsers); ?></p>
                                <div class="flex items-center mt-3 text-sm">
                                    <i class="fas fa-arrow-up mr-1 text-green-300"></i>
                                    <span class="text-white/70">+12% ce mois</span>
                                </div>
                            </div>
                            <div class="bg-white/20 p-4 rounded-2xl">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gradient-card-2 text-white overflow-hidden shadow-2xl rounded-2xl card-hover stagger-item relative">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 bg-white/20 w-20 h-20 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 bg-white/10 w-16 h-16 rounded-full"></div>
                    <div class="p-4 sm:p-6 relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-white/80">Transactions</p>
                                <p class="text-3xl font-bold mt-2"><?php echo e($totalTransactions); ?></p>
                                <div class="flex items-center mt-3 text-sm">
                                    <i class="fas fa-arrow-up mr-1 text-green-300"></i>
                                    <span class="text-white/70">+8% ce mois</span>
                                </div>
                            </div>
                            <div class="bg-white/20 p-4 rounded-2xl">
                                <i class="fas fa-exchange-alt text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gradient-card-3 text-white overflow-hidden shadow-2xl rounded-2xl card-hover stagger-item relative">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 bg-white/20 w-20 h-20 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 bg-white/10 w-16 h-16 rounded-full"></div>
                    <div class="p-4 sm:p-6 relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-white/80">Dépôts (€)</p>
                                <p class="text-3xl font-bold mt-2"><?php echo e(number_format($totalDeposits, 2)); ?></p>
                                <div class="flex items-center mt-3 text-sm">
                                    <i class="fas fa-arrow-up mr-1 text-green-300"></i>
                                    <span class="text-white/70">+15% ce mois</span>
                                </div>
                            </div>
                            <div class="bg-white/20 p-4 rounded-2xl">
                                <i class="fas fa-plus-circle text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gradient-card-4 text-white overflow-hidden shadow-2xl rounded-2xl card-hover stagger-item relative">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 bg-white/20 w-20 h-20 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 bg-white/10 w-16 h-16 rounded-full"></div>
                    <div class="p-4 sm:p-6 relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-white/80">Retraits (€)</p>
                                <p class="text-3xl font-bold mt-2"><?php echo e(number_format($totalWithdrawals, 2)); ?></p>
                                <div class="flex items-center mt-3 text-sm">
                                    <i class="fas fa-arrow-up mr-1 text-green-300"></i>
                                    <span class="text-white/70">+5% ce mois</span>
                                </div>
                            </div>
                            <div class="bg-white/20 p-4 rounded-2xl">
                                <i class="fas fa-minus-circle text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gradient-card-5 text-white overflow-hidden shadow-2xl rounded-2xl card-hover stagger-item relative">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 bg-white/20 w-20 h-20 rounded-full"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 bg-white/10 w-16 h-16 rounded-full"></div>
                    <div class="p-4 sm:p-6 relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-white/80">Virements (€)</p>
                                <p class="text-3xl font-bold mt-2"><?php echo e(number_format($totalTransfers, 2)); ?></p>
                                <div class="flex items-center mt-3 text-sm">
                                    <i class="fas fa-arrow-up mr-1 text-green-300"></i>
                                    <span class="text-white/70">+10% ce mois</span>
                                </div>
                            </div>
                            <div class="bg-white/20 p-4 rounded-2xl">
                                <i class="fas fa-paper-plane text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions améliorées -->
            <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl mb-8 overflow-hidden fade-in-up border border-white/50">
                <div class="px-4 sm:px-8 py-6 sm:py-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-bolt text-yellow-500 mr-3"></i> Actions rapides
                        </h3>
                        <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <i class="fas fa-clock mr-1"></i> Temps réel
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="<?php echo e(localized_route('admin.settings')); ?>" class="action-btn bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-5 sm:px-6 sm:py-6 rounded-xl hover:from-blue-600 hover:to-blue-700 text-center shadow-lg transform hover:scale-105">
                            <div class="bg-white/20 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-cog text-2xl"></i>
                            </div>
                            <div class="font-bold text-lg">Paramètres système</div>
                            <p class="text-sm opacity-90 mt-2">Configurer les préférences</p>
                        </a>
                        <a href="<?php echo e(localized_route('admin.users')); ?>" class="action-btn bg-gradient-to-r from-green-500 to-green-600 text-white px-5 py-5 sm:px-6 sm:py-6 rounded-xl hover:from-green-600 hover:to-green-700 text-center shadow-lg transform hover:scale-105">
                            <div class="bg-white/20 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div class="font-bold text-lg">Gestion des utilisateurs</div>
                            <p class="text-sm opacity-90 mt-2">Voir et gérer les clients</p>
                        </a>
                        <a href="<?php echo e(localized_route('admin.deposit')); ?>" class="action-btn bg-gradient-to-r from-purple-500 to-purple-600 text-white px-5 py-5 sm:px-6 sm:py-6 rounded-xl hover:from-purple-600 hover:to-purple-700 text-center shadow-lg transform hover:scale-105">
                            <div class="bg-white/20 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-plus-circle text-2xl"></i>
                            </div>
                            <div class="font-bold text-lg">Dépôt manuel</div>
                            <p class="text-sm opacity-90 mt-2">Effectuer un dépôt client</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Market Tracker Widget -->
            <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl overflow-hidden fade-in-up border border-white/50 mb-8">
                <div class="px-4 sm:px-8 py-6 sm:py-8">
                    <?php echo $__env->make('components.market-tracker-fixed', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <!-- Graphiques et Activité récente -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                <!-- Graphique des transactions -->
                <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl overflow-hidden fade-in-up border border-white/50">
                    <div class="px-4 sm:px-8 py-6 sm:py-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-chart-line text-blue-500 mr-3"></i> Activité des transactions
                        </h3>
                        <div class="h-64 sm:h-80">
                            <canvas id="transactionChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Activité récente améliorée -->
                <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl overflow-hidden fade-in-up border border-white/50">
                    <div class="px-4 sm:px-8 py-6 sm:py-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-history text-purple-500 mr-3"></i> Activité récente
                        </h3>
                        <div class="space-y-4 max-h-64 sm:max-h-80 overflow-y-auto pr-2">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                                <div class="bg-blue-100 p-3 rounded-full sm:mr-4">
                                    <i class="fas fa-user-plus text-blue-500"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Nouvel utilisateur inscrit</p>
                                    <p class="text-sm text-gray-600">Jean Dupont - il y a 2 heures</p>
                                </div>
                                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full self-start sm:self-auto">Nouveau</span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 bg-green-50/50 rounded-xl border border-green-100">
                                <div class="bg-green-100 p-3 rounded-full sm:mr-4">
                                    <i class="fas fa-plus text-green-500"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Dépôt effectué</p>
                                    <p class="text-sm text-gray-600">Marie Martin - 1 500€ - il y a 4 heures</p>
                                </div>
                                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full self-start sm:self-auto">Succès</span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 bg-purple-50/50 rounded-xl border border-purple-100">
                                <div class="bg-purple-100 p-3 rounded-full sm:mr-4">
                                    <i class="fas fa-exchange-alt text-purple-500"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Virement international</p>
                                    <p class="text-sm text-gray-600">Pierre Bernard - 3 200€ - il y a 6 heures</p>
                                </div>
                                <span class="bg-purple-500 text-white text-xs px-2 py-1 rounded-full self-start sm:self-auto">International</span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 bg-yellow-50/50 rounded-xl border border-yellow-100">
                                <div class="bg-yellow-100 p-3 rounded-full sm:mr-4">
                                    <i class="fas fa-cog text-yellow-500"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Paramètres mis à jour</p>
                                    <p class="text-sm text-gray-600">Taux d'intérêt modifiés - il y a 1 jour</p>
                                </div>
                                <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full self-start sm:self-auto">Système</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const slides = document.querySelectorAll('.dashboard-bg .dashboard-slide');
            if (!slides.length) return;
            let current = 0;
            setInterval(() => {
                slides[current].classList.remove('active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('active');
            }, 6000);
        })();

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

        // Chart.js implementation
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('transactionChart').getContext('2d');
            const transactionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    datasets: [{
                        label: 'Transactions (€)',
                        data: [12000, 19000, 15000, 25000, 22000, 18000, 24000],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#1f2937',
                            bodyColor: '#1f2937',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '€' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
    <?php echo $__env->make('components.admin-chat-widget-v2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>






<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>