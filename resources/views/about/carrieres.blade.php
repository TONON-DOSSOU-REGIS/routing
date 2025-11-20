<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrières - BankPro</title>
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
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-white">BankPro</a>
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
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-teal-900 via-teal-800 to-teal-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Rejoignez l'équipe BankPro
                </h1>
                <p class="text-xl mb-8 text-teal-100 leading-relaxed">
                    Construisez l'avenir de la banque digitale aux côtés d'une équipe passionnée.
                    Innovez, challengez le statu quo et faites partie d'une aventure exceptionnelle.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#jobs" class="btn-premium px-8 py-4 rounded-lg font-semibold text-center">
                        Voir les offres d'emploi
                    </a>
                    <a href="#culture" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-teal-900 transition text-center">
                        Notre culture d'entreprise
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join Us -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Pourquoi nous rejoindre ?</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Découvrez ce qui rend BankPro unique et pourquoi des talents choisissent de nous rejoindre.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-rocket text-teal-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Innovation constante</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Travaillez sur les technologies les plus avancées : IA, blockchain, fintech de nouvelle génération.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Équipe soudée</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Rejoignez une équipe de 50 passionnés où chacun contribue à la réussite collective.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-balance-scale text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Impact réel</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Vos décisions impactent directement des milliers d'entreprises et contribuent à l'économie.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-graduation-cap text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Formation continue</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Budget formation illimité et accès aux meilleures conférences tech internationales.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-home text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Télétravail flexible</h3>
                    <p class="text-gray-600 leading-relaxed">
                        3 jours de télétravail par semaine et horaires flexibles pour concilier vie pro/perso.
                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-euro-sign text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Rémunération attractive</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Salaires compétitifs, primes sur objectifs et participation aux bénéfices de l'entreprise.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Culture -->
    <section id="culture" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Notre culture d'entreprise</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Les valeurs qui guident notre quotidien et notre vision de l'avenir.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-bold mb-8 text-premium">Nos valeurs</h3>
                    <div class="space-y-6">
                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-lightbulb text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Innovation</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Nous challengeons constamment le statu quo bancaire pour créer des solutions meilleures.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-handshake text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Transparence</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Communication ouverte, décisions collectives et responsabilité partagée.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-users text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Collaboration</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Travail d'équipe, entraide et partage des connaissances au quotidien.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-2xl font-bold mb-8 text-premium">Notre environnement de travail</h3>
                    <div class="space-y-6">
                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-building text-orange-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Siège moderne</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Bâtiment haussmannien rénové au cœur de Paris avec espaces de coworking design.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-utensils text-red-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Avantages sociaux</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Tickets restaurant, mutuelle premium, salle de sport et événements d'équipe.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-card rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-seedling text-indigo-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2 text-premium">Engagement RSE</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Politique environnementale, dons aux associations et projets solidaires.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Openings -->
    <section id="jobs" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Postes ouverts</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Découvrez nos opportunités actuelles et rejoignez l'aventure BankPro.
                </p>
            </div>

            <div class="space-y-6">
                <!-- Job 1 -->
                <div class="premium-card rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1 mb-4 lg:mb-0">
                            <div class="flex items-center mb-3">
                                <h3 class="text-2xl font-bold text-premium mr-4">Développeur Full-Stack Senior</h3>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">CDI</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                Rejoignez notre équipe technique pour développer les nouvelles fonctionnalités de notre plateforme bancaire.
                                Technologies : Laravel, Vue.js, PostgreSQL, Docker.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">PHP</span>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Laravel</span>
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">Vue.js</span>
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-sm">Docker</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 lg:ml-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-premium">€55k - €75k</div>
                                <div class="text-sm text-gray-500">selon expérience</div>
                            </div>
                            <a href="#" class="btn-premium px-6 py-3 rounded-lg font-semibold text-center">
                                Postuler
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Job 2 -->
                <div class="premium-card rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1 mb-4 lg:mb-0">
                            <div class="flex items-center mb-3">
                                <h3 class="text-2xl font-bold text-premium mr-4">Product Manager</h3>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">CDI</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                Définissez la stratégie produit et pilotez le développement de nos solutions bancaires innovantes.
                                Travaillez main dans la main avec les équipes tech et business.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Product Strategy</span>
                                <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-sm">Agile</span>
                                <span class="bg-teal-100 text-teal-800 px-2 py-1 rounded text-sm">Fintech</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 lg:ml-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-premium">€60k - €80k</div>
                                <div class="text-sm text-gray-500">selon expérience</div>
                            </div>
                            <a href="#" class="btn-premium px-6 py-3 rounded-lg font-semibold text-center">
                                Postuler
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Job 3 -->
                <div class="premium-card rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1 mb-4 lg:mb-0">
                            <div class="flex items-center mb-3">
                                <h3 class="text-2xl font-bold text-premium mr-4">Data Scientist</h3>
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">CDI</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                Développez des modèles d'IA pour la détection de fraudes et l'analyse prédictive.
                                Technologies : Python, TensorFlow, scikit-learn, Spark.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Python</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">Machine Learning</span>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">TensorFlow</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 lg:ml-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-premium">€65k - €85k</div>
                                <div class="text-sm text-gray-500">selon expérience</div>
                            </div>
                            <a href="#" class="btn-premium px-6 py-3 rounded-lg font-semibold text-center">
                                Postuler
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Job 4 -->
                <div class="premium-card rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1 mb-4 lg:mb-0">
                            <div class="flex items-center mb-3">
                                <h3 class="text-2xl font-bold text-premium mr-4">UX/UI Designer</h3>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">CDI</span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                Concevez des interfaces intuitives pour nos applications bancaires.
                                Travaillez sur l'expérience utilisateur de milliers de clients professionnels.
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-pink-100 text-pink-800 px-2 py-1 rounded text-sm">Figma</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">Sketch</span>
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">User Research</span>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 lg:ml-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-premium">€45k - €65k</div>
                                <div class="text-sm text-gray-500">selon expérience</div>
                            </div>
                            <a href="#" class="btn-premium px-6 py-3 rounded-lg font-semibold text-center">
                                Postuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-6">Vous ne trouvez pas le poste idéal ?</p>
                <a href="mailto:recrutement@bankpro.fr" class="btn-premium px-8 py-4 rounded-lg font-semibold inline-block">
                    <i class="fas fa-envelope mr-2"></i>Envoyez-nous votre CV spontané
                </a>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-teal-900 to-teal-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Prêt à rejoindre l'aventure BankPro ?</h2>
            <p class="text-xl mb-8 text-teal-100 leading-relaxed">
                Construisez l'avenir de la fintech avec nous. L'innovation, la passion et l'excellence vous attendent.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#jobs" class="btn-premium px-8 py-4 rounded-lg font-semibold">
                    Voir les offres
                </a>
                <a href="mailto:recrutement@bankpro.fr" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-teal-900 transition">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <p>&copy; 2025 <span class="text-blue-400 font-semibold">BankPro</span>. Tous droits réservés.</p>
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
