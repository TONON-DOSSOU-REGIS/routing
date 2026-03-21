<?php
    $analyticsI18n = [
        'transactions' => __('dashboard.transactions'),
        'updated' => __('dashboard.data_updated'),
        'loadingError' => __('dashboard.loading_data_error'),
    ];
?>

<section class="premium-panel premium-card-hover min-w-0 overflow-hidden rounded-[30px] p-6">
    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="flex min-w-0 items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-600 to-emerald-500 text-white shadow-lg shadow-emerald-900/10">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div class="min-w-0">
                <h2 class="premium-brand-title text-2xl font-semibold text-slate-950"><?php echo e(__('dashboard.analytics_title')); ?></h2>
                <p class="mt-1 text-sm text-slate-500"><?php echo e(__('dashboard.analytics_subtitle')); ?></p>
            </div>
        </div>

        <div class="hidden flex-wrap items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-1 shadow-sm md:flex">
            <button type="button" onclick="changePremiumAnalyticsPeriod(7, this)" class="analytics-period-btn rounded-xl px-4 py-2 text-sm font-semibold text-slate-500 transition">7 <?php echo e(__('common.days')); ?></button>
            <button type="button" onclick="changePremiumAnalyticsPeriod(30, this)" class="analytics-period-btn is-active rounded-xl px-4 py-2 text-sm font-semibold text-slate-500 transition">30 <?php echo e(__('common.days')); ?></button>
            <button type="button" onclick="changePremiumAnalyticsPeriod(90, this)" class="analytics-period-btn rounded-xl px-4 py-2 text-sm font-semibold text-slate-500 transition">90 <?php echo e(__('common.days')); ?></button>
        </div>
    </div>

    <div class="analytics-metric-grid mt-6 grid gap-4">
        <article class="analytics-metric-card min-w-0 rounded-[26px] bg-slate-50 p-5 ring-1 ring-slate-200/70">
            <div class="analytics-metric-card-header flex min-w-0 items-start justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                    <i class="fas fa-arrow-down"></i>
                </span>
                <span class="analytics-metric-chip rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                    <span id="analytics-deposits-trend">--</span>
                </span>
            </div>
            <p class="mt-4 text-sm font-semibold text-slate-500"><?php echo e(__('dashboard.total_deposits')); ?></p>
            <p class="analytics-metric-value premium-kpi-number mt-3 font-semibold text-slate-950" id="analytics-total-deposits">
                <i class="fas fa-spinner fa-spin text-slate-300"></i>
            </p>
            <p class="mt-auto pt-3 text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.selected_period')); ?></p>
        </article>

        <article class="analytics-metric-card min-w-0 rounded-[26px] bg-slate-50 p-5 ring-1 ring-slate-200/70">
            <div class="analytics-metric-card-header flex min-w-0 items-start justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-100 text-rose-700">
                    <i class="fas fa-arrow-up"></i>
                </span>
                <span class="analytics-metric-chip rounded-full bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-700">
                    <span id="analytics-withdrawals-trend">--</span>
                </span>
            </div>
            <p class="mt-4 text-sm font-semibold text-slate-500"><?php echo e(__('dashboard.total_withdrawals')); ?></p>
            <p class="analytics-metric-value premium-kpi-number mt-3 font-semibold text-slate-950" id="analytics-total-withdrawals">
                <i class="fas fa-spinner fa-spin text-slate-300"></i>
            </p>
            <p class="mt-auto pt-3 text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.selected_period')); ?></p>
        </article>

        <article class="analytics-metric-card min-w-0 rounded-[26px] bg-slate-50 p-5 ring-1 ring-slate-200/70">
            <div class="analytics-metric-card-header flex min-w-0 items-start justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                    <i class="fas fa-wave-square"></i>
                </span>
                <span class="analytics-metric-chip rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                    <?php echo e(__('dashboard.net_flow_label')); ?>

                </span>
            </div>
            <p class="mt-4 text-sm font-semibold text-slate-500"><?php echo e(__('dashboard.net_flow')); ?></p>
            <p class="analytics-metric-value premium-kpi-number mt-3 font-semibold text-slate-950" id="analytics-net-flow">
                <i class="fas fa-spinner fa-spin text-slate-300"></i>
            </p>
            <p class="mt-auto pt-3 text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.net_flow_description')); ?></p>
        </article>

        <article class="analytics-metric-card min-w-0 rounded-[26px] bg-slate-50 p-5 ring-1 ring-slate-200/70">
            <div class="analytics-metric-card-header flex min-w-0 items-start justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-purple-100 text-purple-700">
                    <i class="fas fa-calculator"></i>
                </span>
                <span class="analytics-metric-chip rounded-full bg-purple-100 px-2.5 py-1 text-xs font-semibold text-purple-700">
                    <span id="analytics-transaction-count">--</span> <?php echo e(__('dashboard.transactions_label')); ?>

                </span>
            </div>
            <p class="mt-4 text-sm font-semibold text-slate-500"><?php echo e(__('dashboard.average_transaction')); ?></p>
            <p class="analytics-metric-value premium-kpi-number mt-3 font-semibold text-slate-950" id="analytics-average-transaction">
                <i class="fas fa-spinner fa-spin text-slate-300"></i>
            </p>
            <p class="mt-auto pt-3 text-xs uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.per_transaction')); ?></p>
        </article>
    </div>

    <div class="mt-6 grid gap-6 2xl:grid-cols-2">
        <article class="min-w-0 overflow-hidden rounded-[28px] bg-white p-6 ring-1 ring-slate-200/70 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <h3 class="text-lg font-semibold text-slate-900"><?php echo e(__('dashboard.balance_evolution')); ?></h3>
                <span class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.last_days')); ?></span>
            </div>
            <div class="mt-5 h-[240px] sm:h-[280px] xl:h-[300px]">
                <canvas id="premiumBalanceChart"></canvas>
            </div>
        </article>

        <article class="min-w-0 overflow-hidden rounded-[28px] bg-white p-6 ring-1 ring-slate-200/70 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <h3 class="text-lg font-semibold text-slate-900"><?php echo e(__('dashboard.distribution_by_type')); ?></h3>
                <span class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.transactions')); ?></span>
            </div>
            <div class="mt-5 h-[240px] sm:h-[280px] xl:h-[300px]">
                <canvas id="premiumTypeChart"></canvas>
            </div>
        </article>
    </div>

    <article class="mt-6 min-w-0 overflow-hidden rounded-[28px] bg-white p-6 ring-1 ring-slate-200/70 shadow-sm">
        <div class="flex items-center justify-between gap-3">
            <h3 class="text-lg font-semibold text-slate-900"><?php echo e(__('dashboard.monthly_comparison')); ?></h3>
            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400"><?php echo e(__('dashboard.last_6_months')); ?></span>
        </div>
        <div class="mt-5 h-[260px] sm:h-[320px] xl:h-[340px]">
            <canvas id="premiumMonthlyChart"></canvas>
        </div>
    </article>
</section>

<script>
let premiumAnalyticsPeriod = 30;
let premiumBalanceChart;
let premiumTypeChart;
let premiumMonthlyChart;
let premiumAnalyticsLoading = false;
let premiumAnalyticsRefreshTimer = null;
const premiumAnalyticsLocale = document.documentElement.lang || '<?php echo e(app()->getLocale()); ?>';
const premiumAnalyticsCurrency = '<?php echo e($user->default_currency ?? "EUR"); ?>';
const premiumAnalyticsI18n = <?php echo json_encode($analyticsI18n, 15, 512) ?>;

function runPremiumAnalyticsWhenIdle(callback) {
    if (typeof window.requestIdleCallback === 'function') {
        window.requestIdleCallback(callback, { timeout: 1500 });
        return;
    }

    window.setTimeout(callback, 320);
}

function premiumAnalyticsFormatCurrency(amount) {
    return new Intl.NumberFormat(premiumAnalyticsLocale, {
        style: 'currency',
        currency: premiumAnalyticsCurrency,
    }).format(amount || 0);
}

function changePremiumAnalyticsPeriod(days, button) {
    premiumAnalyticsPeriod = days;
    document.querySelectorAll('.analytics-period-btn').forEach((item) => item.classList.remove('is-active'));
    if (button) {
        button.classList.add('is-active');
    }
    loadPremiumAnalytics();
}

async function loadPremiumAnalytics(showIndicator = false) {
    if (premiumAnalyticsLoading) {
        return;
    }

    premiumAnalyticsLoading = true;

    try {
        const stamp = Date.now();
        const [balanceData, typeData, monthlyData, statsData] = await Promise.all([
            fetch(`/api/analytics/balance-evolution?days=${premiumAnalyticsPeriod}&ts=${stamp}`).then((response) => response.json()),
            fetch(`/api/analytics/transactions-by-type?days=${premiumAnalyticsPeriod}&ts=${stamp}`).then((response) => response.json()),
            fetch(`/api/analytics/monthly-comparison?ts=${stamp}`).then((response) => response.json()),
            fetch(`/api/analytics/statistics?days=${premiumAnalyticsPeriod}&ts=${stamp}`).then((response) => response.json()),
        ]);

        updatePremiumAnalyticsStats(statsData.statistics || {});
        drawPremiumBalanceChart(balanceData || { labels: [], data: [] });
        drawPremiumTypeChart(typeData || { labels: [], amounts: [], counts: [] });
        drawPremiumMonthlyChart(monthlyData || { data: [] });

        if (showIndicator) {
            premiumAnalyticsToast(premiumAnalyticsI18n.updated, 'success');
        }
    } catch (error) {
        console.error('Premium analytics loading error:', error);
        premiumAnalyticsToast(premiumAnalyticsI18n.loadingError, 'error');
    } finally {
        premiumAnalyticsLoading = false;
    }
}

function updatePremiumAnalyticsStats(stats) {
    const netFlow = Number(stats.net_flow || 0);
    const netFlowElement = document.getElementById('analytics-net-flow');

    document.getElementById('analytics-total-deposits').textContent = premiumAnalyticsFormatCurrency(stats.total_deposits || 0);
    document.getElementById('analytics-total-withdrawals').textContent = premiumAnalyticsFormatCurrency(stats.total_withdrawals || 0);
    document.getElementById('analytics-average-transaction').textContent = premiumAnalyticsFormatCurrency(stats.average_transaction || 0);
    document.getElementById('analytics-transaction-count').textContent = stats.transaction_count || 0;
    document.getElementById('analytics-deposits-trend').textContent = stats.deposits_trend ? `${stats.deposits_trend}%` : '--';
    document.getElementById('analytics-withdrawals-trend').textContent = stats.withdrawals_trend ? `${stats.withdrawals_trend}%` : '--';

    netFlowElement.textContent = premiumAnalyticsFormatCurrency(Math.abs(netFlow));
    netFlowElement.className = `analytics-metric-value premium-kpi-number mt-3 font-semibold ${netFlow >= 0 ? 'text-emerald-700' : 'text-rose-700'}`;
}

function drawPremiumBalanceChart(data) {
    const context = document.getElementById('premiumBalanceChart');
    if (!context) return;
    if (premiumBalanceChart) premiumBalanceChart.destroy();

    premiumBalanceChart = new Chart(context, {
        type: 'line',
        data: {
            labels: data.labels || [],
            datasets: [{
                label: '<?php echo e(__('dashboard.balance')); ?>',
                data: data.data || [],
                borderColor: '#167c5b',
                backgroundColor: 'rgba(22, 124, 91, 0.12)',
                fill: true,
                borderWidth: 3,
                pointRadius: 0,
                tension: 0.35,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return premiumAnalyticsFormatCurrency(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    ticks: {
                        callback: function (value) {
                            return premiumAnalyticsFormatCurrency(value);
                        }
                    },
                    grid: { color: 'rgba(148, 163, 184, 0.16)' }
                }
            }
        }
    });
}

function drawPremiumTypeChart(data) {
    const context = document.getElementById('premiumTypeChart');
    if (!context) return;
    if (premiumTypeChart) premiumTypeChart.destroy();

    premiumTypeChart = new Chart(context, {
        type: 'doughnut',
        data: {
            labels: data.labels || [],
            datasets: [{
                data: data.amounts || [],
                backgroundColor: ['rgba(22, 124, 91, 0.85)', 'rgba(59, 130, 246, 0.76)', 'rgba(245, 158, 11, 0.76)'],
                borderWidth: 0,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 18,
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const count = (data.counts || [])[context.dataIndex] || 0;
                            return `${context.label}: ${premiumAnalyticsFormatCurrency(context.parsed)} (${count} ${premiumAnalyticsI18n.transactions})`;
                        }
                    }
                }
            }
        }
    });
}

function drawPremiumMonthlyChart(data) {
    const context = document.getElementById('premiumMonthlyChart');
    if (!context) return;
    if (premiumMonthlyChart) premiumMonthlyChart.destroy();

    const dataset = data.data || [];

    premiumMonthlyChart = new Chart(context, {
        type: 'bar',
        data: {
            labels: dataset.map((item) => item.month),
            datasets: [
                {
                    label: '<?php echo e(__('dashboard.deposits')); ?>',
                    data: dataset.map((item) => item.deposits),
                    backgroundColor: 'rgba(22, 124, 91, 0.78)',
                    borderRadius: 14,
                    borderSkipped: false,
                },
                {
                    label: '<?php echo e(__('dashboard.withdrawals')); ?>',
                    data: dataset.map((item) => item.withdrawals),
                    backgroundColor: 'rgba(59, 130, 246, 0.74)',
                    borderRadius: 14,
                    borderSkipped: false,
                }
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 18,
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.dataset.label}: ${premiumAnalyticsFormatCurrency(context.parsed.y)}`;
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    ticks: {
                        callback: function (value) {
                            return premiumAnalyticsFormatCurrency(value);
                        }
                    },
                    grid: { color: 'rgba(148, 163, 184, 0.16)' }
                }
            }
        }
    });
}

function premiumAnalyticsToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `fixed right-4 top-4 z-[100] rounded-2xl px-4 py-3 text-sm font-semibold text-white shadow-2xl ${type === 'error' ? 'bg-rose-600' : 'bg-emerald-700'}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2200);
}

function startPremiumAnalyticsAutoRefresh() {
    if (premiumAnalyticsRefreshTimer) {
        clearInterval(premiumAnalyticsRefreshTimer);
    }

    premiumAnalyticsRefreshTimer = setInterval(() => {
        if (document.visibilityState === 'visible') {
            loadPremiumAnalytics(true);
        }
    }, 45000);
}

document.addEventListener('DOMContentLoaded', function () {
    runPremiumAnalyticsWhenIdle(() => {
        loadPremiumAnalytics(false);
        startPremiumAnalyticsAutoRefresh();
    });
});

document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'visible') {
        loadPremiumAnalytics(true);
        startPremiumAnalyticsAutoRefresh();
        return;
    }

    if (premiumAnalyticsRefreshTimer) {
        clearInterval(premiumAnalyticsRefreshTimer);
        premiumAnalyticsRefreshTimer = null;
    }
});
</script>

<style>
    .analytics-metric-grid {
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 230px), 1fr));
    }

    .analytics-metric-card {
        display: flex;
        flex-direction: column;
        min-height: 280px;
    }

    .analytics-metric-card-header {
        gap: 0.75rem;
    }

    .analytics-metric-chip {
        max-width: calc(100% - 3.5rem);
        white-space: normal;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .analytics-metric-value {
        display: block;
        max-width: 100%;
        font-size: clamp(1.9rem, 1.1rem + 1.55vw, 3rem);
        line-height: 1.05;
        white-space: normal;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    @media (max-width: 767px) {
        .analytics-metric-card {
            min-height: auto;
        }
    }

    .analytics-period-btn.is-active {
        background: linear-gradient(135deg, #167c5b 0%, #0f5b42 100%);
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(15, 91, 66, 0.22);
    }

    .analytics-period-btn:hover:not(.is-active) {
        background: #ffffff;
        color: #0f172a;
    }
</style>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/components/analytics-section.blade.php ENDPATH**/ ?>