<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e(__('home.page_title')); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <style>
    /* Police et fondations visuelles */
    body {
      font-family: 'Inter', sans-serif;
    }

    /* Animations fluides */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeInUp 1s ease forwards; }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    .fade-in { animation: fadeIn 1.5s ease forwards; }

    /* Parallaxe douce */
    .parallax {
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    /* Hero Background Slideshow */
    .hero-bg {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
    }

    .bg-slide {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      opacity: 0;
      transition: opacity 1.8s ease-in-out;
    }

    .bg-slide.active {
      opacity: 1;
    }

    /* Témoignages slider */
    .testimonial-slide {
      opacity: 0;
      transform: translateX(20px);
      transition: opacity 0.6s ease, transform 0.6s ease;
      display: none;
    }

    .testimonial-slide.active {
      opacity: 1;
      transform: translateX(0);
      display: block;
    }

    .testimonial-dot {
      width: 10px;
      height: 10px;
      border-radius: 999px;
      border: 2px solid #1e40af;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .testimonial-dot.active {
      background-color: #1e40af;
      transform: scale(1.15);
    }

    /* Partenaires – défilement doux */
    @keyframes marquee {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }

    .partners-marquee {
      display: flex;
      width: 200%;
      animation: marquee 25s linear infinite;
    }

    /* FAQ */
    .faq-item {
      border-radius: 0.75rem;
      border: 1px solid #e5e7eb;
      background-color: #ffffff;
      overflow: hidden;
      transition: box-shadow 0.3s ease, transform 0.3s ease, border-color 0.3s ease;
    }
    .faq-item.active {
      box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
      border-color: #1e40af;
      transform: translateY(-2px);
    }
    .faq-answer {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.35s ease;
    }
    .faq-answer.open {
      max-height: 300px;
    }

    /* Améliorations spécifiques pour un aspect premium */
    .gradient-bg {
      background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
    }
    
    .premium-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .nav-gradient {
      background: linear-gradient(90deg, #1e3a8a 0%, #1e40af 100%);
    }
    
    .text-premium {
      color: #1e3a8a;
    }
    
    .border-premium {
      border-color: #1e40af;
    }
    
    .btn-premium {
      background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
      color: white;
      transition: all 0.3s ease;
    }
    
    .btn-premium:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3);
    }

    .btn-auth {
      background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
      color: #ffffff;
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px rgba(249, 115, 22, 0.25);
    }

    .btn-auth:hover {
      background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
      transform: translateY(-2px);
      box-shadow: 0 14px 28px rgba(249, 115, 22, 0.35);
    }
    
    .section-divider {
      height: 1px;
      background: linear-gradient(90deg, transparent 0%, #e5e7eb 50%, transparent 100%);
    }
    
    .stat-card {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
      background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
      color: white;
    }
    
    .security-badge {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
    }

    /* Menu mobile amélioré avec animation fluide */
    .mobile-menu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      transform: translateY(-10px);
      opacity: 0;
    }
    
    .mobile-menu.open {
      max-height: 90vh;
      transform: translateY(0);
      opacity: 1;
      transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), 
                  transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                  opacity 0.3s ease;
    }
    
    .mobile-menu-item {
      transform: translateX(-20px);
      opacity: 0;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }
    
    .mobile-menu.open .mobile-menu-item {
      transform: translateX(0);
      opacity: 1;
    }
    
    .mobile-menu.open .mobile-menu-item:nth-child(1) {
      transition-delay: 0.1s;
    }
    
    .mobile-menu.open .mobile-menu-item:nth-child(2) {
      transition-delay: 0.2s;
    }

    .mobile-menu-link {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      text-align: left;
    }

    .mobile-submenu {
      margin-left: 0.25rem;
      padding-left: 0.75rem;
      border-left: 2px solid rgba(255, 255, 255, 0.15);
    }

    .mobile-submenu a {
      text-align: left;
    }
    
    /* Animation pour les compteurs */
    @keyframes countUp {
      from {
        transform: translateY(20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
    
    .count-animation {
      animation: countUp 1s ease forwards;
    }
    
    /* Bouton menu avec animation */
    .menu-button {
      transition: all 0.3s ease;
    }
    
    .menu-button.active {
      transform: rotate(90deg);
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

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
        
        <!-- Menu Desktop -->
        <div class="hidden md:flex items-center space-x-6">
          <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="text-white hover:text-blue-200 transition font-medium"><?php echo e(__('home.nav_home')); ?></a>
          <div class="relative group">
            <button class="text-white hover:text-blue-200 transition font-medium inline-flex items-center">
              <?php echo e(__('home.nav_services')); ?>

              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 translate-y-1 transition-all duration-300 pointer-events-none group-hover:pointer-events-auto">
              <a href="<?php echo e(localized_route('services.comptes-professionnels', ['locale' => app()->getLocale()])); ?>" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-900"><?php echo e(__('home.services_business_accounts')); ?></a>
              <a href="<?php echo e(localized_route('services.virements-internationaux', ['locale' => app()->getLocale()])); ?>" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-900"><?php echo e(__('home.services_international_transfers')); ?></a>
              <a href="<?php echo e(localized_route('services.gestion-tresorerie', ['locale' => app()->getLocale()])); ?>" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-900"><?php echo e(__('home.services_treasury_management')); ?></a>
              <a href="<?php echo e(localized_route('services.cartes-paiement', ['locale' => app()->getLocale()])); ?>" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-900"><?php echo e(__('home.services_payment_cards')); ?></a>
            </div>
          </div>
          <a href="#testimonial-slider" class="text-white hover:text-blue-200 transition font-medium"><?php echo e(__('home.nav_testimonials')); ?></a>
          <a href="#faq-list" class="text-white hover:text-blue-200 transition font-medium"><?php echo e(__('home.nav_faq')); ?></a>
          <a href="<?php echo e(localized_route('support.nous-contacter', ['locale' => app()->getLocale()])); ?>" class="text-white hover:text-blue-200 transition font-medium"><?php echo e(__('home.nav_contact')); ?></a>
          <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="btn-auth px-6 py-3 rounded-lg font-semibold"><?php echo e(__('home.nav_login')); ?></a>
          <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-auth px-6 py-3 rounded-lg font-semibold"><?php echo e(__('home.nav_register')); ?></a>
          <?php if (isset($component)) { $__componentOriginal27dc6277b85491d47ded5f7c284c1a13 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27dc6277b85491d47ded5f7c284c1a13 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.language-selector','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('language-selector'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27dc6277b85491d47ded5f7c284c1a13)): ?>
<?php $attributes = $__attributesOriginal27dc6277b85491d47ded5f7c284c1a13; ?>
<?php unset($__attributesOriginal27dc6277b85491d47ded5f7c284c1a13); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27dc6277b85491d47ded5f7c284c1a13)): ?>
<?php $component = $__componentOriginal27dc6277b85491d47ded5f7c284c1a13; ?>
<?php unset($__componentOriginal27dc6277b85491d47ded5f7c284c1a13); ?>
<?php endif; ?>
        </div>
        
        <!-- Bouton Menu Mobile -->
        <div class="md:hidden flex items-center">
          <button id="mobile-menu-button" class="menu-button text-white focus:outline-none p-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-bars text-2xl"></i>
          </button>
        </div>
      </div>
      
      <!-- Menu Mobile -->
      <div id="mobile-menu" class="mobile-menu md:hidden bg-blue-800 border-t border-blue-700">
        <div class="px-4 py-6 space-y-4">
          <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="mobile-menu-item mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400">
            <span><?php echo e(__('home.nav_home')); ?></span>
          </a>
          <div class="mobile-menu-item relative group">
            <button class="w-full mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 inline-flex items-center justify-between" type="button">
              <span><?php echo e(__('home.nav_services')); ?></span>
              <svg class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div class="mobile-submenu hidden flex flex-col bg-blue-900/80 border border-blue-700 rounded-md mt-2 p-2 space-y-1">
              <a href="<?php echo e(localized_route('services.comptes-professionnels', ['locale' => app()->getLocale()])); ?>" class="block px-4 py-2 text-white hover:bg-blue-700 hover:text-white rounded-md"><?php echo e(__('home.services_business_accounts')); ?></a>
              <a href="<?php echo e(localized_route('services.virements-internationaux', ['locale' => app()->getLocale()])); ?>" class="block px-4 py-2 text-white hover:bg-blue-700 hover:text-white rounded-md"><?php echo e(__('home.services_international_transfers')); ?></a>
              <a href="<?php echo e(localized_route('services.gestion-tresorerie', ['locale' => app()->getLocale()])); ?>" class="block px-4 py-2 text-white hover:bg-blue-700 hover:text-white rounded-md"><?php echo e(__('home.services_treasury_management')); ?></a>
              <a href="<?php echo e(localized_route('services.cartes-paiement', ['locale' => app()->getLocale()])); ?>" class="block px-4 py-2 text-white hover:bg-blue-700 hover:text-white rounded-md"><?php echo e(__('home.services_payment_cards')); ?></a>
            </div>
          </div>
          <a href="#testimonial-slider" class="mobile-menu-item mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400">
            <span><?php echo e(__('home.nav_testimonials')); ?></span>
          </a>
          <a href="#faq-list" class="mobile-menu-item mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400">
            <span><?php echo e(__('home.nav_faq')); ?></span>
          </a>
          <a href="<?php echo e(localized_route('support.nous-contacter', ['locale' => app()->getLocale()])); ?>" class="mobile-menu-item mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400">
            <span><?php echo e(__('home.nav_contact')); ?></span>
          </a>
          <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="mobile-menu-item btn-auth block font-semibold py-3 px-4 rounded-lg text-center"><?php echo e(__('home.nav_login')); ?></a>
          <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="mobile-menu-item btn-auth block font-semibold py-3 px-4 rounded-lg text-center"><?php echo e(__('home.nav_register')); ?></a>
          <div class="mobile-menu-item">
            <?php if (isset($component)) { $__componentOriginal27dc6277b85491d47ded5f7c284c1a13 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27dc6277b85491d47ded5f7c284c1a13 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.language-selector','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('language-selector'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27dc6277b85491d47ded5f7c284c1a13)): ?>
<?php $attributes = $__attributesOriginal27dc6277b85491d47ded5f7c284c1a13; ?>
<?php unset($__attributesOriginal27dc6277b85491d47ded5f7c284c1a13); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27dc6277b85491d47ded5f7c284c1a13)): ?>
<?php $component = $__componentOriginal27dc6277b85491d47ded5f7c284c1a13; ?>
<?php unset($__componentOriginal27dc6277b85491d47ded5f7c284c1a13); ?>
<?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative text-white pt-32 pb-32 overflow-hidden">
    <!-- Background Images Container -->
    <div class="hero-bg">
      <div class="bg-slide active" style="background-image: url('https://images.pexels.com/photos/259249/pexels-photo-259249.jpeg');"></div>
      <div class="bg-slide" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1920&q=80');"></div>
      <div class="bg-slide" style="background-image: url('https://images.pexels.com/photos/3184338/pexels-photo-3184338.jpeg');"></div>
      <div class="bg-slide" style="background-image: url('https://images.pexels.com/photos/3184325/pexels-photo-3184325.jpeg');"></div>
      <div class="bg-slide" style="background-image: url('<?php echo e(asset('images/photo-15.avif')); ?>');"></div>
      <div class="bg-slide" style="background-image: url('<?php echo e(asset('images/photo-154.avif')); ?>');"></div>
    </div>

    <div class="bg-black bg-opacity-70 py-20 relative z-10">
      <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center fade-in-up">
        <div>
          <span class="inline-flex items-center px-4 py-2 rounded-full security-badge text-sm mb-6">
            <i class="fas fa-shield-alt mr-2"></i> <?php echo e(__('home.hero_badge')); ?>

          </span>
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
            <?php echo e(__('home.hero_title_1')); ?><br>
            <span class="text-blue-300"><?php echo e(__('home.hero_title_2')); ?></span>
          </h1>
          <p class="text-xl mb-8 max-w-xl leading-relaxed">
            <?php echo e(__('home.hero_description')); ?>

          </p>
          <ul class="grid sm:grid-cols-2 gap-4 text-base mb-8">
            <li class="flex items-start space-x-3">
              <i class="fas fa-check-circle text-green-400 mt-1"></i>
              <span><?php echo e(__('home.hero_feature_1')); ?></span>
            </li>
            <li class="flex items-start space-x-3">
              <i class="fas fa-check-circle text-green-400 mt-1"></i>
              <span><?php echo e(__('home.hero_feature_2')); ?></span>
            </li>
            <li class="flex items-start space-x-3">
              <i class="fas fa-check-circle text-green-400 mt-1"></i>
              <span><?php echo e(__('home.hero_feature_3')); ?></span>
            </li>
            <li class="flex items-start space-x-3">
              <i class="fas fa-check-circle text-green-400 mt-1"></i>
              <span><?php echo e(__('home.hero_feature_4')); ?></span>
            </li>
          </ul>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" class="btn-auth px-8 py-4 rounded-lg font-semibold text-center">
              <?php echo e(__('home.hero_cta_register')); ?>

            </a>
            <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="btn-auth px-8 py-4 rounded-lg font-semibold text-center">
              <?php echo e(__('home.hero_cta_login')); ?>

            </a>
          </div>
          <p class="text-sm text-gray-300 mt-6 flex items-center">
            <i class="fas fa-lock mr-2"></i> <?php echo e(__('home.hero_security_note')); ?>

          </p>
        </div>

        <div class="hidden lg:block">
          <div class="premium-card rounded-2xl p-8">
            <h3 class="text-2xl font-semibold mb-6 flex items-center text-premium">
              <i class="fas fa-chart-line mr-3"></i>
              <?php echo e(__('home.dashboard_preview_title')); ?>

            </h3>
            <div class="space-y-6 text-gray-700">
              <div class="flex justify-between items-center border-b pb-4">
                <span class="font-medium"><?php echo e(__('home.dashboard_transfers_in_progress')); ?></span>
                <span class="font-bold text-premium">3 <?php echo e(__('home.dashboard_operations')); ?></span>
              </div>
              <div class="mt-6">
                <p class="mb-3 text-sm uppercase tracking-wide text-gray-500"><?php echo e(__('home.dashboard_priority_transfer')); ?></p>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                  <div class="bg-gradient-to-r from-green-500 to-blue-600 h-3 w-3/4 rounded-full"></div>
                </div>
                <p class="text-sm text-gray-500 mt-2"><?php echo e(__('home.dashboard_step')); ?></p>
              </div>
              <div class="grid grid-cols-3 gap-4 mt-6 text-center">
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                  <p class="text-gray-600 mb-2"><?php echo e(__('home.dashboard_transfers')); ?></p>
                  <p class="font-bold text-premium text-xl">+32</p>
                </div>
                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                  <p class="text-gray-600 mb-2"><?php echo e(__('home.dashboard_reception')); ?></p>
                  <p class="font-bold text-green-600 text-xl">+18</p>
                </div>
                <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                  <p class="text-gray-600 mb-2"><?php echo e(__('home.dashboard_alerts')); ?></p>
                  <p class="font-bold text-red-500 text-xl">0</p>
                </div>
              </div>
              <p class="text-sm text-gray-500 mt-4">
                <?php echo e(__('home.dashboard_description')); ?>

              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Features -->
<section id="features" class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Title -->
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl font-extrabold mb-6 text-gray-900 tracking-tight">
        <?php echo e(__('home.features_title')); ?>

      </h2>
      <p class="text-xl text-gray-600 leading-relaxed">
        <?php echo e(__('home.features_description')); ?>

      </p>
    </div>

    <!-- Cards -->
    <div class="grid md:grid-cols-3 gap-10">

      <!-- CARD 1 -->
      <div class="feature-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="relative h-48 overflow-hidden">
          <img src="<?php echo e(asset('images/256-bit.webp')); ?>"
               class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/40"></div>
        </div>

        <div class="p-8">
          <h3 class="text-2xl font-semibold mb-4 text-gray-800">
            <?php echo e(__('home.feature_1_title')); ?>

          </h3>
          <p class="text-gray-600 mb-6 leading-relaxed">
            <?php echo e(__('home.feature_1_description')); ?>

          </p>

          <ul class="text-gray-600 space-y-3 text-left">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              <?php echo e(__('home.feature_1_item_1')); ?>

            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              <?php echo e(__('home.feature_1_item_2')); ?>

            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              <?php echo e(__('home.feature_1_item_3')); ?>

            </li>
          </ul>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="feature-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="relative h-48 overflow-hidden">
          <img src="<?php echo e(asset('images/zabra.avif')); ?>"
               class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/40"></div>
        </div>

        <div class="p-8">
          <h3 class="text-2xl font-semibold mb-4 text-gray-800">
            <?php echo e(__('home.feature_2_title')); ?>

          </h3>
          <p class="text-gray-600 mb-6 leading-relaxed">
            <?php echo e(__('home.feature_2_description')); ?>

          </p>

          <ul class="text-gray-600 space-y-3 text-left">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              <?php echo e(__('home.feature_2_item_1')); ?>

            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              <?php echo e(__('home.feature_2_item_2')); ?>

            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              Contrôle manuel possible par l'administrateur
            </li>
          </ul>
        </div>
      </div>

      <!-- CARD 3 -->
      <div class="feature-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="relative h-48 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1556742031-c6961e8560b0?auto=format&fit=crop&w=1200&q=80"
               class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/40"></div>
        </div>

        <div class="p-8">
          <h3 class="text-2xl font-semibold mb-4 text-gray-800">
            <?php echo e(__('home.feature_3_title')); ?>

          </h3>
          <p class="text-gray-600 mb-6 leading-relaxed">
            <?php echo e(__('home.feature_3_description')); ?>

          </p>

          <ul class="text-gray-600 space-y-3 text-left">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              <?php echo e(__('home.feature_3_item_1')); ?>

            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              <?php echo e(__('home.feature_3_item_2')); ?>

            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              <?php echo e(__('home.feature_3_item_3')); ?>

            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Intersection Animation -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".feature-card");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate-fade-in-up");
      }
    });
  }, { threshold: 0.3 });

  cards.forEach(card => {
    card.classList.add("opacity-0", "translate-y-8", "transition-all", "duration-700");
    observer.observe(card);
  });
});
</script>

<style>
/* Animation fade-in-up */
.animate-fade-in-up {
  opacity: 1 !important;
  transform: translateY(0) !important;
}
</style>


  <!-- Advantages -->
  <section class="py-24 parallax" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1920&q=80');">
    <div class="gradient-bg bg-opacity-95 py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
        <h2 class="text-4xl font-bold text-center mb-12"><?php echo e(__('home.why_choose_title')); ?></h2>
        <p class="max-w-3xl mx-auto text-center mb-16 text-xl text-blue-100 leading-relaxed">
          <?php echo e(__('home.accompagne_description')); ?>

        </p>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
          <div class="text-center p-6">
            <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-home text-3xl text-yellow-300"></i>
            </div>
            <h3 class="text-xl font-semibold mb-4"><?php echo e(__('home.advantage_1_title')); ?></h3>
            <p class="text-blue-100 leading-relaxed">
              <?php echo e(__('home.advantage_1_description')); ?>

            </p>
          </div>
          <div class="text-center p-6">
            <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-clock text-3xl text-green-300"></i>
            </div>
            <h3 class="text-xl font-semibold mb-4"><?php echo e(__('home.advantage_2_title')); ?></h3>
            <p class="text-blue-100 leading-relaxed">
              <?php echo e(__('home.advantage_2_description')); ?>

            </p>
          </div>
          <div class="text-center p-6">
            <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-check-circle text-3xl text-purple-300"></i>
            </div>
            <h3 class="text-xl font-semibold mb-4"><?php echo e(__('home.advantage_3_title')); ?></h3>
            <p class="text-blue-100 leading-relaxed">
              <?php echo e(__('home.advantage_3_description')); ?>

            </p>
          </div>
          <div class="text-center p-6">
            <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-headset text-3xl text-orange-300"></i>
            </div>
            <h3 class="text-xl font-semibold mb-4"><?php echo e(__('home.advantage_4_title')); ?></h3>
            <p class="text-blue-100 leading-relaxed">
              <?php echo e(__('home.advantage_4_description')); ?>

            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <section class="py-24 gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-3 gap-12 text-center">
        <div class="transform hover:scale-105 transition duration-300 p-6">
          <div class="text-6xl font-bold mb-4" id="client-count">0</div>
          <div class="text-2xl mb-4"><?php echo e(__('home.stats_clients')); ?></div>
          <p class="text-blue-100 text-lg leading-relaxed">
            <?php echo e(__('home.stats_clients_description')); ?>

          </p>
        </div>
        <div class="transform hover:scale-105 transition duration-300 p-6">
          <div class="text-6xl font-bold mb-4" id="transaction-volume">0</div>
          <div class="text-2xl mb-4"><?php echo e(__('home.stats_volume')); ?></div>
          <p class="text-blue-100 text-lg leading-relaxed">
            <?php echo e(__('home.stats_volume_description')); ?>

          </p>
        </div>
        <div class="transform hover:scale-105 transition duration-300 p-6">
          <div class="text-6xl font-bold mb-4" id="satisfaction-rate">0%</div>
          <div class="text-2xl mb-4"><?php echo e(__('home.stats_satisfaction')); ?></div>
          <p class="text-blue-100 text-lg leading-relaxed">
            <?php echo e(__('home.stats_satisfaction_description')); ?>

          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Partenaires -->
  <section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__('home.partners_title')); ?></h2>
        <p class="text-xl text-gray-600 leading-relaxed">
          <?php echo e(__('home.collabore_description')); ?>

        </p>
      </div>

      <div class="overflow-hidden py-6">
        <div class="partners-marquee flex items-center space-x-16">

          <!-- Première série -->
          <img src="<?php echo e(asset('images/MasterCard.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Mastercard">

          <img src="<?php echo e(asset('images/Visa.webp')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Visa">

          <img src="<?php echo e(asset('images/PayPal.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="PayPal">

          <img src="<?php echo e(asset('images/Western_Union.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Western Union">

          <img src="<?php echo e(asset('images/Stripe.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Stripe">

          <img src="<?php echo e(asset('images/Revolut.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Revolut">

          <img src="<?php echo e(asset('images/N26.png')); ?>" 
              class="h-14 grayscale hover:grayscale-0 transition duration-300" alt="N26">

          <!-- Copie pour effet infinie -->
          <img src="<?php echo e(asset('images/MasterCard.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Mastercard">

          <img src="<?php echo e(asset('images/Visa.webp')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Visa">

          <img src="<?php echo e(asset('images/PayPal.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="PayPal">

          <img src="<?php echo e(asset('images/Western_Union.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Western Union">

          <img src="<?php echo e(asset('images/Stripe.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Stripe">

          <img src="<?php echo e(asset('images/Revolut.png')); ?>" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Revolut">

          <img src="<?php echo e(asset('images/N26.png')); ?>" 
              class="h-14 grayscale hover:grayscale-0 transition duration-300" alt="N26">
        </div>
      </div>

      <p class="text-center text-gray-500 mt-10">
        <?php echo e(__('home.partners_note')); ?>

      </p>

    </div>
  </section>


  <!-- Certifications & Badges -->
<section id="certifications" class="py-24 bg-gray-50 relative overflow-hidden">

  <!-- Light Glow Background -->
  <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 opacity-30 blur-3xl"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

    <!-- Title -->
    <div class="text-center max-w-3xl mx-auto mb-16 fade-up">
      <h2 class="text-4xl font-extrabold mb-6 text-gray-900">
        <?php echo e(__('home.certifications_title')); ?>

      </h2>
      <p class="text-xl text-gray-600 leading-relaxed">
        <?php echo e(__('home.certifications_description')); ?>

      </p>
    </div>

    <!-- Cards -->
    <div class="grid md:grid-cols-3 gap-10">

      <!-- CARD 1 -->
      <div class="cert-card bg-white rounded-3xl shadow-lg p-8 text-center transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl fade-up">

        <img src="<?php echo e(asset('images/certification.png')); ?>"
             class="w-full h-40 object-cover rounded-2xl mb-6">

        <div class="flex justify-center mb-6">
          <span class="inline-flex items-center px-5 py-3 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold">
            <i class="fas fa-shield-alt mr-2"></i><?php echo e(__('home.cert_1_badge')); ?>

          </span>
        </div>

        <h3 class="font-bold text-2xl mb-4 text-gray-900"><?php echo e(__('home.cert_1_title')); ?></h3>

        <p class="text-gray-600 mb-6 leading-relaxed">
          <?php echo e(__('home.cert_1_description')); ?>

        </p>

        <div class="flex items-center justify-center space-x-1 text-yellow-400 text-xl">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="cert-card bg-white rounded-3xl shadow-lg p-8 text-center transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl fade-up">

        <img src="<?php echo e(asset('images/services.jpg')); ?>"
             class="w-full h-40 object-cover rounded-2xl mb-6">

        <div class="flex justify-center mb-6">
          <span class="inline-flex items-center px-5 py-3 rounded-full bg-indigo-50 text-indigo-600 text-sm font-semibold">
            <i class="fas fa-award mr-2"></i><?php echo e(__('home.cert_2_badge')); ?>

          </span>
        </div>

        <h3 class="font-bold text-2xl mb-4 text-gray-900"><?php echo e(__('home.cert_2_title')); ?></h3>

        <p class="text-gray-600 mb-6 leading-relaxed">
          <?php echo e(__('home.cert_2_description')); ?>

        </p>

        <div class="flex items-center justify-center space-x-2">
          <i class="fas fa-medal text-yellow-500 text-2xl"></i>
          <span class="text-sm text-gray-500 font-medium"><?php echo e(__('home.cert_2_distinction')); ?></span>
        </div>

      </div>

      <!-- CARD 3 -->
      <div class="cert-card bg-white rounded-3xl shadow-lg p-8 text-center transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl fade-up">

        <img src="https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?auto=format&fit=crop&w=800&q=80"
             class="w-full h-40 object-cover rounded-2xl mb-6">

        <div class="flex justify-center mb-6">
          <span class="inline-flex items-center px-5 py-3 rounded-full bg-purple-50 text-purple-700 text-sm font-semibold">
            <i class="fas fa-user-shield mr-2"></i><?php echo e(__('home.cert_3_badge')); ?>

          </span>
        </div>

        <h3 class="font-bold text-2xl mb-4 text-gray-900"><?php echo e(__('home.cert_3_title')); ?></h3>

        <p class="text-gray-600 mb-6 leading-relaxed">
          <?php echo e(__('home.cert_3_description')); ?>

        </p>

        <div class="flex items-center justify-center space-x-2 text-gray-700">
          <i class="fas fa-lock"></i>
          <span class="text-sm font-medium"><?php echo e(__('home.cert_3_compliance')); ?></span>
        </div>

      </div>

    </div>
  </div>
</section>


<!-- Certifications Animation Script -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const items = document.querySelectorAll(".fade-up");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("fade-visible");
      }
    });
  }, { threshold: 0.3 });

  items.forEach(item => {
    item.classList.add("opacity-0", "translate-y-8", "transition-all", "duration-700");
    observer.observe(item);
  });
});
</script>

<style>
.fade-visible {
  opacity: 1 !important;
  transform: translateY(0) !important;
}
</style>


  <!-- Témoignages (Slider) -->
  <section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__('home.testimonials_title')); ?></h2>
        <p class="text-xl text-gray-600 leading-relaxed">
          <?php echo e(__('home.testimonials_description')); ?>

        </p>
      </div>

      <div class="max-w-5xl mx-auto">
        <div id="testimonial-slider" class="relative">
          <!-- Slide 1 -->
          <div class="testimonial-slide active premium-card rounded-3xl p-10">
            <div class="flex flex-col md:flex-row items-start md:items-center md:space-x-8">
              <div class="flex items-center space-x-4 mb-6 md:mb-0">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                  <i class="fas fa-user text-premium text-2xl"></i>
                </div>
                <div>
                  <p class="font-bold text-gray-800 text-lg"><?php echo e(__('home.testimonial_1_name')); ?></p>
                  <p class="text-sm text-gray-500"><?php echo e(__('home.testimonial_1_role')); ?></p>
                </div>
              </div>
              <div class="flex-1">
                <p class="text-gray-600 mb-4 text-lg leading-relaxed">
                  <?php echo e(__('home.testimonial_1_text')); ?>

                </p>
                <div class="flex items-center space-x-2 text-yellow-400 text-lg">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                  <span class="text-gray-500 text-sm ml-2"><?php echo e(__('home.testimonial_1_rating')); ?></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="testimonial-slide premium-card rounded-3xl p-10">
            <div class="flex flex-col md:flex-row items-start md:items-center md:space-x-8">
              <div class="flex items-center space-x-4 mb-6 md:mb-0">
                <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center">
                  <i class="fas fa-user-tie text-emerald-600 text-2xl"></i>
                </div>
                <div>
                  <p class="font-bold text-gray-800 text-lg"><?php echo e(__('home.testimonial_2_name')); ?></p>
                  <p class="text-sm text-gray-500"><?php echo e(__('home.testimonial_2_role')); ?></p>
                </div>
              </div>
              <div class="flex-1">
                <p class="text-gray-600 mb-4 text-lg leading-relaxed">
                  <?php echo e(__('home.testimonial_2_text')); ?>

                </p>
                <div class="flex items-center space-x-2 text-yellow-400 text-lg">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                  <span class="text-gray-500 text-sm ml-2"><?php echo e(__('home.testimonial_2_rating')); ?></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="testimonial-slide premium-card rounded-3xl p-10">
            <div class="flex flex-col md:flex-row items-start md:items-center md:space-x-8">
              <div class="flex items-center space-x-4 mb-6 md:mb-0">
                <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center">
                  <i class="fas fa-user-circle text-purple-600 text-2xl"></i>
                </div>
                <div>
                  <p class="font-bold text-gray-800 text-lg"><?php echo e(__('home.testimonial_3_name')); ?></p>
                  <p class="text-sm text-gray-500"><?php echo e(__('home.testimonial_3_role')); ?></p>
                </div>
              </div>
              <div class="flex-1">
                <p class="text-gray-600 mb-4 text-lg leading-relaxed">
                  <?php echo e(__('home.testimonial_3_text')); ?>

                </p>
                <div class="flex items-center space-x-2 text-yellow-400 text-lg">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                  <span class="text-gray-500 text-sm ml-2"><?php echo e(__('home.testimonial_3_rating')); ?></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Dots -->
          <div class="flex justify-center items-center space-x-4 mt-10">
            <span class="testimonial-dot active" data-index="0"></span>
            <span class="testimonial-dot" data-index="1"></span>
            <span class="testimonial-dot" data-index="2"></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-4xl font-bold mb-6 text-premium"><?php echo e(__('home.faq_title')); ?></h2>
        <p class="text-xl text-gray-600 leading-relaxed">
          <?php echo e(__('home.faq_description')); ?>

        </p>
      </div>

      <div class="max-w-4xl mx-auto space-y-6" id="faq-list">
        <!-- FAQ Item -->
        <div class="faq-item">
          <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
            <div>
              <p class="font-bold text-xl text-gray-800"><?php echo e(__('home.faq_1_question')); ?></p>
              <p class="text-gray-500 mt-2"><?php echo e(__('home.faq_1_subtitle')); ?></p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
          </button>
          <div class="faq-answer px-8 pb-6">
            <p class="text-gray-600 leading-relaxed">
              <?php echo e(__('home.faq_1_answer')); ?>

            </p>
          </div>
        </div>

        <div class="faq-item">
          <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
            <div>
              <p class="font-bold text-xl text-gray-800"><?php echo e(__('home.faq_2_question')); ?></p>
              <p class="text-gray-500 mt-2"><?php echo e(__('home.faq_2_subtitle')); ?></p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
          </button>
          <div class="faq-answer px-8 pb-6">
            <p class="text-gray-600 leading-relaxed">
              <?php echo e(__('home.faq_2_answer')); ?>

            </p>
          </div>
        </div>

        <div class="faq-item">
          <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
            <div>
              <p class="font-bold text-xl text-gray-800"><?php echo e(__('home.faq_3_question')); ?></p>
              <p class="text-gray-500 mt-2"><?php echo e(__('home.faq_3_subtitle')); ?></p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
          </button>
          <div class="faq-answer px-8 pb-6">
            <p class="text-gray-600 leading-relaxed">
              <?php echo e(__('home.faq_3_answer')); ?>

            </p>
          </div>
        </div>

        <div class="faq-item">
          <button type="button" class="w-full flex justify-between items-center px-8 py-6 text-left">
            <div>
              <p class="font-bold text-xl text-gray-800"><?php echo e(__('home.faq_4_question')); ?></p>
              <p class="text-gray-500 mt-2"><?php echo e(__('home.faq_4_subtitle')); ?></p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-lg"></i>
          </button>
          <div class="faq-answer px-8 pb-6">
            <p class="text-gray-600 leading-relaxed">
              <?php echo e(__('home.faq_4_answer')); ?>

            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
<section id="cta-section" class="py-24 bg-white relative overflow-hidden">
  
  <!-- BACKGROUND SPOTLIGHT EFFECT -->
  <div class="absolute inset-0 opacity-30 bg-gradient-to-r from-blue-100 to-white blur-3xl"></div>

  <div class="max-w-5xl mx-auto px-6 text-center relative z-10 cta-animate">
    <h2 class="text-5xl font-extrabold mb-8 text-gray-900 tracking-tight animate-title">
      <?php echo e(__('home.cta_title')); ?>

    </h2>

    <p class="text-2xl text-gray-600 mb-10 leading-relaxed animate-text">
      <?php echo e(__('home.cta_description')); ?>

    </p>

    <!-- BUTTON -->
    <a href="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>" 
       class="cta-button px-14 py-5 rounded-xl text-2xl font-bold inline-block relative overflow-hidden">
       <span><?php echo e(__('home.cta_button')); ?></span>
    </a>

    <!-- SECURITY TEXT -->
    <p class="text-gray-500 mt-6 flex items-center justify-center animate-text">
      <i class="fas fa-lock mr-2"></i>
      <?php echo e(__('home.cta_security')); ?>

    </p>
  </div>
</section>


<!-- CTA ANIMATIONS SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const cta = document.querySelector(".cta-animate");

  const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      cta.classList.add("cta-visible");
    }
  }, { threshold: 0.4 });

  observer.observe(cta);
});
</script>

<style>
/* Fade-in animation */
.cta-animate {
  opacity: 0;
  transform: translateY(40px);
  transition: all 1.1s ease-out;
}
.cta-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Title Animation */
.animate-title {
  animation: titleFade 1.3s ease forwards;
}
@keyframes titleFade {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Text Animation */
.animate-text {
  opacity: 0;
  animation: textFade 1.8s ease forwards;
}
@keyframes textFade {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* BUTTON STYLES */
.cta-button {
  background: linear-gradient(135deg, #2563eb, #1d4ed8, #1e40af);
  color: white;
  box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
  letter-spacing: 1px;
  position: relative;
  overflow: hidden;
  transition: all 0.35s ease-out;
}

/* BUTTON HOVER GLOW EFFECT */
.cta-button:hover {
  transform: translateY(-5px) scale(1.03);
  box-shadow: 0 18px 45px rgba(37, 99, 235, 0.55);
}

/* Shine Effect */
.cta-button::after {
  content: "";
  position: absolute;
  top: 0;
  left: -120%;
  width: 100%;
  height: 100%;
  background: linear-gradient(120deg, transparent, rgba(255,255,255,0.45), transparent);
  transform: skewX(-20deg);
  transition: 0.7s;
}
.cta-button:hover::after {
  left: 120%;
}

/* Soft Pulse */
.cta-button span {
  animation: softPulse 2.2s infinite ease-in-out;
}
@keyframes softPulse {
  0%, 100% { opacity: 1; }
  50% { opacity: .85; }
}
</style>


  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-400 py-16">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-4 gap-10 mb-12">
        <div>
          <div class="flex items-center mb-6">
            <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center justify-center bg-white/95 p-2 rounded-xl shadow-md ring-1 ring-white/60">
              <img src='<?php echo e(asset("images/Logosite.png")); ?>' class="w-11 h-11 object-contain" alt="logo Valtrix Bank" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
            </a>
          </div>
          <p class="text-gray-400 mb-4">
            <?php echo e(__('home.footer_description')); ?>

          </p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin text-xl"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook text-xl"></i></a>
          </div>
        </div>
        
        <div>
          <h3 class="text-white font-bold text-lg mb-6"><?php echo e(__('home.footer_services')); ?></h3>
          <ul class="space-y-3">
            <li><a href="<?php echo e(localized_route('services.comptes-professionnels', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.services_business_accounts')); ?></a></li>
            <li><a href="<?php echo e(localized_route('services.virements-internationaux', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.services_international_transfers')); ?></a></li>
            <li><a href="<?php echo e(localized_route('services.gestion-tresorerie', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.services_treasury_management')); ?></a></li>
            <li><a href="<?php echo e(localized_route('services.cartes-paiement', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.services_payment_cards')); ?></a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-white font-bold text-lg mb-6"><?php echo e(__('home.footer_about')); ?></h3>
          <ul class="space-y-3">
            <li><a href="<?php echo e(localized_route('about.notre-histoire', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.footer_our_story')); ?></a></li>
            <li><a href="<?php echo e(localized_route('about.carrieres', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.footer_careers')); ?></a></li>
            <li><a href="<?php echo e(localized_route('about.presse', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.footer_press')); ?></a></li>
            <li><a href="<?php echo e(localized_route('about.blog', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.footer_blog')); ?></a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-white font-bold text-lg mb-6"><?php echo e(__('home.footer_support')); ?></h3>
          <ul class="space-y-3">
            <li><a href="<?php echo e(localized_route('support.centre-aide', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.footer_help_center')); ?></a></li>
            <li><a href="<?php echo e(localized_route('support.nous-contacter', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.footer_contact_us')); ?></a></li>
            <li><a href="<?php echo e(localized_route('support.securite', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.footer_security')); ?></a></li>
            <li><a href="<?php echo e(localized_route('support.mentions-legales', ['locale' => app()->getLocale()])); ?>" class="text-gray-400 hover:text-white transition"><?php echo e(__('home.footer_legal')); ?></a></li>
          </ul>
        </div>
      </div>
      
      <div class="section-divider my-8"></div>
      
      <div class="text-center">
        <p>&copy; 2025 <span class="text-blue-400 font-semibold">Valtrix Bank</span>. <?php echo e(__('home.footer_copyright')); ?></p>
        <p class="text-sm text-gray-500 mt-2">
          <?php echo e(__('home.footer_disclaimer')); ?>

        </p>
      </div>
    </div>
  </footer>

  <!-- JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      /* HERO BACKGROUND SLIDESHOW */
      const slides = document.querySelectorAll('.bg-slide');
      let currentSlide = 0;

      if (slides.length > 1) {
        setInterval(function() {
          slides[currentSlide].classList.remove('active');
          currentSlide = (currentSlide + 1) % slides.length;
          slides[currentSlide].classList.add('active');
        }, 5000);
      }

      /* TESTIMONIALS SLIDER */
      const testimonialSlides = document.querySelectorAll('.testimonial-slide');
      const testimonialDots = document.querySelectorAll('.testimonial-dot');
      let currentTestimonial = 0;

      function goToTestimonial(index) {
        if (!testimonialSlides.length) return;
        testimonialSlides.forEach((slide, i) => {
          slide.classList.toggle('active', i === index);
        });
        testimonialDots.forEach((dot, i) => {
          dot.classList.toggle('active', i === index);
        });
        currentTestimonial = index;
      }

      if (testimonialSlides.length > 0) {
        // Auto-play
        setInterval(function() {
          const nextIndex = (currentTestimonial + 1) % testimonialSlides.length;
          goToTestimonial(nextIndex);
        }, 7000);

        // Click on dots
        testimonialDots.forEach(dot => {
          dot.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'), 10);
            goToTestimonial(index);
          });
        });
      }

      /* FAQ ACCORDION */
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

      /* MENU MOBILE TOGGLE AMÉLIORÉ */
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');

      if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
          mobileMenu.classList.toggle('open');
          mobileMenuButton.classList.toggle('active');
          
          // Changer l'icône avec animation
          const icon = mobileMenuButton.querySelector('i');
          if (mobileMenu.classList.contains('open')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
          } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
          }
        });

        // Fermer le menu en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
          if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target) && mobileMenu.classList.contains('open')) {
            mobileMenu.classList.remove('open');
            mobileMenuButton.classList.remove('active');
            const icon = mobileMenuButton.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
            if (servicesSubmenu && !servicesSubmenu.classList.contains('hidden')) {
              servicesSubmenu.classList.add('hidden');
              if (servicesChevron) {
                servicesChevron.classList.remove('rotate-180');
              }
            }
          }
        });

        // Toggle submenu for <?php echo e(__('home.footer_services')); ?> in mobile menu
        const servicesButton = mobileMenu.querySelector('.mobile-menu-item.relative.group > button');
        const servicesSubmenu = mobileMenu.querySelector('.mobile-submenu');
        const servicesChevron = servicesButton ? servicesButton.querySelector('svg') : null;

        if (servicesButton && servicesSubmenu) {
          servicesButton.addEventListener('click', function(event) {
            event.preventDefault();
            servicesSubmenu.classList.toggle('hidden');
            if (servicesChevron) {
              servicesChevron.classList.toggle('rotate-180');
            }
          });
        }
      }

      /* STATISTIQUES DYNAMIQUES CORRIGÉES POUR MOBILE */
      function animateCounter(element, target, suffix = '', duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16); // 60fps
        let current = start;
        
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            element.textContent = target.toLocaleString() + suffix;
            clearInterval(timer);
            element.classList.add('count-animation');
          } else {
            element.textContent = Math.floor(current).toLocaleString() + suffix;
          }
        }, 16);
      }

      // Observer pour déclencher l'animation quand la section est visible
      const statsSection = document.querySelector('.gradient-bg');
      const clientCount = document.getElementById('client-count');
      const transactionVolume = document.getElementById('transaction-volume');
      const satisfactionRate = document.getElementById('satisfaction-rate');

      let statsAnimated = false;

      function animateStats() {
        if (statsAnimated) return;
        
        // Animer les compteurs
        animateCounter(clientCount, 10000);
        animateCounter(transactionVolume, 500, ' M€');
        animateCounter(satisfactionRate, 98, '%');
        
        statsAnimated = true;
      }

      if (statsSection && clientCount && transactionVolume && satisfactionRate) {
        // Vérifier si la section est déjà visible au chargement
        const rect = statsSection.getBoundingClientRect();
        const isVisible = (
          rect.top >= 0 &&
          rect.left >= 0 &&
          rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
          rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );

        if (isVisible) {
          animateStats();
        }

        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              animateStats();
            }
          });
        }, { threshold: 0.3 });

        observer.observe(statsSection);

        // Fallback pour mobile - déclencher après un délai
        setTimeout(() => {
          if (!statsAnimated) {
            animateStats();
          }
        }, 1000);
      }
    });
  </script>

</body>
</html>







<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\home.blade.php ENDPATH**/ ?>