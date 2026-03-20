<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('about.press_title')); ?> - Valtrix Bank</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <section class="support-hero relative pt-32 pb-20 text-white" data-support-hero data-hero-tone="slate">
        <?php echo $__env->make('components.support-hero-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="support-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    <?php echo e(__('about.press_hero_title')); ?>

                </h1>
                <p class="text-xl mb-8 text-slate-100 leading-relaxed">
                    <?php echo e(__('about.press_hero_description')); ?>

                </p>
            </div>
        </div>
    </section>

    <!-- Latest News -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Dernières actualités</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Restez informé des dernières évolutions de Valtrix Bank et de l'écosystème fintech.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- News Article 1 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Communiqué</span>
                            <span class="text-gray-500 text-sm ml-3">15 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">Valtrix Bank lève 50 millions d'euros</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Annonce d'une levée de fonds majeure pour accélérer l'expansion internationale et développer de nouvelles fonctionnalités.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>

                <!-- News Article 2 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                        <i class="fas fa-award text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Prix</span>
                            <span class="text-gray-500 text-sm ml-3">8 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">Prix Fintech Innovation 2024</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Valtrix Bank récompensée pour son système de surveillance anti-fraude par intelligence artificielle.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>

                <!-- News Article 3 -->
                <div class="premium-card rounded-2xl overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-users text-white text-4xl"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">Partenariat</span>
                            <span class="text-gray-500 text-sm ml-3">1 novembre 2024</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-premium">Nouveau partenariat bancaire</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Alliance stratégique avec une grande banque européenne pour étendre nos services transfrontaliers.
                        </p>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lire la suite →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Press Kit -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Kit presse</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Téléchargez nos ressources médias pour vos articles et reportages.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-image text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-premium">Logo Valtrix Bank</h3>
                    <p class="text-gray-600 text-sm mb-4">Pack complet des logos en haute résolution</p>
                    <button class="btn-premium px-4 py-2 rounded-lg font-semibold text-sm">
                        Télécharger
                    </button>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-pdf text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-premium">Fiche entreprise</h3>
                    <p class="text-gray-600 text-sm mb-4">Présentation complète de Valtrix Bank</p>
                    <button class="btn-premium px-4 py-2 rounded-lg font-semibold text-sm">
                        Télécharger
                    </button>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-photo-video text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-premium">Photos équipe</h3>
                    <p class="text-gray-600 text-sm mb-4">Galerie photo de l'équipe dirigeante</p>
                    <button class="btn-premium px-4 py-2 rounded-lg font-semibold text-sm">
                        Télécharger
                    </button>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold mb-2 text-premium">Infographies</h3>
                    <p class="text-gray-600 text-sm mb-4">Chiffres clés et statistiques</p>
                    <button class="btn-premium px-4 py-2 rounded-lg font-semibold text-sm">
                        Télécharger
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Press -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium">Contact presse</h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Pour toute demande d'information ou d'interview, contactez notre équipe presse.
                </p>
            </div>

            <div class="premium-card rounded-2xl p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold mb-6 text-premium">Responsable presse</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-user text-blue-600"></i>
                                <span class="font-semibold">Marie Dubois</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-envelope text-blue-600"></i>
                                <a href="mailto:presse@valtrixbank.fr" class="text-blue-600 hover:text-blue-800">presse@valtrixbank.fr</a>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-phone text-blue-600"></i>
                                <a href="tel:+33123456789" class="text-blue-600 hover:text-blue-800">01 23 45 67 89</a>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-2xl font-bold mb-6 text-premium">Adresse</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-map-marker-alt text-blue-600 mt-1"></i>
                                <div>
                                    <p>123 Avenue des Champs-Élysées</p>
                                    <p>75008 Paris, France</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-clock text-blue-600"></i>
                                <span>Lundi - Vendredi : 9h00 - 18h00</span>
                            </div>
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










<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\about\presse.blade.php ENDPATH**/ ?>