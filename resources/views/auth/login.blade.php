<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion - BankPro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
  />

  <style>
    /* Animation fluide */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeInUp 1s ease-out forwards; }

    /* Effet Glassmorphism amélioré */
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
  </style>
</head>

<body
  class="bg-cover bg-center bg-no-repeat min-h-screen flex flex-col justify-between"
  style="background-image: url('https://images.unsplash.com/photo-1601597111158-2fceff292cdc?auto=format&fit=crop&w=1920&q=80');"
>
  <!-- Overlay sombre amélioré -->
  <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 to-indigo-900/70"></div>

  <!-- Navigation améliorée -->
  <nav class="relative z-10 bg-white/90 shadow-lg backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center space-x-2">
          <i class="fas fa-building-columns text-blue-600 text-2xl"></i>
          <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">BankPro</a>
        </div>
        <div class="hidden md:flex items-center space-x-4">
          <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition duration-300">Accueil</a>
          <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 btn-hover">Créer un compte</a>
        </div>
        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center">
          <button
            id="mobile-menu-button"
            class="text-gray-700 hover:text-blue-600 focus:outline-none transition duration-300"
          >
            <i class="fas fa-bars text-xl"></i>
          </button>
        </div>
      </div>

      <!-- Mobile menu -->
      <div id="mobile-menu" class="hidden pb-4 md:hidden">
        <a href="{{ route('home') }}" class="block px-2 py-1 text-gray-700 hover:text-blue-600 transition duration-300">Accueil</a>
        <a href="{{ route('register') }}" class="block px-2 py-1 bg-blue-600 text-white rounded-lg mt-2 btn-hover">Créer un compte</a>
      </div>
    </div>
  </nav>

  <!-- Formulaire de Connexion amélioré -->
  <div class="relative z-10 flex-grow flex items-center justify-center fade-in-up px-4 py-8">
    <div class="glass rounded-2xl p-8 shadow-2xl max-w-md w-full text-white">
      <div class="text-center mb-8 stagger-item">
        <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-lock text-blue-300 text-2xl"></i>
        </div>
        <h2 class="text-3xl font-bold mb-2">Connexion sécurisée</h2>
        <p class="text-sm text-gray-200">
          Ou
          <a href="{{ route('register') }}" class="font-medium text-blue-300 hover:text-blue-200 transition duration-300">
            créez un nouveau compte
          </a>
        </p>
      </div>

      @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 stagger-item">
          <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
      @endif

      <form class="space-y-6" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="space-y-4">
          <div class="stagger-item">
            <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Adresse email</label>
            <div class="relative">
              <i class="fas fa-envelope absolute left-3 top-2.5 text-gray-400"></i>
              <input
                id="email"
                name="email"
                type="email"
                autocomplete="email"
                required
                class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field"
                placeholder="Entrez votre email"
                value="{{ old('email') }}"
              />
            </div>
          </div>

          <div class="stagger-item">
            <label for="password" class="block text-sm font-medium text-gray-200 mb-1">Mot de passe</label>
            <div class="relative">
              <i class="fas fa-lock absolute left-3 top-2.5 text-gray-400"></i>
              <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
                class="pl-10 w-full px-3 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none input-field"
                placeholder="••••••••"
              />
              <button type="button" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700" id="togglePassword">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>
        </div>

        @error('email')
          <p class="text-red-300 text-sm mt-2 stagger-item">{{ $message }}</p>
        @enderror

        <div class="flex items-center justify-between mt-4 stagger-item">
          <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="remember_me" class="ml-2 text-sm text-gray-200">Se souvenir de moi</label>
          </div>
          <a href="#" class="text-sm text-blue-300 hover:text-blue-200 transition duration-300">Mot de passe oublié ?</a>
        </div>

        <div class="stagger-item">
          <button
            type="submit"
            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-lg shadow-lg btn-hover transition duration-300"
          >
            <i class="fas fa-right-to-bracket mr-2"></i> Se connecter
          </button>
        </div>
      </form>

      <!-- Séparateur -->
      <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
          <div class="w-full border-t border-gray-300/30"></div>
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-2 bg-transparent text-gray-300">Ou continuer avec</span>
        </div>
      </div>

      <!-- Options de connexion alternatives -->
      <div class="grid grid-cols-2 gap-3 stagger-item">
        <button type="button" class="bg-white text-gray-700 py-2 px-4 rounded-lg flex items-center justify-center hover:bg-gray-100 transition duration-300 btn-hover">
          <i class="fab fa-google text-red-500 mr-2"></i> Google
        </button>
        <button type="button" class="bg-white text-gray-700 py-2 px-4 rounded-lg flex items-center justify-center hover:bg-gray-100 transition duration-300 btn-hover">
          <i class="fab fa-apple text-gray-800 mr-2"></i> Apple
        </button>
      </div>
    </div>
  </div>

  <!-- Footer amélioré -->
  <footer class="relative z-10 text-center text-gray-300 py-6 bg-black bg-opacity-40 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4">
      <p>&copy; 2025 <span class="text-blue-300 font-semibold">BankPro</span>. Tous droits réservés.</p>
      <div class="mt-2 flex justify-center space-x-4 text-sm">
        <a href="#" class="hover:text-blue-300 transition duration-300">Confidentialité</a>
        <a href="#" class="hover:text-blue-300 transition duration-300">Conditions</a>
        <a href="#" class="hover:text-blue-300 transition duration-300">Assistance</a>
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
  </script>
</body>
</html>