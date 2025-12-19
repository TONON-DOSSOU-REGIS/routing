<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartes de paiement - SG BANK</title>
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

    <!-- Navigation -->
    <nav class="nav-gradient shadow-xl fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg">
                        <i class="fas fa-building-columns text-premium text-2xl"></i>
                    </div>
                    <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-2xl font-bold text-white">SG BANK</a>
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
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-orange-900 via-orange-800 to-orange-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Cartes de paiement SG BANK
                </h1>
                <p class="text-xl mb-8 text-orange-100 leading-relaxed">
                    Des cartes professionnelles et virtuelles pour vos dépenses quotidiennes,
                    avec contrôle des budgets et sécurité renforcée.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-8 py-4 rounded-lg font-semibold text-center">
                        Commander une carte
                    </a>
                    <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-orange-900 transition text-center">
                        Découvrir les avantages
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Solutions de paiement adaptées à vos besoins</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Cartes physiques et virtuelles pour une gestion optimale de vos dépenses professionnelles.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-credit-card text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Carte professionnelle</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Carte physique premium avec design personnalisable et fonctionnalités avancées.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-mobile-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Cartes virtuelles</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Générez des cartes temporaires pour vos achats en ligne avec limites personnalisées.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Cartes équipe</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Distribuez des cartes à vos collaborateurs avec des budgets et contrôles individualisés.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Sécurité avancée</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Blocage instantané en cas de suspicion, alertes en temps réel et contrôle parental.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-pie text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Contrôle budgétaire</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Définissez des limites de dépenses par carte, catégorie ou période avec alertes.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-receipt text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Suivi des dépenses</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Rapports détaillés et justificatifs automatiques pour toutes vos transactions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Card Types -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Choisissez votre carte idéale</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Différentes formules adaptées à vos besoins professionnels.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Basic Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white text-center">
                        <h3 class="text-2xl font-bold mb-2">Carte Essentielle</h3>
                        <div class="text-3xl font-bold">Gratuite</div>
                        <div class="text-sm opacity-90">par mois</div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Carte virtuelle incluse</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Suivi des transactions</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Support par e-mail</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-times text-gray-400 mr-3"></i>
                                <span class="text-gray-400">Carte physique</span>
                            </li>
                        </ul>
                        <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium w-full py-3 rounded-lg font-semibold text-center block">
                            Choisir cette carte
                        </a>
                    </div>
                </div>

                <!-- Pro Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition relative">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 px-3 py-1 text-sm font-bold rounded-bl-lg">
                        POPULAIRE
                    </div>
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white text-center">
                        <h3 class="text-2xl font-bold mb-2">Carte Professionnelle</h3>
                        <div class="text-3xl font-bold">€9,90</div>
                        <div class="text-sm opacity-90">par mois</div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Carte physique premium</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Cartes virtuelles illimitées</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Contrôle budgétaire avancé</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Support prioritaire</span>
                            </li>
                        </ul>
                        <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium w-full py-3 rounded-lg font-semibold text-center block">
                            Choisir cette carte
                        </a>
                    </div>
                </div>

                <!-- Enterprise Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white text-center">
                        <h3 class="text-2xl font-bold mb-2">Carte Entreprise</h3>
                        <div class="text-3xl font-bold">€19,90</div>
                        <div class="text-sm opacity-90">par mois</div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Cartes équipe illimitées</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>API de paiement intégrée</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Reporting avancé</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Manager dédié</span>
                            </li>
                        </ul>
                        <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium w-full py-3 rounded-lg font-semibold text-center block">
                            Choisir cette carte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-orange-900 to-orange-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Prêt à simplifier vos paiements professionnels ?</h2>
            <p class="text-xl mb-8 text-orange-100 leading-relaxed">
                Rejoignez les entreprises qui font confiance à SG BANK pour leurs solutions de paiement modernes.
            </p>
            <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-12 py-5 rounded-lg text-2xl font-bold inline-block">
                Commander ma carte
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


