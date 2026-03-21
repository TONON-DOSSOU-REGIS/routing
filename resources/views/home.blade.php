<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ __('home.page_title') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  @include('partials.favicon')

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
            <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}"><img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
            {{-- <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}"><img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a> --}}
          </div>
          <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-2xl font-bold text-white"><span class="sr-only">Valtrix Bank</span></a>
        </div>
        
        <!-- Menu Desktop -->
        <div class="hidden md:flex items-center space-x-6">
          <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-white hover:text-blue-200 transition font-medium">{{ __('home.nav_home') }}</a>
          <div class="relative group">
            <button class="text-white hover:text-blue-200 transition font-medium inline-flex items-center">
              {{ __('home.nav_services') }}
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 translate-y-1 transition-all duration-300 pointer-events-none group-hover:pointer-events-auto">
              <a href="{{ localized_route('services.comptes-professionnels', ['locale' => app()->getLocale()]) }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-900">{{ __('home.services_business_accounts') }}</a>
              <a href="{{ localized_route('services.virements-internationaux', ['locale' => app()->getLocale()]) }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-900">{{ __('home.services_international_transfers') }}</a>
              <a href="{{ localized_route('services.gestion-tresorerie', ['locale' => app()->getLocale()]) }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-900">{{ __('home.services_treasury_management') }}</a>
              <a href="{{ localized_route('services.cartes-paiement', ['locale' => app()->getLocale()]) }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-100 hover:text-blue-900">{{ __('home.services_payment_cards') }}</a>
            </div>
          </div>
          <a href="#testimonial-slider" class="text-white hover:text-blue-200 transition font-medium">{{ __('home.nav_testimonials') }}</a>
          <a href="#faq-list" class="text-white hover:text-blue-200 transition font-medium">{{ __('home.nav_faq') }}</a>
          <a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="text-white hover:text-blue-200 transition font-medium">{{ __('home.nav_contact') }}</a>
          <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="btn-auth px-6 py-3 rounded-lg font-semibold">{{ __('home.nav_login') }}</a>
          <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-auth px-6 py-3 rounded-lg font-semibold">{{ __('home.nav_register') }}</a>
          <x-language-selector />
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
          <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="mobile-menu-item mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400">
            <span>{{ __('home.nav_home') }}</span>
          </a>
          <div class="mobile-menu-item relative group">
            <button class="w-full mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400 inline-flex items-center justify-between" type="button">
              <span>{{ __('home.nav_services') }}</span>
              <svg class="w-4 h-4 ml-2 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div class="mobile-submenu hidden flex flex-col bg-blue-900/80 border border-blue-700 rounded-md mt-2 p-2 space-y-1">
              <a href="{{ localized_route('services.comptes-professionnels', ['locale' => app()->getLocale()]) }}" class="block px-4 py-2 text-white hover:bg-blue-700 hover:text-white rounded-md">{{ __('home.services_business_accounts') }}</a>
              <a href="{{ localized_route('services.virements-internationaux', ['locale' => app()->getLocale()]) }}" class="block px-4 py-2 text-white hover:bg-blue-700 hover:text-white rounded-md">{{ __('home.services_international_transfers') }}</a>
              <a href="{{ localized_route('services.gestion-tresorerie', ['locale' => app()->getLocale()]) }}" class="block px-4 py-2 text-white hover:bg-blue-700 hover:text-white rounded-md">{{ __('home.services_treasury_management') }}</a>
              <a href="{{ localized_route('services.cartes-paiement', ['locale' => app()->getLocale()]) }}" class="block px-4 py-2 text-white hover:bg-blue-700 hover:text-white rounded-md">{{ __('home.services_payment_cards') }}</a>
            </div>
          </div>
          <a href="#testimonial-slider" class="mobile-menu-item mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400">
            <span>{{ __('home.nav_testimonials') }}</span>
          </a>
          <a href="#faq-list" class="mobile-menu-item mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400">
            <span>{{ __('home.nav_faq') }}</span>
          </a>
          <a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="mobile-menu-item mobile-menu-link text-white hover:text-blue-200 transition font-medium py-3 px-4 rounded-lg hover:bg-red-400">
            <span>{{ __('home.nav_contact') }}</span>
          </a>
          <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="mobile-menu-item btn-auth block font-semibold py-3 px-4 rounded-lg text-center">{{ __('home.nav_login') }}</a>
          <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="mobile-menu-item btn-auth block font-semibold py-3 px-4 rounded-lg text-center">{{ __('home.nav_register') }}</a>
          <div class="mobile-menu-item">
            <x-language-selector />
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
      <div class="bg-slide" style="background-image: url('{{ asset('images/photo-15.avif') }}');"></div>
      <div class="bg-slide" style="background-image: url('{{ asset('images/photo-154.avif') }}');"></div>
    </div>

    <div class="bg-black bg-opacity-70 py-20 relative z-10">
      <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center fade-in-up">
        <div>
          <span class="inline-flex items-center px-4 py-2 rounded-full security-badge text-sm mb-6">
            <i class="fas fa-shield-alt mr-2"></i> {{ __('home.hero_badge') }}
          </span>
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
            {{ __('home.hero_title_1') }}<br>
            <span class="text-blue-300">{{ __('home.hero_title_2') }}</span>
          </h1>
          <p class="text-xl mb-8 max-w-xl leading-relaxed">
            {{ __('home.hero_description') }}
          </p>
          <ul class="grid sm:grid-cols-2 gap-4 text-base mb-8">
            <li class="flex items-start space-x-3">
              <i class="fas fa-check-circle text-green-400 mt-1"></i>
              <span>{{ __('home.hero_feature_1') }}</span>
            </li>
            <li class="flex items-start space-x-3">
              <i class="fas fa-check-circle text-green-400 mt-1"></i>
              <span>{{ __('home.hero_feature_2') }}</span>
            </li>
            <li class="flex items-start space-x-3">
              <i class="fas fa-check-circle text-green-400 mt-1"></i>
              <span>{{ __('home.hero_feature_3') }}</span>
            </li>
            <li class="flex items-start space-x-3">
              <i class="fas fa-check-circle text-green-400 mt-1"></i>
              <span>{{ __('home.hero_feature_4') }}</span>
            </li>
          </ul>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="btn-auth px-8 py-4 rounded-lg font-semibold text-center">
              {{ __('home.hero_cta_register') }}
            </a>
            <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="btn-auth px-8 py-4 rounded-lg font-semibold text-center">
              {{ __('home.hero_cta_login') }}
            </a>
          </div>
          <p class="text-sm text-gray-300 mt-6 flex items-center">
            <i class="fas fa-lock mr-2"></i> {{ __('home.hero_security_note') }}
          </p>
          <div class="grid grid-cols-2 gap-4 mt-8 lg:hidden">
            <div class="rounded-2xl border border-white/10 bg-white/10 backdrop-blur-sm p-4">
              <p class="text-xs uppercase tracking-[0.2em] text-blue-100 mb-2">{{ __('home.feature_1_title') }}</p>
              <p class="text-2xl font-bold text-white">AES 256</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/10 backdrop-blur-sm p-4">
              <p class="text-xs uppercase tracking-[0.2em] text-blue-100 mb-2">{{ __('home.advantage_4_title') }}</p>
              <p class="text-2xl font-bold text-white">24/7</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/10 backdrop-blur-sm p-4 col-span-2">
              <p class="text-xs uppercase tracking-[0.2em] text-blue-100 mb-2">{{ __('home.advantage_3_title') }}</p>
              <p class="text-base font-medium text-white">{{ __('home.hero_feature_4') }}</p>
            </div>
          </div>
        </div>

        <div class="hidden lg:block">
          <div class="premium-card rounded-[2rem] p-8 xl:p-9 relative overflow-hidden">
            <div class="absolute -top-16 -right-10 w-40 h-40 rounded-full bg-blue-100 opacity-70 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-8 w-44 h-44 rounded-full bg-orange-100 opacity-70 blur-3xl"></div>

            <div class="relative z-10">
              <div class="flex items-start justify-between gap-4 mb-8">
                <div>
                  <span class="inline-flex items-center px-4 py-2 rounded-full bg-orange-50 text-orange-600 text-xs font-semibold tracking-[0.25em] uppercase border border-orange-100">
                    {{-- Valtrix Bank Premium --}}
                  </span>
                  <h3 class="text-3xl font-semibold mt-4 text-premium flex items-center">
                    <i class="fas fa-chart-line mr-3"></i>
                    {{ __('home.dashboard_preview_title') }}
                  </h3>
                  <p class="text-sm text-gray-500 mt-3 max-w-md leading-relaxed">
                    {{ __('home.dashboard_description') }}
                  </p>
                </div>

                <div class="rounded-2xl bg-slate-900 text-white px-4 py-3 shadow-lg min-w-[138px]">
                  <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400 mb-2">{{ __('home.dashboard_transfers_in_progress') }}</p>
                  <p class="text-3xl font-bold">3</p>
                  <p class="text-sm text-slate-300">{{ __('home.dashboard_operations') }}</p>
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="rounded-2xl border border-blue-100 bg-blue-50/80 p-5">
                  <div class="w-11 h-11 rounded-2xl bg-white text-blue-700 flex items-center justify-center shadow-sm mb-4">
                    <i class="fas fa-shield-halved"></i>
                  </div>
                  <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('home.feature_1_title') }}</p>
                  <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.feature_1_item_2') }}</p>
                </div>

                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/80 p-5">
                  <div class="w-11 h-11 rounded-2xl bg-white text-emerald-600 flex items-center justify-center shadow-sm mb-4">
                    <i class="fas fa-file-lines"></i>
                  </div>
                  <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('home.advantage_3_title') }}</p>
                  <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.hero_feature_4') }}</p>
                </div>
              </div>

              <div class="rounded-[1.75rem] bg-slate-950 text-white p-6 shadow-2xl">
                <div class="flex items-start justify-between gap-4 mb-5">
                  <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-orange-300 mb-2">{{ __('home.dashboard_priority_transfer') }}</p>
                    <h4 class="text-2xl font-semibold">{{ __('home.feature_3_title') }}</h4>
                  </div>
                  <div class="text-right">
                    <p class="text-sm text-slate-400">{{ __('transactions.progress_label') }}</p>
                    <p class="text-3xl font-bold text-emerald-300">76%</p>
                  </div>
                </div>

                <div class="w-full h-3 rounded-full bg-white/10 overflow-hidden mb-4">
                  <div class="h-3 rounded-full bg-gradient-to-r from-orange-400 via-amber-300 to-emerald-400" style="width: 76%"></div>
                </div>

                <p class="text-sm text-slate-300 mb-5">{{ __('home.dashboard_step') }}</p>

                <div class="grid grid-cols-3 gap-3">
                  <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 mb-2">01</p>
                    <p class="font-semibold">{{ __('transactions.step_information') }}</p>
                    <p class="text-xs text-slate-400 mt-2">{{ __('home.hero_feature_1') }}</p>
                  </div>
                  <div class="rounded-2xl border border-orange-300/30 bg-orange-400/10 px-4 py-4 shadow-lg shadow-orange-500/10">
                    <p class="text-xs uppercase tracking-[0.2em] text-orange-200 mb-2">02</p>
                    <p class="font-semibold">{{ __('transactions.step_processing') }}</p>
                    <p class="text-xs text-slate-300 mt-2">{{ __('home.hero_feature_2') }}</p>
                  </div>
                  <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 mb-2">03</p>
                    <p class="font-semibold">{{ __('transactions.step_confirmation') }}</p>
                    <p class="text-xs text-slate-400 mt-2">{{ __('home.hero_feature_4') }}</p>
                  </div>
                </div>
              </div>

              <div class="grid grid-cols-3 gap-4 mt-6 text-center">
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
                  <p class="text-gray-500 mb-2 text-sm">{{ __('home.dashboard_transfers') }}</p>
                  <p class="font-bold text-premium text-2xl">+32</p>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
                  <p class="text-gray-500 mb-2 text-sm">{{ __('home.dashboard_reception') }}</p>
                  <p class="font-bold text-emerald-600 text-2xl">+18</p>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
                  <p class="text-gray-500 mb-2 text-sm">{{ __('home.dashboard_alerts') }}</p>
                  <p class="font-bold text-red-500 text-2xl">0</p>
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400 mb-3">{{ __('home.feature_2_title') }}</p>
                  <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.feature_2_description') }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                  <p class="text-xs uppercase tracking-[0.25em] text-slate-400 mb-3">{{ __('home.advantage_4_title') }}</p>
                  <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.advantage_4_description') }}</p>
                </div>
              </div>
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
        {{ __('home.features_title') }}
      </h2>
      <p class="text-xl text-gray-600 leading-relaxed">
        {{ __('home.features_description') }}
      </p>
    </div>

    <div class="grid xl:grid-cols-[1.35fr,0.9fr] gap-8 mb-16 items-stretch">
      <div class="rounded-[2rem] border border-slate-200 bg-gradient-to-br from-slate-50 via-white to-blue-50 p-8 lg:p-10 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
          <div class="max-w-2xl">
            <span class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold tracking-[0.25em] uppercase border border-blue-100">
              {{ __('home.dashboard_preview_title') }}
            </span>
            <h3 class="text-3xl font-bold text-gray-900 mt-4 mb-4">
              {{ __('home.why_choose_title') }}
            </h3>
            <p class="text-gray-600 text-lg leading-relaxed">
              {{ __('home.why_choose_description') }}
            </p>
          </div>

          <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm max-w-xs">
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400 mb-2">{{ __('home.stats_satisfaction') }}</p>
            <p class="text-4xl font-bold text-premium mb-2">98%</p>
            <p class="text-sm text-gray-500 leading-relaxed">{{ __('home.stats_satisfaction_description') }}</p>
          </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
          <div class="rounded-3xl bg-white border border-blue-100 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center mb-5">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-900 mb-3">{{ __('home.feature_1_title') }}</h4>
            <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('home.feature_1_description') }}</p>
            <p class="text-sm font-medium text-blue-700">{{ __('home.feature_1_item_1') }}</p>
          </div>

          <div class="rounded-3xl bg-white border border-orange-100 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-5">
              <i class="fas fa-user-shield"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-900 mb-3">{{ __('home.feature_2_title') }}</h4>
            <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('home.feature_2_description') }}</p>
            <p class="text-sm font-medium text-orange-600">{{ __('home.feature_2_item_2') }}</p>
          </div>

          <div class="rounded-3xl bg-white border border-emerald-100 p-6 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5">
              <i class="fas fa-file-lines"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-900 mb-3">{{ __('home.feature_3_title') }}</h4>
            <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ __('home.feature_3_description') }}</p>
            <p class="text-sm font-medium text-emerald-600">{{ __('home.feature_3_item_3') }}</p>
          </div>
        </div>
      </div>

      <div class="relative overflow-hidden rounded-[2rem] bg-slate-950 p-8 lg:p-10 text-white shadow-[0_30px_60px_rgba(15,23,42,0.28)]">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(251,146,60,0.28),_transparent_35%),radial-gradient(circle_at_bottom_left,_rgba(59,130,246,0.24),_transparent_35%)]"></div>
        <div class="relative z-10 h-full flex flex-col">
          <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 text-orange-200 text-xs font-semibold tracking-[0.25em] uppercase border border-white/10 w-fit">
            {{ __('home.dashboard_priority_transfer') }}
          </span>

          <h3 class="text-3xl font-semibold mt-6 mb-3">{{ __('home.feature_3_title') }}</h3>
          <p class="text-slate-300 leading-relaxed">
            {{ __('home.dashboard_description') }}
          </p>

          <div class="space-y-4 mt-8">
            <div class="rounded-3xl border border-white/10 bg-white/5 px-5 py-5">
              <div class="flex items-center justify-between gap-4">
                <div>
                  <p class="text-lg font-semibold">{{ __('transactions.step_information') }}</p>
                  <p class="text-sm text-slate-300 mt-1">{{ __('home.hero_feature_1') }}</p>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center text-blue-200">
                  <i class="fas fa-user-check"></i>
                </div>
              </div>
            </div>

            <div class="rounded-3xl border border-orange-300/30 bg-orange-400/10 px-5 py-5 shadow-lg shadow-orange-500/10">
              <div class="flex items-center justify-between gap-4">
                <div>
                  <p class="text-lg font-semibold">{{ __('transactions.step_processing') }}</p>
                  <p class="text-sm text-slate-200 mt-1">{{ __('home.hero_feature_2') }}</p>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-orange-300/20 flex items-center justify-center text-orange-100">
                  <i class="fas fa-spinner"></i>
                </div>
              </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 px-5 py-5">
              <div class="flex items-center justify-between gap-4">
                <div>
                  <p class="text-lg font-semibold">{{ __('transactions.step_confirmation') }}</p>
                  <p class="text-sm text-slate-300 mt-1">{{ __('home.hero_feature_4') }}</p>
                </div>
                <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center text-emerald-200">
                  <i class="fas fa-circle-check"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-5">
            <div class="flex items-center justify-between gap-4 mb-4">
              <p class="text-sm font-semibold text-white">{{ __('transactions.transfer_progress') }}</p>
              <p class="text-2xl font-bold text-orange-200">76%</p>
            </div>
            <div class="w-full h-3 rounded-full bg-white/10 overflow-hidden">
              <div class="h-3 rounded-full bg-gradient-to-r from-orange-400 via-amber-300 to-emerald-400" style="width: 76%"></div>
            </div>
            <p class="text-sm text-slate-300 mt-4">{{ __('home.dashboard_step') }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Cards -->
    <div class="grid md:grid-cols-3 gap-10">

      <!-- CARD 1 -->
      <div class="feature-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="relative h-48 overflow-hidden">
          <img src="{{ asset('images/256-bit.webp') }}"
               class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/40"></div>
        </div>

        <div class="p-8">
          <h3 class="text-2xl font-semibold mb-4 text-gray-800">
            {{ __('home.feature_1_title') }}
          </h3>
          <p class="text-gray-600 mb-6 leading-relaxed">
            {{ __('home.feature_1_description') }}
          </p>

          <ul class="text-gray-600 space-y-3 text-left">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_1_item_1') }}
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_1_item_2') }}
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_1_item_3') }}
            </li>
          </ul>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="feature-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-2">
        <div class="relative h-48 overflow-hidden">
          <img src="{{ asset('images/zabra.avif') }}"
               class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
          <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/40"></div>
        </div>

        <div class="p-8">
          <h3 class="text-2xl font-semibold mb-4 text-gray-800">
            {{ __('home.feature_2_title') }}
          </h3>
          <p class="text-gray-600 mb-6 leading-relaxed">
            {{ __('home.feature_2_description') }}
          </p>

          <ul class="text-gray-600 space-y-3 text-left">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_2_item_1') }}
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_2_item_2') }}
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_2_item_3') }}
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
            {{ __('home.feature_3_title') }}
          </h3>
          <p class="text-gray-600 mb-6 leading-relaxed">
            {{ __('home.feature_3_description') }}
          </p>

          <ul class="text-gray-600 space-y-3 text-left">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_3_item_1') }}
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_3_item_2') }}
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
              {{ __('home.feature_3_item_3') }}
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
        <h2 class="text-4xl font-bold text-center mb-12">{{ __('home.why_choose_title') }}</h2>
        <p class="max-w-3xl mx-auto text-center mb-16 text-xl text-blue-100 leading-relaxed">
          {{ __('home.accompagne_description') }}
        </p>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
          <div class="text-center p-6">
            <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-home text-3xl text-yellow-300"></i>
            </div>
            <h3 class="text-xl font-semibold mb-4">{{ __('home.advantage_1_title') }}</h3>
            <p class="text-blue-100 leading-relaxed">
              {{ __('home.advantage_1_description') }}
            </p>
          </div>
          <div class="text-center p-6">
            <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-clock text-3xl text-green-300"></i>
            </div>
            <h3 class="text-xl font-semibold mb-4">{{ __('home.advantage_2_title') }}</h3>
            <p class="text-blue-100 leading-relaxed">
              {{ __('home.advantage_2_description') }}
            </p>
          </div>
          <div class="text-center p-6">
            <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-check-circle text-3xl text-purple-300"></i>
            </div>
            <h3 class="text-xl font-semibold mb-4">{{ __('home.advantage_3_title') }}</h3>
            <p class="text-blue-100 leading-relaxed">
              {{ __('home.advantage_3_description') }}
            </p>
          </div>
          <div class="text-center p-6">
            <div class="bg-white bg-opacity-10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-headset text-3xl text-orange-300"></i>
            </div>
            <h3 class="text-xl font-semibold mb-4">{{ __('home.advantage_4_title') }}</h3>
            <p class="text-blue-100 leading-relaxed">
              {{ __('home.advantage_4_description') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <section class="py-24 gradient-bg text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(251,146,60,0.18),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(255,255,255,0.12),_transparent_40%)]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="text-center max-w-3xl mx-auto mb-14">
        <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm font-semibold tracking-[0.2em] uppercase">
          {{ __('home.hero_badge') }}
        </span>
        <h2 class="text-4xl md:text-5xl font-bold mt-6 mb-5">{{ __('home.why_choose_title') }}</h2>
        <p class="text-xl text-blue-100 leading-relaxed">
          {{ __('home.why_choose_description') }}
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-6 text-center">
        <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-sm p-8 shadow-xl">
          <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-6 text-orange-200">
            <i class="fas fa-users text-2xl"></i>
          </div>
          <div class="text-6xl font-bold mb-4" id="client-count">0</div>
          <div class="text-2xl mb-4">{{ __('home.stats_clients') }}</div>
          <p class="text-blue-100 text-lg leading-relaxed">
            {{ __('home.stats_clients_description') }}
          </p>
          <div class="mt-6 pt-6 border-t border-white/10 text-sm text-blue-100">
            {{ __('home.advantage_1_title') }}
          </div>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-sm p-8 shadow-xl">
          <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-6 text-emerald-200">
            <i class="fas fa-building-columns text-2xl"></i>
          </div>
          <div class="text-6xl font-bold mb-4" id="transaction-volume">0</div>
          <div class="text-2xl mb-4">{{ __('home.stats_volume') }}</div>
          <p class="text-blue-100 text-lg leading-relaxed">
            {{ __('home.stats_volume_description') }}
          </p>
          <div class="mt-6 pt-6 border-t border-white/10 text-sm text-blue-100">
            {{ __('home.advantage_2_title') }}
          </div>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-sm p-8 shadow-xl">
          <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-6 text-yellow-200">
            <i class="fas fa-star text-2xl"></i>
          </div>
          <div class="text-6xl font-bold mb-4" id="satisfaction-rate">0%</div>
          <div class="text-2xl mb-4">{{ __('home.stats_satisfaction') }}</div>
          <p class="text-blue-100 text-lg leading-relaxed">
            {{ __('home.stats_satisfaction_description') }}
          </p>
          <div class="mt-6 pt-6 border-t border-white/10 text-sm text-blue-100">
            {{ __('home.advantage_3_title') }}
          </div>
        </div>
      </div>

      <div class="grid lg:grid-cols-3 gap-6 mt-10">
        <div class="rounded-3xl border border-white/10 bg-slate-900/20 p-6 backdrop-blur-sm">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center text-blue-200">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="text-lg font-semibold">{{ __('home.feature_1_title') }}</h3>
          </div>
          <p class="text-blue-100 leading-relaxed">{{ __('home.feature_1_description') }}</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/20 p-6 backdrop-blur-sm">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center text-orange-200">
              <i class="fas fa-chart-line"></i>
            </div>
            <h3 class="text-lg font-semibold">{{ __('home.dashboard_preview_title') }}</h3>
          </div>
          <p class="text-blue-100 leading-relaxed">{{ __('home.dashboard_description') }}</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/20 p-6 backdrop-blur-sm">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center text-emerald-200">
              <i class="fas fa-award"></i>
            </div>
            <h3 class="text-lg font-semibold">{{ __('home.cert_2_title') }}</h3>
          </div>
          <p class="text-blue-100 leading-relaxed">{{ __('home.cert_2_description') }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Partenaires -->
  <section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-4xl font-bold mb-6 text-premium">{{ __('home.partners_title') }}</h2>
        <p class="text-xl text-gray-600 leading-relaxed">
          {{ __('home.partners_description') }}
        </p>
      </div>

      <div class="grid lg:grid-cols-3 gap-6 mb-12">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
          <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center mb-5">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('home.cert_1_title') }}</h3>
          <p class="text-gray-600 leading-relaxed">{{ __('home.cert_1_description') }}</p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
          <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center mb-5">
            <i class="fas fa-award"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('home.cert_2_title') }}</h3>
          <p class="text-gray-600 leading-relaxed">{{ __('home.cert_2_description') }}</p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
          <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5">
            <i class="fas fa-lock"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('home.cert_3_title') }}</h3>
          <p class="text-gray-600 leading-relaxed">{{ __('home.cert_3_description') }}</p>
        </div>
      </div>

      <div class="rounded-[2rem] border border-slate-200 bg-gradient-to-br from-slate-50 via-white to-orange-50 p-8 lg:p-10 shadow-sm">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
        <div class="max-w-2xl">
          <span class="inline-flex items-center px-4 py-2 rounded-full bg-white text-orange-600 text-xs font-semibold tracking-[0.25em] uppercase border border-orange-100 shadow-sm">
            {{ __('home.partners_title') }}
          </span>
          <h3 class="text-3xl font-bold text-gray-900 mt-4 mb-3">{{ __('home.certifications_title') }}</h3>
          <p class="text-gray-600 leading-relaxed">
            {{ __('home.collabore_description') }}
          </p>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm max-w-sm">
          <p class="text-xs uppercase tracking-[0.25em] text-slate-400 mb-3">{{ __('home.partners_note') }}</p>
          <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.certifications_description') }}</p>
        </div>
      </div>

      <div class="overflow-hidden py-6 border-y border-slate-200/80">
        <div class="partners-marquee flex items-center space-x-16">

          <!-- Première série -->
          <img src="{{ asset('images/MasterCard.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Mastercard">

          <img src="{{ asset('images/Visa.webp') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Visa">

          <img src="{{ asset('images/PayPal.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="PayPal">

          <img src="{{ asset('images/Western_Union.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Western Union">

          <img src="{{ asset('images/Stripe.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Stripe">

          <img src="{{ asset('images/Revolut.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Revolut">

          <img src="{{ asset('images/N26.png') }}" 
              class="h-14 grayscale hover:grayscale-0 transition duration-300" alt="N26">

          <!-- Copie pour effet infinie -->
          <img src="{{ asset('images/MasterCard.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Mastercard">

          <img src="{{ asset('images/Visa.webp') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Visa">

          <img src="{{ asset('images/PayPal.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="PayPal">

          <img src="{{ asset('images/Western_Union.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Western Union">

          <img src="{{ asset('images/Stripe.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Stripe">

          <img src="{{ asset('images/Revolut.png') }}" 
              class="h-16 grayscale hover:grayscale-0 transition duration-300" alt="Revolut">

          <img src="{{ asset('images/N26.png') }}" 
              class="h-14 grayscale hover:grayscale-0 transition duration-300" alt="N26">
        </div>
      </div>

      <div class="grid md:grid-cols-3 gap-4 mt-8">
        <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
          <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('home.advantage_2_title') }}</p>
          <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.advantage_2_description') }}</p>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
          <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('home.advantage_3_title') }}</p>
          <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.advantage_3_description') }}</p>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-sm">
          <p class="text-sm font-semibold text-gray-900 mb-2">{{ __('home.advantage_4_title') }}</p>
          <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.advantage_4_description') }}</p>
        </div>
      </div>
      </div>

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
        {{ __('home.certifications_title') }}
      </h2>
      <p class="text-xl text-gray-600 leading-relaxed">
        {{ __('home.certifications_description') }}
      </p>
    </div>

    <!-- Cards -->
    <div class="grid md:grid-cols-3 gap-10">

      <!-- CARD 1 -->
      <div class="cert-card bg-white rounded-3xl shadow-lg p-8 text-center transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl fade-up">

        <img src="{{ asset('images/certification.png') }}"
             class="w-full h-40 object-cover rounded-2xl mb-6">

        <div class="flex justify-center mb-6">
          <span class="inline-flex items-center px-5 py-3 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold">
            <i class="fas fa-shield-alt mr-2"></i>{{ __('home.cert_1_badge') }}
          </span>
        </div>

        <h3 class="font-bold text-2xl mb-4 text-gray-900">{{ __('home.cert_1_title') }}</h3>

        <p class="text-gray-600 mb-6 leading-relaxed">
          {{ __('home.cert_1_description') }}
        </p>

        <div class="flex items-center justify-center space-x-1 text-yellow-400 text-xl">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="cert-card bg-white rounded-3xl shadow-lg p-8 text-center transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl fade-up">

        <img src="{{ asset('images/services.jpg') }}"
             class="w-full h-40 object-cover rounded-2xl mb-6">

        <div class="flex justify-center mb-6">
          <span class="inline-flex items-center px-5 py-3 rounded-full bg-indigo-50 text-indigo-600 text-sm font-semibold">
            <i class="fas fa-award mr-2"></i>{{ __('home.cert_2_badge') }}
          </span>
        </div>

        <h3 class="font-bold text-2xl mb-4 text-gray-900">{{ __('home.cert_2_title') }}</h3>

        <p class="text-gray-600 mb-6 leading-relaxed">
          {{ __('home.cert_2_description') }}
        </p>

        <div class="flex items-center justify-center space-x-2">
          <i class="fas fa-medal text-yellow-500 text-2xl"></i>
          <span class="text-sm text-gray-500 font-medium">{{ __('home.cert_2_distinction') }}</span>
        </div>

      </div>

      <!-- CARD 3 -->
      <div class="cert-card bg-white rounded-3xl shadow-lg p-8 text-center transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl fade-up">

        <img src="https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?auto=format&fit=crop&w=800&q=80"
             class="w-full h-40 object-cover rounded-2xl mb-6">

        <div class="flex justify-center mb-6">
          <span class="inline-flex items-center px-5 py-3 rounded-full bg-purple-50 text-purple-700 text-sm font-semibold">
            <i class="fas fa-user-shield mr-2"></i>{{ __('home.cert_3_badge') }}
          </span>
        </div>

        <h3 class="font-bold text-2xl mb-4 text-gray-900">{{ __('home.cert_3_title') }}</h3>

        <p class="text-gray-600 mb-6 leading-relaxed">
          {{ __('home.cert_3_description') }}
        </p>

        <div class="flex items-center justify-center space-x-2 text-gray-700">
          <i class="fas fa-lock"></i>
          <span class="text-sm font-medium">{{ __('home.cert_3_compliance') }}</span>
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
  @php
    $testimonials = [
      ['id' => 1, 'icon' => 'fas fa-user-tie', 'avatar_bg' => 'bg-blue-100', 'icon_color' => 'text-blue-600', 'badge_bg' => 'bg-blue-50', 'badge_text' => 'text-blue-700', 'border_color' => 'border-blue-100', 'photo' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=900&q=80', 'photo_class' => 'object-center'],
      ['id' => 2, 'icon' => 'fas fa-globe', 'avatar_bg' => 'bg-emerald-100', 'icon_color' => 'text-emerald-600', 'badge_bg' => 'bg-emerald-50', 'badge_text' => 'text-emerald-700', 'border_color' => 'border-emerald-100', 'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=900&q=80', 'photo_class' => 'object-center'],
      ['id' => 3, 'icon' => 'fas fa-building', 'avatar_bg' => 'bg-purple-100', 'icon_color' => 'text-purple-600', 'badge_bg' => 'bg-purple-50', 'badge_text' => 'text-purple-700', 'border_color' => 'border-purple-100', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=900&q=80', 'photo_class' => 'object-center'],
      ['id' => 4, 'icon' => 'fas fa-briefcase', 'avatar_bg' => 'bg-orange-100', 'icon_color' => 'text-orange-600', 'badge_bg' => 'bg-orange-50', 'badge_text' => 'text-orange-700', 'border_color' => 'border-orange-100', 'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=900&q=80', 'photo_class' => 'object-top'],
      ['id' => 5, 'icon' => 'fas fa-landmark', 'avatar_bg' => 'bg-slate-200', 'icon_color' => 'text-slate-700', 'badge_bg' => 'bg-slate-100', 'badge_text' => 'text-slate-700', 'border_color' => 'border-slate-200', 'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=900&q=80', 'photo_class' => 'object-center'],
    ];
  @endphp

  <section class="py-24 bg-gray-50 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.12),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(249,115,22,0.14),_transparent_35%)]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid xl:grid-cols-[0.82fr,1.18fr] gap-10 items-stretch">
        <div class="rounded-[2rem] bg-slate-950 text-white p-8 lg:p-10 shadow-[0_32px_64px_rgba(15,23,42,0.28)] h-full">
          <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 border border-white/10 text-xs font-semibold tracking-[0.25em] uppercase">
            {{ __('home.testimonials_title') }}
          </span>
          <h2 class="text-4xl lg:text-5xl font-bold mt-6 mb-5 leading-tight">{{ __('home.testimonials_title') }}</h2>
          <p class="text-lg text-slate-300 leading-relaxed">
            {{ __('home.testimonials_description') }}
          </p>

          <div class="grid grid-cols-3 gap-3 mt-8">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-center">
              <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">{{ __('home.stats_satisfaction') }}</p>
              <p class="text-2xl font-bold text-white">98%</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-center">
              <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">{{ __('home.dashboard_transfers') }}</p>
              <p class="text-2xl font-bold text-white">24/7</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-center">
              <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">{{ __('home.advantage_3_title') }}</p>
              <p class="text-2xl font-bold text-white">PDF</p>
            </div>
          </div>

          <div class="space-y-4 mt-8">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
              <p class="text-sm font-semibold text-white mb-2">{{ __('home.feature_3_title') }}</p>
              <p class="text-sm text-slate-300 leading-relaxed">{{ __('home.feature_3_description') }}</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
              <p class="text-sm font-semibold text-white mb-2">{{ __('home.advantage_4_title') }}</p>
              <p class="text-sm text-slate-300 leading-relaxed">{{ __('home.advantage_4_description') }}</p>
            </div>
          </div>
        </div>

        <div id="testimonial-slider" class="relative h-full flex flex-col">
          @foreach ($testimonials as $testimonial)
            <div class="testimonial-slide{{ $loop->first ? ' active' : '' }} premium-card rounded-[2rem] p-8 lg:p-10 border border-white/40 shadow-[0_24px_48px_rgba(15,23,42,0.12)] h-full min-h-[480px]">
              <div class="grid xl:grid-cols-[270px,1fr] gap-8 h-full items-stretch">
                <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6 flex flex-col justify-between">
                  <div>
                    <div class="relative overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-100 mb-6 shadow-sm">
                      <img
                        src="{{ $testimonial['photo'] }}"
                        alt="{{ __('home.testimonial_' . $testimonial['id'] . '_name') }}"
                        class="aspect-[4/5] w-full object-cover {{ $testimonial['photo_class'] }}"
                        loading="lazy"
                      >
                      <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                      <div class="absolute bottom-4 right-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-white/90 shadow-lg">
                        <i class="{{ $testimonial['icon'] }} {{ $testimonial['icon_color'] }} text-lg"></i>
                      </div>
                    </div>

                    <div class="flex items-center gap-4 mb-6">
                      <div class="w-14 h-14 rounded-full {{ $testimonial['avatar_bg'] }} flex items-center justify-center shadow-sm shrink-0">
                        <i class="{{ $testimonial['icon'] }} {{ $testimonial['icon_color'] }} text-xl"></i>
                      </div>
                      <div>
                        <p class="font-bold text-gray-900 text-lg">{{ __('home.testimonial_' . $testimonial['id'] . '_name') }}</p>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ __('home.testimonial_' . $testimonial['id'] . '_role') }}</p>
                      </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                      <span class="inline-flex items-center px-4 py-2 rounded-full border {{ $testimonial['border_color'] }} {{ $testimonial['badge_bg'] }} {{ $testimonial['badge_text'] }} text-sm font-semibold">
                        {{ __('home.testimonial_' . $testimonial['id'] . '_rating') }}
                      </span>
                      <span class="inline-flex items-center px-4 py-2 rounded-full border border-slate-200 bg-white text-slate-600 text-sm font-medium">
                        {{ __('home.feature_3_item_3') }}
                      </span>
                    </div>
                  </div>

                  <div class="rounded-2xl bg-white border border-slate-200 p-5 mt-6 xl:mt-8">
                    <div class="flex items-center gap-2 text-yellow-400 text-sm mb-3">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">{{ __('home.dashboard_transfers_in_progress') }}</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.hero_feature_3') }}</p>
                  </div>
                </div>

                <div class="flex flex-col justify-between h-full">
                  <div class="flex items-start gap-5">
                    <div class="hidden xl:flex w-14 h-14 rounded-2xl bg-orange-50 text-orange-500 items-center justify-center shrink-0">
                      <i class="fas fa-quote-left text-2xl"></i>
                    </div>

                    <div class="flex-1">
                      <p class="text-gray-700 text-xl xl:text-[1.35rem] leading-relaxed">
                        {{ __('home.testimonial_' . $testimonial['id'] . '_text') }}
                      </p>
                    </div>
                  </div>

                  <div class="grid sm:grid-cols-2 gap-4 mt-8 xl:mt-10">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                      <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">{{ __('home.hero_feature_2') }}</p>
                      <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.dashboard_step') }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                      <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">{{ __('home.hero_feature_4') }}</p>
                      <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.advantage_3_description') }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach

          <div class="flex justify-center xl:justify-start items-center flex-wrap gap-4 mt-8 xl:mt-10">
            @foreach ($testimonials as $testimonial)
              <button type="button" class="testimonial-dot{{ $loop->first ? ' active' : '' }} bg-transparent p-0" data-index="{{ $loop->index }}" aria-label="Testimonial {{ $loop->iteration }}"></button>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  @php
    $faqItems = [1, 2, 3, 4, 5, 6];
  @endphp

  <!-- FAQ -->
  <section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(59,130,246,0.10),_transparent_28%),radial-gradient(circle_at_bottom_left,_rgba(249,115,22,0.10),_transparent_32%)]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid xl:grid-cols-[0.88fr,1.12fr] gap-8 items-start">
        <div class="rounded-[2rem] border border-slate-200 bg-gradient-to-br from-slate-50 via-white to-orange-50 p-8 lg:p-10 shadow-sm">
          <span class="inline-flex items-center px-4 py-2 rounded-full bg-white text-orange-600 text-xs font-semibold tracking-[0.25em] uppercase border border-orange-100 shadow-sm">
            {{ __('home.nav_faq') }}
          </span>
          <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mt-6 mb-5 leading-tight">{{ __('home.faq_title') }}</h2>
          <p class="text-lg text-gray-600 leading-relaxed">
            {{ __('home.faq_description') }}
          </p>

          <div class="space-y-4 mt-8">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
              <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                  <i class="fas fa-shield-alt"></i>
                </div>
                <p class="font-semibold text-gray-900">{{ __('home.feature_1_title') }}</p>
              </div>
              <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.hero_security_note') }}</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
              <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                  <i class="fas fa-headset"></i>
                </div>
                <p class="font-semibold text-gray-900">{{ __('home.advantage_4_title') }}</p>
              </div>
              <p class="text-sm text-gray-600 leading-relaxed">{{ __('home.advantage_4_description') }}</p>
            </div>
          </div>
        </div>

        <div class="space-y-5" id="faq-list">
          @foreach ($faqItems as $faqIndex)
            <div class="faq-item rounded-[1.75rem] border border-slate-200 bg-white shadow-sm">
              <button type="button" class="w-full flex justify-between items-start gap-4 px-6 sm:px-8 py-6 text-left">
                <div class="flex items-start gap-4 pr-4">
                  <span class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center font-semibold shrink-0">
                    {{ str_pad((string) $faqIndex, 2, '0', STR_PAD_LEFT) }}
                  </span>
                  <div>
                    <p class="font-bold text-lg sm:text-xl text-gray-900 leading-snug">{{ __('home.faq_' . $faqIndex . '_question') }}</p>
                    <p class="text-gray-500 mt-2">{{ __('home.faq_' . $faqIndex . '_subtitle') }}</p>
                  </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                  <i class="fas fa-chevron-down text-lg"></i>
                </span>
              </button>
              <div class="faq-answer px-6 sm:px-8 pb-8">
                <div class="ml-[3.35rem] border-l border-orange-100 pl-5">
                  <p class="text-gray-600 leading-relaxed text-base sm:text-lg">
                    {{ __('home.faq_' . $faqIndex . '_answer') }}
                  </p>
                </div>
              </div>
            </div>
          @endforeach
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
      {{ __('home.cta_title') }}
    </h2>

    <p class="text-2xl text-gray-600 mb-10 leading-relaxed animate-text">
      {{ __('home.cta_description') }}
    </p>

    <!-- BUTTON -->
    <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" 
       class="cta-button px-14 py-5 rounded-xl text-2xl font-bold inline-block relative overflow-hidden">
       <span>{{ __('home.cta_button') }}</span>
    </a>

    <!-- SECURITY TEXT -->
    <p class="text-gray-500 mt-6 flex items-center justify-center animate-text">
      <i class="fas fa-lock mr-2"></i>
      {{ __('home.cta_security') }}
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
            <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center bg-white/95 p-2 rounded-xl shadow-md ring-1 ring-white/60">
              <img src='{{ asset("images/Logosite.png") }}' class="w-11 h-11 object-contain" alt="logo Valtrix Bank" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
            </a>
          </div>
          <p class="text-gray-400 mb-4">
            {{ __('home.footer_description') }}
          </p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin text-xl"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter text-xl"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook text-xl"></i></a>
          </div>
        </div>
        
        <div>
          <h3 class="text-white font-bold text-lg mb-6">{{ __('home.footer_services') }}</h3>
          <ul class="space-y-3">
            <li><a href="{{ localized_route('services.comptes-professionnels', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.services_business_accounts') }}</a></li>
            <li><a href="{{ localized_route('services.virements-internationaux', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.services_international_transfers') }}</a></li>
            <li><a href="{{ localized_route('services.gestion-tresorerie', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.services_treasury_management') }}</a></li>
            <li><a href="{{ localized_route('services.cartes-paiement', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.services_payment_cards') }}</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-white font-bold text-lg mb-6">{{ __('home.footer_about') }}</h3>
          <ul class="space-y-3">
            <li><a href="{{ localized_route('about.notre-histoire', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.footer_our_story') }}</a></li>
            <li><a href="{{ localized_route('about.carrieres', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.footer_careers') }}</a></li>
            <li><a href="{{ localized_route('about.presse', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.footer_press') }}</a></li>
            <li><a href="{{ localized_route('about.blog', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.footer_blog') }}</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-white font-bold text-lg mb-6">{{ __('home.footer_support') }}</h3>
          <ul class="space-y-3">
            <li><a href="{{ localized_route('support.centre-aide', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.footer_help_center') }}</a></li>
            <li><a href="{{ localized_route('support.nous-contacter', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.footer_contact_us') }}</a></li>
            <li><a href="{{ localized_route('support.securite', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.footer_security') }}</a></li>
            <li><a href="{{ localized_route('support.mentions-legales', ['locale' => app()->getLocale()]) }}" class="text-gray-400 hover:text-white transition">{{ __('home.footer_legal') }}</a></li>
          </ul>
        </div>
      </div>
      
      <div class="section-divider my-8"></div>
      
      <div class="text-center">
        <p>&copy; 2025 <span class="text-blue-400 font-semibold">Valtrix Bank</span>. {{ __('home.footer_copyright') }}</p>
        <p class="text-sm text-gray-500 mt-2">
          {{ __('home.footer_disclaimer') }}
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

        // Toggle submenu for {{ __('home.footer_services') }} in mobile menu
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
