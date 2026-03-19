<?php
    $compact = $compact ?? false;
    $trackerId = 'market-tracker-' . str_replace('.', '-', uniqid('', true));
?>

<style>
    #<?php echo e($trackerId); ?> {
        background: linear-gradient(180deg, #0f172a 0%, #111827 100%);
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 22px;
        padding: 18px;
        color: #e5e7eb;
        overflow: hidden;
    }

    #<?php echo e($trackerId); ?> .market-tab {
        background: rgba(148, 163, 184, 0.12);
        color: #cbd5e1;
        transition: background-color 180ms ease, color 180ms ease;
    }

    #<?php echo e($trackerId); ?> .market-tab.active {
        background: #f8fafc;
        color: #0f172a;
    }

    #<?php echo e($trackerId); ?> .market-card {
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 10px 24px rgba(2, 6, 23, 0.35);
        transition: transform 180ms ease, border-color 180ms ease;
    }

    #<?php echo e($trackerId); ?>:not(.market-tracker-widget--compact) .market-card:hover {
        transform: translateY(-3px);
        border-color: rgba(191, 219, 254, 0.3);
    }

    #<?php echo e($trackerId); ?> .market-label {
        color: #f8fafc;
    }

    #<?php echo e($trackerId); ?> .market-sub {
        color: #94a3b8;
    }

    #<?php echo e($trackerId); ?> .market-price {
        color: #f8fafc;
    }

    #<?php echo e($trackerId); ?> .market-muted {
        color: #94a3b8;
    }
</style>

<div id="<?php echo e($trackerId); ?>" class="market-tracker-widget <?php echo e($compact ? 'market-tracker-widget--compact' : ''); ?>" data-compact="<?php echo e($compact ? '1' : '0'); ?>">
    <div class="mb-5 flex flex-wrap items-start justify-between gap-4">
        <div class="flex min-w-0 items-center gap-3">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-500 to-purple-600">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="min-w-0">
                <h3 class="truncate text-lg font-bold text-white sm:text-xl"><?php echo e(__('market.title_tracker')); ?></h3>
                <p class="market-muted truncate text-sm" data-market-last-update><?php echo e(__('market.last_update_now')); ?></p>
            </div>
        </div>

        <button type="button" data-market-refresh class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 transition-colors duration-200 hover:bg-white/20" title="<?php echo e(__('market.refresh')); ?>">
            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </button>
    </div>

    <div class="mb-5 flex flex-wrap gap-2">
        <button type="button" class="market-tab active rounded-xl px-3 py-2 text-sm font-medium" data-market-tab="all">
            <?php echo e(__('market.tab_all')); ?>

        </button>
        <button type="button" class="market-tab rounded-xl px-3 py-2 text-sm font-medium hover:bg-white/20 hover:text-white" data-market-tab="crypto">
            <?php echo e(__('market.tab_crypto')); ?>

        </button>
        <button type="button" class="market-tab rounded-xl px-3 py-2 text-sm font-medium hover:bg-white/20 hover:text-white" data-market-tab="stocks">
            <?php echo e(__('market.tab_stocks')); ?>

        </button>
        <button type="button" class="market-tab rounded-xl px-3 py-2 text-sm font-medium hover:bg-white/20 hover:text-white" data-market-tab="forex">
            <?php echo e(__('market.tab_forex')); ?>

        </button>
    </div>

    <div data-market-loading class="hidden items-center justify-center py-12">
        <div class="h-8 w-8 animate-spin rounded-full border-b-2 border-white"></div>
        <span class="market-muted ml-3"><?php echo e(__('market.loading')); ?></span>
    </div>

    <div data-market-error class="hidden flex-col items-center justify-center py-12 text-center">
        <svg class="mb-4 h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="mb-4 text-red-400"><?php echo e(__('market.error_loading')); ?></p>
        <button type="button" data-market-retry class="rounded-lg bg-red-600 px-4 py-2 text-white transition-colors duration-200 hover:bg-red-700">
            <?php echo e(__('market.retry')); ?>

        </button>
    </div>

    <div
        data-market-grid
        class="grid grid-cols-1 gap-3 sm:grid-cols-2 <?php echo e($compact ? '2xl:grid-cols-2' : 'xl:grid-cols-3 2xl:grid-cols-4'); ?>"
    ></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const root = document.getElementById(<?php echo json_encode($trackerId, 15, 512) ?>);

    if (!root || root.dataset.initialized === '1') {
        return;
    }

    root.dataset.initialized = '1';

    const compact = root.dataset.compact === '1';
    const lastUpdatePrefix = <?php echo json_encode(__('market.last_update_prefix'), 15, 512) ?>;
    const locale = document.documentElement.lang || '<?php echo e(app()->getLocale()); ?>';
    const marketDataContainer = root.querySelector('[data-market-grid]');
    const loadingState = root.querySelector('[data-market-loading]');
    const errorState = root.querySelector('[data-market-error]');
    const lastUpdateElement = root.querySelector('[data-market-last-update]');
    const refreshButton = root.querySelector('[data-market-refresh]');
    const retryButton = root.querySelector('[data-market-retry]');
    const marketTabs = root.querySelectorAll('[data-market-tab]');

    let marketData = [];
    let currentFilter = 'all';
    let refreshInterval = null;
    let previousPrices = {};

    function getItemKey(item) {
        return item.id || item.symbol || item.pair || item.name || Math.random().toString(36).slice(2);
    }

    function getDisplayLabel(item) {
        return {
            primary: item.symbol || item.pair || item.name || '---',
            secondary: item.name || item.pair || item.symbol || <?php echo json_encode(__('market.title_tracker'), 15, 512) ?>,
        };
    }

    function getLogoMarkup(item) {
        const label = (item.symbol || item.pair || item.name || '?').toUpperCase();
        const initial = label.charAt(0);
        const gradient = item.type === 'crypto'
            ? 'from-amber-400 to-orange-600'
            : (item.type === 'forex' ? 'from-emerald-400 to-emerald-700' : 'from-blue-500 to-indigo-700');

        return `<div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br ${gradient} text-xs font-bold text-white shadow-sm">${initial}</div>`;
    }

    function formatPrice(item, price) {
        if (!isFinite(price)) {
            return compact ? '$0.00' : '$0';
        }

        if (item.type === 'forex') {
            return price.toLocaleString(locale, {
                minimumFractionDigits: 3,
                maximumFractionDigits: 4,
            });
        }

        return `$${price.toLocaleString(locale, {
            minimumFractionDigits: price < 10 ? 2 : 0,
            maximumFractionDigits: 2,
        })}`;
    }

    function normalizePrice(item) {
        return parseFloat(
            item.price_usd !== undefined ? item.price_usd :
            (item.price !== undefined ? item.price :
            (item.rate !== undefined ? item.rate : 0))
        );
    }

    function normalizeChange(item) {
        return parseFloat(
            item.change_24h !== undefined ? item.change_24h :
            (item.change_percent !== undefined ? item.change_percent :
            (item.change !== undefined ? item.change : 0))
        );
    }

    function createMarketItem(item) {
        const key = getItemKey(item);
        const price = normalizePrice(item);
        const changePercent = normalizeChange(item);
        const labels = getDisplayLabel(item);
        const changeIsPositive = changePercent >= 0;
        const directionClass = previousPrices[key] !== undefined && price > previousPrices[key]
            ? 'flash-up'
            : (previousPrices[key] !== undefined && price < previousPrices[key] ? 'flash-down' : '');
        previousPrices[key] = price;

        return `
            <div class="market-card rounded-2xl p-4 ${compact ? '' : 'cursor-pointer'}">
                <div class="flex min-w-0 items-start gap-3">
                    <div class="shrink-0">
                        ${getLogoMarkup(item)}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="market-label truncate text-sm font-semibold">${labels.primary}</p>
                        <p class="market-sub truncate text-xs">${labels.secondary}</p>
                    </div>
                    <div class="shrink-0 text-right">
                        <p class="market-price ${compact ? 'text-base' : 'text-lg'} font-bold leading-tight ${directionClass}">
                            ${formatPrice(item, price)}
                        </p>
                        <p class="${changeIsPositive ? 'text-emerald-400' : 'text-rose-400'} mt-1 text-xs font-semibold sm:text-sm">
                            ${changeIsPositive ? '+' : '-'} ${isFinite(changePercent) ? Math.abs(changePercent).toFixed(2) : '0.00'}%
                        </p>
                    </div>
                </div>
            </div>
        `;
    }

    function showLoading() {
        loadingState.classList.remove('hidden');
        loadingState.classList.add('flex');
        errorState.classList.add('hidden');
        marketDataContainer.classList.add('hidden');
    }

    function hideLoading() {
        loadingState.classList.add('hidden');
        loadingState.classList.remove('flex');
        marketDataContainer.classList.remove('hidden');
    }

    function showError() {
        errorState.classList.remove('hidden');
        errorState.classList.add('flex');
        loadingState.classList.add('hidden');
        loadingState.classList.remove('flex');
        marketDataContainer.classList.add('hidden');
    }

    function hideError() {
        errorState.classList.add('hidden');
        errorState.classList.remove('flex');
    }

    function updateLastUpdate() {
        const now = new Date();
        lastUpdateElement.textContent = lastUpdatePrefix.replace(':time', now.toLocaleTimeString(locale));
    }

    function getFilteredData() {
        switch (currentFilter) {
            case 'crypto':
                return marketData.crypto || [];
            case 'stocks':
                return marketData.stocks || [];
            case 'forex':
                return marketData.forex || [];
            default:
                return [
                    ...(marketData.crypto || []),
                    ...(marketData.stocks || []),
                    ...(marketData.forex || []),
                ];
        }
    }

    function renderMarketData() {
        hideLoading();
        hideError();

        const filteredData = getFilteredData();
        marketDataContainer.innerHTML = filteredData.map(createMarketItem).join('');
    }

    async function fetchMarketData() {
        try {
            showLoading();

            const response = await fetch(`/api/market/all?ts=${Date.now()}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                credentials: 'same-origin',
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            marketData = (data && typeof data === 'object' && 'data' in data) ? data.data : data;
            renderMarketData();
            updateLastUpdate();
        } catch (error) {
            console.error('Error fetching market data:', error);
            showError();
        }
    }

    function setActiveTab(tab) {
        marketTabs.forEach((button) => {
            const isActive = button === tab;
            button.classList.toggle('active', isActive);
        });
    }

    function startAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }

        refreshInterval = setInterval(() => {
            if (document.visibilityState === 'visible') {
                fetchMarketData();
            }
        }, 60000);
    }

    refreshButton?.addEventListener('click', fetchMarketData);
    retryButton?.addEventListener('click', fetchMarketData);

    marketTabs.forEach((tab) => {
        tab.addEventListener('click', function () {
            currentFilter = this.dataset.marketTab || 'all';
            setActiveTab(this);
            renderMarketData();
        });
    });

    fetchMarketData();
    startAutoRefresh();

    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible') {
            fetchMarketData();
            startAutoRefresh();
            return;
        }

        if (refreshInterval) {
            clearInterval(refreshInterval);
            refreshInterval = null;
        }
    });
});
</script>

<style>
    #<?php echo e($trackerId); ?> .flash-up {
        animation: marketFlashUp 800ms ease-out;
    }

    #<?php echo e($trackerId); ?> .flash-down {
        animation: marketFlashDown 800ms ease-out;
    }

    @keyframes marketFlashUp {
        0% { color: #34d399; }
        100% { color: #f8fafc; }
    }

    @keyframes marketFlashDown {
        0% { color: #fb7185; }
        100% { color: #f8fafc; }
    }
</style>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/components/market-tracker-fixed.blade.php ENDPATH**/ ?>