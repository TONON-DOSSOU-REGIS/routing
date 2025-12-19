<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ __('dashboard.dashboard_title') }} - {{ __('dashboard.bank_name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

  <style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
    .fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }

    .card-hover { transition: all 0.25s ease; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(0,0,0,0.12); }

    .glass-card {
      background: rgba(255,255,255,0.9);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }

    .stat-chip {
      background: linear-gradient(135deg, rgba(59,130,246,0.12), rgba(99,102,241,0.12));
      border: 1px solid rgba(255,255,255,0.4);
    }

    /* Flash for price changes (market tracker uses these) */
    .flash-up { animation: flashUp 0.8s ease; }
    .flash-down { animation: flashDown 0.8s ease; }
    @keyframes flashUp { 0%{ background-color: rgba(34,197,94,0.25);} 100%{ background-color: transparent;} }
    @keyframes flashDown { 0%{ background-color: rgba(239,68,68,0.25);} 100%{ background-color: transparent;} }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-red-900 via-red-800 to-red-700">
  <!-- Top Navigation -->
  <header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img src='{{ asset("images/logobank.png") }}' class="w-9 h-9" alt="">
        {{-- <i class="fas fa-building-columns text-blue-600 text-2xl"></i> --}}
        <a href="{{ localized_route('home', ['locale' => app()->getLocale()]) }}" class="text-2xl font-bold text-blue-600">{{ __('dashboard.bank_name') }}</a>
        <span class="ml-3 hidden sm:inline-block text-sm text-slate-500">{{ __('dashboard.client_area') }}</span>
      </div>

      <nav class="flex items-center gap-3">
        {{-- Notification bell component (polling + sound) --}}
        @include('components.notification-bell')

        <a href="{{ localized_route('profile', ['locale' => app()->getLocale()]) }}" class="hidden sm:inline-flex items-center px-3 py-2 text-sm rounded-lg text-slate-700 hover:text-blue-700 hover:bg-blue-50">
          <i class="fa-regular fa-user mr-2"></i> {{ __('dashboard.profile') }}
        </a>

        <form method="POST" action="{{ localized_route('logout', ['locale' => app()->getLocale()]) }}">
          @csrf
          <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
            <i class="fa-solid fa-right-from-bracket mr-2"></i> {{ __('dashboard.logout') }}
          </button>
        </form>
      </nav>
    </div>
  </header>

  <!-- Page container -->
  <main class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Welcome + quick stats -->
      <section class="mb-8 fade-in-up">
        <div class="bg-gradient-to-r from-white via-blue-50/30 to-indigo-50/30 rounded-2xl shadow-lg border border-white/60 px-6 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between backdrop-blur-sm">
          <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
              {{ __('dashboard.welcome_greeting', ['name' => isset($user) && $user->first_name && $user->last_name ? $user->first_name . ' ' . $user->last_name : (isset($user) && $user->first_name ? $user->first_name : __('common.user'))]) }}
            </h1>
            <p class="mt-1 text-slate-500">{{ __('dashboard.welcome_subtitle') }}</p>
          </div>
          <div class="flex items-center gap-2 mt-4 sm:mt-0">
            <a href="{{ localized_route('transfer.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 card-hover">
              <i class="fa-solid fa-paper-plane mr-2"></i> {{ __('dashboard.new_transfer') }}
            </a>
            <a href="{{ localized_route('transactions.history', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-slate-100 text-slate-800 hover:bg-slate-200 card-hover">
              <i class="fa-solid fa-clock-rotate-left mr-2"></i> {{ __('dashboard.history') }}
            </a>
          </div>
        </div>
      </section>

      <!-- KPI cards -->
      <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 fade-in-up">
        <div class="glass-card card-hover rounded-2xl p-5">
          <div class="flex items-center justify-between">
            <span class="text-slate-500 text-sm">{{ __('dashboard.current_balance') }}</span>
            <i class="fa-solid fa-wallet text-blue-600"></i>
          </div>
          <div class="mt-3 text-2xl font-bold text-slate-800">
            @if(isset($user) && $user->balance)
              {{ \App\Helpers\CurrencyHelper::format($user->balance, $user->default_currency ?? 'EUR') }}
            @else
              {{ __('dashboard.empty_value') }}
            @endif
          </div>
          <div class="mt-2 text-xs stat-chip inline-block px-2 py-1 rounded-full text-slate-700">
            {{ __('dashboard.updated_today') }}
          </div>
        </div>

        <div class="glass-card card-hover rounded-2xl p-5">
          <div class="flex items-center justify-between">
            <span class="text-slate-500 text-sm">{{ __('dashboard.transactions_30_days') }}</span>
            <i class="fa-solid fa-arrow-right-arrow-left text-indigo-600"></i>
          </div>
          <div class="mt-3 text-2xl font-bold text-slate-800">
            {{ isset($user) && method_exists($user, 'transactions') ? $user->transactions()->where('created_at','>=',now()->subDays(30))->count() : '—' }}
          </div>
          <div class="mt-2 text-xs stat-chip inline-block px-2 py-1 rounded-full text-slate-700">
            {{ __('dashboard.last_month') }}
          </div>
        </div>

        <div class="glass-card card-hover rounded-2xl p-5">
          <div class="flex items-center justify-between">
            <span class="text-slate-500 text-sm">{{ __('dashboard.status') }}</span>
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
          </div>
          <div class="mt-3 text-2xl font-bold text-slate-800 text-emerald-600">
            {{ isset($user) && $user->status ? ucfirst($user->status) : '—' }}
          </div>
          <div class="mt-2 text-xs stat-chip inline-block px-2 py-1 rounded-full text-slate-700">
            {{ __('dashboard.verified_account') }}
          </div>
        </div>

        <div class="glass-card card-hover rounded-2xl p-5">
          <div class="flex items-center justify-between">
            <span class="text-slate-500 text-sm">{{ __('dashboard.card') }}</span>
            <i class="fa-regular fa-credit-card text-fuchsia-600"></i>
          </div>
          <div class="mt-3 text-2xl font-bold text-slate-800">
            {{ isset($user) && $user->creditCard ? __('dashboard.card_mask_prefix').substr($user->creditCard->card_number ?? '0000', -4) : __('dashboard.empty_value') }}
          </div>
          <div class="mt-2 text-xs stat-chip inline-block px-2 py-1 rounded-full text-slate-700">
            {{ __('dashboard.payment_method') }}
          </div>
        </div>
      </section>

      <!-- Analytics section -->
      <section class="mb-8 fade-in-up">
        {{-- Include Analytics Section (graphiques) --}}
        @include('components.analytics-section')
      </section>

      <!-- Market tracker widget -->
      <section class="mb-8 fade-in-up">
        <div class="glass-card rounded-2xl overflow-hidden card-hover border border-white/50">
          <div class="px-6 sm:px-8 py-6">
            {{-- Market tracker (rafraîchissement ~5s) --}}
            @include('components.market-tracker-fixed')
          </div>
        </div>
      </section>

      <!-- {{ __('dashboard.recent_transactions_and_quick_actions') }} -->
      <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-in-up">
        <!-- Transactions -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-semibold text-slate-800">
                <i class="fa-solid fa-list-ul mr-2 text-slate-500"></i> {{ __('dashboard.recent_transactions') }}
              </h2>
              <a href="{{ localized_route('transactions.history', ['locale' => app()->getLocale()]) }}" class="text-sm text-blue-600 hover:text-blue-700">
                {{ __('dashboard.view_all') }}
              </a>
            </div>

            @php
              $items = isset($transactions) ? $transactions : collect();
            @endphp

            @if($items->count() === 0)
              <div class="text-slate-500 text-sm">
                {{ __('dashboard.no_recent_transactions') }}
              </div>
            @else
              <div class="divide-y divide-slate-100">
                @foreach($items as $tx)
                  <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">
                        @if(($tx->type ?? '') === 'credit')
                          <i class="fa-solid fa-arrow-down text-emerald-600"></i>
                        @else
                          <i class="fa-solid fa-arrow-up text-rose-600"></i>
                        @endif
                      </div>
                      <div>
                        <div class="text-slate-800 font-medium">
                          {{ ucfirst($tx->type ?? __('dashboard.transaction_type')) }}
                          <span class="text-xs text-slate-400 ml-2">{{ __('dashboard.transaction_id_prefix') }}{{ $tx->id }}</span>
                        </div>
                        <div class="text-xs text-slate-500">
                          {{ \Carbon\Carbon::parse($tx->created_at)->format(__('dashboard.date_format')) }}
                        </div>
                      </div>
                    </div>
                    <div class="text-right">
                      <div class="font-semibold {{ ($tx->type ?? '') === 'credit' ? 'text-emerald-600' : 'text-rose-600' }}">
                        @if(isset($tx->amount) && isset($user))
                          {{ \App\Helpers\CurrencyHelper::format($tx->amount, $user->default_currency ?? 'EUR') }}
                        @else
                          {{ __('dashboard.zero_amount') }}
                        @endif
                      </div>
                      <div class="text-xs text-slate-500 capitalize">
                        {{ str_replace('_', ' ', $tx->status ?? '—') }}
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>

        <!-- Actions rapides -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">{{ __('dashboard.quick_actions') }}</h3>
            <div class="space-y-3">
              <a href="{{ localized_route('transfer.create', ['locale' => app()->getLocale()]) }}" class="block action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4 rounded-xl hover:from-blue-600 hover:to-indigo-700 transition card-hover">
                <div class="flex items-center">
                  <div class="bg-white/20 p-2 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <i class="fas fa-paper-plane text-lg"></i>
                  </div>
                  <div>
                    <div class="font-bold text-sm">{{ __('dashboard.new_transfer') }}</div>
                    <div class="text-xs text-white/90">{{ __('dashboard.send_payment') }}</div>
                  </div>
                </div>
              </a>

              <a href="{{ localized_route('transactions.history', ['locale' => app()->getLocale()]) }}" class="block action-btn bg-gradient-to-r from-slate-600 to-slate-700 text-white p-4 rounded-xl hover:from-slate-700 hover:to-slate-800 transition card-hover">
                <div class="flex items-center">
                  <div class="bg-white/20 p-2 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <i class="fas fa-history text-lg"></i>
                  </div>
                  <div>
                    <div class="font-bold text-sm">{{ __('dashboard.history') }}</div>
                    <div class="text-xs text-white/90">{{ __('dashboard.view_operations') }}</div>
                  </div>
                </div>
              </a>

              <a href="{{ localized_route('profile', ['locale' => app()->getLocale()]) }}" class="block action-btn bg-gradient-to-r from-emerald-500 to-green-600 text-white p-4 rounded-xl hover:from-emerald-600 hover:to-green-700 transition card-hover">
                <div class="flex items-center">
                  <div class="bg-white/20 p-2 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <i class="fas fa-user-cog text-lg"></i>
                  </div>
                  <div>
                    <div class="font-bold text-sm">{{ __('dashboard.my_profile') }}</div>
                    <div class="text-xs text-white/90">{{ __('dashboard.manage_my_information') }}</div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <!-- Footer -->
  <footer class="mt-10 py-8 bg-white border-t">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-slate-500 flex items-center justify-between">
      <p>&copy; {{ date('Y') }} SG BANK. {{ __('dashboard.all_rights_reserved') }}</p>
      <div class="space-x-4">
        <a href="#" class="hover:text-slate-700">{{ __('dashboard.privacy') }}</a>
        <a href="#" class="hover:text-slate-700">{{ __('dashboard.terms') }}</a>
        <a href="#" class="hover:text-slate-700">{{ __('dashboard.support') }}</a>
      </div>
    </div>
  </footer>

  {{-- Client Chat Widget --}}
  @include('components.client-chat-widget')
</body>
</html>


