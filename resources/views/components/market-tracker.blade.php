<style>[x-cloak]{ display: none !important; }</style>
<!-- Market Tracker Widget -->
<div x-data="marketTracker()" x-cloak>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-3 rounded-2xl mr-4 shadow-lg">
                <i class="fas fa-chart-line text-white text-2xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Marchés en temps réel</h3>
                <p class="text-gray-600 mt-1">Suivez les variations du marché boursier</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full flex items-center">
                <i class="fas fa-sync-alt mr-2" :class="{ 'fa-spin': loading }"></i>
                <span x-text="lastUpdate"></span>
            </div>
            <button @click="refreshData()" class="text-blue-600 hover:text-blue-700 transition">
                <i class="fas fa-redo text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Market Type Tabs -->
    <div class="flex space-x-2 mb-6 bg-gray-100 p-1 rounded-xl">
        <button @click="activeTab = 'all'" 
                :class="activeTab === 'all' ? 'bg-white text-blue-600 shadow-md' : 'text-gray-600 hover:text-gray-900'"
                class="flex-1 px-4 py-2 rounded-lg font-medium transition duration-200">
            <i class="fas fa-globe mr-2"></i>Tous
        </button>
        <button @click="activeTab = 'crypto'" 
                :class="activeTab === 'crypto' ? 'bg-white text-blue-600 shadow-md' : 'text-gray-600 hover:text-gray-900'"
                class="flex-1 px-4 py-2 rounded-lg font-medium transition duration-200">
            <i class="fab fa-bitcoin mr-2"></i>Crypto
        </button>
        <button @click="activeTab = 'stocks'" 
                :class="activeTab === 'stocks' ? 'bg-white text-blue-600 shadow-md' : 'text-gray-600 hover:text-gray-900'"
                class="flex-1 px-4 py-2 rounded-lg font-medium transition duration-200">
            <i class="fas fa-chart-bar mr-2"></i>Actions
        </button>
        <button @click="activeTab = 'forex'" 
                :class="activeTab === 'forex' ? 'bg-white text-blue-600 shadow-md' : 'text-gray-600 hover:text-gray-900'"
                class="flex-1 px-4 py-2 rounded-lg font-medium transition duration-200">
            <i class="fas fa-dollar-sign mr-2"></i>Forex
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="loading && !marketData.length" x-transition.opacity class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-10 w-10 border-2 border-blue-600 border-t-transparent"></div>
        <p class="text-gray-600 mt-4">Chargement des données du marché...</p>

        <!-- Skeleton shimmer placeholders -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <template x-for="i in Array.from({ length: 8 })" :key="i">
                <div class="rounded-xl p-6 border border-gray-200 bg-white/60 animate-pulse">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-200 mr-3"></div>
                            <div>
                                <div class="h-4 bg-gray-200 rounded w-24 mb-2"></div>
                                <div class="h-3 bg-gray-200 rounded w-32"></div>
                            </div>
                        </div>
                        <div class="h-5 bg-gray-200 rounded w-16"></div>
                    </div>
                    <div class="h-6 bg-gray-200 rounded w-28 mb-3"></div>
                    <div class="h-3 bg-gray-200 rounded w-20 mb-2"></div>
                    <div class="mt-4 h-1 bg-gray-200 rounded-full"></div>
                </div>
            </template>
        </div>
    </div>

    <!-- Error State -->
    <div x-show="error" x-transition.opacity class="text-center py-12">
        <div class="bg-red-100 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
        </div>
        <p class="text-red-600 font-medium">Erreur lors du chargement des données</p>
        <button @click="refreshData()" class="mt-4 text-blue-600 hover:text-blue-700 font-medium">
            <i class="fas fa-redo mr-2"></i>Réessayer
        </button>
    </div>

    <!-- Market Data Grid -->
    <div class="relative">
        <!-- Subtle veil during refresh to avoid abrupt pops -->
        <div x-show="refreshing" x-transition.opacity class="absolute inset-0 bg-white/30 backdrop-blur-[1px] rounded-xl pointer-events-none"></div>

        <div x-show="!loading && !error && filteredData.length"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <template x-for="(item, index) in filteredData" :key="item.symbol || item.id || item.pair">
                <div
                    x-init="$el.classList.add('opacity-0','translate-y-2'); setTimeout(() => { $el.classList.remove('opacity-0','translate-y-2') }, index * 80)"
                    :style="`transition-delay: ${index * 80}ms`"
                    class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-500 ease-out">
                    <!-- Icon and Name -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3 overflow-hidden"
                                 :class="!item.image ? getIconBgColor(item.type) : 'bg-white border border-gray-200'">
                                <template x-if="item.image">
                                    <img :src="item.image" :alt="item.name" class="w-10 h-10 object-contain rounded-full">
                                </template>
                                <template x-if="!item.image">
                                    <i :class="item.icon" class="text-white text-xl"></i>
                                </template>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900" x-text="item.symbol || item.pair"></h4>
                                <p class="text-xs text-gray-500" x-text="item.name"></p>
                            </div>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full"
                              :class="getTypeBadgeColor(item.type)"
                              x-text="getTypeLabel(item.type)"></span>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <div class="text-2xl font-bold text-gray-900 transition-colors duration-500" x-text="formatPrice(item)"></div>
                        <div class="text-xs text-gray-500" x-show="item.type === 'crypto'">
                            <span x-text="formatEurPrice(item)"></span>
                        </div>
                    </div>

                    <!-- Change -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i :class="getChangeIcon(item)" class="mr-2"></i>
                            <span class="font-bold transition-colors duration-500" 
                                  :class="getChangeColor(item)"
                                  x-text="formatChange(item)"></span>
                        </div>
                        <div class="text-xs text-gray-500" x-show="item.volume_24h || item.volume">
                            Vol: <span x-text="formatVolume(item)"></span>
                        </div>
                    </div>

                    <!-- Mini Chart Indicator -->
                    <div class="mt-4 h-1 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500"
                             :class="getChange(item) >= 0 ? 'bg-green-500' : 'bg-red-500'"
                             :style="`width: ${Math.min(Math.abs(getChange(item)) * 10, 100)}%`"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function marketTracker() {
    return {
        marketData: [],
        loading: true,
        refreshing: false,
        error: false,
        activeTab: 'all',
        lastUpdate: 'Chargement...',

        init() {
            this.fetchMarketData();
            setInterval(() => {
                this.fetchMarketData();
            }, 30000);
        },

        async fetchMarketData() {
            try {
                const initial = this.marketData.length === 0;
                if (initial) {
                    this.loading = true;
                } else {
                    this.refreshing = true;
                }
                this.error = false;

                const response = await fetch('/api/market/all');
                const result = await response.json();

                if (result.success) {
                    this.marketData = [
                        ...result.data.crypto,
                        ...result.data.stocks,
                        ...result.data.forex
                    ];
                    this.lastUpdate = 'À l\'instant';
                    this.error = false;
                } else {
                    this.error = true;
                }
            } catch (error) {
                console.error('Error fetching market data:', error);
                this.error = true;
            } finally {
                this.loading = false;
                this.refreshing = false;
            }
        },

        refreshData() {
            this.fetchMarketData();
        },

        get filteredData() {
            if (this.activeTab === 'all') {
                return this.marketData;
            }
            return this.marketData.filter(item => item.type === this.activeTab);
        },

        formatPrice(item) {
            if (item.type === 'crypto') {
                return '$' + (item.price_usd || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            } else if (item.type === 'stock') {
                return '$' + (item.price || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            } else if (item.type === 'forex') {
                return (item.rate || 0).toFixed(4);
            }
            return '0.00';
        },

        formatEurPrice(item) {
            if (item.price_eur) {
                return '€' + item.price_eur.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
            return '';
        },

        formatChange(item) {
            const change = this.getChange(item);
            const sign = change >= 0 ? '+' : '';
            return sign + change.toFixed(2) + '%';
        },

        formatVolume(item) {
            const volume = item.volume_24h || item.volume || 0;
            if (volume >= 1000000000) {
                return (volume / 1000000000).toFixed(2) + 'B';
            } else if (volume >= 1000000) {
                return (volume / 1000000).toFixed(2) + 'M';
            } else if (volume >= 1000) {
                return (volume / 1000).toFixed(2) + 'K';
            }
            return volume.toFixed(0);
        },

        getChange(item) {
            return item.change_24h || item.change_percent || item.change || 0;
        },

        getChangeColor(item) {
            return this.getChange(item) >= 0 ? 'text-green-600' : 'text-red-600';
        },

        getChangeIcon(item) {
            return this.getChange(item) >= 0 ? 'fas fa-arrow-up text-green-600' : 'fas fa-arrow-down text-red-600';
        },

        getIconBgColor(type) {
            const colors = {
                'crypto': 'bg-gradient-to-r from-yellow-500 to-orange-500',
                'stock': 'bg-gradient-to-r from-blue-500 to-indigo-500',
                'forex': 'bg-gradient-to-r from-green-500 to-emerald-500'
            };
            return colors[type] || 'bg-gray-500';
        },

        getTypeBadgeColor(type) {
            const colors = {
                'crypto': 'bg-yellow-100 text-yellow-800',
                'stock': 'bg-blue-100 text-blue-800',
                'forex': 'bg-green-100 text-green-800'
            };
            return colors[type] || 'bg-gray-100 text-gray-800';
        },

        getTypeLabel(type) {
            const labels = {
                'crypto': 'Crypto',
                'stock': 'Action',
                'forex': 'Forex'
            };
            return labels[type] || type;
        }
    }
}
</script>


