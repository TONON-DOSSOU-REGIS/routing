<style>
    .market-tracker-widget {
        background: linear-gradient(180deg, #0f172a 0%, #111827 100%);
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 16px;
        padding: 16px;
        color: #e5e7eb;
    }
    .market-tracker-widget .market-tab {
        background: rgba(148, 163, 184, 0.12);
        color: #cbd5e1;
    }
    .market-tracker-widget .market-tab.active {
        background: #f8fafc;
        color: #0f172a;
    }
    .market-tracker-widget .market-card {
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 10px 24px rgba(2, 6, 23, 0.35);
    }
    .market-tracker-widget .market-label {
        color: #f8fafc;
    }
    .market-tracker-widget .market-sub {
        color: #94a3b8;
    }
    .market-tracker-widget .market-price {
        color: #f8fafc;
    }
    .market-tracker-widget .market-muted {
        color: #94a3b8;
    }
</style>

<div class="market-tracker-widget">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-white"><?php echo e(__('market.title_tracker')); ?></h3>
                <p class="market-muted text-sm" id="last-update"><?php echo e(__('market.last_update_now')); ?></p>
            </div>
        </div>
        <button id="refresh-btn" class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors duration-200" title="<?php echo e(__('market.refresh')); ?>">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </button>
    </div>

    <!-- Market Type Tabs -->
    <div class="flex space-x-2 mb-6">
        <button class="market-tab active px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200" data-type="all">
            <?php echo e(__('market.tab_all')); ?>

        </button>
        <button class="market-tab px-4 py-2 hover:text-white hover:bg-white/20 rounded-lg text-sm font-medium transition-colors duration-200" data-type="crypto">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v1.252a3.078 3.078 0 01-2.353-1.253 1 1 0 00-1.51-1.31c-.163.187-.452.377-.843.504V8.662c.622-.117 1.196-.342 1.676-.662C10.398 7.766 11 6.991 11 6V5.092z" clip-rule="evenodd"/>
            </svg>
            <?php echo e(__('market.tab_crypto')); ?>

        </button>
        <button class="market-tab px-4 py-2 hover:text-white hover:bg-white/20 rounded-lg text-sm font-medium transition-colors duration-200" data-type="stocks">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
            <?php echo e(__('market.tab_stocks')); ?>

        </button>
        <button class="market-tab px-4 py-2 hover:text-white hover:bg-white/20 rounded-lg text-sm font-medium transition-colors duration-200" data-type="forex">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v1.252a3.078 3.078 0 01-2.353-1.253 1 1 0 00-1.51-1.31c-.163.187-.452.377-.843.504V8.662c.622-.117 1.196-.342 1.676-.662C10.398 7.766 11 6.991 11 6V5.092z" clip-rule="evenodd"/>
            </svg>
            <?php echo e(__('market.tab_forex')); ?>

        </button>
    </div>

    <!-- Loading State -->
    <div id="loading-state" class="hidden flex items-center justify-center py-12">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white"></div>
        <span class="ml-3 market-muted"><?php echo e(__('market.loading')); ?></span>
    </div>

    <!-- Error State -->
    <div id="error-state" class="hidden flex flex-col items-center justify-center py-12">
        <svg class="w-12 h-12 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-red-400 mb-4"><?php echo e(__('market.error_loading')); ?></p>
        <button id="retry-btn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
            <?php echo e(__('market.retry')); ?>

        </button>
    </div>

    <!-- Market Data Grid -->
    <div id="market-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Data will be populated by JavaScript -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let marketData = [];
    let currentFilter = 'all';
    let refreshInterval;
    let previousPrices = {};

    const marketDataContainer = document.getElementById('market-data');
    const loadingState = document.getElementById('loading-state');
    const errorState = document.getElementById('error-state');
    const lastUpdateElement = document.getElementById('last-update');
    const refreshBtn = document.getElementById('refresh-btn');
    const retryBtn = document.getElementById('retry-btn');
    const marketTabs = document.querySelectorAll('.market-tab');
    const locale = document.documentElement.lang || '<?php echo e(app()->getLocale()); ?>';
    const lastUpdatePrefix = <?php echo json_encode(__('market.last_update_prefix'), 15, 512) ?>;

    // Professional logo function with real images
    function getProfessionalLogo(item) {
        const symbol = (item.symbol || item.pair || '').toUpperCase();
        const name = (item.name || '').toLowerCase();
        const type = item.type;

        if (type === 'crypto') {
            // Real cryptocurrency logos from CoinCap API
            const cryptoLogos = {
                'BTC': 'https://assets.coincap.io/assets/icons/btc@2x.png',
                'ETH': 'https://assets.coincap.io/assets/icons/eth@2x.png',
                'BNB': 'https://assets.coincap.io/assets/icons/bnb@2x.png',
                'ADA': 'https://assets.coincap.io/assets/icons/ada@2x.png',
                'SOL': 'https://assets.coincap.io/assets/icons/sol@2x.png',
                'DOT': 'https://assets.coincap.io/assets/icons/dot@2x.png',
                'DOGE': 'https://assets.coincap.io/assets/icons/doge@2x.png',
                'AVAX': 'https://assets.coincap.io/assets/icons/avax@2x.png',
                'LTC': 'https://assets.coincap.io/assets/icons/ltc@2x.png',
                'LINK': 'https://assets.coincap.io/assets/icons/link@2x.png',
                'XRP': 'https://assets.coincap.io/assets/icons/xrp@2x.png',
                'MATIC': 'https://assets.coincap.io/assets/icons/matic@2x.png',
                'UNI': 'https://assets.coincap.io/assets/icons/uni@2x.png',
                'ALGO': 'https://assets.coincap.io/assets/icons/algo@2x.png',
                'VET': 'https://assets.coincap.io/assets/icons/vet@2x.png',
                'ICP': 'https://assets.coincap.io/assets/icons/icp@2x.png',
                'FIL': 'https://assets.coincap.io/assets/icons/fil@2x.png',
                'TRX': 'https://assets.coincap.io/assets/icons/trx@2x.png',
                'ETC': 'https://assets.coincap.io/assets/icons/etc@2x.png',
                'XLM': 'https://assets.coincap.io/assets/icons/xlm@2x.png',
                'THETA': 'https://assets.coincap.io/assets/icons/theta@2x.png',
                'FTT': 'https://assets.coincap.io/assets/icons/ftt@2x.png',
                'HBAR': 'https://assets.coincap.io/assets/icons/hbar@2x.png',
                'NEAR': 'https://assets.coincap.io/assets/icons/near@2x.png',
                'FLOW': 'https://assets.coincap.io/assets/icons/flow@2x.png',
                'MANA': 'https://assets.coincap.io/assets/icons/mana@2x.png',
                'SAND': 'https://assets.coincap.io/assets/icons/sand@2x.png',
                'AXS': 'https://assets.coincap.io/assets/icons/axs@2x.png',
                'CHZ': 'https://assets.coincap.io/assets/icons/chz@2x.png',
                'ENJ': 'https://assets.coincap.io/assets/icons/enj@2x.png',
                'BAT': 'https://assets.coincap.io/assets/icons/bat@2x.png',
                'OMG': 'https://assets.coincap.io/assets/icons/omg@2x.png',
                'ZRX': 'https://assets.coincap.io/assets/icons/zrx@2x.png',
                'REP': 'https://assets.coincap.io/assets/icons/rep@2x.png',
                'GNT': 'https://assets.coincap.io/assets/icons/gnt@2x.png',
                'STORJ': 'https://assets.coincap.io/assets/icons/storj@2x.png',
                'ANT': 'https://assets.coincap.io/assets/icons/ant@2x.png',
                'FUN': 'https://assets.coincap.io/assets/icons/fun@2x.png',
                'WAVES': 'https://assets.coincap.io/assets/icons/waves@2x.png',
                'LSK': 'https://assets.coincap.io/assets/icons/lsk@2x.png',
                'ARK': 'https://assets.coincap.io/assets/icons/ark@2x.png',
                'STRAT': 'https://assets.coincap.io/assets/icons/strat@2x.png',
                'XEM': 'https://assets.coincap.io/assets/icons/xem@2x.png',
                'QTUM': 'https://assets.coincap.io/assets/icons/qtum@2x.png',
                'BTG': 'https://assets.coincap.io/assets/icons/btg@2x.png',
                'ZEC': 'https://assets.coincap.io/assets/icons/zec@2x.png',
                'DASH': 'https://assets.coincap.io/assets/icons/dash@2x.png',
                'XMR': 'https://assets.coincap.io/assets/icons/xmr@2x.png',
                'NEO': 'https://assets.coincap.io/assets/icons/neo@2x.png',
                'EOS': 'https://assets.coincap.io/assets/icons/eos@2x.png',
                'IOTA': 'https://assets.coincap.io/assets/icons/iota@2x.png',
                'NEM': 'https://assets.coincap.io/assets/icons/nem@2x.png',
                'STEEM': 'https://assets.coincap.io/assets/icons/steem@2x.png',
                'SBD': 'https://assets.coincap.io/assets/icons/sbd@2x.png',
                'GOLOS': 'https://assets.coincap.io/assets/icons/golos@2x.png',
                'GBG': 'https://assets.coincap.io/assets/icons/gbg@2x.png'
            };
            const logoUrl = cryptoLogos[symbol] || 'https://assets.coincap.io/assets/icons/generic@2x.png';
            return `<img src="${logoUrl}" alt="${symbol}" class="w-8 h-8 rounded-full object-cover shadow-sm" onerror="this.src='https://assets.coincap.io/assets/icons/generic@2x.png'">`;
        } else if (type === 'stock') {
            // Real stock logos using Clearbit API for company logos
            const stockLogos = {
                'AAPL': 'https://logo.clearbit.com/apple.com',
                'GOOGL': 'https://logo.clearbit.com/google.com',
                'MSFT': 'https://logo.clearbit.com/microsoft.com',
                'AMZN': 'https://logo.clearbit.com/amazon.com',
                'TSLA': 'https://logo.clearbit.com/tesla.com',
                'META': 'https://logo.clearbit.com/meta.com',
                'NVDA': 'https://logo.clearbit.com/nvidia.com',
                'NFLX': 'https://logo.clearbit.com/netflix.com',
                'BABA': 'https://logo.clearbit.com/alibaba.com',
                'ORCL': 'https://logo.clearbit.com/oracle.com',
                'CRM': 'https://logo.clearbit.com/salesforce.com',
                'AMD': 'https://logo.clearbit.com/amd.com',
                'INTC': 'https://logo.clearbit.com/intel.com',
                'CSCO': 'https://logo.clearbit.com/cisco.com',
                'IBM': 'https://logo.clearbit.com/ibm.com',
                'UBER': 'https://logo.clearbit.com/uber.com',
                'SPOT': 'https://logo.clearbit.com/spotify.com',
                'PYPL': 'https://logo.clearbit.com/paypal.com',
                'ADBE': 'https://logo.clearbit.com/adobe.com',
                'SHOP': 'https://logo.clearbit.com/shopify.com',
                'SQ': 'https://logo.clearbit.com/block.xyz',
                'COIN': 'https://logo.clearbit.com/coinbase.com',
                'PLTR': 'https://logo.clearbit.com/palantir.com',
                'SNOW': 'https://logo.clearbit.com/snowflake.com',
                'ABNB': 'https://logo.clearbit.com/airbnb.com',
                'ZM': 'https://logo.clearbit.com/zoom.us',
                'DOCU': 'https://logo.clearbit.com/docusign.com',
                'ROKU': 'https://logo.clearbit.com/roku.com',
                'TWLO': 'https://logo.clearbit.com/twilio.com',
                'OKTA': 'https://logo.clearbit.com/okta.com',
                'DDOG': 'https://logo.clearbit.com/datadoghq.com',
                'CRWD': 'https://logo.clearbit.com/crowdstrike.com',
                'ZS': 'https://logo.clearbit.com/zscaler.com',
                'NET': 'https://logo.clearbit.com/cloudflare.com',
                'FSLY': 'https://logo.clearbit.com/fastly.com',
                'MDB': 'https://logo.clearbit.com/mongodb.com',
                'ESTC': 'https://logo.clearbit.com/elastic.co',
                'SPLK': 'https://logo.clearbit.com/splunk.com'
            };

            if (stockLogos[symbol]) {
                return `<img src="${stockLogos[symbol]}" alt="${symbol}" class="w-8 h-8 rounded-lg object-cover shadow-sm bg-white" onerror="this.outerHTML='<div class=\'w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center text-white text-sm font-bold shadow-sm\'>${symbol.charAt(0)}</div>'">`;
            } else {
                // Fallback to initial with professional styling
                const initial = symbol.charAt(0).toUpperCase();
                return `<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center text-white text-sm font-bold shadow-sm">${initial}</div>`;
            }
        } else if (type === 'forex') {
            // Real currency flags and symbols
            const baseCurrency = symbol.split('/')[0];
            const currencyImages = {
                'EUR': 'https://flagcdn.com/w40/eu.png',
                'USD': 'https://flagcdn.com/w40/us.png',
                'GBP': 'https://flagcdn.com/w40/gb.png',
                'JPY': 'https://flagcdn.com/w40/jp.png',
                'CHF': 'https://flagcdn.com/w40/ch.png',
                'CAD': 'https://flagcdn.com/w40/ca.png',
                'AUD': 'https://flagcdn.com/w40/au.png',
                'NZD': 'https://flagcdn.com/w40/nz.png',
                'SEK': 'https://flagcdn.com/w40/se.png',
                'NOK': 'https://flagcdn.com/w40/no.png',
                'DKK': 'https://flagcdn.com/w40/dk.png',
                'CNY': 'https://flagcdn.com/w40/cn.png',
                'INR': 'https://flagcdn.com/w40/in.png',
                'BRL': 'https://flagcdn.com/w40/br.png',
                'ZAR': 'https://flagcdn.com/w40/za.png',
                'MXN': 'https://flagcdn.com/w40/mx.png',
                'SGD': 'https://flagcdn.com/w40/sg.png',
                'HKD': 'https://flagcdn.com/w40/hk.png',
                'KRW': 'https://flagcdn.com/w40/kr.png',
                'TRY': 'https://flagcdn.com/w40/tr.png',
                'RUB': 'https://flagcdn.com/w40/ru.png'
            };

            if (currencyImages[baseCurrency]) {
                return `<img src="${currencyImages[baseCurrency]}" alt="${baseCurrency}" class="w-8 h-6 rounded object-cover shadow-sm">`;
            } else {
                // Fallback to currency symbol
                const symbols = {
                    'EUR': '€',
                    'USD': '$',
                    'GBP': '£',
                    'JPY': '¥',
                    'CHF': 'Fr',
                    'CAD': 'C$',
                    'AUD': 'A$',
                    'NZD': 'NZ$',
                    'SEK': 'kr',
                    'NOK': 'kr',
                    'DKK': 'kr',
                    'CNY': '¥',
                    'INR': '₹',
                    'BRL': 'R$',
                    'ZAR': 'R',
                    'MXN': '$',
                    'SGD': 'S$',
                    'HKD': 'HK$',
                    'KRW': '₩',
                    'TRY': '₺',
                    'RUB': '₽'
                };
                const symbol = symbols[baseCurrency] || '💱';
                return `<div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center text-white text-lg font-bold shadow-sm">${symbol}</div>`;
            }
        } else {
            return `<div class="w-8 h-8 bg-gradient-to-br from-gray-500 to-gray-700 rounded-lg flex items-center justify-center text-white text-lg font-bold shadow-sm">?</div>`;
        }
    }

    // Initialize
    fetchMarketData();
    startAutoRefresh();

    // Event listeners
    refreshBtn.addEventListener('click', fetchMarketData);
    retryBtn.addEventListener('click', fetchMarketData);

    marketTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            marketTabs.forEach(t => {
                t.classList.remove('active', 'bg-white/20', 'text-white');
                t.classList.add('bg-white/10', 'text-gray-300');
            });
            this.classList.add('active', 'bg-white/20', 'text-white');
            this.classList.remove('bg-white/10', 'text-gray-300');
            currentFilter = this.dataset.type;
            renderMarketData();
        });
    });

    async function fetchMarketData() {
        try {
            showLoading();

            const response = await fetch(`/api/market/all?ts=${Date.now()}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            // Backend returns { success: true, data: {...} }
            // Fallback to raw data if already shaped
            marketData = (data && typeof data === 'object' && 'data' in data) ? data.data : data;
            renderMarketData();
            updateLastUpdate();

        } catch (error) {
            console.error('Error fetching market data:', error);
            showError();
        }
    }

    function renderMarketData() {
        hideLoading();
        hideError();

        let filteredData = [];

        switch (currentFilter) {
            case 'crypto':
                filteredData = marketData.crypto || [];
                break;
            case 'stocks':
                filteredData = marketData.stocks || [];
                break;
            case 'forex':
                filteredData = marketData.forex || [];
                break;
            default:
                filteredData = [
                    ...(marketData.crypto || []),
                    ...(marketData.stocks || []),
                    ...(marketData.forex || [])
                ];
        }

        marketDataContainer.innerHTML = filteredData.map(item => createMarketItem(item)).join('');
    }

    function createMarketItem(item) {
        // Normalize fields across crypto, stocks and forex
        const price = parseFloat(
            (item.price_usd !== undefined ? item.price_usd :
            (item.price !== undefined ? item.price :
            (item.rate !== undefined ? item.rate : 0)))
        );

        const changePercent = parseFloat(
            (item.change_24h !== undefined ? item.change_24h :
            (item.change_percent !== undefined ? item.change_percent :
            (item.change !== undefined ? item.change : 0)))
        );

        const changeClass = changePercent >= 0 ? 'text-green-400' : 'text-red-400';
        const changeIcon = changePercent >= 0 ? '+' : '-';
        const bgColor = getBackgroundColor(item.type);

        // Build a stable key to track previous price and animate changes
        const key = item.id || item.symbol || item.pair || item.name || Math.random().toString(36).slice(2);
        let direction = 'none';
        if (previousPrices.hasOwnProperty(key)) {
            if (price > previousPrices[key]) direction = 'up';
            else if (price < previousPrices[key]) direction = 'down';
        }
        previousPrices[key] = price;

        const priceChangeClass = direction === 'up' ? 'flash-up' : (direction === 'down' ? 'flash-down' : '');

        // Choose display label
        const primaryLabel = item.symbol || item.pair || item.name || '';
        const secondaryLabel = item.name || item.pair || item.symbol || '';

        // Get professional logo for the asset
        const logoHtml = getProfessionalLogo(item);

        return `
            <div class="market-card p-4 rounded-xl hover:scale-105 transition-transform duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        ${logoHtml}
                        <div>
                            <p class="market-label font-semibold text-sm">${primaryLabel}</p>
                            <p class="market-sub text-xs">${secondaryLabel}</p>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="market-price font-bold text-lg ${priceChangeClass}">$${isFinite(price) ? price.toLocaleString() : '0'}</p>
                    <p class="text-sm ${changeClass} font-medium">
                        ${changeIcon} ${isFinite(changePercent) ? Math.abs(changePercent).toFixed(2) : '0.00'}%
                    </p>
                </div>
            </div>
        `;
    }

    function getBackgroundColor(type) {
        switch (type) {
            case 'crypto': return 'bg-orange-500';
            case 'stock': return 'bg-blue-500';
            case 'forex': return 'bg-green-500';
            default: return 'bg-gray-500';
        }
    }

    function getProfessionalLogo(item) {
        const symbol = (item.symbol || item.pair || '').toUpperCase();
        const name = (item.name || '').toLowerCase();

        // Cryptocurrency logos
        const cryptoLogos = {
            'BTC': '<div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">BTC</span></div>',
            'ETH': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">ETH</span></div>',
            'BNB': '<div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">B</span></div>',
            'ADA': '<div class="w-8 h-8 bg-gradient-to-br from-blue-300 to-blue-500 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">ADA</span></div>',
            'SOL': '<div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">SOL</span></div>',
            'DOT': '<div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">DOT</span></div>',
            'DOGE': '<div class="w-8 h-8 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">DOGE</span></div>',
            'AVAX': '<div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">A</span></div>',
            'LTC': '<div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">LTC</span></div>',
            'MATIC': '<div class="w-8 h-8 bg-gradient-to-br from-purple-300 to-purple-500 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">M</span></div>',
            'USDT': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">$</span></div>',
            'USDC': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">$</span></div>',
            'BUSD': '<div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">$</span></div>',
            'XRP': '<div class="w-8 h-8 bg-gradient-to-br from-blue-300 to-blue-500 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">XRP</span></div>',
            'LINK': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">L</span></div>',
            'UNI': '<div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">U</span></div>',
            'ALGO': '<div class="w-8 h-8 bg-gradient-to-br from-black to-gray-800 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">A</span></div>',
            'VET': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">V</span></div>',
            'ICP': '<div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">ICP</span></div>',
            'FIL': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">F</span></div>',
            'TRX': '<div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">T</span></div>',
            'ETC': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">E</span></div>',
            'XLM': '<div class="w-8 h-8 bg-gradient-to-br from-blue-300 to-blue-500 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">*</span></div>',
            'THETA': '<div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">TH</span></div>',
            'FTT': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">F</span></div>',
            'HBAR': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">H</span></div>',
            'NEAR': '<div class="w-8 h-8 bg-gradient-to-br from-black to-gray-800 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">N</span></div>',
            'FLOW': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">F</span></div>',
            'MANA': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">M</span></div>',
            'SAND': '<div class="w-8 h-8 bg-gradient-to-br from-blue-300 to-blue-500 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'AXS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">A</span></div>',
            'CHZ': '<div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">C</span></div>',
            'ENJ': '<div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">E</span></div>',
            'BAT': '<div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">B</span></div>',
            'OMG': '<div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">O</span></div>',
            'ZRX': '<div class="w-8 h-8 bg-gradient-to-br from-black to-gray-800 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">Z</span></div>',
            'REP': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">R</span></div>',
            'GNT': '<div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'STORJ': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'ANT': '<div class="w-8 h-8 bg-gradient-to-br from-black to-gray-800 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">A</span></div>',
            'FUN': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">F</span></div>',
            'WAVES': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">W</span></div>',
            'LSK': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">L</span></div>',
            'ARK': '<div class="w-8 h-8 bg-gradient-to-br from-black to-gray-800 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">A</span></div>',
            'STRAT': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'XEM': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">X</span></div>',
            'QTUM': '<div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">Q</span></div>',
            'BTG': '<div class="w-8 h-8 bg-gradient-to-br from-gold to-yellow-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">B</span></div>',
            'ZEC': '<div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">Z</span></div>',
            'DASH': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">D</span></div>',
            'XMR': '<div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">M</span></div>',
            'NEO': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">N</span></div>',
            'EOS': '<div class="w-8 h-8 bg-gradient-to-br from-black to-gray-800 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">E</span></div>',
            'IOTA': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">I</span></div>',
            'NEM': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">N</span></div>',
            'STEEM': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'SBD': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">S</span></div>',
            'GOLOS': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'GBG': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>'
        };

        if (cryptoLogos[symbol]) {
            return cryptoLogos[symbol];
        }

        // Stock logos
        const stockLogos = {
            'AAPL': '<div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">A</span></div>',
            'GOOGL': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">G</span></div>',
            'MSFT': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">M</span></div>',
            'AMZN': '<div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">A</span></div>',
            'TSLA': '<div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">T</span></div>',
            'META': '<div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">M</span></div>',
            'NVDA': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">N</span></div>',
            'NFLX': '<div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-700 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">N</span></div>'
        };

        if (stockLogos[symbol]) {
            return stockLogos[symbol];
        }

        // Forex logos
        const forexLogos = {
            'EUR': '<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">€</span></div>',
            'USD': '<div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">$</span></div>',
            'GBP': '<div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">£</span></div>',
            'JPY': '<div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-xs">¥</span></div>'
        };

        const baseCurrency = symbol.split('/')[0];
        if (forexLogos[baseCurrency]) {
            return forexLogos[baseCurrency];
        }

        // Default fallback
        return '<div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg flex items-center justify-center"><span class="text-white font-bold text-[10px]">TH</span></div>';
    }

    function showLoading() {
        loadingState.classList.remove('hidden');
        marketDataContainer.classList.add('hidden');
        errorState.classList.add('hidden');
    }

    function hideLoading() {
        loadingState.classList.add('hidden');
        marketDataContainer.classList.remove('hidden');
    }

    function showError() {
        errorState.classList.remove('hidden');
        marketDataContainer.classList.add('hidden');
        loadingState.classList.add('hidden');
    }

    function hideError() {
        errorState.classList.add('hidden');
    }

    function updateLastUpdate() {
        const now = new Date();
        lastUpdateElement.textContent = lastUpdatePrefix.replace(':time', now.toLocaleTimeString(locale));
    }

    function startAutoRefresh() {
        refreshInterval = setInterval(fetchMarketData, 60000); // Refresh every 60 seconds
    }

    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    }
});
</script>
<style>
@keyframes flashUp {
    0% { background-color: rgba(16, 185, 129, 0.25); }
    100% { background-color: transparent; }
}
@keyframes flashDown {
    0% { background-color: rgba(239, 68, 68, 0.25); }
    100% { background-color: transparent; }
}
.flash-up { animation: flashUp 0.6s ease-out; }
.flash-down { animation: flashDown 0.6s ease-out; }
</style>



<?php /**PATH C:\xampp\htdocs\cerveau\resources\views/components/market-tracker-fixed.blade.php ENDPATH**/ ?>