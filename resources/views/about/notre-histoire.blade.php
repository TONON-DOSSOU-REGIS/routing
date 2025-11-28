<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre histoire - SG BANK</title>
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
        .timeline-item { position: relative; padding-left: 2rem; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
        }
        .timeline-line {
            position: absolute;
            left: 0.5rem;
            top: 2rem;
            bottom: -2rem;
            width: 2px;
            background: linear-gradient(to bottom, #1e40af, #e5e7eb);
        }
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
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Notre histoire
                </h1>
                <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                    Depuis 2018, SG BANK révolutionne la banque en ligne pour les professionnels
                    avec une approche centrée sur la simplicité, la sécurité et l'innovation.
                </p>
            </div>
        </div>
    </section>

    <!-- Timeline -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">L'évolution de SG BANK</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Découvrez les moments clés qui ont façonné notre entreprise.
                </p>
            </div>

            <div class="space-y-12">
                <!-- 2018 -->
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="premium-card rounded-2xl p-8">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                            <div class="flex-shrink-0 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-blue-600">2018</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold mb-3 text-premium">Naissance de SG BANK</h3>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    Création de SG BANK par une équipe d'experts en finance et technologie.
                                    Notre vision : simplifier la gestion bancaire des entreprises grâce au numérique.
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-users mr-2"></i>
                                    <span>Équipe fondatrice de 5 personnes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2019 -->
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="premium-card rounded-2xl p-8">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                            <div class="flex-shrink-0 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-green-600">2019</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold mb-3 text-premium">Premier lancement commercial</h3>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    Ouverture de nos services aux premières entreprises clientes.
                                    Mise en place des fonctionnalités de base : virements SEPA et suivi des transactions.
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-rocket mr-2"></i>
                                    <span>500 premiers clients professionnels</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2020 -->
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="premium-card rounded-2xl p-8">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                            <div class="flex-shrink-0 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-orange-600">2020</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold mb-3 text-premium">Croissance accélérée</h3>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    Développement rapide pendant la crise sanitaire. Les entreprises découvrent
                                    les avantages de la banque digitale pour leur trésorerie.
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-chart-line mr-2"></i>
                                    <span>Croissance de 300% du nombre de clients</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2021 -->
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="premium-card rounded-2xl p-8">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                            <div class="flex-shrink-0 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-purple-600">2021</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold mb-3 text-premium">Expansion internationale</h3>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    Lancement des virements internationaux et ouverture à de nouveaux marchés européens.
                                    Certification bancaire officielle obtenue.
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-globe mr-2"></i>
                                    <span>Présence dans 15 pays européens</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2022 -->
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="premium-card rounded-2xl p-8">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                            <div class="flex-shrink-0 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-red-600">2022</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold mb-3 text-premium">Innovation technologique</h3>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    Intégration de l'IA pour la surveillance anti-fraude et lancement des cartes professionnelles.
                                    Interface utilisateur complètement repensée.
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-brain mr-2"></i>
                                    <span>IA intégrée pour la sécurité</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2023 -->
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="premium-card rounded-2xl p-8">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                            <div class="flex-shrink-0 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-indigo-600">2023</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold mb-3 text-premium">Maturité et reconnaissance</h3>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    10 000 clients actifs et reconnaissance par les institutions financières.
                                    Lancement des outils de gestion de trésorerie avancés.
                                </p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-award mr-2"></i>
                                    <span>10 000 clients satisfaits</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2024 -->
                <div class="timeline-item">
                    <div class="premium-card rounded-2xl p-8 border-2 border-blue-200">
                        <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                            <div class="flex-shrink-0 mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-white">2024</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold mb-3 text-premium">Aujourd'hui : Excellence continue</h3>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    SG BANK continue d'innover pour offrir la meilleure expérience bancaire digitale
                                    aux professionnels. Notre engagement : sécurité, simplicité et performance.
                                </p>
                                <div class="flex items-center text-sm text-blue-600 font-semibold">
                                    <i class="fas fa-star mr-2"></i>
                                    <span>Excellence et innovation au quotidien</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Nos valeurs fondamentales</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Les principes qui guident chacune de nos décisions depuis le premier jour.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Sécurité</h3>
                    <p class="text-gray-600 leading-relaxed">
                        La protection de vos données et de vos fonds est notre priorité absolue.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lightbulb text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Innovation</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Nous investissons constamment dans les technologies les plus avancées.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-handshake text-orange-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Transparence</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Frais clairs, processus transparents, communication honnête.
                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium">Proximité</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Un service client humain et réactif à votre écoute.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">L'équipe SG BANK</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Des experts passionnés qui travaillent chaque jour pour révolutionner la banque professionnelle.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center premium-card rounded-2xl p-8">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-tie text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-premium">Jean Dupont</h3>
                    <p class="text-gray-500 mb-4">Directeur Général</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Ancien banquier d'affaires avec 15 ans d'expérience dans la finance d'entreprise.
                    </p>
                </div>

                <div class="text-center premium-card rounded-2xl p-8">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-graduate text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-premium">Marie Leroy</h3>
                    <p class="text-gray-500 mb-4">Directrice Technique</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Experte en cybersécurité et architecte de solutions bancaires digitales.
                    </p>
                </div>

                <div class="text-center premium-card rounded-2xl p-8">
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-cog text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-premium">Pierre Martin</h3>
                    <p class="text-gray-500 mb-4">Responsable Produit</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Spécialiste UX/UI avec une passion pour l'amélioration de l'expérience client.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Rejoignez l'aventure SG BANK</h2>
            <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                Découvrez pourquoi des milliers d'entreprises nous font confiance pour leur gestion bancaire quotidienne.
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


