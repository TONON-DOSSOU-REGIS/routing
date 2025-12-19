<?php

namespace App\Http\Controllers;

use App\Services\MarketDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarketController extends Controller
{
    protected $marketDataService;

    public function __construct(MarketDataService $marketDataService)
    {
        $this->marketDataService = $marketDataService;
    }

    /**
     * Get all market data (crypto, stocks, forex)
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
            Log::error('Error fetching all market data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données du marché',
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
            Log::error('Error fetching crypto data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données crypto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get stock market data only
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
            Log::error('Error fetching stocks data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données boursières',
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
            Log::error('Error fetching forex data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données forex',
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
                'message' => 'Cache du marché effacé avec succès',
            ]);
        } catch (\Exception $e) {
            Log::error('Error clearing market cache: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'effacement du cache',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
