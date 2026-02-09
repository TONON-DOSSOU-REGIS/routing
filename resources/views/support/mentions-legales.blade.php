<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions légales - SG BANK</title>
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
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Mentions légales
                </h1>
                <p class="text-xl mb-8 text-gray-100 leading-relaxed">
                    Informations légales et réglementaires concernant SG BANK
                    et nos services bancaires professionnels.
                </p>
            </div>
        </div>
    </section>

    <!-- Legal Content -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg max-w-none">

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">1. Éditeur du site</h2>
                    <div class="space-y-4 text-gray-700">
                        <p><strong>SG BANK SAS</strong></p>
                        <p>Société par actions simplifiée au capital de 1 000 000 €</p>
                        <p>RCS Paris : 123 456 789</p>
                        <p>N° TVA intracommunautaire : FR 12 345 678 901</p>
                        <p>Siège social : 123 Avenue des Champs-Élysées, 75008 Paris, France</p>
                        <p>Téléphone : 01 23 45 67 89</p>
                        <p>E-mail : contact@SG BANK.fr</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">2. Directeur de la publication</h2>
                    <div class="space-y-4 text-gray-700">
                        <p><strong>Jean Dupont</strong></p>
                        <p>Directeur Général de SG BANK SAS</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">3. Hébergement</h2>
                    <div class="space-y-4 text-gray-700">
                        <p><strong>OVHcloud</strong></p>
                        <p>SAS au capital de 10 069 020 €</p>
                        <p>RCS Lille Métropole 424 761 419 00045</p>
                        <p>Siège social : 2 rue Kellermann, 59100 Roubaix, France</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">4. Agréments et autorisations</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>SG BANK est enregistré auprès de l'Autorité de Contrôle Prudentiel et de Résolution (ACPR) :</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>N° d'enregistrement : 12345</li>
                            <li>Établissement de paiement agréé selon la directive DSP2</li>
                            <li>Membre du Fonds de Garantie des Dépôts et de Résolution</li>
                        </ul>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">5. Conditions générales d'utilisation</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>L'utilisation du site web SG BANK.fr et de nos services est soumise aux présentes conditions générales d'utilisation.</p>

                        <h3 class="text-xl font-semibold mt-6 mb-3">5.1 Acceptation des conditions</h3>
                        <p>L'accès et l'utilisation de ce site impliquent l'acceptation pleine et entière des présentes conditions générales d'utilisation.</p>

                        <h3 class="text-xl font-semibold mt-6 mb-3">5.2 Description des services</h3>
                        <p>SG BANK propose des services bancaires en ligne destinés aux professionnels : comptes courants, virements, cartes de paiement, gestion de trésorerie.</p>

                        <h3 class="text-xl font-semibold mt-6 mb-3">5.3 Responsabilités</h3>
                        <p>L'utilisateur est responsable de la confidentialité de ses identifiants de connexion et de toutes les opérations effectuées avec son compte.</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">6. Protection des données personnelles</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>Conformément au Règlement Général sur la Protection des Données (RGPD), SG BANK s'engage à :</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Collecter uniquement les données nécessaires aux services fournis</li>
                            <li>Traiter les données de manière licite, loyale et transparente</li>
                            <li>Assurer la sécurité des données par des mesures techniques appropriées</li>
                            <li>Respecter les droits des personnes concernées (accès, rectification, effacement)</li>
                            <li>Ne pas conserver les données au-delà de la durée nécessaire</li>
                        </ul>

                        <h3 class="text-xl font-semibold mt-6 mb-3">6.1 Données collectées</h3>
                        <p>Nous collectons : nom, prénom, adresse e-mail, numéro de téléphone, informations bancaires, données de connexion.</p>

                        <h3 class="text-xl font-semibold mt-6 mb-3">6.2 Finalités du traitement</h3>
                        <p>Les données sont utilisées pour : fournir les services bancaires, assurer la sécurité, respecter les obligations légales.</p>

                        <h3 class="text-xl font-semibold mt-6 mb-3">6.3 Destinataires des données</h3>
                        <p>Les données sont accessibles uniquement au personnel autorisé de SG BANK et à nos prestataires techniques.</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">7. Cookies</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>Le site SG BANK.fr utilise des cookies pour améliorer l'expérience utilisateur :</p>
                        <ul class="list-disc list-inside space-y-2 ml-4">
                            <li>Cookies techniques : nécessaires au fonctionnement du site</li>
                            <li>Cookies analytiques : mesure d'audience (Google Analytics)</li>
                            <li>Cookies fonctionnels : personnalisation de l'interface</li>
                        </ul>
                        <p>L'utilisateur peut gérer ses préférences cookies via les paramètres de son navigateur.</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">8. Propriété intellectuelle</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>Le site SG BANK.fr et son contenu sont protégés par le droit d'auteur et les droits de propriété intellectuelle.</p>
                        <p>La marque "SG BANK", le logo et tous les éléments graphiques sont la propriété exclusive de SG BANK SAS.</p>
                        <p>Toute reproduction, distribution ou exploitation commerciale est interdite sans autorisation préalable.</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">9. Responsabilité</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>SG BANK met tout en œuvre pour assurer la disponibilité et la sécurité de ses services.</p>
                        <p>Cependant, la responsabilité de SG BANK ne peut être engagée en cas d'interruption due à des circonstances extérieures (maintenance, panne technique, etc.).</p>
                        <p>L'utilisateur est responsable de l'utilisation qu'il fait des services et des conséquences de ses opérations bancaires.</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">10. Droit applicable et juridiction</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>Les présentes mentions légales sont soumises au droit français.</p>
                        <p>En cas de litige, les tribunaux de Paris seront seuls compétents.</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8 mb-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">11. Modification des mentions légales</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>SG BANK se réserve le droit de modifier les présentes mentions légales à tout moment.</p>
                        <p>Les modifications prendront effet immédiatement après leur publication sur le site.</p>
                        <p>L'utilisation continue du site après modification vaut acceptation des nouvelles conditions.</p>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8">
                    <h2 class="text-3xl font-bold mb-6 text-premium">12. Contact</h2>
                    <div class="space-y-4 text-gray-700">
                        <p>Pour toute question concernant ces mentions légales, contactez-nous :</p>
                        <ul class="list-none space-y-2">
                            <li><i class="fas fa-envelope mr-2 text-blue-600"></i> contact@SG BANK.fr</li>
                            <li><i class="fas fa-phone mr-2 text-blue-600"></i> 01 23 45 67 89</li>
                            <li><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> 123 Avenue des Champs-Élysées, 75008 Paris</li>
                        </ul>
                    </div>
                </div>

            </div>
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











