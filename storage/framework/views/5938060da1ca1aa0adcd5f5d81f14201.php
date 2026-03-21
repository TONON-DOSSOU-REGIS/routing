<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('about.blog_title')); ?> - Valtrix Bank</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
  <?php echo $__env->make('components.background-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- Navigation -->
    <nav class="nav-gradient shadow-xl fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg">
                        <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>"><img src='<?php echo e(asset("images/Logosite.png")); ?>' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
                    </div>
                    <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="text-2xl font-bold text-white"><span class="sr-only">Valtrix Bank</span></a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="text-white hover:text-blue-200 transition font-medium"><?php echo e(__('about.nav_login')); ?></a>
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-6 py-3 rounded-lg font-semibold"><?php echo e(__('about.nav_register')); ?></a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="mobile-menu md:hidden bg-blue-800 border-t border-blue-700">
                <div class="px-4 py-6 space-y-4">
                    <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="block text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 text-center"><?php echo e(__('about.nav_login')); ?></a>
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="block text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 text-center"><?php echo e(__('about.nav_register')); ?></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="support-hero relative pt-32 pb-20 text-white" data-support-hero data-hero-tone="indigo">
        <?php echo $__env->make('components.support-hero-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="support-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    <?php echo e(__('about.blog_hero_title')); ?>

                </h1>
                <p class="text-xl mb-8 text-indigo-100 leading-relaxed">
                    <?php echo e(__('about.blog_hero_description')); ?>

                </p>
            </div>
        </div>
    </section>

    <!-- Featured Article -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="premium-card rounded-2xl overflow-hidden mb-16">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <div class="h-64 md:h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-chart-line text-white text-6xl"></i>
                        </div>
                    </div>
                    <div class="md:w-1/2 p-8">
                        <div class="flex items-center mb-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Article à la une</span>
                            <span class="text-gray-500 text-sm ml-4">15 novembre 2024</span>
                        </div>
                        <h2 class="text-3xl font-bold mb-4 text-premium">L'avenir de la banque digitale en 2025</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Découvrez les tendances qui façonneront le secteur bancaire : IA, blockchain,
                            open banking et expérience client digitale. Comment les entreprises peuvent-elles
                            s'adapter à ces changements ?
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-premium">Marie Dubois</p>
                                    <p class="text-sm text-gray-500">Directrice Innovation</p>
                                </div>
                            </div>
                            <a href="#" class="btn-premium px-6 py-3 rounded-lg font-semibold">
                                Lire l'article
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Posts -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Derniers articles</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Restez informé des dernières actualités et conseils en matière de finance d'entreprise.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Article 1 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                        <i class="fas fa-euro-sign text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-semibold">Financement</span>
                            <span class="text-gray-500 text-sm ml-3">12 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">Optimiser sa trésorerie en période d'inflation</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Stratégies pratiques pour protéger et faire fructifier votre trésorerie face à l'inflation.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>

                <!-- Article 2 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm font-semibold">Sécurité</span>
                            <span class="text-gray-500 text-sm ml-3">10 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">Cybersécurité : protéger son entreprise</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Les meilleures pratiques pour sécuriser vos données financières et éviter les cyberattaques.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>

                <!-- Article 3 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                        <i class="fas fa-globe text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-sm font-semibold">International</span>
                            <span class="text-gray-500 text-sm ml-3">8 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">Commerce international : choisir le bon partenaire bancaire</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Guide complet pour sélectionner une banque adaptée à vos besoins d'exportation.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>

                <!-- Article 4 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <i class="fas fa-robot text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-semibold">Innovation</span>
                            <span class="text-gray-500 text-sm ml-3">5 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">L'IA dans la gestion financière</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Comment l'intelligence artificielle transforme l'analyse financière et la prise de décision.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>

                <!-- Article 5 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center">
                        <i class="fas fa-handshake text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-semibold">Conseils</span>
                            <span class="text-gray-500 text-sm ml-3">3 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">Négocier avec sa banque : les clés du succès</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Astuces et stratégies pour obtenir les meilleures conditions bancaires pour votre entreprise.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>

                <!-- Article 6 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center">
                        <i class="fas fa-chart-pie text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-teal-100 text-teal-800 px-2 py-1 rounded text-sm font-semibold">Analyse</span>
                            <span class="text-gray-500 text-sm ml-3">1 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">Les tendances fintech à surveiller en 2025</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Panorama des innovations qui vont bouleverser le secteur bancaire dans les prochains mois.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="text-center mt-12">
                <div class="inline-flex space-x-2">
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Précédent</button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Suivant</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-24 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Restez informé</h2>
            <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                Abonnez-vous à notre newsletter pour recevoir nos derniers articles et conseils financiers directement dans votre boîte mail.
            </p>
            <div class="max-w-md mx-auto">
                <div class="flex">
                    <input type="email" placeholder="Votre adresse e-mail" class="flex-1 px-4 py-3 rounded-l-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <button class="btn-premium px-6 py-3 rounded-r-lg font-semibold">
                        S'abonner
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <p>&copy; 2025 <span class="text-blue-400 font-semibold">Valtrix Bank</span>. <?php echo e(__('about.footer_rights')); ?></p>
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









<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\about\blog.blade.php ENDPATH**/ ?>