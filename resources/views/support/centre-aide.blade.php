<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre d'aide - SG BANK</title>
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
        .faq-item { border-radius: 0.75rem; border: 1px solid #e5e7eb; background-color: #ffffff; overflow: hidden; transition: box-shadow 0.3s ease, transform 0.3s ease, border-color 0.3s ease; }
        .faq-item.active { box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12); border-color: #1e40af; transform: translateY(-2px); }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
        .faq-answer.open { max-height: 500px; }
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
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-indigo-900 via-indigo-800 to-indigo-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Centre d'aide SG BANK
                </h1>
                <p class="text-xl mb-8 text-indigo-100 leading-relaxed">
                    Trouvez rapidement des réponses à vos questions.
                    Notre base de connaissances est à votre disposition 24/7.
                </p>

                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher dans l'aide..." class="w-full px-6 py-4 rounded-2xl text-gray-900 text-lg focus:outline-none focus:ring-4 focus:ring-indigo-300 shadow-xl">
                        <button class="absolute right-3 top-3 btn-premium px-6 py-2 rounded-xl font-semibold">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 text-premium">Actions rapides</h2>
                <p class="text-gray-600">Accédez directement aux solutions les plus demandées</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="#faq" class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-question-circle text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-premium">FAQ</h3>
                    <p class="text-gray-600 text-sm">Questions fréquentes</p>
                </a>

                <a href="#guides" class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-premium">Guides</h3>
                    <p class="text-gray-600 text-sm">Tutoriels détaillés</p>
                </a>

                <a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-premium">Support</h3>
                    <p class="text-gray-600 text-sm">Contacter l'équipe</p>
                </a>

                <a href="#status" class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-server text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-premium">Statut</h3>
                    <p class="text-gray-600 text-sm">État des services</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Popular Topics -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 text-premium">Sujets populaires</h2>
                <p class="text-gray-600">Les questions les plus fréquemment posées par nos clients</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-plus text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-premium">Créer un compte</h3>
                            <p class="text-gray-600 text-sm mb-3">Guide complet pour ouvrir votre compte professionnel SG BANK.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lire le guide →</a>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-paper-plane text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-premium">Effectuer un virement</h3>
                            <p class="text-gray-600 text-sm mb-3">Comment réaliser un virement SEPA ou international en toute sécurité.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lire le guide →</a>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-credit-card text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-premium">Commander une carte</h3>
                            <p class="text-gray-600 text-sm mb-3">Tout savoir sur nos cartes professionnelles et virtuelles.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lire le guide →</a>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-alt text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-premium">Sécurité du compte</h3>
                            <p class="text-gray-600 text-sm mb-3">Protégez votre compte avec nos meilleures pratiques de sécurité.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lire le guide →</a>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-invoice-dollar text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-premium">Justificatifs et reçus</h3>
                            <p class="text-gray-600 text-sm mb-3">Comment obtenir et gérer vos justificatifs de paiement PDF.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lire le guide →</a>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-chart-line text-indigo-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2 text-premium">Tableau de bord</h3>
                            <p class="text-gray-600 text-sm mb-3">Découvrez toutes les fonctionnalités de votre espace client.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lire le guide →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Questions fréquentes</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Retrouvez les réponses aux questions les plus courantes sur SG BANK.
                </p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6" id="faq-list">
                <!-- FAQ Item -->
                <div class="faq-item">
                    <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
                        <div>
                            <p class="font-bold text-xl text-gray-800">Comment ouvrir un compte sur SG BANK ?</p>
                            <p class="text-gray-500 mt-2">Inscription simple en quelques étapes.</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
                    </button>
                    <div class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Cliquez sur « Créer un compte », remplissez le formulaire avec vos informations
                            (nom, e-mail, téléphone, etc.), confirmez votre adresse e-mail, puis accédez à votre
                            espace sécurisé pour réaliser vos premières opérations.
                        </p>
                        <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-premium px-4 py-2 rounded-lg font-semibold text-sm">
                            Créer un compte
                        </a>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
                        <div>
                            <p class="font-bold text-xl text-gray-800">Mes virements sont-ils vraiment surveillés ?</p>
                            <p class="text-gray-500 mt-2">Suivi et contrôle manuel des opérations.</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
                    </button>
                    <div class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Oui. Chaque virement passe par plusieurs étapes de validation. Les administrateurs SG BANK
                            peuvent contrôler et certifier les opérations sensibles, ce qui réduit fortement les risques d'erreur ou de fraude.
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
                        <div>
                            <p class="font-bold text-xl text-gray-800">Puis-je télécharger un reçu pour chaque virement ?</p>
                            <p class="text-gray-500 mt-2">Justificatif PDF disponible.</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
                    </button>
                    <div class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Bien sûr. Une fois le virement finalisé et certifié, un reçu PDF est généré automatiquement.
                            Vous pouvez le télécharger, l'imprimer ou le partager avec vos partenaires.
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
                        <div>
                            <p class="font-bold text-xl text-gray-800">Que faire en cas de problème ou de doute ?</p>
                            <p class="text-gray-500 mt-2">Support humain disponible.</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
                    </button>
                    <div class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Vous pouvez contacter notre support client via votre espace sécurisé ou par les coordonnées
                            indiquées sur le site. Un conseiller vous répondra dans les meilleurs délais.
                        </p>
                        <a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="btn-premium px-4 py-2 rounded-lg font-semibold text-sm">
                            Nous contacter
                        </a>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
                        <div>
                            <p class="font-bold text-xl text-gray-800">Quels sont les frais de SG BANK ?</p>
                            <p class="text-gray-500 mt-2">Transparence totale sur les tarifs.</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
                    </button>
                    <div class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            SG BANK applique une politique de transparence totale. Les frais sont clairement affichés
                            avant chaque opération. Pas de frais cachés, pas de mauvaises surprises.
                        </p>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
                        <div>
                            <p class="font-bold text-xl text-gray-800">Mes données sont-elles sécurisées ?</p>
                            <p class="text-gray-500 mt-2">Protection maximale des données.</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
                    </button>
                    <div class="faq-answer px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Absolument. SG BANK utilise le chiffrement AES 256-bit, conforme aux standards bancaires
                            européens. Vos données sont stockées sur des serveurs sécurisés et ne sont jamais partagées.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-24 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Besoin d'aide supplémentaire ?</h2>
            <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                Notre équipe de support est là pour vous accompagner dans toutes vos démarches.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="btn-premium px-8 py-4 rounded-lg font-semibold">
                    Contacter le support
                </a>
                <a href="tel:+33123456789" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-900 transition">
                    <i class="fas fa-phone mr-2"></i>01 23 45 67 89
                </a>
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

        // FAQ Accordion
        const faqItems = document.querySelectorAll('#faq-list .faq-item');

        faqItems.forEach(item => {
            const button = item.querySelector('button');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('i.fas.fa-chevron-down');

            button.addEventListener('click', function() {
                const isOpen = answer.classList.contains('open');

                // Fermer toutes les FAQ
                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    const otherIcon = otherItem.querySelector('i.fas.fa-chevron-down');
                    if (otherAnswer) otherAnswer.classList.remove('open');
                    if (otherIcon) otherIcon.classList.remove('rotate-180');
                });

                // Si ce n'était pas ouvert, on l'ouvre
                if (!isOpen) {
                    item.classList.add('active');
                    answer.classList.add('open');
                    icon.classList.add('rotate-180');
                }
            });
        });
    </script>

</body>
</html>


