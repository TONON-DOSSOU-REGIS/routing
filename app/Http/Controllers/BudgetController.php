<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BudgetController extends Controller
{
    public function __construct()
    {
        // Middleware is already applied at route level
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Budget::with('user');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->where('month', $request->month . '-01');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $budgets = $query->orderBy('month', 'desc')
                         ->orderBy('category')
                         ->paginate(15);

        $users = User::select('id', 'first_name', 'last_name', 'email')->get();

        return view('budgets.index', compact('budgets', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'first_name', 'last_name', 'email')->get();
        $categories = $this->getTransactionCategories();

        return view('budgets.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|date_format:Y-m',
            'alert_enabled' => 'boolean',
            'alert_threshold' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            $budget = Budget::create([
                'user_id' => $request->user_id,
                'category' => $request->category,
                'amount' => $request->amount,
                'spent' => 0, // Will be calculated by the command
                'month' => $request->month . '-01',
                'alert_enabled' => $request->boolean('alert_enabled'),
                'alert_threshold' => $request->alert_threshold ?? 80,
            ]);

            // Update spent amount
            $this->updateBudgetSpentAmount($budget);

            return redirect()->route('budgets.index')
                           ->with('success', 'Budget créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Error creating budget: ' . $e->getMessage());
            return back()->withInput()
                        ->with('error', 'Erreur lors de la création du budget.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        $budget->load('user');

        // Get transactions for this budget category and month
        $transactions = DB::table('transactions')
            ->where('user_id', $budget->user_id)
            ->where('type', 'transfer')
            ->where('status', 'success')
            ->whereYear('created_at', $budget->month->year)
            ->whereMonth('created_at', $budget->month->month)
            ->where('category', $budget->category)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('budgets.show', compact('budget', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        $users = User::select('id', 'first_name', 'last_name', 'email')->get();
        $categories = $this->getTransactionCategories();

        return view('budgets.edit', compact('budget', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|date_format:Y-m',
            'alert_enabled' => 'boolean',
            'alert_threshold' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            $budget->update([
                'user_id' => $request->user_id,
                'category' => $request->category,
                'amount' => $request->amount,
                'month' => $request->month . '-01',
                'alert_enabled' => $request->boolean('alert_enabled'),
                'alert_threshold' => $request->alert_threshold ?? 80,
            ]);

            // Update spent amount
            $this->updateBudgetSpentAmount($budget);

            return redirect()->route('budgets.index')
                           ->with('success', 'Budget mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Error updating budget: ' . $e->getMessage());
            return back()->withInput()
                        ->with('error', 'Erreur lors de la mise à jour du budget.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        try {
            $budget->delete();

            return redirect()->route('budgets.index')
                           ->with('success', 'Budget supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Error deleting budget: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la suppression du budget.');
        }
    }

    /**
     * Update spent amounts for all budgets
     */
    public function updateAllSpentAmounts()
    {
        try {
            $budgets = Budget::all();
            $updated = 0;

            foreach ($budgets as $budget) {
                $this->updateBudgetSpentAmount($budget);
                $updated++;
            }

            return redirect()->route('budgets.index')
                           ->with('success', $updated . ' budgets mis à jour.');
        } catch (\Exception $e) {
            Log::error('Error updating budget spent amounts: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la mise à jour des montants dépensés.');
        }
    }

    /**
     * Update spent amount for a specific budget
     */
    private function updateBudgetSpentAmount(Budget $budget)
    {
        $spent = DB::table('transactions')
            ->where('user_id', $budget->user_id)
            ->where('type', 'transfer')
            ->where('status', 'success')
            ->whereYear('created_at', $budget->month->year)
            ->whereMonth('created_at', $budget->month->month)
            ->where('category', $budget->category)
            ->sum('amount');

        $budget->update(['spent' => $spent]);
    }

    /**
     * Get available transaction categories
     */
    private function getTransactionCategories()
    {
        return [
            'Alimentation',
            'Transport',
            'Logement',
            'Santé',
            'Éducation',
            'Divertissement',
            'Shopping',
            'Services',
            'Voyages',
            'Assurance',
            'Impôts',
            'Autres'
        ];
    }
}

