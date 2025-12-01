<?php

namespace App\Console\Commands;

use App\Models\Budget;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateBudgetSpentAmounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'budgets:update-spent-amounts {--user_id= : Update budgets for specific user} {--month= : Update budgets for specific month (YYYY-MM)} {--category= : Update budgets for specific category}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update spent amounts for budgets based on transaction data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting budget spent amounts update...');

        $query = Budget::query();

        // Apply filters if provided
        if ($this->option('user_id')) {
            $query->where('user_id', $this->option('user_id'));
            $this->info("Filtering by user ID: {$this->option('user_id')}");
        }

        if ($this->option('month')) {
            $query->where('month', $this->option('month') . '-01');
            $this->info("Filtering by month: {$this->option('month')}");
        }

        if ($this->option('category')) {
            $query->where('category', $this->option('category'));
            $this->info("Filtering by category: {$this->option('category')}");
        }

        $budgets = $query->get();
        $totalBudgets = $budgets->count();

        if ($totalBudgets === 0) {
            $this->warn('No budgets found matching the criteria.');
            return;
        }

        $this->info("Found {$totalBudgets} budget(s) to update.");
        $bar = $this->output->createProgressBar($totalBudgets);
        $bar->start();

        $updated = 0;
        $errors = 0;

        foreach ($budgets as $budget) {
            try {
                $spent = $this->calculateSpentAmount($budget);
                $budget->update(['spent' => $spent]);
                $updated++;
            } catch (\Exception $e) {
                $errors++;
                Log::error("Error updating budget ID {$budget->id}: " . $e->getMessage());
                $this->error("Failed to update budget ID {$budget->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Update completed:");
        $this->info("- Total budgets processed: {$totalBudgets}");
        $this->info("- Successfully updated: {$updated}");
        $this->info("- Errors: {$errors}");

        if ($errors > 0) {
            $this->warn('Some budgets could not be updated. Check the logs for details.');
        } else {
            $this->info('All budgets updated successfully!');
        }
    }

    /**
     * Calculate the spent amount for a budget based on transactions
     */
    private function calculateSpentAmount(Budget $budget): float
    {
        return DB::table('transactions')
            ->where('user_id', $budget->user_id)
            ->where('type', 'transfer')
            ->where('status', 'success')
            ->whereYear('created_at', $budget->month->year)
            ->whereMonth('created_at', $budget->month->month)
            ->where('category', $budget->category)
            ->sum('amount');
    }
}

