<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous contacter - BankPro</title>
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
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-cyan-900 via-cyan-800 to-cyan-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    Nous contacter
                </h1>
                <p class="text-xl mb-8 text-cyan-100 leading-relaxed">
                    Notre équipe est à votre disposition pour répondre à toutes vos questions
                    et vous accompagner dans vos démarches bancaires.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Options -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Comment nous joindre ?</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Plusieurs moyens de nous contacter selon vos besoins et votre disponibilité.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-8 premium-card rounded-2xl hover:shadow-xl transition">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-phone text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Par téléphone</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Support téléphonique disponible du lundi au vendredi de 9h à 18h.
                    </p>
                    <div class="space-y-2">
                        <p class="font-semibold text-premium">01 23 45 67 89</p>
                        <p class="text-sm text-gray-500">Service client</p>
                    </div>
                </div>

                <div class="text-center p-8 premium-card rounded-2xl hover:shadow-xl transition">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-envelope text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Par e-mail</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Réponse garantie sous 24h ouvrées pour toutes vos demandes.
                    </p>
                    <div class="space-y-2">
                        <p class="font-semibold text-premium">support@bankpro.fr</p>
                        <p class="text-sm text-gray-500">Support général</p>
                    </div>
                </div>

                <div class="text-center p-8 premium-card rounded-2xl hover:shadow-xl transition">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-comments text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Chat en ligne</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Assistance instantanée via notre chat intégré disponible 24/7.
                    </p>
                    <div class="space-y-2">
                        <p class="font-semibold text-premium">Disponible maintenant</p>
                        <p class="text-sm text-gray-500">Réponse immédiate</p>
                    </div>
                </div>

                <div class="text-center p-8 premium-card rounded-2xl hover:shadow-xl transition">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-orange-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium">Sur rendez-vous</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Rencontrez notre équipe dans nos bureaux parisiens sur rendez-vous.
                    </p>
                    <div class="space-y-2">
                        <p class="font-semibold text-premium">Paris 8ème</p>
                        <p class="text-sm text-gray-500">Prise de RDV</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Envoyez-nous un message</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Remplissez ce formulaire et nous vous répondrons dans les plus brefs délais.
                </p>
            </div>

            <div class="premium-card rounded-2xl p-8">
                <form class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Prénom *</label>
                            <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nom *</label>
                            <input type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">E-mail *</label>
                            <input type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sujet *</label>
                        <select required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Sélectionnez un sujet</option>
                            <option value="support">Support technique</option>
                            <option value="commercial">Demande commerciale</option>
                            <option value="partnership">Partenariat</option>
                            <option value="press">Presse</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                        <textarea rows="6" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" placeholder="Décrivez votre demande..."></textarea>
                    </div>

                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="privacy" required class="mt-1">
                        <label for="privacy" class="text-sm text-gray-600 leading-relaxed">
                            J'accepte que mes données soient utilisées pour traiter ma demande conformément à la
                            <a href="#" class="text-blue-600 hover:text-blue-800">politique de confidentialité</a>.
                        </label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn-premium px-12 py-4 rounded-lg font-semibold text-lg">
                            Envoyer le message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Questions fréquentes</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Trouvez rapidement des réponses à vos questions les plus courantes.
                </p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6">
                <div class="premium-card rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-3 text-premium">Quels sont vos horaires d'ouverture ?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Notre service client est disponible du lundi au vendredi de 9h00 à 18h00 (heure de Paris).
                        Le chat en ligne est disponible 24h/24 et 7j/7.
                    </p>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-3 text-premium">Comment suivre l'état de mon virement ?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Connectez-vous à votre espace client pour suivre en temps réel l'état de vos virements.
                        Vous recevrez également des notifications par e-mail à chaque étape.
                    </p>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-3 text-premium">Puis-je modifier un virement en cours ?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Les virements peuvent être modifiés tant qu'ils n'ont pas été validés par nos administrateurs.
                        Contactez-nous rapidement si vous devez apporter des changements.
                    </p>
                </div>

                <div class="premium-card rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-3 text-premium">Comment récupérer mes identifiants ?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Utilisez le lien "Mot de passe oublié" sur la page de connexion.
                        Un e-mail de réinitialisation vous sera envoyé dans les minutes qui suivent.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Office Location -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold mb-6 text-premium">Nos bureaux</h2>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Situés en plein cœur de Paris, nos bureaux sont facilement accessibles
                        par les transports en commun et ouverts aux rendez-vous professionnels.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-premium mb-1">Adresse</h3>
                                <p class="text-gray-600">123 Avenue des Champs-Élysées<br>75008 Paris, France</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-premium mb-1">Horaires d'ouverture</h3>
                                <p class="text-gray-600">Lundi - Vendredi : 9h00 - 18h00<br>Samedi : Fermé<br>Dimanche : Fermé</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-subway text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-premium mb-1">Accès</h3>
                                <p class="text-gray-600">Métro : George V (ligne 1)<br>Bus : Lignes 73, 84<br>Parking : Q-Park Champs-Élysées</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="premium-card rounded-2xl p-8">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-map text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Carte interactive à venir</p>
                        </div>
                    </div>
                </div>
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
