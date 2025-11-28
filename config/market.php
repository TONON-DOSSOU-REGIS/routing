<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Market Data API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for various market data APIs used to fetch real-time
    | stock, cryptocurrency, and forex data.
    |
    */

    'apis' => [
        'coingecko' => [
            'base_url' => 'https://api.coingecko.com/api/v3',
            'enabled' => true,
        ],
        
        'alpha_vantage' => [
            'base_url' => 'https://www.alphavantage.co/query',
            'api_key' => env('ALPHA_VANTAGE_API_KEY', 'demo'),
            'enabled' => env('ALPHA_VANTAGE_ENABLED', false),
        ],
        
        'finnhub' => [
            'base_url' => 'https://finnhub.io/api/v1',
            'api_key' => env('FINNHUB_API_KEY', ''),
            'enabled' => env('FINNHUB_ENABLED', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache duration for market data to avoid hitting API rate limits
    |
    */

    'cache' => [
        'duration' => 5, // seconds (realtime-like; lower cache to allow frequent updates)
        'prefix' => 'market_data_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Refresh Configuration
    |--------------------------------------------------------------------------
    |
    | Auto-refresh settings for the market tracker widget
    |
    */

    'refresh' => [
        'interval' => 5000, // milliseconds (5 seconds)
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cryptocurrencies to Track
    |--------------------------------------------------------------------------
    |
    | List of cryptocurrencies to display in the market tracker
    |
    */

    'cryptocurrencies' => [
        'bitcoin' => [
            'id' => 'bitcoin',
            'symbol' => 'BTC',
            'name' => 'Bitcoin',
            'icon' => 'fab fa-bitcoin',
            'image' => 'https://assets.coingecko.com/coins/images/1/large/bitcoin.png',
        ],
        'ethereum' => [
            'id' => 'ethereum',
            'symbol' => 'ETH',
            'name' => 'Ethereum',
            'icon' => 'fab fa-ethereum',
            'image' => 'https://assets.coingecko.com/coins/images/279/large/ethereum.png',
        ],
        'binancecoin' => [
            'id' => 'binancecoin',
            'symbol' => 'BNB',
            'name' => 'Binance Coin',
            'icon' => 'fas fa-coins',
            'image' => 'https://assets.coingecko.com/coins/images/825/large/bnb-icon2_2x.png',
        ],
        'cardano' => [
            'id' => 'cardano',
            'symbol' => 'ADA',
            'name' => 'Cardano',
            'icon' => 'fas fa-coins',
            'image' => 'https://assets.coingecko.com/coins/images/975/large/cardano.png',
        ],
        'solana' => [
            'id' => 'solana',
            'symbol' => 'SOL',
            'name' => 'Solana',
            'icon' => 'fas fa-coins',
            'image' => 'https://assets.coingecko.com/coins/images/4128/large/solana.png',
        ],
        'ripple' => [
            'id' => 'ripple',
            'symbol' => 'XRP',
            'name' => 'Ripple',
            'icon' => 'fas fa-coins',
            'image' => 'https://assets.coingecko.com/coins/images/44/large/xrp-symbol-white-128.png',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Stocks to Track
    |--------------------------------------------------------------------------
    |
    | List of stocks to display in the market tracker
    |
    */

    'stocks' => [
        'AAPL' => [
            'symbol' => 'AAPL',
            'name' => 'Apple Inc.',
            'icon' => 'fab fa-apple',
            'image' => 'https://logo.clearbit.com/apple.com',
        ],
        'MSFT' => [
            'symbol' => 'MSFT',
            'name' => 'Microsoft',
            'icon' => 'fab fa-microsoft',
            'image' => 'https://logo.clearbit.com/microsoft.com',
        ],
        'GOOGL' => [
            'symbol' => 'GOOGL',
            'name' => 'Google',
            'icon' => 'fab fa-google',
            'image' => 'https://logo.clearbit.com/google.com',
        ],
        'AMZN' => [
            'symbol' => 'AMZN',
            'name' => 'Amazon',
            'icon' => 'fab fa-amazon',
            'image' => 'https://logo.clearbit.com/amazon.com',
        ],
        'TSLA' => [
            'symbol' => 'TSLA',
            'name' => 'Tesla',
            'icon' => 'fas fa-car',
            'image' => 'https://logo.clearbit.com/tesla.com',
        ],
        'META' => [
            'symbol' => 'META',
            'name' => 'Meta',
            'icon' => 'fab fa-meta',
            'image' => 'https://logo.clearbit.com/meta.com',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Forex Pairs to Track
    |--------------------------------------------------------------------------
    |
    | List of forex currency pairs to display in the market tracker
    |
    */

    'forex' => [
        'EUR/USD' => [
            'pair' => 'EUR/USD',
            'name' => 'Euro / US Dollar',
            'icon' => 'fas fa-euro-sign',
            'image' => 'https://flagpedia.net/data/flags/w580/eu.png',
        ],
        'GBP/USD' => [
            'pair' => 'GBP/USD',
            'name' => 'British Pound / US Dollar',
            'icon' => 'fas fa-pound-sign',
            'image' => 'https://flagpedia.net/data/flags/w580/gb.png',
        ],
        'USD/JPY' => [
            'pair' => 'USD/JPY',
            'name' => 'US Dollar / Japanese Yen',
            'icon' => 'fas fa-yen-sign',
            'image' => 'https://flagpedia.net/data/flags/w580/jp.png',
        ],
        'USD/CHF' => [
            'pair' => 'USD/CHF',
            'name' => 'US Dollar / Swiss Franc',
            'icon' => 'fas fa-franc-sign',
            'image' => 'https://flagpedia.net/data/flags/w580/ch.png',
        ],
        'AUD/USD' => [
            'pair' => 'AUD/USD',
            'name' => 'Australian Dollar / US Dollar',
            'icon' => 'fas fa-dollar-sign',
            'image' => 'https://flagpedia.net/data/flags/w580/au.png',
        ],
        'USD/CAD' => [
            'pair' => 'USD/CAD',
            'name' => 'US Dollar / Canadian Dollar',
            'icon' => 'fas fa-dollar-sign',
            'image' => 'https://flagpedia.net/data/flags/w580/ca.png',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Settings
    |--------------------------------------------------------------------------
    |
    | Settings for how market data is displayed
    |
    */

    'display' => [
        'items_per_slide' => 4,
        'show_icons' => true,
        'show_charts' => true,
        'decimal_places' => 2,
    ],
];

