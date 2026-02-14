<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('transactions.page_title')); ?></title>
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
        .stagger-item:nth-child(6) { animation-delay: 0.6s; }
        .stagger-item:nth-child(7) { animation-delay: 0.7s; }
        
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

        /* Overlay popup fade in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Icon smooth fade & scale */
        .icon-fade-transition {
            transition: opacity 0.5s ease, transform 0.5s ease;
            opacity: 0;
            transform: scale(0.8);
        }

        .icon-visible {
            opacity: 1 !important;
            transform: scale(1) !important;
        }

        /* Professional modal overlay */
        .flash-overlay {
            position: fixed !important;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            z-index: 9999 !important;
        }

        .flash-overlay.is-visible {
            display: flex;
            animation: fadeIn 0.25s ease forwards;
        }

        .flash-card {
            --accent: #ef4444;
            --accent-strong: #dc2626;
            --accent-soft: rgba(239, 68, 68, 0.12);
            width: 100%;
            max-width: 420px;
            border-radius: 1.5rem;
            padding: 2rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.35);
            position: relative;
            overflow: hidden;
        }

        .flash-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--accent-strong));
        }

        .flash-card--success {
            --accent: #10b981;
            --accent-strong: #059669;
            --accent-soft: rgba(16, 185, 129, 0.16);
        }

        .flash-icon-container {
            background: var(--accent-soft);
            width: 72px;
            height: 72px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.25);
        }

        .flash-icon {
            color: var(--accent);
            font-size: 1.75rem;
        }

        .flash-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }

        .flash-message {
            color: #475569;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .flash-button {
            width: 100%;
            border-radius: 0.9rem;
            padding: 0.85rem 1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .flash-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.24);
        }

        .flash-button:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2), 0 18px 35px rgba(15, 23, 42, 0.24);
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

        @media (max-width: 640px) {
            .background-container {
                background-attachment: scroll;
            }

            .flash-card {
                padding: 1.5rem;
            }
        }

        /* Style pour la barre de progression */
        .progress-bar {
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Style pour les étapes */
        .step-indicator {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .step-active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .step-inactive {
            background: #e5e7eb;
            color: #9ca3af;
        }
    </style>
</head>
<body class="min-h-screen">
  <?php echo $__env->make('components.background-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                                    <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>"><img src='<?php echo e(asset("images/Logosite.png")); ?>' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
                                </div>
                                <div>
                                    <a href="<?php echo e(localized_route('dashboard')); ?>" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"><span class="sr-only">SG BANK</span></a>
                                    <div class="text-xs text-gray-500 -mt-1"><?php echo e(__('transactions.new_transfer')); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-6">
                            <a href="<?php echo e(localized_route('dashboard')); ?>" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-tachometer-alt mr-2"></i> <?php echo e(__('transactions.dashboard')); ?>

                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <form method="POST" action="<?php echo e(localized_route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="relative text-gray-700 hover:text-red-600 transition duration-300 font-medium group">
                                    <i class="fas fa-sign-out-alt mr-2"></i> <?php echo e(__('transactions.logout')); ?>

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
                            <a href="<?php echo e(localized_route('dashboard')); ?>" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i>
                                <?php echo e(__('transactions.dashboard')); ?>

                            </a>
                            <form method="POST" action="<?php echo e(localized_route('logout')); ?>" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="flex items-center w-full px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition duration-300">
                                    <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                                    <?php echo e(__('transactions.logout')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="max-w-4xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <!-- En-tête de la page -->
                <div class="mb-8 fade-in-up">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white drop-shadow-lg text-center"><?php echo e(__('transactions.transfer_title')); ?></h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center"><?php echo e(__('transactions.transfer_subtitle')); ?></p>
                </div>

                <!-- Indicateur d'étapes -->
                <div class="glass-card rounded-2xl p-4 sm:p-6 mb-8 fade-in-up">
                    <div class="flex flex-col items-center sm:flex-row sm:items-center sm:justify-between gap-4 max-w-md sm:mx-auto">
                        <div class="flex flex-col items-center">
                            <div class="step-indicator step-active">
                                <i class="fas fa-edit"></i>
                            </div>
                            <span class="text-xs sm:text-sm font-medium text-gray-700 mt-2 text-center"><?php echo e(__('transactions.step_information')); ?></span>
                        </div>
                        <div class="hidden sm:block flex-1 h-1 bg-gray-200 mx-4"></div>
                        <div class="flex flex-col items-center">
                            <div class="step-indicator step-inactive">
                                <i class="fas fa-cog"></i>
                            </div>
                            <span class="text-xs sm:text-sm font-medium text-gray-500 mt-2 text-center"><?php echo e(__('transactions.step_processing')); ?></span>
                        </div>
                        <div class="hidden sm:block flex-1 h-1 bg-gray-200 mx-4"></div>
                        <div class="flex flex-col items-center">
                            <div class="step-indicator step-inactive">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-xs sm:text-sm font-medium text-gray-500 mt-2 text-center"><?php echo e(__('transactions.step_confirmation')); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Formulaire principal -->
                <div class="glass-card rounded-2xl overflow-hidden card-hover">
                    <div class="px-4 sm:px-8 py-6 sm:py-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                <i class="fas fa-paper-plane text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900"><?php echo e(__('transactions.transfer_details')); ?></h1>
                                <p class="text-gray-600 mt-1"><?php echo e(__('transactions.beneficiary_info')); ?></p>
                            </div>
                        </div>

                        <form id="transferForm" method="POST" class="space-y-6">
                            <?php echo csrf_field(); ?>

                            <!-- Montant -->
                            <div class="stagger-item">
                                <label for="amount" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-euro-sign mr-2 text-green-500"></i>
                                    <?php echo e(__('transactions.transfer_amount')); ?>

                                </label>
                                <div class="relative rounded-xl shadow-sm">
                                    <input type="number" 
                                           step="0.01" 
                                           id="amount" 
                                           name="amount" 
                                           required
                                           class="block w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 input-field"
                                           placeholder="0.00">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-euro-sign text-gray-400"></i>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </p> 
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Informations bénéficiaire -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="stagger-item">
                                    <label for="recipient_name" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-user mr-2 text-blue-500"></i>
                                        <?php echo e(__('transactions.recipient_name')); ?>

                                    </label>
                                    <input type="text" 
                                           id="recipient_name" 
                                           name="recipient_name" 
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-field"
                                           placeholder="<?php echo e(__('transactions.recipient_name_placeholder')); ?>">
                                    <?php $__errorArgs = ['recipient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </p> 
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="stagger-item">
                                    <label for="bank_name" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-university mr-2 text-purple-500"></i>
                                        <?php echo e(__('transactions.bank_name')); ?>

                                    </label>
                                    <input type="text" 
                                           id="bank_name" 
                                           name="bank_name" 
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 input-field"
                                           placeholder="<?php echo e(__('transactions.bank_name_placeholder')); ?>">
                                    <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </p> 
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Coordonnées bancaires -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="stagger-item">
                                    <label for="recipient_iban" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-credit-card mr-2 text-indigo-500"></i>
                                        <?php echo e(__('transactions.recipient_iban')); ?>

                                    </label>
                                    <input type="text" 
                                           id="recipient_iban" 
                                           name="recipient_iban" 
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-field"
                                           placeholder="<?php echo e(__('transactions.recipient_iban_placeholder')); ?>">
                                    <?php $__errorArgs = ['recipient_iban'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </p> 
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="stagger-item">
                                    <label for="recipient_bic" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-code mr-2 text-orange-500"></i>
                                        <?php echo e(__('transactions.recipient_bic')); ?>

                                    </label>
                                    <input type="text" 
                                           id="recipient_bic" 
                                           name="recipient_bic" 
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 input-field"
                                           placeholder="<?php echo e(__('transactions.recipient_bic_placeholder')); ?>">
                                    <?php $__errorArgs = ['recipient_bic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </p> 
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Informations supplémentaires -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="stagger-item">
                                    <label for="reason" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-comment mr-2 text-gray-500"></i>
                                        <?php echo e(__('transactions.transfer_reason')); ?>

                                    </label>
                                    <input type="text" 
                                           id="reason" 
                                           name="reason"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 input-field"
                                           placeholder="<?php echo e(__('transactions.transfer_reason_placeholder')); ?>">
                                    <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </p> 
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="stagger-item">
                                    <label for="activation_code" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-shield-alt mr-2 text-red-500"></i>
                                        <?php echo e(__('transactions.activation_code')); ?>

                                    </label>
                                    <input type="text"
                                           id="activation_code"
                                           name="activation_code"
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 input-field"
                                           placeholder="<?php echo e(__('transactions.activation_code_placeholder')); ?>">
                                    <?php $__errorArgs = ['activation_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="stagger-item flex flex-col sm:flex-row sm:justify-end gap-3 pt-6">
                                <a href="<?php echo e(localized_route('dashboard')); ?>"
                                   class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition duration-300 font-medium shadow-sm flex items-center justify-center gap-2 w-full sm:w-auto">
                                    <i class="fas fa-arrow-left"></i>
                                    <?php echo e(__('transactions.cancel')); ?>

                                </a>
                                <button type="button" 
                                        id="startBtn" 
                                        class="action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-3 rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-semibold shadow-lg transform hover:scale-105 transition duration-300 pulse-glow flex items-center justify-center gap-2 w-full sm:w-auto">
                                    <i class="fas fa-paper-plane"></i>
                                    <?php echo e(__('transactions.start_transfer')); ?>

                                </button>
                            </div>
                        </form>

                        <!-- Section de progression -->
                        <div class="mt-8 hidden" id="progressSection">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-4 sm:p-6">
                                <div class="flex items-center mb-4">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-cog text-blue-500 text-lg"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900"><?php echo e(__('transactions.processing')); ?></h3>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                                            <span><?php echo e(__('transactions.progress_label')); ?></span>
                                            <span id="progressText">0%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div id="progressBar" class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500 progress-bar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-sm text-gray-500 flex items-center gap-2">
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                        <span><?php echo e(__('transactions.processing_message')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay d'interruption -->
    <div id="flashOverlay" class="flash-overlay" aria-hidden="true">
        <div id="flashCard" class="flash-card flash-card--error" role="dialog" aria-modal="true" aria-labelledby="flashTitle" aria-describedby="flashMessage">
            <div id="flashIconContainer" class="flash-icon-container">
                <i id="flashIcon" class="flash-icon fas fa-exclamation-triangle"></i>
            </div>
            <h3 id="flashTitle" class="flash-title"><?php echo e(__('transactions.operation_interrupted')); ?></h3>
            <p id="flashMessage" class="flash-message"></p>
            <button id="closeFlash" class="flash-button">
                <i class="fas fa-check mr-2"></i><?php echo e(__('transactions.understood')); ?>

            </button>
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

        const startBtn = document.getElementById('startBtn');
        const progressSection = document.getElementById('progressSection');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const overlay = document.getElementById('flashOverlay');
        const flashMsg = document.getElementById('flashMessage');
        const closeFlash = document.getElementById('closeFlash');
        const flashIcon = document.getElementById('flashIcon');
        const flashIconContainer = document.getElementById('flashIconContainer');
        const flashCard = document.getElementById('flashCard');
        const flashTitle = document.getElementById('flashTitle');

        let txId = null;
        let ticking = false;
        let audioContext = null;
        let soundUnlocked = false;

        function getAudioContext() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            return audioContext;
        }

        function unlockAudio() {
            try {
                const ctx = getAudioContext();
                if (ctx.state === 'suspended') {
                    ctx.resume();
                }
            } catch (e) {
                // Ignore audio unlock errors
            }
        }

        function playTone(frequency, startTime, duration, volume) {
            const ctx = getAudioContext();
            const oscillator = ctx.createOscillator();
            const gainNode = ctx.createGain();

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(frequency, startTime);

            gainNode.gain.setValueAtTime(0, startTime);
            gainNode.gain.linearRampToValueAtTime(volume, startTime + 0.02);
            gainNode.gain.exponentialRampToValueAtTime(0.0001, startTime + duration);

            oscillator.connect(gainNode);
            gainNode.connect(ctx.destination);

            oscillator.start(startTime);
            oscillator.stop(startTime + duration + 0.02);
        }

        function playModalSound(type) {
            if (!soundUnlocked) return;
            try {
                const ctx = getAudioContext();
                const now = ctx.currentTime;
                if (type === 'success') {
                    playTone(660, now, 0.2, 0.07);
                    playTone(880, now + 0.05, 0.25, 0.06);
                } else {
                    playTone(360, now, 0.25, 0.08);
                }
            } catch (e) {
                // Ignore audio playback errors
            }
        }

        document.addEventListener('click', () => {
            soundUnlocked = true;
            unlockAudio();
        }, { once: true });

        function setProgress(p) {
            progressBar.style.width = p + '%';
            progressText.textContent = p + '%';
        }

        startBtn.addEventListener('click', async () => {
            if (ticking) return;
            soundUnlocked = true;
            unlockAudio();
            const form = document.getElementById('transferForm');
            const payload = new FormData(form);

            try {
                const res = await fetch('<?php echo e(localized_route('transactions.start')); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: payload
                });

                const data = await res.json();

                if (res.ok) {
                    txId = data.tx_id;
                    ticking = true;
                    progressSection.classList.remove('hidden');
                    startBtn.disabled = true;
                    startBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><?php echo e(__('transactions.processing_in_progress')); ?>';
                    tick();
                } else {
                    showMessage('<?php echo e(__('transactions.error_starting_transfer')); ?>', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('<?php echo e(__('transactions.connection_error')); ?>', 'error');
            }
        });

        async function tick() {
            if (!ticking || !txId) return;

            try {
                const res = await fetch('<?php echo e(localized_route('transactions.progress')); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ tx_id: txId })
                });

                const data = await res.json();

                console.log('Progress response:', data);
                setProgress(data.progress);

                if (data.status === 'on_hold') {
                    ticking = false;
                    resetStartButton();
                    showMessage(data.message || '<?php echo e(__('transactions.transaction_on_hold')); ?>', 'error');
                    return;
                }

                if (data.status === 'success') {
                    ticking = false;
                    resetStartButton();
                    // Animation de succès avant redirection
                    progressBar.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                    showMessage('<?php echo e(__('transactions.transfer_success_message')); ?>', 'success');
                    // Let the success message show for 2 seconds before redirect
                    setTimeout(() => {
                        window.location.href = '<?php echo e(localized_route('transactions.history')); ?>';
                    }, 2000);
                    return;
                }

                // Continue ticking avec un délai réduit pour une progression plus fluide
                setTimeout(tick, 500);
            } catch (error) {
                console.error('Error:', error);
                ticking = false;
                resetStartButton();
                showMessage('<?php echo e(__('transactions.connection_error_processing')); ?>', 'error');
            }
        }

        function resetStartButton() {
            startBtn.disabled = false;
            startBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i><?php echo e(__('transactions.start_transfer')); ?>';
        }

        function showMessage(message, type = 'error') {
            flashMsg.textContent = message;
            // Remove previous icon classes and animation classes
            flashIcon.classList.remove('icon-visible');
            flashIcon.classList.add('icon-fade-transition');
            flashCard.classList.remove('flash-card--success', 'flash-card--error');

            if (type === 'success') {
                // Change to validated icon and green styling
                flashIcon.className = 'flash-icon fas fa-check-circle icon-fade-transition';
                flashIconContainer.className = 'flash-icon-container';
                flashCard.classList.add('flash-card--success');
                flashTitle.textContent = '<?php echo e(__('transactions.operation_success')); ?>';

                // Animate icon appearance
                setTimeout(() => {
                    flashIcon.classList.add('icon-visible');
                }, 50);
            } else {
                // Change to alert icon and red styling
                flashIcon.className = 'flash-icon fas fa-exclamation-triangle icon-fade-transition';
                flashIconContainer.className = 'flash-icon-container';
                flashCard.classList.add('flash-card--error');
                flashTitle.textContent = '<?php echo e(__('transactions.operation_interrupted')); ?>';

                // Animate icon appearance
                setTimeout(() => {
                    flashIcon.classList.add('icon-visible');
                }, 50);
            }

            // Show overlay as a centered modal
            overlay.classList.add('is-visible');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');
            playModalSound(type);

            console.log("Current icon class:", flashIcon.className); // Debug log
        }

        closeFlash.addEventListener('click', () => {
            overlay.classList.remove('is-visible');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('overflow-hidden');
        });

        overlay.addEventListener('click', (event) => {
            if (event.target === overlay) {
                overlay.classList.remove('is-visible');
                overlay.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
            }
        });

        // Validation en temps réel
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
    </script>
</body>
</html>







<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/transactions/create.blade.php ENDPATH**/ ?>