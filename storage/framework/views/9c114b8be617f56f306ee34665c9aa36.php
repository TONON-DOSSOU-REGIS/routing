<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('support.security_page_title')); ?></title>
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
    </style>
</head>
<body class="bg-gray-50">
  <?php echo $__env->make('components.background-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <nav class="nav-gradient shadow-xl fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg">
                        <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>"><img src='<?php echo e(asset("images/Logosite.png")); ?>' class="w-9 h-9" alt=""></a>
                    </div>
                    <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="text-2xl font-bold text-white"><span class="sr-only">Valtrix Bank</span></a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="text-white hover:text-blue-200 transition font-medium"><?php echo e(__('support.login')); ?></a>
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-6 py-3 rounded-lg font-semibold"><?php echo e(__('support.create_account')); ?></a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="mobile-menu md:hidden bg-blue-800 border-t border-blue-700 hidden">
                <div class="px-4 py-6 space-y-4">
                    <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="block text-white py-3 text-center"><?php echo e(__('support.login')); ?></a>
                    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="block text-white py-3 text-center"><?php echo e(__('support.create_account')); ?></a>
                </div>
            </div>
        </div>
    </nav>

    <section class="support-hero relative pt-32 pb-20 text-white" data-support-hero data-hero-tone="red">
        <?php echo $__env->make('components.support-hero-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="support-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6"><?php echo e(__('support.security_hero_title')); ?></h1>
                <p class="text-xl mb-8 text-red-100 leading-relaxed"><?php echo e(__('support.security_hero_subtitle')); ?></p>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__('support.security_overview_title')); ?></h2>
                <p class="text-xl text-gray-600 leading-relaxed"><?php echo e(__('support.security_overview_desc')); ?></p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="premium-card rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-lock text-red-600 text-3xl"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-premium"><?php echo e(__('support.security_card1_title')); ?></h3>
                    <p class="text-gray-600"><?php echo e(__('support.security_card1_desc')); ?></p>
                </div>
                <div class="premium-card rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-shield-alt text-blue-600 text-3xl"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-premium"><?php echo e(__('support.security_card2_title')); ?></h3>
                    <p class="text-gray-600"><?php echo e(__('support.security_card2_desc')); ?></p>
                </div>
                <div class="premium-card rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-user-check text-green-600 text-3xl"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-premium"><?php echo e(__('support.security_card3_title')); ?></h3>
                    <p class="text-gray-600"><?php echo e(__('support.security_card3_desc')); ?></p>
                </div>
                <div class="premium-card rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-server text-purple-600 text-3xl"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-premium"><?php echo e(__('support.security_card4_title')); ?></h3>
                    <p class="text-gray-600"><?php echo e(__('support.security_card4_desc')); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-gradient-to-r from-red-900 to-red-800 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6"><?php echo e(__('support.security_cta_title')); ?></h2>
            <p class="text-xl mb-8 text-red-100 leading-relaxed"><?php echo e(__('support.security_cta_desc')); ?></p>
            <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-premium px-12 py-5 rounded-lg text-2xl font-bold inline-block"><?php echo e(__('support.security_cta_btn')); ?></a>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6"><div class="text-center"><p>&copy; 2025 <span class="text-blue-400 font-semibold">Valtrix Bank</span>. <?php echo e(__('support.all_rights_reserved')); ?></p></div></div>
    </footer>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\support\securite.blade.php ENDPATH**/ ?>