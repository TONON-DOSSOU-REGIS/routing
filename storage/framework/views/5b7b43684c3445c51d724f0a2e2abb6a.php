<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('support.thank_you_title')); ?></title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .hero-bg { background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216'); background-size: cover; background-position: center; }
        .hero-overlay { background: linear-gradient(rgba(17, 24, 39, 0.75), rgba(17, 24, 39, 0.85)); }
        .bg-premium { background: linear-gradient(135deg, #667eea, #764ba2); }
        .bg-premium-dark { background: linear-gradient(135deg, #5a6fd8, #6a4190); }
    </style>
</head>
<body class="min-h-screen">
  <?php echo $__env->make('components.background-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <section class="hero-bg min-h-screen flex items-center justify-center relative">
        <div class="absolute inset-0 hero-overlay"></div>

        <div id="thankyou-card" class="relative z-10 max-w-xl w-full mx-4 bg-white rounded-2xl shadow-2xl p-10 opacity-0 translate-y-6 transition-all duration-700">
            <div class="flex justify-center mb-8">
                <div class="bg-green-100 text-green-600 p-5 rounded-full shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2c0 5.523-4.477 10-10 10S1 17.523 1 12 5.477 2 11 2s10 4.477 10 10z"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-6"><?php echo e(__('support.thank_you_message')); ?></h1>

            <p class="text-gray-600 text-center mb-8 leading-relaxed"><?php echo e(__('support.request_received')); ?></p>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-8">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                    <p class="text-blue-800 text-sm"><?php echo e(__('support.response_time')); ?></p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(localized_route('support.nous-contacter', ['locale' => app()->getLocale()])); ?>" class="bg-premium hover:bg-premium-dark text-white px-6 py-3 rounded-xl font-semibold shadow transition transform hover:-translate-y-1">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <?php echo e(__('support.back_to_form')); ?>

                </a>

                <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold shadow transition transform hover:-translate-y-1">
                    <i class="fas fa-home mr-2"></i>
                    <?php echo e(__('support.home')); ?>

                </a>
            </div>

            <div class="mt-10 pt-6 border-t text-center">
                <p class="text-gray-500 mb-4"><?php echo e(__('support.follow_us')); ?></p>
                <div class="flex justify-center gap-6 text-lg">
                    <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-pink-500"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-700"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.getElementById('thankyou-card');
            setTimeout(() => {
                card.classList.remove('opacity-0', 'translate-y-6');
            }, 150);
        });
    </script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\support\contact_thank_you.blade.php ENDPATH**/ ?>