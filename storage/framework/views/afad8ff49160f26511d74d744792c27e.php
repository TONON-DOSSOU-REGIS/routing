<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tableau de bord - SG BANK</title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
        <i class="fas fa-building-columns text-blue-600 text-2xl"></i>
        <a href="<?php echo e(route('home')); ?>" class="text-xl font-semibold text-slate-800">SG BANK</a>
        <span class="ml-3 hidden sm:inline-block text-sm text-slate-500">Espace client</span>
      </div>

      <nav class="flex items-center gap-3">
        
        <?php echo $__env->make('components.notification-bell', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <a href="<?php echo e(route('profile')); ?>" class="hidden sm:inline-flex items-center px-3 py-2 text-sm rounded-lg text-slate-700 hover:text-blue-700 hover:bg-blue-50">
          <i class="fa-regular fa-user mr-2"></i> Profil
        </a>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
            <i class="fa-solid fa-right-from-bracket mr-2"></i> Déconnexion
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
              Bonjour <?php echo e(isset($user) && $user->first_name && $user->last_name ? $user->first_name . ' ' . $user->last_name : (isset($user) && $user->first_name ? $user->first_name : 'Utilisateur')); ?> 👋
            </h1>
            <p class="mt-1 text-slate-500">Voici un aperçu de votre activité récente et des marchés.</p>
          </div>
          <div class="flex items-center gap-2 mt-4 sm:mt-0">
            <a href="<?php echo e(route('transfer.create')); ?>" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 card-hover">
              <i class="fa-solid fa-paper-plane mr-2"></i> Nouveau virement
            </a>
            <a href="<?php echo e(route('transactions.history')); ?>" class="inline-flex items-center px-4 py-2 rounded-lg bg-slate-100 text-slate-800 hover:bg-slate-200 card-hover">
              <i class="fa-solid fa-clock-rotate-left mr-2"></i> Historique
            </a>
          </div>
        </div>
      </section>

      <!-- KPI cards -->
      <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 fade-in-up">
        <div class="glass-card card-hover rounded-2xl p-5">
          <div class="flex items-center justify-between">
            <span class="text-slate-500 text-sm">Solde courant</span>
            <i class="fa-solid fa-wallet text-blue-600"></i>
          </div>
          <div class="mt-3 text-2xl font-bold text-slate-800">
            <?php if(isset($user) && $user->balance): ?>
              <?php echo e(\App\Helpers\CurrencyHelper::format($user->balance, $user->default_currency ?? 'EUR')); ?>

            <?php else: ?>
              —
            <?php endif; ?>
          </div>
          <div class="mt-2 text-xs stat-chip inline-block px-2 py-1 rounded-full text-slate-700">
            Mise à jour aujourd’hui
          </div>
        </div>

        <div class="glass-card card-hover rounded-2xl p-5">
          <div class="flex items-center justify-between">
            <span class="text-slate-500 text-sm">Transactions (30j)</span>
            <i class="fa-solid fa-arrow-right-arrow-left text-indigo-600"></i>
          </div>
          <div class="mt-3 text-2xl font-bold text-slate-800">
            <?php echo e(isset($user) && method_exists($user, 'transactions') ? $user->transactions()->where('created_at','>=',now()->subDays(30))->count() : '—'); ?>

          </div>
          <div class="mt-2 text-xs stat-chip inline-block px-2 py-1 rounded-full text-slate-700">
            Dernier mois
          </div>
        </div>

        <div class="glass-card card-hover rounded-2xl p-5">
          <div class="flex items-center justify-between">
            <span class="text-slate-500 text-sm">Statut</span>
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
          </div>
          <div class="mt-3 text-2xl font-bold text-slate-800 text-emerald-600">
            <?php echo e(isset($user) && $user->status ? ucfirst($user->status) : '—'); ?>

          </div>
          <div class="mt-2 text-xs stat-chip inline-block px-2 py-1 rounded-full text-slate-700">
            Compte vérifié
          </div>
        </div>

        <div class="glass-card card-hover rounded-2xl p-5">
          <div class="flex items-center justify-between">
            <span class="text-slate-500 text-sm">Carte</span>
            <i class="fa-regular fa-credit-card text-fuchsia-600"></i>
          </div>
          <div class="mt-3 text-2xl font-bold text-slate-800">
            <?php echo e(isset($user) && $user->creditCard ? '**** **** **** '.substr($user->creditCard->card_number ?? '0000', -4) : '—'); ?>

          </div>
          <div class="mt-2 text-xs stat-chip inline-block px-2 py-1 rounded-full text-slate-700">
            Moyen de paiement
          </div>
        </div>
      </section>

      <!-- Analytics section -->
      <section class="mb-8 fade-in-up">
        
        <?php echo $__env->make('components.analytics-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </section>

      <!-- Market tracker widget -->
      <section class="mb-8 fade-in-up">
        <div class="glass-card rounded-2xl overflow-hidden card-hover border border-white/50">
          <div class="px-6 sm:px-8 py-6">
            
            <?php echo $__env->make('components.market-tracker-fixed', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>
        </div>
      </section>

      <!-- Transactions récentes + actions rapides -->
      <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-in-up">
        <!-- Transactions -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-semibold text-slate-800">
                <i class="fa-solid fa-list-ul mr-2 text-slate-500"></i> Transactions récentes
              </h2>
              <a href="<?php echo e(route('transactions.history')); ?>" class="text-sm text-blue-600 hover:text-blue-700">
                Voir tout
              </a>
            </div>

            <?php
              $items = isset($transactions) ? $transactions : collect();
            ?>

            <?php if($items->count() === 0): ?>
              <div class="text-slate-500 text-sm">
                Aucune transaction récente.
              </div>
            <?php else: ?>
              <div class="divide-y divide-slate-100">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">
                        <?php if(($tx->type ?? '') === 'credit'): ?>
                          <i class="fa-solid fa-arrow-down text-emerald-600"></i>
                        <?php else: ?>
                          <i class="fa-solid fa-arrow-up text-rose-600"></i>
                        <?php endif; ?>
                      </div>
                      <div>
                        <div class="text-slate-800 font-medium">
                          <?php echo e(ucfirst($tx->type ?? 'transaction')); ?>

                          <span class="text-xs text-slate-400 ml-2">#<?php echo e($tx->id); ?></span>
                        </div>
                        <div class="text-xs text-slate-500">
                          <?php echo e(\Carbon\Carbon::parse($tx->created_at)->format('d/m/Y H:i')); ?>

                        </div>
                      </div>
                    </div>
                    <div class="text-right">
                      <div class="font-semibold <?php echo e(($tx->type ?? '') === 'credit' ? 'text-emerald-600' : 'text-rose-600'); ?>">
                        <?php if(isset($tx->amount) && isset($user)): ?>
                          <?php echo e(\App\Helpers\CurrencyHelper::format($tx->amount, $user->default_currency ?? 'EUR')); ?>

                        <?php else: ?>
                          0,00
                        <?php endif; ?>
                      </div>
                      <div class="text-xs text-slate-500 capitalize">
                        <?php echo e(str_replace('_', ' ', $tx->status ?? '—')); ?>

                      </div>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Actions rapides -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Actions rapides</h3>
            <div class="space-y-3">
              <a href="<?php echo e(route('transfer.create')); ?>" class="block action-btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4 rounded-xl hover:from-blue-600 hover:to-indigo-700 transition card-hover">
                <div class="flex items-center">
                  <div class="bg-white/20 p-2 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <i class="fas fa-paper-plane text-lg"></i>
                  </div>
                  <div>
                    <div class="font-bold text-sm">Nouveau virement</div>
                    <div class="text-xs text-white/90">Envoyer un paiement</div>
                  </div>
                </div>
              </a>

              <a href="<?php echo e(route('transactions.history')); ?>" class="block action-btn bg-gradient-to-r from-slate-600 to-slate-700 text-white p-4 rounded-xl hover:from-slate-700 hover:to-slate-800 transition card-hover">
                <div class="flex items-center">
                  <div class="bg-white/20 p-2 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <i class="fas fa-history text-lg"></i>
                  </div>
                  <div>
                    <div class="font-bold text-sm">Historique</div>
                    <div class="text-xs text-white/90">Voir vos opérations</div>
                  </div>
                </div>
              </a>

              <a href="<?php echo e(route('profile')); ?>" class="block action-btn bg-gradient-to-r from-emerald-500 to-green-600 text-white p-4 rounded-xl hover:from-emerald-600 hover:to-green-700 transition card-hover">
                <div class="flex items-center">
                  <div class="bg-white/20 p-2 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                    <i class="fas fa-user-cog text-lg"></i>
                  </div>
                  <div>
                    <div class="font-bold text-sm">Mon profil</div>
                    <div class="text-xs text-white/90">Gérer mes informations</div>
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
      <p>&copy; <?php echo e(date('Y')); ?> SG BANK. Tous droits réservés.</p>
      <div class="space-x-4">
        <a href="#" class="hover:text-slate-700">Confidentialité</a>
        <a href="#" class="hover:text-slate-700">Conditions</a>
        <a href="#" class="hover:text-slate-700">Assistance</a>
      </div>
    </div>
  </footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/dashboard/index.blade.php ENDPATH**/ ?>
