<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de trésorerie - SG BANK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-gradient { background: linear-gradient(90deg, #1e3a8a 0%, #1e40af 100%); }
        .text-premium { color: #1e3a8a; }
        .btn-premium { background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%); color: white; transition: all 0.3s ease; }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3); }
        .premium-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-50">
  @include('components.background-slider')
<!-- Navigation -->
    <nav class="nav-gradient shadow-xl fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg">
                        <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}"><img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
                    </div>
                    <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-2xl font-bold text-white"><span class="sr-only">SG BANK</span></a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="text-white hover:text-blue-200 transition font-medium">Connexion</a>
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-6 py-3 rounded-lg font-semibold">Créer un compte</a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="mobile-menu md:hidden bg-blue-800 border-t border-blue-700">
                <div class="px-4 py-6 space-y-4">
                    <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="block text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 text-center">Connexion</a>
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="block text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 text-center">Créer un compte</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Gestion de trésorerie SG BANK
                </h1>
                <p class="text-xl mb-8 text-purple-100 leading-relaxed">
                    Optimisez votre trésorerie d'entreprise avec des outils avancés de prévision,
                    suivi des encaissements et pilotage financier en temps réel.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-8 py-4 rounded-lg font-semibold text-center">
                        Accéder aux outils de trésorerie
                    </a>
                    <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-purple-900 transition text-center">
                        Découvrir les fonctionnalités
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Outils complets pour une gestion optimale</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Des solutions intégrées pour anticiper vos besoins de trésorerie et optimiser vos flux financiers.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Prévisions de trésorerie</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Analysez vos flux entrants et sortants pour anticiper vos besoins de trésorerie sur 12 mois.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Planification budgétaire</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Créez et suivez vos budgets mensuels avec alertes automatiques en cas de dépassement.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-sync text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Connexions bancaires</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Synchronisation automatique avec vos comptes bancaires pour un suivi en temps réel.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bell text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Alertes intelligentes</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Notifications personnalisées pour les échéances, soldes critiques et opportunités d'optimisation.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-invoice-dollar text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Gestion des factures</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Suivi automatisé des factures clients et fournisseurs avec relances intégrées.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-coins text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Optimisation des excédents</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Suggestions automatiques pour placer vos excédents de trésorerie de manière optimale.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Tableau de bord intuitif</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Visualisez votre trésorerie en un coup d'œil avec des graphiques clairs et des indicateurs pertinents.
                </p>
            </div>

            <div class="premium-card rounded-3xl p-8 max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold mb-2">€125,430</div>
                        <div class="text-sm opacity-90">Solde actuel</div>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold mb-2">€28,650</div>
                        <div class="text-sm opacity-90">Encaissements (30j)</div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold mb-2">€15,230</div>
                        <div class="text-sm opacity-90">Décaissements (30j)</div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-6 text-center">
                        <div class="text-2xl font-bold mb-2">+13.5%</div>
                        <div class="text-sm opacity-90">Croissance</div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="font-bold text-lg mb-4 text-premium">Prévision de trésorerie - 6 mois</h3>
                    <div class="h-64 bg-gradient-to-r from-blue-100 to-purple-100 rounded-lg flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-chart-area text-4xl mb-4"></i>
                            <p>Graphique de prévision de trésorerie</p>
                            <p class="text-sm">Visualisation interactive disponible dans votre espace client</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-purple-900 to-purple-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Prêt à optimiser votre trésorerie ?</h2>
            <p class="text-xl mb-8 text-purple-100 leading-relaxed">
                Rejoignez les entreprises qui font confiance à SG BANK pour piloter leur trésorerie efficacement.
            </p>
            <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-12 py-5 rounded-lg text-2xl font-bold inline-block">
                Commencer l'optimisation
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <p>&copy; 2025 <span class="text-blue-400 font-semibold">SG BANK</span>. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>











