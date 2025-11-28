<?php

namespace App\Http\Controllers;

use App\Services\MarketDataService;
use Illuminate\Http\Request;

class MarketDataController extends Controller
{
    protected $marketDataService;

    public function __construct(MarketDataService $marketDataService)
    {
        $this->marketDataService = $marketDataService;
    }

    /**
     * Get all market data
     */
    public function index()
    {
        try {
            $data = $this->marketDataService->getAllMarketData();
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching market data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get cryptocurrency data only
     */
    public function crypto()
    {
        try {
            $data = $this->marketDataService->getCryptoData();
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching crypto data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get stocks data only
     */
    public function stocks()
    {
        try {
            $data = $this->marketDataService->getStocksData();
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching stocks data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get forex data only
     */
    public function forex()
    {
        try {
            $data = $this->marketDataService->getForexData();
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching forex data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear market data cache
     */
    public function clearCache()
    {
        try {
            $this->marketDataService->clearCache();
            return response()->json([
                'success' => true,
                'message' => 'Cache cleared successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cache',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

