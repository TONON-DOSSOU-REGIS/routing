<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau virement - SG BANK</title>
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
                                    <a href="{{ route('dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">SG BANK</a>
                                    <div class="text-xs text-gray-500 -mt-1">Nouveau virement</div>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-6">
                            <a href="{{ route('dashboard') }}" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="relative text-gray-700 hover:text-red-600 transition duration-300 font-medium group">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
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
                            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i>
                                Dashboard
                            </a>
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

            <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- En-tête de la page -->
                <div class="mb-8 fade-in-up">
                    <h1 class="text-3xl font-bold text-white drop-shadow-lg text-center">Nouveau virement</h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center">Effectuez un transfert sécurisé vers un bénéficiaire</p>
                </div>

                <!-- Indicateur d'étapes -->
                <div class="glass-card rounded-2xl p-6 mb-8 fade-in-up">
                    <div class="flex items-center justify-between max-w-md mx-auto">
                        <div class="flex flex-col items-center">
                            <div class="step-indicator step-active">
                                <i class="fas fa-edit"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 mt-2">Informations</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                        <div class="flex flex-col items-center">
                            <div class="step-indicator step-inactive">
                                <i class="fas fa-cog"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-500 mt-2">Traitement</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                        <div class="flex flex-col items-center">
                            <div class="step-indicator step-inactive">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-500 mt-2">Confirmation</span>
                        </div>
                    </div>
                </div>

                <!-- Formulaire principal -->
                <div class="glass-card rounded-2xl overflow-hidden card-hover">
                    <div class="px-8 py-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                <i class="fas fa-paper-plane text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Détails du virement</h1>
                                <p class="text-gray-600 mt-1">Renseignez les informations du bénéficiaire</p>
                            </div>
                        </div>

                        <form id="transferForm" method="POST" class="space-y-6">
                            @csrf

                            <!-- Montant -->
                            <div class="stagger-item">
                                <label for="amount" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-euro-sign mr-2 text-green-500"></i>
                                    Montant du virement
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
                                @error('amount') 
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p> 
                                @enderror
                            </div>

                            <!-- Informations bénéficiaire -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="stagger-item">
                                    <label for="recipient_name" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-user mr-2 text-blue-500"></i>
                                        Nom du bénéficiaire
                                    </label>
                                    <input type="text" 
                                           id="recipient_name" 
                                           name="recipient_name" 
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-field"
                                           placeholder="Jean Dupont">
                                    @error('recipient_name') 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p> 
                                    @enderror
                                </div>

                                <div class="stagger-item">
                                    <label for="bank_name" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-university mr-2 text-purple-500"></i>
                                        Nom de la banque
                                    </label>
                                    <input type="text" 
                                           id="bank_name" 
                                           name="bank_name" 
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 input-field"
                                           placeholder="Banque Nationale">
                                    @error('bank_name') 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p> 
                                    @enderror
                                </div>
                            </div>

                            <!-- Coordonnées bancaires -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="stagger-item">
                                    <label for="recipient_iban" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-credit-card mr-2 text-indigo-500"></i>
                                        IBAN du bénéficiaire
                                    </label>
                                    <input type="text" 
                                           id="recipient_iban" 
                                           name="recipient_iban" 
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-field"
                                           placeholder="FR76 1234 5678 9012 3456 7890 123">
                                    @error('recipient_iban') 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p> 
                                    @enderror
                                </div>

                                <div class="stagger-item">
                                    <label for="recipient_bic" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-code mr-2 text-orange-500"></i>
                                        BIC du bénéficiaire
                                    </label>
                                    <input type="text" 
                                           id="recipient_bic" 
                                           name="recipient_bic" 
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 input-field"
                                           placeholder="BNPAFRPP">
                                    @error('recipient_bic') 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p> 
                                    @enderror
                                </div>
                            </div>

                            <!-- Informations supplémentaires -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="stagger-item">
                                    <label for="reason" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-comment mr-2 text-gray-500"></i>
                                        Motif du virement (optionnel)
                                    </label>
                                    <input type="text" 
                                           id="reason" 
                                           name="reason"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 input-field"
                                           placeholder="Remboursement, cadeau...">
                                    @error('reason') 
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p> 
                                    @enderror
                                </div>

                                <div class="stagger-item">
                                    <label for="activation_code" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-shield-alt mr-2 text-red-500"></i>
                                        Code d'activation
                                    </label>
                                    <input type="text"
                                           id="activation_code"
                                           name="activation_code"
                                           required
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 input-field"
                                           placeholder="Votre code d'activation personnel">
                                    @error('activation_code')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="stagger-item flex justify-end space-x-4 pt-6">
                                <a href="{{ route('dashboard') }}" 
                                   class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition duration-300 font-medium shadow-sm flex items-center gap-2">
                                    <i class="fas fa-arrow-left"></i>
                                    Annuler
                                </a>
                                <button type="button" 
                                        id="startBtn" 
                                        class="action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-3 rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-semibold shadow-lg transform hover:scale-105 transition duration-300 pulse-glow flex items-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    Lancer le virement
                                </button>
                            </div>
                        </form>

                        <!-- Section de progression -->
                        <div class="mt-8 hidden" id="progressSection">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6">
                                <div class="flex items-center mb-4">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                        <i class="fas fa-cog text-blue-500 text-lg"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Traitement en cours</h3>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                                            <span>Progression du virement</span>
                                            <span id="progressText">0%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div id="progressBar" class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500 progress-bar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-sm text-gray-500 flex items-center gap-2">
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                        <span>Votre virement est en cours de traitement. Veuillez patienter...</span>
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
    <div id="flashOverlay" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-70 z-50 p-4">
        <div id="flashCard" class="glass-card max-w-md w-full mx-auto p-8 rounded-2xl shadow-2xl text-center animate-pulse border border-red-200">
            <div id="flashIconContainer" class="bg-red-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i id="flashIcon" class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            </div>
            <h3 id="flashTitle" class="text-xl font-bold text-gray-900 mb-3">Opération interrompue</h3>
            <p id="flashMessage" class="text-gray-700 mb-6 leading-relaxed"></p>
            <button id="closeFlash" class="action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-indigo-700 font-medium shadow-lg w-full">
                <i class="fas fa-check mr-2"></i>J'ai compris
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

        function setProgress(p) {
            progressBar.style.width = p + '%';
            progressText.textContent = p + '%';
        }

        startBtn.addEventListener('click', async () => {
            if (ticking) return;
            const form = document.getElementById('transferForm');
            const payload = new FormData(form);

            try {
                const res = await fetch('{{ route('transactions.start') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: payload
                });

                const data = await res.json();

                if (res.ok) {
                    txId = data.tx_id;
                    ticking = true;
                    progressSection.classList.remove('hidden');
                    startBtn.disabled = true;
                    startBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Traitement en cours...';
                    tick();
                } else {
                    showMessage('Erreur lors du lancement du virement', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Une erreur est survenue lors de la connexion', 'error');
            }
        });

        async function tick() {
            if (!ticking || !txId) return;

            try {
                const res = await fetch('{{ route('transactions.progress') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ tx_id: txId })
                });

                const data = await res.json();

                setProgress(data.progress);

                if (data.status === 'on_hold') {
                    ticking = false;
                    resetStartButton();
                    showMessage(data.message || 'Transaction en attente de vérification de sécurité.', 'error');
                    return;
                }

                if (data.status === 'success') {
                    ticking = false;
                    resetStartButton();
                    // Animation de succès avant redirection
                    progressBar.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                    showMessage('Virement effectué avec succès ! Vous allez être redirigé...', 'success');
                    // Let the success message show for 2 seconds before redirect
                    setTimeout(() => {
                        window.location.href = '{{ route('transactions.history') }}';
                    }, 2000);
                    return;
                }

                // Continue ticking
                setTimeout(tick, 700);
            } catch (error) {
                console.error('Error:', error);
                ticking = false;
                resetStartButton();
                showMessage('Erreur de connexion lors du traitement', 'error');
            }
        }

        function resetStartButton() {
            startBtn.disabled = false;
            startBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Lancer le virement';
        }

        function showMessage(message, type = 'error') {
            flashMsg.textContent = message;
            // Remove previous icon classes and animation classes
            flashIcon.classList.remove('icon-visible');
            flashIcon.classList.add('icon-fade-transition');

            if (type === 'success') {
                // Change to validated icon and green styling
                flashIcon.className = 'fas fa-check-circle text-green-500 text-2xl icon-fade-transition';
                flashIconContainer.className = 'bg-green-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4';
                flashCard.className = 'glass-card max-w-md w-full mx-auto p-8 rounded-2xl shadow-2xl text-center border border-green-200';
                flashTitle.textContent = 'Opération réussie';

                // Animate icon appearance
                setTimeout(() => {
                    flashIcon.classList.add('icon-visible');
                }, 50);
            } else {
                // Change to alert icon and red styling
                flashIcon.className = 'fas fa-exclamation-triangle text-red-500 text-2xl icon-fade-transition';
                flashIconContainer.className = 'bg-red-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4';
                flashCard.className = 'glass-card max-w-md w-full mx-auto p-8 rounded-2xl shadow-2xl text-center border border-red-200';
                flashTitle.textContent = 'Opération interrompue';

                // Animate icon appearance
                setTimeout(() => {
                    flashIcon.classList.add('icon-visible');
                }, 50);
            }

            // Show overlay with fade-in animation
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            overlay.style.animation = 'fadeIn 0.3s ease forwards';

            console.log("Current icon class:", flashIcon.className); // Debug log
        }

        closeFlash.addEventListener('click', () => {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
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

