<!DOCTYPE html>
<html lang="<?php echo e(str_replace("_", "-", app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__("services.intl_page_title")); ?></title>
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
    <section class="support-hero relative pt-32 pb-20 text-white" data-support-hero data-hero-tone="emerald">
        <?php echo $__env->make('components.support-hero-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="support-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto fade-in-up">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">
                    <?php echo e(__("services.intl_hero_title")); ?>

                </h1>
                <p class="text-xl mb-8 text-emerald-100 leading-relaxed">
                    <?php echo e(__("services.intl_hero_desc")); ?>

                    
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-8 py-4 rounded-lg font-semibold">
                        <?php echo e(__("services.intl_hero_cta_primary")); ?>

                    </a>
                    <a href="#fees" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-emerald-900 transition">
                        <?php echo e(__("services.intl_hero_cta_secondary")); ?>

                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__("services.intl_features_title")); ?></h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    <?php echo e(__("services.intl_features_desc")); ?>

                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-globe text-emerald-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium"><?php echo e(__("services.intl_f1_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.intl_f1_desc")); ?>

                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bolt text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium"><?php echo e(__("services.intl_f2_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.intl_f2_desc")); ?>

                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-euro-sign text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium"><?php echo e(__("services.intl_f3_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.intl_f3_desc")); ?>

                    </p>
                </div>

                <div class="text-center p-6">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium"><?php echo e(__("services.intl_f4_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.intl_f4_desc")); ?>

                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__("services.intl_how_title")); ?></h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    <?php echo e(__("services.intl_how_desc")); ?>

                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                        1
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium"><?php echo e(__("services.intl_step1_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.intl_step1_desc")); ?>

                    </p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                        2
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium"><?php echo e(__("services.intl_step2_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.intl_step2_desc")); ?>

                    </p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                        3
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-premium"><?php echo e(__("services.intl_step3_title")); ?></h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(__("services.intl_step3_desc")); ?>

                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fees Section -->
    <section id="fees" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__("services.intl_fees_title")); ?></h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    <?php echo e(__("services.intl_fees_desc")); ?>

                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- SEPA -->
                <div class="premium-card rounded-2xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-euro-sign text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-premium"><?php echo e(__("services.intl_sepa_title")); ?></h3>
                            <p class="text-gray-600"><?php echo e(__("services.intl_sepa_subtitle")); ?></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium"><?php echo e(__("services.intl_fee_fixed")); ?></span>
                            <span class="font-bold text-premium">0,50 &euro;</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium"><?php echo e(__("services.intl_exec_delay")); ?></span>
                            <span class="font-bold text-green-600"><?php echo e(__("services.intl_instant")); ?></span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="font-medium"><?php echo e(__("services.intl_free_limit")); ?></span>
                            <span class="font-bold text-premium">500 &euro;/<?php echo e(__("services.cards_plan_per_month")); ?></span>
                        </div>
                    </div>
                </div>

                <!-- SWIFT -->
                <div class="premium-card rounded-2xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-globe text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-premium"><?php echo e(__("services.intl_swift_title")); ?></h3>
                            <p class="text-gray-600"><?php echo e(__("services.intl_swift_subtitle")); ?></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium"><?php echo e(__("services.intl_fee_fixed")); ?></span>
                            <span class="font-bold text-premium">15 &euro;</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium"><?php echo e(__("services.intl_variable_fee")); ?></span>
                            <span class="font-bold text-premium">0,15%</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="font-medium"><?php echo e(__("services.intl_avg_delay")); ?></span>
                            <span class="font-bold text-blue-600"><?php echo e(__("services.intl_days_1_3")); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-6"><?php echo e(__("services.intl_fee_calc_note")); ?></p>
                <div class="inline-flex items-center bg-green-100 text-green-800 px-4 py-2 rounded-full">
                    <i class="fas fa-check mr-2"></i>
                    <span class="font-semibold"><?php echo e(__("services.intl_no_hidden_fee")); ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Supported Countries -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__("services.intl_countries_title")); ?></h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    <?php echo e(__("services.intl_countries_desc")); ?>

                </p>
            </div>

            <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6">
                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">US</div>
                    <h4 class="font-semibold text-premium"><?php echo e(__("services.intl_country_us")); ?></h4>
                    <p class="text-sm text-gray-600">USD</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">UK</div>
                    <h4 class="font-semibold text-premium"><?php echo e(__("services.intl_country_uk")); ?></h4>
                    <p class="text-sm text-gray-600">GBP</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">CH</div>
                    <h4 class="font-semibold text-premium"><?php echo e(__("services.intl_country_ch")); ?></h4>
                    <p class="text-sm text-gray-600">CHF</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">JP</div>
                    <h4 class="font-semibold text-premium"><?php echo e(__("services.intl_country_jp")); ?></h4>
                    <p class="text-sm text-gray-600">JPY</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">CA</div>
                    <h4 class="font-semibold text-premium"><?php echo e(__("services.intl_country_ca")); ?></h4>
                    <p class="text-sm text-gray-600">CAD</p>
                </div>

                <div class="premium-card rounded-xl p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-3">AU</div>
                    <h4 class="font-semibold text-premium"><?php echo e(__("services.intl_country_au")); ?></h4>
                    <p class="text-sm text-gray-600">AUD</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-6"><?php echo e(__("services.intl_more_countries")); ?></p>
                <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-8 py-4 rounded-lg font-semibold">
                    <?php echo e(__("services.intl_all_supported")); ?>

                </a>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-r from-emerald-900 to-emerald-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6"><?php echo e(__("services.intl_cta_title")); ?></h2>
            <p class="text-xl mb-8 text-emerald-100 leading-relaxed">
                <?php echo e(__("services.intl_cta_desc")); ?>

                
            </p>
            <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-12 py-5 rounded-lg text-2xl font-bold inline-block">
                <?php echo e(__("services.intl_cta_btn")); ?>

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











<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\services\virements-internationaux.blade.php ENDPATH**/ ?>