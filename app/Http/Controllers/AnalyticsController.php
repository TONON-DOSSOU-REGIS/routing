<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Get balance evolution data for the last 30 days
     */
    public function getBalanceEvolution(Request $request)
    {
        $user = auth()->user();
        $days = $request->input('days', 30);
        
        $startDate = Carbon::now()->subDays($days);
        
        // Get all transactions for the period
        $transactions = Transaction::where('user_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->where('status', 'success')
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Calculate balance evolution
        $balanceData = [];
        $currentBalance = $user->balance;
        
        // Start from current balance and go backwards
        $dates = [];
        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[$date] = $currentBalance;
        }
        
        // Adjust balances based on transactions
        foreach ($transactions as $transaction) {
            $date = $transaction->created_at->format('Y-m-d');
            
            if (isset($dates[$date])) {
                // Reverse the transaction effect to get historical balance
                if ($transaction->type === 'deposit') {
                    $dates[$date] -= $transaction->amount;
                } elseif ($transaction->type === 'withdrawal' || $transaction->type === 'transfer') {
                    $dates[$date] += $transaction->amount;
                }
            }
        }
        
        // Format data for Chart.js
        $labels = array_keys($dates);
        $data = array_values($dates);
        
        return response()->json([
            'success' => true,
            'labels' => $labels,
            'data' => $data,
            'current_balance' => $user->balance,
            'currency' => $user->default_currency ?? 'EUR',
            'currency_symbol' => $user->currency_symbol
        ]);
    }
    
    /**
     * Get transactions by type (pie chart data)
     */
    public function getTransactionsByType(Request $request)
    {
        $user = auth()->user();
        $days = $request->input('days', 30);
        
        $startDate = Carbon::now()->subDays($days);
        
        $transactionsByType = Transaction::where('user_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->where('status', 'success')
            ->select('type', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('type')
            ->get();
        
        $labels = [];
        $counts = [];
        $amounts = [];
        
        foreach ($transactionsByType as $transaction) {
            $labels[] = ucfirst($transaction->type);
            $counts[] = $transaction->count;
            $amounts[] = $transaction->total;
        }
        
        return response()->json([
            'success' => true,
            'labels' => $labels,
            'counts' => $counts,
            'amounts' => $amounts,
            'currency' => $user->default_currency ?? 'EUR',
            'currency_symbol' => $user->currency_symbol
        ]);
    }
    
    /**
     * Get monthly comparison data
     */
    public function getMonthlyComparison(Request $request)
    {
        $user = auth()->user();
        $months = $request->input('months', 6);
        
        $data = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $startDate = Carbon::now()->subMonths($i)->startOfMonth();
            $endDate = Carbon::now()->subMonths($i)->endOfMonth();
            
            $deposits = Transaction::where('user_id', $user->id)
                ->where('type', 'deposit')
                ->where('status', 'success')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
            
            $withdrawals = Transaction::where('user_id', $user->id)
                ->whereIn('type', ['withdrawal', 'transfer'])
                ->where('status', 'success')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
            
            $data[] = [
                'month' => $startDate->format('M Y'),
                'deposits' => $deposits,
                'withdrawals' => $withdrawals,
                'net' => $deposits - $withdrawals
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'currency' => $user->default_currency ?? 'EUR',
            'currency_symbol' => $user->currency_symbol
        ]);
    }
    
    /**
     * Get detailed statistics
     */
    public function getStatistics(Request $request)
    {
        $user = auth()->user();
        $days = $request->input('days', 30);
        
        $startDate = Carbon::now()->subDays($days);
        
        $totalDeposits = Transaction::where('user_id', $user->id)
            ->where('type', 'deposit')
            ->where('status', 'success')
            ->where('created_at', '>=', $startDate)
            ->sum('amount');
        
        $totalWithdrawals = Transaction::where('user_id', $user->id)
            ->whereIn('type', ['withdrawal', 'transfer'])
            ->where('status', 'success')
            ->where('created_at', '>=', $startDate)
            ->sum('amount');
        
        $transactionCount = Transaction::where('user_id', $user->id)
            ->where('status', 'success')
            ->where('created_at', '>=', $startDate)
            ->count();
        
        $averageTransaction = $transactionCount > 0 
            ? ($totalDeposits + $totalWithdrawals) / $transactionCount 
            : 0;
        
        $largestDeposit = Transaction::where('user_id', $user->id)
            ->where('type', 'deposit')
            ->where('status', 'success')
            ->where('created_at', '>=', $startDate)
            ->max('amount') ?? 0;
        
        $largestWithdrawal = Transaction::where('user_id', $user->id)
            ->whereIn('type', ['withdrawal', 'transfer'])
            ->where('status', 'success')
            ->where('created_at', '>=', $startDate)
            ->max('amount') ?? 0;
        
        return response()->json([
            'success' => true,
            'statistics' => [
                'total_deposits' => $totalDeposits,
                'total_withdrawals' => $totalWithdrawals,
                'net_flow' => $totalDeposits - $totalWithdrawals,
                'transaction_count' => $transactionCount,
                'average_transaction' => $averageTransaction,
                'largest_deposit' => $largestDeposit,
                'largest_withdrawal' => $largestWithdrawal,
                'current_balance' => $user->balance
            ],
            'currency' => $user->default_currency ?? 'EUR',
            'currency_symbol' => $user->currency_symbol
        ]);
    }
}

