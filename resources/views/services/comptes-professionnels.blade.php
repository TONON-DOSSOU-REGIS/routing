<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptes professionnels - SG BANK</title>
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
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Comptes professionnels SG BANK
                </h1>
                <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                    Des solutions bancaires adaptées aux besoins des entreprises et professionnels.
                    Sécurité, rapidité et contrôle total de vos opérations financières.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-8 py-4 rounded-lg font-semibold text-center">
                        Ouvrir un compte professionnel
                    </a>
                    <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-900 transition text-center">
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
                <h2 class="text-4xl font-bold mb-6 text-premium">Pourquoi choisir un compte professionnel SG BANK ?</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Des fonctionnalités avancées conçues spécifiquement pour les besoins des entreprises modernes.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-premium text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Sécurité renforcée</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Protection avancée avec authentification multi-facteurs et surveillance 24/7 de vos comptes.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bolt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Virements instantanés</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Effectuez des virements SEPA instantanés et suivez leur progression en temps réel.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Tableau de bord avancé</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Analysez vos flux financiers avec des rapports détaillés et des graphiques intuitifs.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Gestion multi-utilisateurs</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Créez des accès différenciés pour vos collaborateurs avec des droits personnalisés.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-invoice-dollar text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Facturation automatique</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Générez des factures professionnelles et recevez des justificatifs PDF certifiés.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-headset text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Support prioritaire</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Assistance téléphonique dédiée et chat en ligne pour vos opérations urgentes.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Prêt à digitaliser votre trésorerie ?</h2>
            <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                Rejoignez les milliers d'entreprises qui font confiance à SG BANK pour leur gestion bancaire quotidienne.
            </p>
            <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-12 py-5 rounded-lg text-2xl font-bold inline-block">
                Créer mon compte professionnel
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











