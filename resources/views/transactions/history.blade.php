<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('transactions.history_page_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io11/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io11/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io11/favicon-16x16.png">
    <link rel="manifest" href="/favicon_io11/site.webmanifest">
    <style>
        /* Animations élégantes */
        @keyframes fadeInUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateX(-20px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }
        
        .fade-in-up { 
            animation: fadeInUp 0.6s ease-out forwards; 
        }
        
        .slide-in { 
            animation: slideIn 0.5s ease-out forwards; 
        }
        
        /* Animation d'entrée pour les éléments */
        .stagger-item {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .stagger-item:nth-child(1) { animation-delay: 0.1s; }
        .stagger-item:nth-child(2) { animation-delay: 0.2s; }
        .stagger-item:nth-child(3) { animation-delay: 0.3s; }
        .stagger-item:nth-child(4) { animation-delay: 0.4s; }
        
        /* Effet de survol amélioré */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Effet glassmorphism pour la navigation */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        /* Style pour les boutons d'action */
        .action-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .action-btn:hover::before {
            left: 100%;
        }
        
        /* Style pour les cartes avec effet glass */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        /* Style pour les inputs */
        .input-field {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.7);
        }
        
        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.9);
        }

        /* Style pour l'arrière-plan */
        .background-container {
            background-image: url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        .background-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(139, 92, 246, 0.85) 50%, rgba(14, 165, 233, 0.9) 100%);
            backdrop-filter: blur(2px);
        }

        @media (max-width: 640px) {
            .background-container {
                background-attachment: scroll;
            }
        }

        /* Style pour les badges */
        .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Style pour le tableau */
        .table-row-hover {
            transition: all 0.2s ease;
        }

        .table-row-hover:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: scale(1.01);
        }

        /* Style pour les barres de progression */
        .progress-bar {
            position: relative;
            overflow: hidden;
        }

        .progress-fill {
            height: 6px;
            border-radius: 3px;
            transition: all 0.5s ease;
        }

        /* Style pour les icônes de type de transaction */
        .transaction-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
    </style>
</head>
<body class="min-h-screen">
  @include('components.background-slider')
<!-- Container avec image de fond -->
    <div class="background-container min-h-screen">
        <div class="min-h-screen relative z-10">
            <!-- Navigation améliorée -->
            <nav class="glass-nav sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-2 rounded-lg">
                                    <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}"><img src='{{ asset("images/Logosite.png") }}' class="w-9 h-9" alt="" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;"></a>
                                </div>
                                <div>
                                    <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"><span class="sr-only">Valtrix Bank</span></a>
                                    <div class="text-xs text-gray-500 -mt-1">{{ __('transactions.history_title') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex items-center space-x-6">
                            <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="relative text-gray-700 hover:text-blue-600 transition duration-300 font-medium group">
                                <i class="fas fa-tachometer-alt mr-2"></i> {{ __('transactions.dashboard') }}
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="{{ localized_route('transfer.create', ['locale' => app()->getLocale()]) }}" class="action-btn bg-gradient-to-r from-orange-500 to-amber-500 text-white px-4 py-2 rounded-xl hover:from-orange-600 hover:to-amber-600 font-medium shadow-lg transition duration-300 flex items-center gap-2">
                                <i class="fas fa-paper-plane"></i>
                                {{ __('transactions.new_transfer') }}
                            </a>
                            <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}">
                                @csrf
                                <button type="submit" class="relative text-gray-700 hover:text-red-600 transition duration-300 font-medium group">
                                    <i class="fas fa-sign-out-alt mr-2"></i> {{ __('transactions.logout') }}
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                                </button>
                            </form>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden flex items-center">
                            <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none transition duration-300 p-2 rounded-lg hover:bg-blue-50">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile menu -->
                    <div id="mobile-menu" class="hidden pb-4">
                        <div class="px-2 pt-2 pb-3 space-y-2 bg-white/95 backdrop-blur-lg border border-gray-200 rounded-lg shadow-xl mt-2">
                            <a href="{{ localized_route('dashboard', ['locale' => app()->getLocale()]) }}" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i>
                                {{ __('transactions.dashboard') }}
                            </a>
                            <a href="{{ localized_route('transfer.create', ['locale' => app()->getLocale()]) }}" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-300">
                                <i class="fas fa-paper-plane w-5 mr-3 text-center"></i>
                                {{ __('transactions.new_transfer') }}
                            </a>
                            <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition duration-300">
                                    <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                                    {{ __('transactions.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <!-- En-tête de la page -->
                <div class="mb-8 fade-in-up">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white drop-shadow-lg text-center">{{ __('transactions.history_title') }}</h1>
                    <p class="text-white/90 mt-2 drop-shadow text-center">{{ __('transactions.history_subtitle') }}</p>
                </div>

                <!-- Carte principale -->
                <div class="glass-card rounded-2xl overflow-hidden card-hover">
                    <div class="px-4 sm:px-8 py-6 sm:py-8">
                        <!-- En-tête avec statistiques -->
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-3 rounded-2xl mr-4 shadow-lg">
                                    <i class="fas fa-history text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ __('transactions.history_title') }}</h1>
                                    <p class="text-gray-600 mt-1">{{ __('transactions.history_overview') }}</p>
                                </div>
                            </div>
                            
                            @if(auth()->user()->isAdmin())
                                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                    <a href="{{ localized_route('admin.export.pdf') }}" 
                                       class="action-btn bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-3 rounded-xl hover:from-red-600 hover:to-pink-700 font-semibold shadow-lg transition duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                        <i class="fas fa-file-pdf"></i>
                                        {{ __('transactions.export_pdf') }}
                                    </a>
                                    <a href="{{ localized_route('admin.export.excel') }}" 
                                       class="action-btn bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl hover:from-green-600 hover:to-emerald-700 font-semibold shadow-lg transition duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                                        <i class="fas fa-file-excel"></i>
                                        {{ __('transactions.export_excel') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Filtres améliorés -->
                        <div class="mb-8 stagger-item">
                            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                                <div>
                                    <label for="type" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <i class="fas fa-filter mr-2 text-blue-500"></i>
                                        {{ __('transactions.filter_type') }}
                                    </label>
                                    <select name="type" id="type" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-field">
                                        <option value="">{{ __('transactions.all_types') }}</option>
                                        <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>{{ __('transactions.type_transfer') }}</option>
                                        <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>{{ __('transactions.type_deposit') }}</option>
                                        <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>{{ __('transactions.type_withdrawal') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <i class="fas fa-circle mr-2 text-green-500"></i>
                                        {{ __('transactions.filter_status') }}
                                    </label>
                                    <select name="status" id="status" class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 input-field">
                                        <option value="">{{ __('transactions.all_statuses') }}</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('transactions.status_pending') }}</option>
                                        <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>{{ __('transactions.status_on_hold') }}</option>
                                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>{{ __('transactions.status_success') }}</option>
                                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>{{ __('transactions.status_failed') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="date_from" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <i class="fas fa-calendar mr-2 text-purple-500"></i>
                                        {{ __('transactions.filter_date_from') }}
                                    </label>
                                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 input-field">
                                </div>

                                <div>
                                    <label for="date_to" class="block text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <i class="fas fa-calendar mr-2 text-orange-500"></i>
                                        {{ __('transactions.filter_date_to') }}
                                    </label>
                                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 input-field">
                                </div>

                                <div class="flex items-end">
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-xl hover:from-gray-700 hover:to-gray-800 font-medium shadow-lg transition duration-300 flex items-center justify-center gap-2">
                                        <i class="fas fa-filter"></i>
                                        {{ __('transactions.filter_apply') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau des transactions amélioré -->
                        <div class="overflow-hidden rounded-2xl stagger-item">
                            <div class="overflow-x-auto">
                                <table class="min-w-[900px] w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                        <tr>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-hashtag text-blue-500"></i>
                                                    {{ __('transactions.table_transaction') }}
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-exchange-alt text-purple-500"></i>
                                                    {{ __('transactions.table_type') }}
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-euro-sign text-green-500"></i>
                                                    {{ __('transactions.table_amount') }}
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user text-indigo-500"></i>
                                                    {{ __('transactions.table_beneficiary') }}
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-circle text-yellow-500"></i>
                                                    {{ __('transactions.table_status') }}
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-chart-line text-red-500"></i>
                                                    {{ __('transactions.table_progress') }}
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-calendar text-gray-500"></i>
                                                    {{ __('transactions.table_date') }}
                                                </div>
                                            </th>
                                            <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-cog text-gray-500"></i>
                                                    {{ __('transactions.table_actions') }}
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($transactions as $transaction)
                                            @php
                                                $typeKey = match ($transaction->type) {
                                                    'transfer' => 'type_transfer',
                                                    'deposit' => 'type_deposit',
                                                    'withdrawal' => 'type_withdrawal',
                                                    default => null,
                                                };
                                                $typeLabel = $typeKey ? __('transactions.' . $typeKey) : ucfirst($transaction->type);
                                                $statusKey = match ($transaction->status) {
                                                    'pending' => 'status_pending',
                                                    'on_hold' => 'status_on_hold',
                                                    'success' => 'status_success',
                                                    'failed' => 'status_failed',
                                                    'refunded' => 'status_refunded',
                                                    default => null,
                                                };
                                                $statusLabel = $statusKey ? __('transactions.' . $statusKey) : ucfirst(str_replace('_', ' ', $transaction->status));
                                            @endphp
                                            <tr class="table-row-hover">
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        #{{ $transaction->id }}
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <div class="transaction-icon 
                                                            @if($transaction->type == 'transfer') bg-blue-100 text-blue-600
                                                            @elseif($transaction->type == 'deposit') bg-green-100 text-green-600
                                                            @else bg-red-100 text-red-600 @endif">
                                                            <i class="fas fa-@if($transaction->type == 'transfer') paper-plane @elseif($transaction->type == 'deposit') arrow-down @else arrow-up @endif"></i>
                                                        </div>
                                                        <span class="text-sm font-medium text-gray-900 capitalize">
                                                            {{ $typeLabel }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold @if($transaction->type == 'deposit') text-green-600 @elseif($transaction->type == 'withdrawal') text-red-600 @else text-gray-900 @endif">
                                                        {{ \App\Helpers\CurrencyHelper::format($transaction->amount, $transaction->user->default_currency ?? 'EUR') }}
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        {{ $transaction->recipient_name ?? __('transactions.not_available') }}
                                                    </div>
                                                        @if($transaction->recipient_iban)
                                                        <div class="text-xs text-gray-500">
                                                            {{ substr($transaction->recipient_iban, 0, 4) }}...{{ substr($transaction->recipient_iban, -4) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <span class="badge 
                                                        @if($transaction->status == 'success') 
                                                            bg-gradient-to-r from-green-100 to-green-200 text-green-800
                                                        @elseif($transaction->status == 'on_hold')
                                                            bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800
                                                        @elseif($transaction->status == 'pending')
                                                            bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800
                                                        @else 
                                                            bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 
                                                        @endif">
                                                        <i class="fas fa-@if($transaction->status == 'success') check-circle @elseif($transaction->status == 'on_hold') clock @elseif($transaction->status == 'pending') hourglass-half @else ban @endif"></i>
                                                        {{ $statusLabel }}
                                                    </span>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="progress-fill 
                                                            @if($transaction->progress >= 100) bg-green-500
                                                            @elseif($transaction->progress >= 70) bg-blue-500
                                                            @elseif($transaction->progress >= 30) bg-yellow-500
                                                            @else bg-red-500 @endif" 
                                                            style="width: {{ $transaction->progress }}%">
                                                        </div>
                                                    </div>
                                                    <div class="text-xs text-gray-500 text-center mt-1">
                                                        {{ $transaction->progress }}%
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 font-medium">
                                                        {{ $transaction->created_at->format('d/m/Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $transaction->created_at->format('H:i') }}
                                                    </div>
                                                </td>
                                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-2">
                                                        @if($transaction->status == 'success' && in_array($transaction->type, ['transfer', 'deposit']))
                                                            <a href="{{ localized_route('transactions.receipt', $transaction) }}" 
                                                               class="bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:from-blue-100 hover:to-blue-200 transition duration-300 flex items-center gap-2 text-sm font-medium shadow-sm"
                                                               title="{{ __('transactions.action_download_receipt') }}">
                                                                <i class="fas fa-download"></i>
                                                                <span class="hidden sm:inline">{{ __('transactions.action_receipt') }}</span>
                                                            </a>
                                                        @endif
                                                        @if($transaction->status == 'on_hold')
                                                            <span class="text-yellow-600 text-sm font-medium px-3 py-2 bg-yellow-50 rounded-lg">
                                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                {{ $transaction->message }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-4 sm:px-6 py-10 sm:py-12 text-center">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <div class="bg-gray-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                                                            <i class="fas fa-exchange-alt text-gray-400 text-2xl"></i>
                                                        </div>
                                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('transactions.no_transactions') }}</h3>
                                                        <p class="text-gray-600 mb-4">{{ __('transactions.no_transactions_message') }}</p>
                                                        <a href="{{ localized_route('transactions.history', ['locale' => app()->getLocale()]) }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
                                                            <i class="fas fa-redo"></i>
                                                            {{ __('transactions.reset_filters') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($transactions->hasPages())
                            <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="text-sm text-gray-700">
                                    {{ __('transactions.showing_results', ['first' => $transactions->firstItem(), 'last' => $transactions->lastItem(), 'total' => $transactions->total()]) }}
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    {{ $transactions->links('vendor.pagination.tailwind') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
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

        // Auto-submit form on filter change
        document.getElementById('type').addEventListener('change', function() {
            this.form.submit();
        });

        document.getElementById('status').addEventListener('change', function() {
            this.form.submit();
        });

        // Auto-submit date filters when both are selected
        const dateFrom = document.getElementById('date_from');
        const dateTo = document.getElementById('date_to');

        function submitDateFilter() {
            if (dateFrom.value && dateTo.value) {
                dateFrom.form.submit();
            }
        }

        dateFrom.addEventListener('change', submitDateFilter);
        dateTo.addEventListener('change', submitDateFilter);

        // Add loading state to export buttons
        document.querySelectorAll('a[href*="export"]').forEach(link => {
            link.addEventListener('click', function(e) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>{{ __('transactions.generating') }}';
                this.disabled = true;

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 3000);
            });
        });
    </script>
</body>
</html>








