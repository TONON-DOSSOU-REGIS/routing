<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function index()
    {
        $user = auth()->user();
        $transactions = $user->transactions()->latest()->take(5)->get();

        return view('dashboard.index', compact('user', 'transactions'));
    }

    public function profile()
    {
        $user = auth()->user()->load('creditCard');
        return view('profile.index', compact('user'));
    }

    /**
     * Get balance evolution data for the specified period
     */
    public function getBalanceEvolution(Request $request)
    {
        $days = $request->input('days', 30);
        $user = auth()->user();
        
        // Get transactions for the period
        $startDate = Carbon::now()->subDays($days);
        $transactions = $user->transactions()
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at', 'asc')
            ->get();

        // Calculate running balance
        $labels = [];
        $data = [];
        $currentBalance = $user->balance;

        // Get initial balance (balance before the period)
        $transactionsBeforePeriod = $user->transactions()
            ->where('created_at', '<', $startDate)
            ->get();
        
        $initialBalance = $user->balance;
        foreach ($transactionsBeforePeriod as $transaction) {
            if ($transaction->type === 'deposit') {
                $initialBalance -= $transaction->amount;
            } elseif ($transaction->type === 'withdrawal') {
                $initialBalance += $transaction->amount;
            }
        }

        // Group transactions by day
        $transactionsByDay = $transactions->groupBy(function($transaction) {
            return $transaction->created_at->format('Y-m-d');
        });

        // Generate data points
        $runningBalance = $initialBalance;
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            $labels[] = $date->format('d/m');

            // Apply transactions for this day
            if (isset($transactionsByDay[$dateKey])) {
                foreach ($transactionsByDay[$dateKey] as $transaction) {
                    if ($transaction->type === 'deposit') {
                        $runningBalance += $transaction->amount;
                    } elseif ($transaction->type === 'withdrawal') {
                        $runningBalance -= $transaction->amount;
                    }
                }
            }

            $data[] = round($runningBalance, 2);
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    /**
     * Get transactions grouped by type
     */
    public function getTransactionsByType(Request $request)
    {
        $days = $request->input('days', 30);
        $user = auth()->user();
        
        $startDate = Carbon::now()->subDays($days);
        
        $transactionsByType = $user->transactions()
            ->where('created_at', '>=', $startDate)
            ->select('type', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get();

        $labels = [];
        $amounts = [];
        $counts = [];

        $typeLabels = [
            'deposit' => 'Dépôts',
            'withdrawal' => 'Retraits',
            'transfer' => 'Virements'
        ];

        foreach ($transactionsByType as $item) {
            $labels[] = $typeLabels[$item->type] ?? ucfirst($item->type);
            $amounts[] = round($item->total, 2);
            $counts[] = $item->count;
        }

        return response()->json([
            'labels' => $labels,
            'amounts' => $amounts,
            'counts' => $counts
        ]);
    }

    /**
     * Get monthly comparison data (last 6 months)
     */
    public function getMonthlyComparison(Request $request)
    {
        $user = auth()->user();
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $deposits = $user->transactions()
                ->where('type', 'deposit')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $withdrawals = $user->transactions()
                ->where('type', 'withdrawal')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $data[] = [
                'month' => $date->locale('fr')->isoFormat('MMM YYYY'),
                'deposits' => round($deposits, 2),
                'withdrawals' => round($withdrawals, 2)
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Get analytics statistics
     */
    public function getAnalyticsStatistics(Request $request)
    {
        $days = $request->input('days', 30);
        $user = auth()->user();
        
        $startDate = Carbon::now()->subDays($days);

        // Get transactions for the period
        $transactions = $user->transactions()
            ->where('created_at', '>=', $startDate)
            ->get();

        $totalDeposits = $transactions->where('type', 'deposit')->sum('amount');
        $totalWithdrawals = $transactions->where('type', 'withdrawal')->sum('amount');
        $netFlow = $totalDeposits - $totalWithdrawals;
        $transactionCount = $transactions->count();
        $averageTransaction = $transactionCount > 0 ? ($totalDeposits + $totalWithdrawals) / $transactionCount : 0;

        // Calculate trends (compare with previous period)
        $previousStartDate = Carbon::now()->subDays($days * 2);
        $previousEndDate = $startDate->copy();
        
        $previousTransactions = $user->transactions()
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->get();

        $previousDeposits = $previousTransactions->where('type', 'deposit')->sum('amount');
        $previousWithdrawals = $previousTransactions->where('type', 'withdrawal')->sum('amount');

        $depositsTrend = $previousDeposits > 0 
            ? round((($totalDeposits - $previousDeposits) / $previousDeposits) * 100, 1) 
            : 0;
        
        $withdrawalsTrend = $previousWithdrawals > 0 
            ? round((($totalWithdrawals - $previousWithdrawals) / $previousWithdrawals) * 100, 1) 
            : 0;

        return response()->json([
            'statistics' => [
                'total_deposits' => round($totalDeposits, 2),
                'total_withdrawals' => round($totalWithdrawals, 2),
                'net_flow' => round($netFlow, 2),
                'transaction_count' => $transactionCount,
                'average_transaction' => round($averageTransaction, 2),
                'deposits_trend' => $depositsTrend,
                'withdrawals_trend' => $withdrawalsTrend
            ]
        ]);
    }
}

