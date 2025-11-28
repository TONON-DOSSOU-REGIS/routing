<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MarketDataService
{
    protected $cachePrefix;
    protected $cacheDuration;

    public function __construct()
    {
        $this->cachePrefix = config('market.cache.prefix', 'market_data_');
        $this->cacheDuration = config('market.cache.duration', 60);
    }

    /**
     * Get all market data (crypto, stocks, forex)
     */
    public function getAllMarketData()
    {
        return Cache::remember($this->cachePrefix . 'all', $this->cacheDuration, function () {
            return [
                'crypto' => $this->getCryptoData(),
                'stocks' => $this->getStocksData(),
                'forex' => $this->getForexData(),
                'timestamp' => now()->toIso8601String(),
            ];
        });
    }

    /**
     * Get cryptocurrency data from CoinGecko
     */
    public function getCryptoData()
    {
        return Cache::remember($this->cachePrefix . 'crypto', $this->cacheDuration, function () {
            try {
                $cryptos = config('market.cryptocurrencies', []);
                $ids = implode(',', array_column($cryptos, 'id'));

                $response = Http::timeout(10)->get(config('market.apis.coingecko.base_url') . '/simple/price', [
                    'ids' => $ids,
                    'vs_currencies' => 'usd,eur',
                    'include_24hr_change' => 'true',
                    'include_24hr_vol' => 'true',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $result = [];

                    foreach ($cryptos as $key => $crypto) {
                        if (isset($data[$crypto['id']])) {
                            $result[] = [
                                'id' => $crypto['id'],
                                'symbol' => $crypto['symbol'],
                                'name' => $crypto['name'],
                                'icon' => $crypto['icon'],
                                'image' => $crypto['image'] ?? null,
                                'price_usd' => $data[$crypto['id']]['usd'] ?? 0,
                                'price_eur' => $data[$crypto['id']]['eur'] ?? 0,
                                'change_24h' => $data[$crypto['id']]['usd_24h_change'] ?? 0,
                                'volume_24h' => $data[$crypto['id']]['usd_24h_vol'] ?? 0,
                                'type' => 'crypto',
                            ];
                        }
                    }

                    return $result;
                }

                return $this->getMockCryptoData();
            } catch (\Exception $e) {
                Log::error('Error fetching crypto data: ' . $e->getMessage());
                return $this->getMockCryptoData();
            }
        });
    }

    /**
     * Get stock market data
     */
    public function getStocksData()
    {
        return Cache::remember($this->cachePrefix . 'stocks', $this->cacheDuration, function () {
            // For demo purposes, return mock data
            // In production, integrate with Alpha Vantage or Finnhub
            return $this->getMockStocksData();
        });
    }

    /**
     * Get forex data
     */
    public function getForexData()
    {
        return Cache::remember($this->cachePrefix . 'forex', $this->cacheDuration, function () {
            // For demo purposes, return mock data
            // In production, integrate with Alpha Vantage or Finnhub
            return $this->getMockForexData();
        });
    }

    /**
     * Get mock cryptocurrency data for demo/fallback
     */
    protected function getMockCryptoData()
    {
        $cryptos = config('market.cryptocurrencies', []);
        $result = [];

        foreach ($cryptos as $crypto) {
            $basePrice = $this->getBasePriceForCrypto($crypto['symbol']);
            $change = rand(-1000, 1500) / 100;

            $result[] = [
                'id' => $crypto['id'],
                'symbol' => $crypto['symbol'],
                'name' => $crypto['name'],
                'icon' => $crypto['icon'],
                'image' => $crypto['image'] ?? null,
                'price_usd' => $basePrice + ($basePrice * $change / 100),
                'price_eur' => ($basePrice + ($basePrice * $change / 100)) * 0.92,
                'change_24h' => $change,
                'volume_24h' => rand(1000000000, 50000000000),
                'type' => 'crypto',
            ];
        }

        return $result;
    }

    /**
     * Get mock stocks data for demo/fallback
     */
    protected function getMockStocksData()
    {
        $stocks = config('market.stocks', []);
        $result = [];

        foreach ($stocks as $stock) {
            $basePrice = $this->getBasePriceForStock($stock['symbol']);
            $change = rand(-500, 800) / 100;

            $result[] = [
                'symbol' => $stock['symbol'],
                'name' => $stock['name'],
                'icon' => $stock['icon'],
                'image' => $stock['image'] ?? null,
                'price' => $basePrice + ($basePrice * $change / 100),
                'change' => $change,
                'change_percent' => $change,
                'volume' => rand(10000000, 100000000),
                'type' => 'stock',
            ];
        }

        return $result;
    }

    /**
     * Get mock forex data for demo/fallback
     */
    protected function getMockForexData()
    {
        $forexPairs = config('market.forex', []);
        $result = [];

        foreach ($forexPairs as $forex) {
            $baseRate = $this->getBaseRateForForex($forex['pair']);
            $change = rand(-200, 200) / 100;

            $result[] = [
                'pair' => $forex['pair'],
                'name' => $forex['name'],
                'icon' => $forex['icon'],
                'image' => $forex['image'] ?? null,
                'rate' => $baseRate + ($baseRate * $change / 100),
                'change' => $change,
                'change_percent' => $change,
                'type' => 'forex',
            ];
        }

        return $result;
    }

    /**
     * Get base price for cryptocurrency
     */
    protected function getBasePriceForCrypto($symbol)
    {
        $prices = [
            'BTC' => 43000,
            'ETH' => 2300,
            'BNB' => 310,
            'ADA' => 0.52,
            'SOL' => 98,
            'XRP' => 0.61,
        ];

        return $prices[$symbol] ?? 100;
    }

    /**
     * Get base price for stock
     */
    protected function getBasePriceForStock($symbol)
    {
        $prices = [
            'AAPL' => 178.50,
            'MSFT' => 378.90,
            'GOOGL' => 140.20,
            'AMZN' => 151.30,
            'TSLA' => 242.80,
            'META' => 352.70,
        ];

        return $prices[$symbol] ?? 100;
    }

    /**
     * Get base rate for forex pair
     */
    protected function getBaseRateForForex($pair)
    {
        $rates = [
            'EUR/USD' => 1.0850,
            'GBP/USD' => 1.2650,
            'USD/JPY' => 149.50,
            'USD/CHF' => 0.8750,
            'AUD/USD' => 0.6580,
            'USD/CAD' => 1.3520,
        ];

        return $rates[$pair] ?? 1.0;
    }

    /**
     * Clear all market data cache
     */
    public function clearCache()
    {
        Cache::forget($this->cachePrefix . 'all');
        Cache::forget($this->cachePrefix . 'crypto');
        Cache::forget($this->cachePrefix . 'stocks');
        Cache::forget($this->cachePrefix . 'forex');
    }
}

