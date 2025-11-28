<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virements Internationaux - SG BANK</title>
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
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-white">SG BANK</a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="btn-premium px-6 py-3 rounded-lg font-semibold">Créer un compte</a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="mobile-menu md:hidden bg-blue-800 border-t border-blue-700">
                <div class="px-4 py-6 space-y-4">
                    <a href="{{ route('login') }}" class="block text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 text-center">Connexion</a>
                    <a href="{{ route('register') }}" class="block text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 text-center">Créer un compte</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Virements Internationaux
                </h1>
                <p class="text-xl mb-8 text-emerald-100 leading-relaxed">
                    Envoyez de l'argent partout dans le monde avec des frais transparents,
                    des taux de change compétitifs et une exécution ultra-rapide.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="btn-premium px-8 py-4 rounded-lg font-semibold">
                        Commencer un virement
                    </a>
                    <a href="#fees" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-emerald-900 transition">
                        Voir les frais
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Pourquoi choisir SG BANK pour vos virements ?</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Des virements internationaux simples, rapides et sécurisés pour votre entreprise.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-globe text-emerald-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">180+ pays</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Couverture mondiale avec accès aux principales devises et marchés financiers.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bolt text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Exécution rapide</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Virements SEPA instantanés et virements SWIFT en 1-3 jours ouvrés.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-euro-sign text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Taux compétitifs</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Spreads réduits et frais transparents, meilleurs que les banques traditionnelles.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Sécurité maximale</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Chiffrement bancaire et conformité aux réglementations internationales.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Comment ça marche ?</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Effectuez vos virements internationaux en quelques clics seulement.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                        1
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Renseignez les détails</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Indiquez le bénéficiaire, le montant, la devise et la date d'exécution souhaitée.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                        2
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Validez et signez</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Confirmez le virement avec authentification forte et signature électronique.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                        3
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Suivez l'exécution</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Recevez des notifications en temps réel et un justificatif PDF à la fin.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fees Section -->
    <section id="fees" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Frais transparents</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Des tarifs clairs et compétitifs pour tous vos virements internationaux.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- SEPA -->
                <div class="premium-card rounded-2xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-euro-sign text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-premium">Virements SEPA</h3>
                            <p class="text-gray-600">Zone Euro - Instantané</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium">Frais fixes</span>
                            <span class="font-bold text-premium">0,50 €</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium">Délai d'exécution</span>
                            <span class="font-bold text-green-600">Instantané</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="font-medium">Plafond gratuit</span>
                            <span class="font-bold text-premium">500 €/mois</span>
                        </div>
                    </div>
                </div>

                <!-- SWIFT -->
                <div class="premium-card rounded-2xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-globe text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-premium">Virements SWIFT</h3>
                            <p class="text-gray-600">International - 1-3 jours</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium">Frais fixes</span>
                            <span class="font-bold text-premium">15 €</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium">Commission variable</span>
                            <span class="font-bold text-premium">0,15%</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="font-medium">Délai moyen</span>
                            <span class="font-bold text-blue-600">1-3 jours</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-6">Calcul automatique des frais selon le montant et la destination</p>
                <div class="inline-flex items-center bg-green-100 text-green-800 px-4 py-2 rounded-full">
                    <i class="fas fa-check mr-2"></i>
                    <span class="font-semibold">Aucun frais caché</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Supported Countries -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Pays et devises supportés</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Envoyez de l'argent vers plus de 180 pays avec conversion automatique.
                </p>
            </div>

            <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6">
                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">🇺🇸</div>
                    <h4 class="font-semibold text-premium">États-Unis</h4>
                    <p class="text-sm text-gray-600">USD</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">🇬🇧</div>
                    <h4 class="font-semibold text-premium">Royaume-Uni</h4>
                    <p class="text-sm text-gray-600">GBP</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">🇨🇭</div>
                    <h4 class="font-semibold text-premium">Suisse</h4>
                    <p class="text-sm text-gray-600">CHF</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">🇯🇵</div>
                    <h4 class="font-semibold text-premium">Japon</h4>
                    <p class="text-sm text-gray-600">JPY</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">🇨🇦</div>
                    <h4 class="font-semibold text-premium">Canada</h4>
                    <p class="text-sm text-gray-600">CAD</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">🇦🇺</div>
                    <h4 class="font-semibold text-premium">Australie</h4>
                    <p class="text-sm text-gray-600">AUD</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-6">Et bien d'autres pays encore...</p>
                <a href="{{ route('register') }}" class="btn-premium px-8 py-4 rounded-lg font-semibold">
                    Voir tous les pays supportés
                </a>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-emerald-900 to-emerald-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Prêt à effectuer votre premier virement international ?</h2>
            <p class="text-xl mb-8 text-emerald-100 leading-relaxed">
                Rejoignez des milliers d'entreprises qui font confiance à SG BANK pour leurs paiements internationaux.
                Inscription gratuite en 2 minutes.
            </p>
            <a href="{{ route('register') }}" class="btn-premium px-12 py-5 rounded-lg text-2xl font-bold inline-block">
                Créer mon compte
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


