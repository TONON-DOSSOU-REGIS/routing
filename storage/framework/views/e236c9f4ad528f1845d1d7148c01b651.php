<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo e(__('auth.register_page_title')); ?></title>
  <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io11/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io11/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io11/favicon-16x16.png">
  <link rel="manifest" href="/favicon_io11/site.webmanifest">
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
  />

  <style>
    /* Animations élégantes */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeInUp 1s ease-out forwards; }

    /* Effet glassmorphism amélioré */
    .glass {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36);
    }

    /* Animation d'entrée pour les éléments */
    .stagger-item {
      opacity: 0;
      animation: fadeInUp 0.8s ease-out forwards;
    }

    .stagger-item:nth-child(1) { animation-delay: 0.1s; }
    .stagger-item:nth-child(2) { animation-delay: 0.2s; }
    .stagger-item:nth-child(3) { animation-delay: 0.3s; }
    .stagger-item:nth-child(4) { animation-delay: 0.4s; }
    .stagger-item:nth-child(5) { animation-delay: 0.5s; }
    .stagger-item:nth-child(6) { animation-delay: 0.6s; }
    .stagger-item:nth-child(7) { animation-delay: 0.7s; }
    .stagger-item:nth-child(8) { animation-delay: 0.8s; }

    /* Effet de survol amélioré pour les boutons */
    .btn-hover {
      transition: all 0.3s ease;
    }
    .btn-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Style pour les inputs */
    .input-field {
      transition: all 0.3s ease;
    }
    .input-field:focus {
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }

    /* Indicateur de force du mot de passe */
    .password-strength {
      height: 4px;
      border-radius: 2px;
      transition: all 0.3s ease;
    }
  </style>
</head>

<body class="bg-slate-900 min-h-screen flex flex-col">
  <?php echo $__env->make('components.background-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <!-- Hero background -->
  <div class="pointer-events-none fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 to-indigo-900/70"></div>
    <img alt="" class="w-full h-full object-cover opacity-30"
         src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&amp;fit=crop&amp;w=1920&amp;q=80">
  </div>

  <!-- Navigation améliorée -->
  <nav class="relative z-50 bg-white/90 shadow-lg backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center space-x-2">
          <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>"><img src='<?php echo e(asset("images/Logosite.png")); ?>' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
          
          <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="text-2xl font-bold text-blue-600"><span class="sr-only">Valtrix Bank</span></a>
        </div>
        <div class="hidden md:flex items-center space-x-4">
          <?php echo $__env->make('components.language-selector', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="text-gray-700 hover:text-blue-600 transition duration-300"><?php echo e(__('auth.nav_home')); ?></a>
          <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 btn-hover"><?php echo e(__('auth.nav_login')); ?></a>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden flex items-center">
          <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none transition duration-300">
            <i class="fas fa-bars text-xl"></i>
          </button>
        </div>
      </div>
      <div id="mobile-menu" class="hidden pb-4 md:hidden">
        <a href="<?php echo e(localized_route('home', ['locale' => app()->getLocale()])); ?>" class="block px-2 py-1 text-gray-700 hover:text-blue-600 transition duration-300"><?php echo e(__('auth.nav_home')); ?></a>
        <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="block px-2 py-1 bg-blue-600 text-white rounded-lg mt-2 btn-hover"><?php echo e(__('auth.nav_login')); ?></a>
      </div>
    </div>
  </nav>

  <!-- Formulaire d'inscription amélioré -->
  <div class="relative z-10 flex-grow fade-in-up px-4 py-8">
    <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Panneau gauche -->
        <div class="text-white fade-in-up">
          <h1 class="text-3xl sm:text-4xl font-extrabold">
            <?php echo e(__('auth.register_hero_title_1')); ?> <span class="text-orange-400"><?php echo e(__('auth.register_hero_title_2')); ?></span> <?php echo e(__('auth.register_hero_title_3')); ?> <span class="text-orange-400"><?php echo e(__('auth.register_hero_title_4')); ?></span>
          </h1>
          <p class="mt-3 text-slate-200">
            <?php echo e(__('auth.register_hero_description_1')); ?> <span class="text-orange-300"><?php echo e(__('auth.register_hero_description_2')); ?></span> <?php echo e(__('auth.register_hero_description_3')); ?> <span class="text-orange-300"><?php echo e(__('auth.register_hero_description_4')); ?></span>.
          </p>
          <ul class="mt-6 space-y-3 text-slate-200">
            <li class="flex items-center"><i class="fa-solid fa-bolt text-orange-400 mr-3"></i> <?php echo e(__('auth.register_feature_fast')); ?> <span class="text-white font-semibold"><?php echo e(__('auth.register_feature_fast_bold')); ?></span></li>
            <li class="flex items-center"><i class="fa-solid fa-shield-halved text-orange-400 mr-3"></i> <?php echo e(__('auth.register_feature_security')); ?> <span class="text-white font-semibold"><?php echo e(__('auth.register_feature_security_bold')); ?></span></li>
            <li class="flex items-center"><i class="fa-solid fa-bell text-orange-400 mr-3"></i> <?php echo e(__('auth.register_feature_notifications')); ?> <span class="text-white font-semibold"><?php echo e(__('auth.register_feature_notifications_bold')); ?></span></li>
          </ul>
        </div>
        <!-- Carte formulaire -->
        <div class="glass rounded-2xl p-8 shadow-2xl w-full text-white">
      <div class="text-center mb-8 stagger-item">
        <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-user-plus text-blue-300 text-2xl"></i>
        </div>
        <h2 class="text-3xl font-bold mb-2"><?php echo e(__('auth.register_title')); ?></h2>
        <p class="text-sm text-gray-200">
          <?php echo e(__('auth.already_account')); ?>

          <a href="<?php echo e(localized_route('login', ['locale' => app()->getLocale()])); ?>" class="font-medium text-blue-300 hover:text-blue-200 transition duration-300">
            <?php echo e(__('auth.login_link')); ?>

          </a>
        </p>
      </div>

      <?php if($errors->any()): ?>
        <div class="stagger-item rounded-lg border border-red-400/60 bg-red-500/20 px-4 py-3 text-sm text-red-100">
          <div class="font-semibold mb-1"><?php echo e(__('auth.register_error_title') ?? 'Merci de corriger les erreurs ci-dessous.'); ?></div>
          <ul class="list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="space-y-6" method="POST" action="<?php echo e(localized_route('register', ['locale' => app()->getLocale()])); ?>">
        <?php echo csrf_field(); ?>

        <!-- Informations de base -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 stagger-item">
          <div>
            <label for="first_name" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.first_name')); ?></label>
            <div class="relative">
              <i class="fas fa-user absolute left-3 top-2.5 text-gray-400"></i>
              <input id="first_name" name="first_name" type="text" required class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.first_name_placeholder')); ?>" value="<?php echo e(old('first_name')); ?>">
            </div>
          </div>
          <div>
            <label for="last_name" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.last_name')); ?></label>
            <div class="relative">
              <i class="fas fa-user absolute left-3 top-2.5 text-gray-400"></i>
              <input id="last_name" name="last_name" type="text" required class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.last_name_placeholder')); ?>" value="<?php echo e(old('last_name')); ?>">
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 stagger-item">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.email_address')); ?></label>
            <div class="relative">
              <i class="fas fa-envelope absolute left-3 top-2.5 text-gray-400"></i>
              <input id="email" name="email" type="email" required class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.email_address_placeholder')); ?>" value="<?php echo e(old('email')); ?>">
            </div>
          </div>
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.phone')); ?></label>
            <div class="relative">
              <i class="fas fa-phone absolute left-3 top-2.5 text-gray-400"></i>
              <input id="phone" name="phone" type="text" class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.phone_placeholder')); ?>" value="<?php echo e(old('phone')); ?>">
            </div>
          </div>
        </div>

        <div class="stagger-item">
          <label for="address" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.address')); ?></label>
          <div class="relative">
            <i class="fas fa-home absolute left-3 top-2.5 text-gray-400"></i>
            <input id="address" name="address" type="text" class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.address_placeholder')); ?>" value="<?php echo e(old('address')); ?>">
          </div>
        </div>

        <!-- Pays / Ville -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 stagger-item">
          <div>
            <label for="country" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.country')); ?></label>
            <div class="relative">
              <i class="fas fa-globe absolute left-3 top-2.5 text-gray-400"></i>
              <select id="country" name="country" class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field">
                <option value=""><?php echo e(__('auth.country_select')); ?></option>
                <option value="France" <?php echo e(old('country') == 'France' ? 'selected' : ''); ?>><?php echo e(__('auth.country_france')); ?></option>
                <option value="Allemagne" <?php echo e(old('country') == 'Allemagne' ? 'selected' : ''); ?>><?php echo e(__('auth.country_germany')); ?></option>
                <option value="Autriche" <?php echo e(old('country') == 'Autriche' ? 'selected' : ''); ?>><?php echo e(__('auth.country_austria')); ?></option>
                <option value="Belgique" <?php echo e(old('country') == 'Belgique' ? 'selected' : ''); ?>><?php echo e(__('auth.country_belgium')); ?></option>
                <option value="Bulgarie" <?php echo e(old('country') == 'Bulgarie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_bulgaria')); ?></option>
                <option value="Chypre" <?php echo e(old('country') == 'Chypre' ? 'selected' : ''); ?>><?php echo e(__('auth.country_cyprus')); ?></option>
                <option value="Croatie" <?php echo e(old('country') == 'Croatie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_croatia')); ?></option>
                <option value="Danemark" <?php echo e(old('country') == 'Danemark' ? 'selected' : ''); ?>><?php echo e(__('auth.country_denmark')); ?></option>
                <option value="Espagne" <?php echo e(old('country') == 'Espagne' ? 'selected' : ''); ?>><?php echo e(__('auth.country_spain')); ?></option>
                <option value="Estonie" <?php echo e(old('country') == 'Estonie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_estonia')); ?></option>
                <option value="Finlande" <?php echo e(old('country') == 'Finlande' ? 'selected' : ''); ?>><?php echo e(__('auth.country_finland')); ?></option>
                <option value="Grèce" <?php echo e(old('country') == 'Grèce' ? 'selected' : ''); ?>><?php echo e(__('auth.country_greece')); ?></option>
                <option value="Hongrie" <?php echo e(old('country') == 'Hongrie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_hungary')); ?></option>
                <option value="Irlande" <?php echo e(old('country') == 'Irlande' ? 'selected' : ''); ?>><?php echo e(__('auth.country_ireland')); ?></option>
                <option value="Italie" <?php echo e(old('country') == 'Italie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_italy')); ?></option>
                <option value="Lettonie" <?php echo e(old('country') == 'Lettonie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_latvia')); ?></option>
                <option value="Lituanie" <?php echo e(old('country') == 'Lituanie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_lithuania')); ?></option>
                <option value="Luxembourg" <?php echo e(old('country') == 'Luxembourg' ? 'selected' : ''); ?>><?php echo e(__('auth.country_luxembourg')); ?></option>
                <option value="Malte" <?php echo e(old('country') == 'Malte' ? 'selected' : ''); ?>><?php echo e(__('auth.country_malta')); ?></option>
                <option value="Pays-Bas" <?php echo e(old('country') == 'Pays-Bas' ? 'selected' : ''); ?>><?php echo e(__('auth.country_netherlands')); ?></option>
                <option value="Pologne" <?php echo e(old('country') == 'Pologne' ? 'selected' : ''); ?>><?php echo e(__('auth.country_poland')); ?></option>
                <option value="Portugal" <?php echo e(old('country') == 'Portugal' ? 'selected' : ''); ?>><?php echo e(__('auth.country_portugal')); ?></option>
                <option value="République Tchèque" <?php echo e(old('country') == 'République Tchèque' ? 'selected' : ''); ?>><?php echo e(__('auth.country_czech')); ?></option>
                <option value="Roumanie" <?php echo e(old('country') == 'Roumanie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_romania')); ?></option>
                <option value="Slovaquie" <?php echo e(old('country') == 'Slovaquie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_slovakia')); ?></option>
                <option value="Slovénie" <?php echo e(old('country') == 'Slovénie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_slovenia')); ?></option>
                <option value="Suède" <?php echo e(old('country') == 'Suède' ? 'selected' : ''); ?>><?php echo e(__('auth.country_sweden')); ?></option>
                <option value="Suisse" <?php echo e(old('country') == 'Suisse' ? 'selected' : ''); ?>><?php echo e(__('auth.country_switzerland')); ?></option>
                <option value="Norvège" <?php echo e(old('country') == 'Norvège' ? 'selected' : ''); ?>><?php echo e(__('auth.country_norway')); ?></option>
                <option value="Islande" <?php echo e(old('country') == 'Islande' ? 'selected' : ''); ?>><?php echo e(__('auth.country_iceland')); ?></option>
                <option value="Royaume-Uni" <?php echo e(old('country') == 'Royaume-Uni' ? 'selected' : ''); ?>><?php echo e(__('auth.country_uk')); ?></option>
                <option value="Albanie" <?php echo e(old('country') == 'Albanie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_albania')); ?></option>
                <option value="Bosnie-Herzégovine" <?php echo e(old('country') == 'Bosnie-Herzégovine' ? 'selected' : ''); ?>><?php echo e(__('auth.country_bosnia')); ?></option>
                <option value="Serbie" <?php echo e(old('country') == 'Serbie' ? 'selected' : ''); ?>><?php echo e(__('auth.country_serbia')); ?></option>
                <option value="Monténégro" <?php echo e(old('country') == 'Monténégro' ? 'selected' : ''); ?>><?php echo e(__('auth.country_montenegro')); ?></option>
                <option value="Macédoine du Nord" <?php echo e(old('country') == 'Macédoine du Nord' ? 'selected' : ''); ?>><?php echo e(__('auth.country_macedonia')); ?></option>
                <option value="Kosovo" <?php echo e(old('country') == 'Kosovo' ? 'selected' : ''); ?>><?php echo e(__('auth.country_kosovo')); ?></option>
                <option value="Andorre" <?php echo e(old('country') == 'Andorre' ? 'selected' : ''); ?>><?php echo e(__('auth.country_andorra')); ?></option>
                <option value="Liechtenstein" <?php echo e(old('country') == 'Liechtenstein' ? 'selected' : ''); ?>><?php echo e(__('auth.country_liechtenstein')); ?></option>
                <option value="Monaco" <?php echo e(old('country') == 'Monaco' ? 'selected' : ''); ?>><?php echo e(__('auth.country_monaco')); ?></option>
                <option value="Saint-Marin" <?php echo e(old('country') == 'Saint-Marin' ? 'selected' : ''); ?>><?php echo e(__('auth.country_san_marino')); ?></option>
                <option value="Vatican" <?php echo e(old('country') == 'Vatican' ? 'selected' : ''); ?>><?php echo e(__('auth.country_vatican')); ?></option>
                <option value="Canada" <?php echo e(old('country') == 'Canada' ? 'selected' : ''); ?>><?php echo e(__('auth.country_canada')); ?></option>
                <option value="Autre" <?php echo e(old('country') == 'Autre' ? 'selected' : ''); ?>><?php echo e(__('auth.country_other')); ?></option>
              </select>
            </div>
          </div>
          <div>
            <label for="city" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.city')); ?></label>
            <div class="relative">
              <i class="fas fa-city absolute left-3 top-2.5 text-gray-400"></i>
              <input id="city" name="city" type="text" class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.city_placeholder')); ?>" value="<?php echo e(old('city')); ?>">
            </div>
          </div>
        </div>

        <!-- Naissance / Identité -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 stagger-item">
          <div>
            <label for="date_of_birth" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.date_of_birth')); ?></label>
            <div class="relative">
              <i class="fas fa-calendar-alt absolute left-3 top-2.5 text-gray-400"></i>
              <input id="date_of_birth" name="date_of_birth" type="date" required class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" value="<?php echo e(old('date_of_birth')); ?>">
            </div>
          </div>
          <div>
            <label for="id_type" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.id_type')); ?></label>
            <div class="relative">
              <i class="fas fa-id-card absolute left-3 top-2.5 text-gray-400"></i>
              <select id="id_type" name="id_type" required class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field">
                <option value=""><?php echo e(__('auth.id_type_select')); ?></option>
                <option value="CNI"><?php echo e(__('auth.id_type_cni')); ?></option>
                <option value="Passport"><?php echo e(__('auth.id_type_passport')); ?></option>
                <option value="Permis"><?php echo e(__('auth.id_type_license')); ?></option>
              </select>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 stagger-item">
          <div>
            <label for="id_number" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.id_number')); ?></label>
            <div class="relative">
              <i class="fas fa-hashtag absolute left-3 top-2.5 text-gray-400"></i>
              <input id="id_number" name="id_number" type="text" required class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.id_number_placeholder')); ?>" value="<?php echo e(old('id_number')); ?>">
            </div>
          </div>
          <div>
            <label for="iban" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.iban')); ?></label>
            <div class="relative">
              <i class="fas fa-credit-card absolute left-3 top-2.5 text-gray-400"></i>
              <input id="iban" name="iban" type="text" class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.iban_placeholder')); ?>" value="<?php echo e(old('iban')); ?>">
            </div>
          </div>
        </div>

        <!-- Sécurité -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 stagger-item">
          <div>
            <label for="password" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.password_field')); ?></label>
            <div class="relative">
              <i class="fas fa-lock absolute left-3 top-2.5 text-gray-400"></i>
              <input id="password" name="password" type="password" required class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.password_placeholder')); ?>">
              <button type="button" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700" id="togglePassword">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div id="password-strength" class="mt-2">
              <div class="flex justify-between text-xs text-gray-300 mb-1">
                <span><?php echo e(__('auth.password_strength')); ?></span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-1">
                <div id="password-strength-bar" class="password-strength h-1 rounded-full bg-red-500 w-0"></div>
              </div>
            </div>
          </div>
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-200 mb-1"><?php echo e(__('auth.confirm_password')); ?></label>
            <div class="relative">
              <i class="fas fa-lock absolute left-3 top-2.5 text-gray-400"></i>
              <input id="password_confirmation" name="password_confirmation" type="password" required class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field" placeholder="<?php echo e(__('auth.password_placeholder')); ?>">
              <button type="button" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700" id="togglePasswordConfirmation">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Conditions -->
        <div class="flex items-center mt-4 stagger-item">
          <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
          <label for="terms" class="ml-2 text-sm text-gray-200">
            <?php echo e(__('auth.terms_accept')); ?>

            <a href="#" class="text-blue-300 hover:text-blue-200 transition duration-300"><?php echo e(__('auth.terms_link')); ?></a>
            <?php echo e(__('auth.terms_and')); ?>

            <a href="#" class="text-blue-300 hover:text-blue-200 transition duration-300"><?php echo e(__('auth.privacy_link')); ?></a>
          </label>
        </div>

        <!-- Bouton -->
        <div class="stagger-item">
          <button
            type="submit"
            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-lg shadow-lg btn-hover transition duration-300"
          >
            <i class="fas fa-user-plus mr-2"></i> <?php echo e(__('auth.register_button')); ?>

          </button>
        </div>
      </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer amélioré -->
  <footer class="relative z-10 text-center text-gray-300 py-6 bg-black bg-opacity-40 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4">
      <p>&copy; 2025 <span class="text-blue-300 font-semibold">Valtrix Bank</span>. <?php echo e(__('auth.footer_copyright')); ?></p>
      <div class="mt-2 flex justify-center space-x-4 text-sm">
        <a href="#" class="hover:text-blue-300 transition duration-300"><?php echo e(__('auth.footer_privacy')); ?></a>
        <a href="#" class="hover:text-blue-300 transition duration-300"><?php echo e(__('auth.footer_terms')); ?></a>
        <a href="#" class="hover:text-blue-300 transition duration-300"><?php echo e(__('auth.footer_support')); ?></a>
      </div>
    </div>
  </footer>

  <script>
    // Toggle menu mobile
    document.getElementById("mobile-menu-button").addEventListener("click", function () {
      const menu = document.getElementById("mobile-menu");
      menu.classList.toggle("hidden");
    });

    // Toggle password visibility
    document.getElementById("togglePassword").addEventListener("click", function() {
      const passwordInput = document.getElementById("password");
      const icon = this.querySelector("i");
      
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    });

    // Toggle password confirmation visibility
    document.getElementById("togglePasswordConfirmation").addEventListener("click", function() {
      const passwordInput = document.getElementById("password_confirmation");
      const icon = this.querySelector("i");
      
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    });

    // Password strength indicator
    document.getElementById("password").addEventListener("input", function() {
      const password = this.value;
      const strengthBar = document.getElementById("password-strength-bar");
      let strength = 0;
      
      if (password.length >= 8) strength += 25;
      if (/[A-Z]/.test(password)) strength += 25;
      if (/[0-9]/.test(password)) strength += 25;
      if (/[^A-Za-z0-9]/.test(password)) strength += 25;
      
      strengthBar.style.width = strength + '%';
      
      if (strength < 50) {
        strengthBar.style.backgroundColor = '#ef4444'; // red
      } else if (strength < 75) {
        strengthBar.style.backgroundColor = '#f59e0b'; // amber
      } else {
        strengthBar.style.backgroundColor = '#10b981'; // green
      }
    });
  </script>
</body>
</html>










<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\auth\register.blade.php ENDPATH**/ ?>