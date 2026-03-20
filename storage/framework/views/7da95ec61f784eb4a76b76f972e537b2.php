<!DOCTYPE html>
<html lang="<?php echo e(str_replace("_", "-", app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__("services.cards_page_title")); ?></title>
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
                    <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="text-white hover:text-blue-200 transition font-medium"><?php echo e(__("services.nav_login")); ?></a>
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-6 py-3 rounded-lg font-semibold"><?php echo e(__("services.nav_register")); ?></a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="mobile-menu md:hidden bg-blue-800 border-t border-blue-700">
                <div class="px-4 py-6 space-y-4">
                    <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="block text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 text-center"><?php echo e(__("services.nav_login")); ?></a>
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="block text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 text-center"><?php echo e(__("services.nav_register")); ?></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="support-hero relative pt-32 pb-20 text-white" data-support-hero data-hero-tone="orange">
        <?php echo $__env->make('components.support-hero-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="support-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    <?php echo e(__("services.cards_hero_title")); ?>

                </h1>
                <p class="text-xl mb-8 text-orange-100 leading-relaxed">
                    <?php echo e(__("services.cards_hero_desc")); ?>

                    
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-8 py-4 rounded-lg font-semibold text-center">
                        <?php echo e(__("services.cards_hero_cta_primary")); ?>

                    </a>
                    <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-orange-900 transition text-center">
                        <?php echo e(__("services.cards_hero_cta_secondary")); ?>

                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__("services.cards_features_title")); ?></h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    <?php echo e(__("services.cards_features_desc")); ?>

                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-credit-card text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium"><?php echo e(__("services.cards_f1_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.cards_f1_desc")); ?>

                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-mobile-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium"><?php echo e(__("services.cards_f2_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.cards_f2_desc")); ?>

                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium"><?php echo e(__("services.cards_f3_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.cards_f3_desc")); ?>

                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium"><?php echo e(__("services.cards_f4_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.cards_f4_desc")); ?>

                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-pie text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium"><?php echo e(__("services.cards_f5_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.cards_f5_desc")); ?>

                    </p>
                </div>

                <div class="premium-card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-receipt text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-premium"><?php echo e(__("services.cards_f6_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.cards_f6_desc")); ?>

                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Card Types -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__("services.cards_choose_title")); ?></h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    <?php echo e(__("services.cards_choose_desc")); ?>

                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Basic Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white text-center">
                        <h3 class="text-2xl font-bold mb-2"><?php echo e(__("services.cards_plan_basic_title")); ?></h3>
                        <div class="text-3xl font-bold"><?php echo e(__("services.cards_plan_free")); ?></div>
                        <div class="text-sm opacity-90"><?php echo e(__("services.cards_plan_per_month")); ?></div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_b1")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_b2")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_b3")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-times text-gray-400 mr-3"></i>
                                <span class="text-gray-400"><?php echo e(__("services.cards_b4")); ?></span>
                            </li>
                        </ul>
                        <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium w-full py-3 rounded-lg font-semibold text-center block">
                            <?php echo e(__("services.cards_choose_btn")); ?>

                        </a>
                    </div>
                </div>

                <!-- Pro Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition relative">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 px-3 py-1 text-sm font-bold rounded-bl-lg">
                        <?php echo e(__("services.cards_plan_popular")); ?>

                    </div>
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white text-center">
                        <h3 class="text-2xl font-bold mb-2"><?php echo e(__("services.cards_plan_pro_title")); ?></h3>
                        <div class="text-3xl font-bold">&euro;9,90</div>
                        <div class="text-sm opacity-90"><?php echo e(__("services.cards_plan_per_month")); ?></div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_p1")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_p2")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_p3")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_p4")); ?></span>
                            </li>
                        </ul>
                        <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium w-full py-3 rounded-lg font-semibold text-center block">
                            <?php echo e(__("services.cards_choose_btn")); ?>

                        </a>
                    </div>
                </div>

                <!-- Enterprise Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white text-center">
                        <h3 class="text-2xl font-bold mb-2"><?php echo e(__("services.cards_plan_enterprise_title")); ?></h3>
                        <div class="text-3xl font-bold">&euro;19,90</div>
                        <div class="text-sm opacity-90"><?php echo e(__("services.cards_plan_per_month")); ?></div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_e1")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_e2")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_e3")); ?></span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span><?php echo e(__("services.cards_e4")); ?></span>
                            </li>
                        </ul>
                        <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium w-full py-3 rounded-lg font-semibold text-center block">
                            <?php echo e(__("services.cards_choose_btn")); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-orange-900 to-orange-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6"><?php echo e(__("services.cards_cta_title")); ?></h2>
            <p class="text-xl mb-8 text-orange-100 leading-relaxed">
                <?php echo e(__("services.cards_cta_desc")); ?>

            </p>
            <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-12 py-5 rounded-lg text-2xl font-bold inline-block">
                <?php echo e(__("services.cards_cta_btn")); ?>

            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center">
                <p>&copy; 2025 <span class="text-blue-400 font-semibold">Valtrix Bank</span>. <?php echo e(__("services.footer_rights")); ?></p>
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












<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\services\cartes-paiement.blade.php ENDPATH**/ ?>