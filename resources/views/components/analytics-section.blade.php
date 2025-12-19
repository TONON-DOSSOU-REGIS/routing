{{-- Analytics Section Component --}}
<div class="mt-8 fade-in-up">
    <!-- En-tête de la section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-3 rounded-2xl mr-4 shadow-lg">
                <i class="fas fa-chart-line text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white drop-shadow-lg">📊 {{ __('dashboard.analytics_title') }}</h2>
                <p class="text-white/90 drop-shadow">{{ __('dashboard.analytics_subtitle') }}</p>
            </div>
        </div>
        
        <!-- Sélecteur de période -->
        <div class="hidden md:flex items-center gap-2 bg-white/90 backdrop-blur-lg rounded-xl p-1 shadow-lg">
            <button onclick="changePeriod(7)" class="period-btn px-4 py-2 rounded-lg text-sm font-medium transition-all">
                7 {{ __('common.days') }}
            </button>
            <button onclick="changePeriod(30)" class="period-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all">
                30 {{ __('common.days') }}
            </button>
            <button onclick="changePeriod(90)" class="period-btn px-4 py-2 rounded-lg text-sm font-medium transition-all">
                90 {{ __('common.days') }}
            </button>
        </div>
    </div>

    <!-- Cartes de statistiques détaillées -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Dépôts -->
        <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card">
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-green-100 p-2 rounded-lg">
                        <i class="fas fa-arrow-down text-green-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full">
                        <i class="fas fa-arrow-up"></i> <span id="deposits-trend">--</span>
                    </span>
                </div>
                <p class="text-sm font-semibold text-gray-600 mb-1">{{ __('dashboard.total_deposits') }}</p>
                <p class="text-2xl font-bold text-gray-900" id="total-deposits">
                    <i class="fas fa-spinner fa-spin text-gray-400"></i>
                </p>
                <p class="text-xs text-gray-500 mt-2">{{ __('dashboard.selected_period') }}</p>
            </div>
        </div>

        <!-- Total Retraits -->
        <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card">
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-red-100 p-2 rounded-lg">
                        <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-full">
                        <i class="fas fa-arrow-down"></i> <span id="withdrawals-trend">--</span>
                    </span>
                </div>
                <p class="text-sm font-semibold text-gray-600 mb-1">{{ __('dashboard.total_withdrawals') }}</p>
                <p class="text-2xl font-bold text-gray-900" id="total-withdrawals">
                    <i class="fas fa-spinner fa-spin text-gray-400"></i>
                </p>
                <p class="text-xs text-gray-500 mt-2">{{ __('dashboard.selected_period') }}</p>
            </div>
        </div>

        <!-- Flux Net -->
        <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card">
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <i class="fas fa-exchange-alt text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                        {{ __('dashboard.net_flow_label') }}
                    </span>
                </div>
                <p class="text-sm font-semibold text-gray-600 mb-1">{{ __('dashboard.net_flow') }}</p>
                <p class="text-2xl font-bold" id="net-flow">
                    <i class="fas fa-spinner fa-spin text-gray-400"></i>
                </p>
                <p class="text-xs text-gray-500 mt-2">{{ __('dashboard.net_flow_description') }}</p>
            </div>
        </div>

        <!-- Moyenne Transaction -->
        <div class="glass-card rounded-2xl overflow-hidden card-hover stat-card">
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-purple-100 p-2 rounded-lg">
                        <i class="fas fa-calculator text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-1 rounded-full">
                        <span id="transaction-count">--</span> ops
                    </span>
                </div>
                <p class="text-sm font-semibold text-gray-600 mb-1">{{ __('dashboard.average_transaction') }}</p>
                <p class="text-2xl font-bold text-gray-900" id="average-transaction">
                    <i class="fas fa-spinner fa-spin text-gray-400"></i>
                </p>
                <p class="text-xs text-gray-500 mt-2">{{ __('dashboard.per_transaction') }}</p>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Graphique 1: Évolution du Solde -->
        <div class="glass-card rounded-2xl overflow-hidden card-hover">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-chart-line text-blue-600"></i>
                        {{ __('dashboard.balance_evolution') }}
                    </h3>
                    <span class="text-xs text-gray-500">{{ __('dashboard.last_days') }}</span>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="balanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Graphique 2: Répartition par Type -->
        <div class="glass-card rounded-2xl overflow-hidden card-hover">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-purple-600"></i>
                        {{ __('dashboard.distribution_by_type') }}
                    </h3>
                    <span class="text-xs text-gray-500">{{ __('dashboard.transactions') }}</span>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique 3: Comparaison Mensuelle (Pleine largeur) -->
    <div class="glass-card rounded-2xl overflow-hidden card-hover mb-8">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-green-600"></i>
                    {{ __('dashboard.monthly_comparison') }}
                </h3>
                <span class="text-xs text-gray-500">{{ __('dashboard.last_6_months') }}</span>
            </div>
            <div class="relative" style="height: 350px;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
    .period-btn {
        color: #6b7280;
    }
    
    .period-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .period-btn:hover:not(.active) {
        background: #f3f4f6;
        color: #374151;
    }
</style>

<script>
let currentPeriod = 30;
let balanceChart, typeChart, monthlyChart;
let userCurrency = '{{ $user->default_currency ?? "EUR" }}';
let userCurrencySymbol = '{{ $user->currency_symbol }}';
let analyticsRefreshInterval;
let isLoadingAnalytics = false;

// Fonction pour changer la période
function changePeriod(days) {
    currentPeriod = days;
    
    // Mettre à jour les boutons actifs
    document.querySelectorAll('.period-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Recharger les données
    loadAnalytics();
}

// Fonction pour formater les montants avec la devise de l'utilisateur
function formatCurrency(amount) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: userCurrency
    }).format(amount);
}

// Fonction pour charger les analytics
async function loadAnalytics(showIndicators = true) {
    // Éviter les chargements multiples simultanés
    if (isLoadingAnalytics) {
        return;
    }
    
    isLoadingAnalytics = true;
    
    try {
        // Ajouter un timestamp pour éviter le cache
        const timestamp = Date.now();
        
        // Charger toutes les données en parallèle
        const [balanceData, typeData, monthlyData, stats] = await Promise.all([
            fetch(`/api/analytics/balance-evolution?days=${currentPeriod}&ts=${timestamp}`)
                .then(async r => {
                    if (!r.ok) {
                        const text = await r.text();
                        console.error('Balance evolution error:', text);
                        throw new Error(`HTTP error! status: ${r.status}`);
                    }
                    const contentType = r.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Response is not JSON');
                    }
                    return r.json();
                }),
            fetch(`/api/analytics/transactions-by-type?days=${currentPeriod}&ts=${timestamp}`)
                .then(async r => {
                    if (!r.ok) {
                        const text = await r.text();
                        console.error('Transactions by type error:', text);
                        throw new Error(`HTTP error! status: ${r.status}`);
                    }
                    const contentType = r.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Response is not JSON');
                    }
                    return r.json();
                }),
            fetch(`/api/analytics/monthly-comparison?ts=${timestamp}`)
                .then(async r => {
                    if (!r.ok) {
                        const text = await r.text();
                        console.error('Monthly comparison error:', text);
                        throw new Error(`HTTP error! status: ${r.status}`);
                    }
                    const contentType = r.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Response is not JSON');
                    }
                    return r.json();
                }),
            fetch(`/api/analytics/statistics?days=${currentPeriod}&ts=${timestamp}`)
                .then(async r => {
                    if (!r.ok) {
                        const text = await r.text();
                        console.error('Statistics error:', text);
                        throw new Error(`HTTP error! status: ${r.status}`);
                    }
                    const contentType = r.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Response is not JSON');
                    }
                    return r.json();
                })
        ]);

        // Mettre à jour les statistiques
        updateStatistics(stats.statistics);
        
        // Créer/Mettre à jour les graphiques
        createBalanceChart(balanceData);
        createTypeChart(typeData);
        createMonthlyChart(monthlyData);
        
        // Ajouter un indicateur visuel de mise à jour (seulement pour les rafraîchissements automatiques)
        if (showIndicators) {
            showUpdateIndicator();
        }
        
    } catch (error) {
        console.error('{{ __('dashboard.analytics_loading_error') }}', error);
        
        // Afficher un message d'erreur à l'utilisateur
        showErrorIndicator('{{ __('dashboard.loading_data_error') }}');
        
        // Initialize with empty data if needed
        if (!balanceChart && !typeChart && !monthlyChart) {
            // Initialize empty charts on first load failure
            createBalanceChart({ labels: [], data: [] });
            createTypeChart({ labels: [], amounts: [], counts: [] });
            createMonthlyChart({ data: [] });
        }
    } finally {
        isLoadingAnalytics = false;
    }
}

// Fonction pour afficher un indicateur de mise à jour
function showUpdateIndicator() {
    const indicator = document.createElement('div');
    indicator.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in-out';
    indicator.innerHTML = '<i class="fas fa-check-circle mr-2"></i>{{ __('dashboard.data_updated') }}';
    document.body.appendChild(indicator);
    
    setTimeout(() => {
        indicator.remove();
    }, 2000);
}

// Fonction pour afficher un indicateur d'erreur
function showErrorIndicator(message) {
    const indicator = document.createElement('div');
    indicator.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in-out';
    indicator.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
    document.body.appendChild(indicator);
    
    setTimeout(() => {
        indicator.remove();
    }, 5000);
}

// Fonction pour démarrer le rafraîchissement automatique
function startAnalyticsAutoRefresh() {
    // Rafraîchir toutes les 30 secondes
    analyticsRefreshInterval = setInterval(() => {
        loadAnalytics(true); // Afficher les indicateurs pour les rafraîchissements automatiques
    }, 30000);
}

// Fonction pour arrêter le rafraîchissement automatique
function stopAnalyticsAutoRefresh() {
    if (analyticsRefreshInterval) {
        clearInterval(analyticsRefreshInterval);
    }
}

// Mettre à jour les statistiques
function updateStatistics(stats) {
    document.getElementById('total-deposits').textContent = formatCurrency(stats.total_deposits || 0);
    document.getElementById('total-withdrawals').textContent = formatCurrency(stats.total_withdrawals || 0);
    
    const netFlow = stats.net_flow || 0;
    const netFlowElement = document.getElementById('net-flow');
    netFlowElement.textContent = formatCurrency(Math.abs(netFlow));
    netFlowElement.className = `text-2xl font-bold ${netFlow >= 0 ? 'text-green-600' : 'text-red-600'}`;
    
    document.getElementById('average-transaction').textContent = formatCurrency(stats.average_transaction || 0);
    document.getElementById('transaction-count').textContent = stats.transaction_count || 0;
    
    document.getElementById('deposits-trend').textContent = stats.deposits_trend ? `${stats.deposits_trend}%` : '--';
    document.getElementById('withdrawals-trend').textContent = stats.withdrawals_trend ? `${stats.withdrawals_trend}%` : '--';
}

// Créer le graphique d'évolution du solde
function createBalanceChart(data) {
    const ctx = document.getElementById('balanceChart');
    
    if (balanceChart) {
        balanceChart.destroy();
    }
    
    // Vérifier si nous avons des données
    if (!data || !data.labels || data.labels.length === 0) {
        ctx.getContext('2d').clearRect(0, 0, ctx.width, ctx.height);
        return;
    }
    
    balanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: '{{ __('dashboard.balance') }}',
                data: data.data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return '{{ __('dashboard.balance') }}: ' + formatCurrency(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        callback: function(value) {
                            return formatCurrency(value);
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Créer le graphique par type
function createTypeChart(data) {
    const ctx = document.getElementById('typeChart');
    
    if (typeChart) {
        typeChart.destroy();
    }
    
    // Vérifier si nous avons des données
    if (!data || !data.labels || data.labels.length === 0) {
        ctx.getContext('2d').clearRect(0, 0, ctx.width, ctx.height);
        return;
    }
    
    typeChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.amounts,
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(59, 130, 246, 0.8)'
                ],
                borderColor: [
                    'rgb(16, 185, 129)',
                    'rgb(239, 68, 68)',
                    'rgb(59, 130, 246)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = formatCurrency(context.parsed);
                            const count = data.counts[context.dataIndex];
                            return `${label}: ${value} (${count} transactions)`;
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });
}

// Créer le graphique de comparaison mensuelle
function createMonthlyChart(data) {
    const ctx = document.getElementById('monthlyChart');
    
    if (monthlyChart) {
        monthlyChart.destroy();
    }
    
    // Vérifier si nous avons des données
    if (!data || !data.data || data.data.length === 0) {
        ctx.getContext('2d').clearRect(0, 0, ctx.width, ctx.height);
        return;
    }
    
    const labels = data.data.map(d => d.month);
    const deposits = data.data.map(d => d.deposits);
    const withdrawals = data.data.map(d => d.withdrawals);
    
    monthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: '{{ __('dashboard.deposits') }}',
                    data: deposits,
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 2,
                    borderRadius: 8
                },
                {
                    label: '{{ __('dashboard.withdrawals') }}',
                    data: withdrawals,
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 2,
                    borderRadius: 8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + formatCurrency(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatCurrency(value);
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Charger les analytics au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    loadAnalytics(false); // Pas d'indicateurs au chargement initial
    startAnalyticsAutoRefresh();
});

// Arrêter le rafraîchissement quand l'utilisateur quitte la page
window.addEventListener('beforeunload', function() {
    stopAnalyticsAutoRefresh();
});

// Reprendre le rafraîchissement quand l'utilisateur revient sur la page
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        stopAnalyticsAutoRefresh();
    } else {
        startAnalyticsAutoRefresh();
        loadAnalytics(true); // Afficher les indicateurs lors du retour
    }
});
</script>

<style>
@keyframes fadeInOut {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    10% {
        opacity: 1;
        transform: translateY(0);
    }
    90% {
        opacity: 1;
        transform: translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateY(-10px);
    }
}

.animate-fade-in-out {
    animation: fadeInOut 2s ease-in-out;
}
</style>


