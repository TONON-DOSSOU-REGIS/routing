<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sécurité - SG BANK</title>
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
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-red-900 via-red-800 to-red-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Sécurité SG BANK
                </h1>
                <p class="text-xl mb-8 text-red-100 leading-relaxed">
                    La sécurité de vos données et de vos fonds est notre priorité absolue.
                    Découvrez nos mesures de protection avancées.
                </p>
            </div>
        </div>
    </section>

    <!-- Security Overview -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Une sécurité bancaire de niveau professionnel</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    SG BANK applique les standards de sécurité les plus élevés du secteur bancaire,
                    dépassant même les exigences réglementaires européennes.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lock text-red-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Chiffrement AES 256-bit</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Toutes vos données sont chiffrées avec le plus haut niveau de sécurité disponible.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Protection anti-fraude</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Système d'intelligence artificielle pour détecter et bloquer les activités suspectes.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-check text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Authentification forte</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Double authentification et biométrie pour sécuriser vos connexions.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-server text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Infrastructure sécurisée</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Serveurs certifiés hébergés dans des data centers de niveau bancaire.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Features -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Mesures de sécurité avancées</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Découvrez les technologies et processus qui protègent votre argent et vos données.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Technical Security -->
                <div>
                    <h3 class="text-2xl font-bold mb-8 text-premium">Sécurité technique</h3>
                    <div class="space-y-6">
                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-key text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Chiffrement de bout en bout</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Toutes les communications sont chiffrées avec des protocoles TLS 1.3 et des certificats EV.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-robot text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">IA anti-fraude</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Analyse en temps réel de tous les mouvements pour détecter les comportements inhabituels.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-database text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Stockage sécurisé</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Données stockées sur des serveurs certifiés ISO 27001 avec sauvegardes chiffrées.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Process Security -->
                <div>
                    <h3 class="text-2xl font-bold mb-8 text-premium">Sécurité des processus</h3>
                    <div class="space-y-6">
                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-shield text-orange-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Validation manuelle</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Tous les virements sensibles sont validés par nos administrateurs certifiés.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-bell text-red-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Alertes en temps réel</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Notifications immédiates pour toute activité suspecte sur votre compte.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-contract text-indigo-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Traçabilité complète</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Chaque action est journalisée avec horodatage pour une transparence totale.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Certifications -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Certifications et conformité</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    SG BANK respecte les normes les plus strictes du secteur bancaire et financier.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-certificate text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">ISO 27001</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Certification internationale pour la gestion de la sécurité de l'information.
                    </p>
                    <div class="flex items-center justify-center">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Certifié 2024
                        </span>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-euro-sign text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">DSP2 Compliant</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Conformité aux directives européennes de paiement (PSD2) pour la sécurité des paiements.
                    </p>
                    <div class="flex items-center justify-center">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Validé
                        </span>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lock text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">RGPD Compliant</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Respect total du Règlement Général sur la Protection des Données personnelles.
                    </p>
                    <div class="flex items-center justify-center">
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Conformité
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Tips -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Conseils de sécurité</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Quelques bonnes pratiques pour protéger votre compte SG BANK au quotidien.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-key text-red-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-premium">Mot de passe fort</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Utilisez un mot de passe complexe avec au moins 12 caractères, combinant lettres, chiffres et symboles.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-mobile-alt text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-premium">2FA activé</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Activez l'authentification à deux facteurs pour une protection supplémentaire de votre compte.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-eye text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-premium">Surveillance active</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Vérifiez régulièrement vos transactions et signalez immédiatement toute activité suspecte.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-wifi text-purple-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-premium">Connexions sécurisées</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Évitez les réseaux Wi-Fi publics pour vos opérations bancaires sensibles.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-orange-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-premium">E-mails de phishing</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Ne cliquez jamais sur les liens suspects et vérifiez toujours l'expéditeur des e-mails.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-sign-out-alt text-indigo-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-premium">Déconnexion</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Déconnectez-vous toujours de votre compte après utilisation, surtout sur ordinateurs partagés.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-red-900 to-red-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Votre sécurité est notre priorité</h2>
            <p class="text-xl mb-8 text-red-100 leading-relaxed">
                Avec SG BANK, vos données et vos fonds sont protégés par les technologies
                de sécurité les plus avancées du marché bancaire.
            </p>
            <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-12 py-5 rounded-lg text-2xl font-bold inline-block">
                Ouvrir un compte sécurisé
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











