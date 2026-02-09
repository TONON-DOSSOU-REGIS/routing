<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ __('auth.login_page_title') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

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

    .input-field { transition: all 0.2s ease; }
    .input-field:focus { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3); }

    .error-text { font-size: 0.825rem; }
  </style>
</head>

<body class="bg-slate-900 min-h-screen flex flex-col">
  @include('components.background-slider')
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
          <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}"><img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
          {{-- <i class="fas fa-building-columns text-blue-600 text-2xl"></i> --}}
          <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-xl font-semibold text-slate-800 hover:text-blue-700 transition"><span class="sr-only">SG BANK</span></a>
        </div>
        <div class="flex items-center space-x-4">
          @include('components.language-selector')
          <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="hidden sm:inline-block text-slate-700 hover:text-blue-600 transition">
            {{ __('auth.nav_create_account') }}
          </a>
          <a href="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg btn-hover shadow">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> {{ __('auth.nav_login') }}
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
            {{ __('auth.login_hero_title') }}
          </h1>
          <p class="mt-3 text-slate-200">
            {{ __('auth.login_hero_description') }}
          </p>
          <ul class="mt-6 space-y-3 text-slate-200">
            <li class="flex items-center"><i class="fa-solid fa-shield-halved text-blue-300 mr-3"></i> {{ __('auth.login_feature_security') }}</li>
            <li class="flex items-center"><i class="fa-solid fa-bell text-blue-300 mr-3"></i> {{ __('auth.login_feature_notifications') }}</li>
            <li class="flex items-center"><i class="fa-solid fa-chart-line text-blue-300 mr-3"></i> {{ __('auth.login_feature_analytics') }}</li>
          </ul>
        </div>

        <!-- Login card -->
        <div class="glass rounded-2xl p-6 sm:p-8 text-white fade-in-up">
          @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-500/20 text-green-200 border border-green-400/40">
              <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
            </div>
          @endif

          @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-500/20 text-red-200 border border-red-400/40">
              <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <h2 class="text-2xl font-bold mb-1">{{ __('auth.login_title') }}</h2>
          <p class="text-slate-200 mb-6">{{ __('auth.login_subtitle') }}</p>

          <form method="POST" action="{{ localized_route('login', ['locale' => app()->getLocale()]) }}" class="space-y-5">
            @csrf

            <div>
              <label for="email" class="block mb-1 text-sm text-slate-200">{{ __('auth.email') }}</label>
              <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}"
                     class="input-field w-full px-4 py-3 rounded-lg bg-white/90 text-slate-900 placeholder-slate-500 focus:outline-none"
                     placeholder="{{ __('auth.email_placeholder') }}">
              @error('email')
                <p class="error-text text-red-300 mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="password" class="block mb-1 text-sm text-slate-200">{{ __('auth.password') }}</label>
              <div class="relative">
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="input-field w-full px-4 py-3 pr-12 rounded-lg bg-white/90 text-slate-900 placeholder-slate-500 focus:outline-none"
                       placeholder="{{ __('auth.password_placeholder') }}">
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 text-slate-600 hover:text-slate-800">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
              @error('password')
                <p class="error-text text-red-300 mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-2">
                <input id="remember" type="checkbox" name="remember"
                       class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <label for="remember" class="text-sm text-slate-200">{{ __('auth.remember_me') }}</label>
              </div>
              <div class="text-sm">
                <a href="#" class="text-blue-300 hover:text-blue-200">{{ __('auth.forgot_password') }}</a>
              </div>
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 btn-hover shadow-lg font-semibold">
              {{ __('auth.login_button') }}
            </button>

            <div class="relative my-6">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/20"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-transparent text-slate-200">{{ __('auth.or') }}</span>
              </div>
            </div>

            <div class="text-center">
              <span class="text-slate-200">{{ __('auth.no_account') }}</span>
              <a href="{{ localized_route('register', ['locale' => app()->getLocale()]) }}" class="text-blue-300 hover:text-blue-200 font-semibold ml-1">{{ __('auth.register_link') }}</a>
            </div>
          </form>

          <div class="mt-6 grid grid-cols-2 gap-3">
            <button type="button" class="bg-white text-slate-700 py-2.5 px-4 rounded-lg flex items-center justify-center hover:bg-slate-100 transition btn-hover">
              <i class="fab fa-google text-red-500 mr-2"></i> {{ __('auth.login_with_google') }}
            </button>
            <button type="button" class="bg-white text-slate-700 py-2.5 px-4 rounded-lg flex items-center justify-center hover:bg-slate-100 transition btn-hover">
              <i class="fab fa-apple text-slate-800 mr-2"></i> {{ __('auth.login_with_apple') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="mt-auto text-center text-slate-200 py-6 bg-black/40 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4">
      <p>&copy; {{ date('Y') }} <span class="text-blue-300 font-semibold">SG BANK</span>. {{ __('auth.footer_copyright') }}</p>
      <div class="mt-2 flex justify-center space-x-4 text-sm">
        <a href="#" class="hover:text-blue-300 transition">{{ __('auth.footer_privacy') }}</a>
        <a href="#" class="hover:text-blue-300 transition">{{ __('auth.footer_terms') }}</a>
        <a href="#" class="hover:text-blue-300 transition">{{ __('auth.footer_support') }}</a>
      </div>
    </div>
  </footer>

  <script>
    const toggleBtn = document.getElementById("togglePassword");
    if (toggleBtn) {
      toggleBtn.addEventListener("click", function () {
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
    }
  </script>
</body>
</html>










