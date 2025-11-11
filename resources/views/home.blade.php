<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BankPro - Banque en Ligne Professionnelle</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">BankPro</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Créer un compte</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-6">Votre Banque en Ligne Professionnelle</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">
                Ouvrez votre compte en quelques minutes et profitez de virements sécurisés, rapides, contrôlés et certifiés.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">Créer mon compte</a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600">Accéder à mon espace</a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sécurité bancaire AES 256-bit</h3>
                    <p class="text-gray-600">Vos données sont protégées par les plus hauts standards de sécurité.</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-eye text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Surveillance anti-fraude</h3>
                    <p class="text-gray-600">Système de surveillance 24/7 pour détecter toute activité suspecte.</p>
                </div>
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-play-circle text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Progression des virements supervisée</h3>
                    <p class="text-gray-600">Chaque virement est contrôlé par nos administrateurs pour votre sécurité.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Advantages -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Pourquoi choisir BankPro ?</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <i class="fas fa-home text-4xl text-blue-600 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Aucun déplacement nécessaire</h3>
                </div>
                <div class="text-center">
                    <i class="fas fa-clock text-4xl text-green-600 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Approbation rapide</h3>
                </div>
                <div class="text-center">
                    <i class="fas fa-check-circle text-4xl text-purple-600 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Virements contrôlés + reçu PDF</h3>
                </div>
                <div class="text-center">
                    <i class="fas fa-headset text-4xl text-orange-600 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-2">Support client humain</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">10,000+</div>
                    <div class="text-xl">Clients satisfaits</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">500M€</div>
                    <div class="text-xl">Volume de transactions</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="text-xl">Taux de satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à commencer ?</h2>
            <p class="text-xl text-gray-600 mb-8">Rejoignez des milliers de clients qui nous font confiance.</p>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-4 rounded-lg text-xl font-semibold hover:bg-blue-700">Commencer maintenant</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2024 BankPro. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
