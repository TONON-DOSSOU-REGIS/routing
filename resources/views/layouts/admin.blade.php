@extends('layouts.app')

@section('title', 'Administration - Zuider Bank S.A')

@push('head')
    @vite(['resources/css/app.css'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Import de polices */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        /* Animations simples */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .slide-in {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Navigation simplifiée */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Boutons d'action simplifiés */
        .action-btn {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Effets de texte simplifiés */
        .text-gradient-gold {
            color: #d4af37;
            font-weight: 600;
        }

        .text-gradient-platinum {
            color: #c0c0c0;
            font-weight: 500;
        }

        /* Animation de pulsation simple */
        @keyframes pulse-vip {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .pulse-vip {
            animation: pulse-vip 3s ease-in-out infinite;
        }

        /* Bordures dorées simples */
        .border-gold {
            border: 2px solid #d4af37;
            border-radius: 8px;
        }

        /* Police */
        .font-cinzel {
            font-family: 'Cinzel', serif;
        }

        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        /* Hover effects simples */
        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
        }

        /* Background simple */
        .simple-bg {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* Styles pour les badges Bootstrap */
        .badge-lg {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        /* Styles pour l'état vide */
        .empty-state {
            text-align: center;
        }
        @include('components.admin-dashboard-background-styles')
    </style>
@endpush

@section('content')
<div class="simple-bg min-h-screen font-inter">

    @include('components.admin-dashboard-background')

    <div class="min-h-screen relative z-10">
        <!-- Navigation ultra-premium -->
        <nav class="glass-nav sticky top-0 z-50 border-gold slide-in">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <div class="flex items-center space-x-4">
                            <div class="gradient-vip-gold p-3 rounded-2xl pulse-vip border-gold">
                                <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center bg-white/95 p-2 rounded-xl shadow-md ring-1 ring-white/60"><img src='{{ asset("images/Logosite.png") }}' class="w-11 h-11 object-contain" alt="logo Zuider Bank S.A" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
                            </div>
                            <div>
                                <a href="{{ localized_route('admin.dashboard') }}" class="text-2xl font-bold font-cinzel text-gradient-gold hover:scale-105 transition-transform duration-300" aria-label="Zuider Bank S.A"><span class="sr-only">Zuider Bank S.A</span></a>
                                <div class="text-xs text-gradient-platinum font-medium -mt-1">Administration VIP</div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Navigation Premium -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ localized_route('admin.dashboard') }}" class="relative text-gray-700 hover:text-gray-900 transition-all duration-300 font-medium group font-inter text-lg">
                            <i class="fas fa-tachometer-alt mr-2 text-blue-600"></i> Dashboard
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ localized_route('admin.users') }}" class="relative text-gray-700 hover:text-gray-900 transition-all duration-300 font-medium group font-inter text-lg">
                            <i class="fas fa-users mr-2 text-green-600"></i> {{ __('admin_dashboard.nav_users') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ localized_route('admin.transactions') }}" class="relative text-gray-700 hover:text-gray-900 transition-all duration-300 font-medium group font-inter text-lg">
                            <i class="fas fa-exchange-alt mr-2 text-purple-600"></i> {{ __('admin_dashboard.nav_transfers') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-purple-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ localized_route('admin.deposit') }}" class="relative text-gray-700 hover:text-gray-900 transition-all duration-300 font-medium group font-inter text-lg">
                            <i class="fas fa-plus-circle mr-2 text-indigo-600"></i> {{ __('admin_dashboard.nav_deposit') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ localized_route('budgets.index') }}" class="relative text-gray-700 hover:text-gray-900 transition-all duration-300 font-medium group font-inter text-lg">
                            <i class="fas fa-chart-pie mr-2 text-pink-600"></i> Budgets
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-pink-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ localized_route('admin.settings') }}" class="relative text-gray-700 hover:text-gray-900 transition-all duration-300 font-medium group font-inter text-lg">
                            <i class="fas fa-cog mr-2 text-gray-600"></i> {{ __('admin_dashboard.nav_settings') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gray-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <div class="h-8 w-px bg-gray-300"></div>
                        <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="relative text-gray-700 hover:text-gray-900 transition-all duration-300 font-medium group font-inter text-lg">
                            <i class="fas fa-arrow-left mr-2 text-emerald-600"></i> {{ __('common.back') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        @include('components.notification-bell')
                        <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}" class="relative">
                            @csrf
                            <button type="submit" class="relative text-gray-700 hover:text-red-600 transition-all duration-300 font-medium group font-inter text-lg">
                                <i class="fas fa-sign-out-alt mr-2 text-red-500"></i> {{ __('admin_dashboard.nav_logout') }}
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-500 transition-all duration-300 group-hover:w-full"></span>
                            </button>
                        </form>
                    </div>

                    <!-- Mobile menu button premium -->
                    <div class="md:hidden flex items-center">
                        <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-gray-900 focus:outline-none transition-all duration-300 p-3 rounded-xl hover:bg-gray-100">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation Menu Premium -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-4 pt-4 pb-4 space-y-2 sm:px-4 glass-card border-gold rounded-2xl shadow-2xl mt-4">
                        <a href="{{ localized_route('admin.dashboard') }}" class="flex items-center px-4 py-4 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-xl transition-all duration-300 border border-gray-200">
                            <i class="fas fa-tachometer-alt w-6 mr-4 text-center text-blue-600"></i> Dashboard
                        </a>
                        <a href="{{ localized_route('admin.users') }}" class="flex items-center px-4 py-4 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-xl transition-all duration-300 border border-gray-200">
                            <i class="fas fa-users w-6 mr-4 text-center text-green-600"></i> {{ __('admin_dashboard.nav_users') }}
                        </a>
                        <a href="{{ localized_route('admin.transactions') }}" class="flex items-center px-4 py-4 text-base font-medium text-gray-700 hover:text-purple-600 hover:bg-gray-50 rounded-xl transition-all duration-300 border border-gray-200">
                            <i class="fas fa-exchange-alt w-6 mr-4 text-center text-purple-600"></i> {{ __('admin_dashboard.nav_transfers') }}
                        </a>
                        <a href="{{ localized_route('admin.deposit') }}" class="flex items-center px-4 py-4 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-xl transition-all duration-300 border border-gray-200">
                            <i class="fas fa-plus-circle w-6 mr-4 text-center text-indigo-600"></i> {{ __('admin_dashboard.nav_deposit') }}
                        </a>
                        <a href="{{ localized_route('admin.settings') }}" class="flex items-center px-4 py-4 text-base font-medium text-gray-700 hover:text-gray-600 hover:bg-gray-50 rounded-xl transition-all duration-300 border border-gray-200">
                            <i class="fas fa-cog w-6 mr-4 text-center text-gray-600"></i> {{ __('admin_dashboard.nav_settings') }}
                        </a>
                        <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="flex items-center px-4 py-4 text-base font-medium text-gray-700 hover:text-emerald-600 hover:bg-gray-50 rounded-xl transition-all duration-300 border border-gray-200">
                            <i class="fas fa-arrow-left w-6 mr-4 text-center text-emerald-600"></i> {{ __('admin_dashboard.nav_back') }}
                        </a>
                        <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}" class="block">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-4 text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 rounded-xl transition-all duration-300 border border-gray-200">
                                <i class="fas fa-sign-out-alt w-6 mr-4 text-center text-red-500"></i> {{ __('admin_dashboard.nav_logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenu principal avec effets premium -->
        <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8 relative">
            <!-- Effet de particules supplémentaires -->
            <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
                <div class="absolute top-20 left-10 w-2 h-2 bg-yellow-100 rounded-full opacity-60 animate-ping"></div>
                <div class="absolute top-40 right-20 w-1 h-1 bg-blue-400 rounded-full opacity-40 animate-pulse"></div>
                <div class="absolute bottom-20 left-1/4 w-3 h-3 bg-purple-400 rounded-full opacity-30 float"></div>
            </div>

            <div class="relative z-10">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
    @include('components.admin-dashboard-background-script')
    @include('components.admin-chat-widget-v2')
</div>
@endsection




