<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo e(__('auth.pending_approval_title') ?? 'Pending Approval'); ?></title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io11/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io11/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io11/favicon-16x16.png">
  <link rel="manifest" href="/favicon_io11/site.webmanifest">
  <style>
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeInUp 0.9s ease-out forwards; }

    .glass {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
    }

    .btn-hover { transition: all 0.2s ease; }
    .btn-hover:hover { transform: translateY(-2px); }
  </style>
</head>

<body class="bg-slate-900 min-h-screen flex flex-col">
  <?php echo $__env->make('components.background-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- Hero background -->
  <div class="pointer-events-none fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 to-indigo-900/70"></div>
    <img alt="" class="w-full h-full object-cover opacity-30"
         src="https://images.unsplash.com/photo-1601597111158-2fceff292cdc?auto=format&amp;fit=crop&amp;w=1920&amp;q=80">
  </div>

  <!-- Navigation -->
  <nav class="relative z-50 bg-white/90 shadow-lg backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center space-x-2">
          <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>"><img src='<?php echo e(asset("images/Logosite.png")); ?>' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
          <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="text-xl font-semibold text-slate-800 hover:text-blue-700 transition"><span class="sr-only">Valtrix Bank</span></a>
        </div>
        <div class="flex items-center space-x-4">
          <?php echo $__env->make('components.language-selector', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg btn-hover shadow">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> <?php echo e(__('auth.nav_login')); ?>

          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <main class="flex-1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Left panel -->
        <div class="text-white fade-in-up">
          <h1 class="text-3xl sm:text-4xl font-extrabold">
            <?php echo e(__('auth.pending_approval_hero_title') ?? 'Account Under Review'); ?>

          </h1>
          <p class="mt-3 text-slate-200">
            <?php echo e(__('auth.pending_approval_hero_description') ?? 'Your account registration is being reviewed by our administrators. You will receive an email notification once your account is approved.'); ?>

          </p>
          <ul class="mt-6 space-y-3 text-slate-200">
            <li class="flex items-center"><i class="fa-solid fa-clock text-blue-300 mr-3"></i> <?php echo e(__('auth.pending_approval_feature_review') ?? 'Review in progress'); ?></li>
            <li class="flex items-center"><i class="fa-solid fa-envelope text-blue-300 mr-3"></i> <?php echo e(__('auth.pending_approval_feature_notification') ?? 'Email notification'); ?></li>
            <li class="flex items-center"><i class="fa-solid fa-shield-halved text-blue-300 mr-3"></i> <?php echo e(__('auth.pending_approval_feature_security') ?? 'Secure verification process'); ?></li>
          </ul>
        </div>

        <!-- Pending approval card -->
        <div class="glass rounded-2xl p-6 sm:p-8 text-white fade-in-up">
          <div class="text-center">
            <?php if(session('status')): ?>
              <div class="mb-6 rounded-lg border border-yellow-500/30 bg-yellow-500/15 px-4 py-3 text-sm text-yellow-100">
                <i class="fa-solid fa-circle-info mr-2 text-yellow-300"></i><?php echo e(session('status')); ?>

              </div>
            <?php endif; ?>
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-500/20 mb-4">
              <i class="fa-solid fa-clock text-yellow-400 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold mb-2"><?php echo e(__('auth.pending_approval_title') ?? 'Account Pending Approval'); ?></h2>
            <p class="text-slate-200 mb-6">
              <?php echo e(__('auth.pending_approval_message') ?? 'Thank you for registering with SG Bank. Your account is currently under review by our administrators. This process typically takes 24-48 hours.'); ?>

            </p>

            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-4 mb-6">
              <div class="flex items-center">
                <i class="fa-solid fa-info-circle text-yellow-400 mr-3"></i>
                <p class="text-sm text-yellow-200">
                  <?php echo e(__('auth.pending_approval_info') ?? 'You will receive an email notification once your account is approved and you can start using all banking services.'); ?>

                </p>
              </div>
            </div>

            <div class="space-y-3">
              <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>"
                 class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 btn-hover shadow-lg font-semibold block text-center">
                <?php echo e(__('auth.back_to_home') ?? 'Back to Home'); ?>

              </a>

              <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>"
                 class="w-full py-3 rounded-lg bg-slate-700 hover:bg-slate-600 btn-hover shadow-lg font-semibold block text-center">
                <?php echo e(__('auth.back_to_login') ?? 'Back to Login'); ?>

              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="mt-auto text-center text-slate-200 py-6 bg-black/40 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4">
      <p>&copy; <?php echo e(date('Y')); ?> <span class="text-blue-300 font-semibold">Valtrix Bank</span>. <?php echo e(__('auth.footer_copyright')); ?></p>
      <div class="mt-2 flex justify-center space-x-4 text-sm">
        <a href="#" class="hover:text-blue-300 transition"><?php echo e(__('auth.footer_privacy')); ?></a>
        <a href="#" class="hover:text-blue-300 transition"><?php echo e(__('auth.footer_terms')); ?></a>
        <a href="#" class="hover:text-blue-300 transition"><?php echo e(__('auth.footer_support')); ?></a>
      </div>
    </div>
  </footer>
</body>
</html>









<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\auth\pending-approval.blade.php ENDPATH**/ ?>