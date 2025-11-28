<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InspectDateOfBirthColumn extends Command
{
    protected $signature = 'inspect:date_of_birth_column';

    protected $description = 'Inspect the date_of_birth column definition and invalid data in users table';

    public function handle(): int
    {
        // Get column info
        $column_info = DB::select("SHOW COLUMNS FROM users LIKE 'date_of_birth'");

        if (empty($column_info)) {
            $this->error("Column 'date_of_birth' does not exist in users table.");
            return 1;
        }

        $this->info("Column 'date_of_birth' info:");

        $rows = [];
        foreach ($column_info as $row) {
            $rows[] = (array) $row;
        }
        $this->table(['Field', 'Type', 'Null', 'Key', 'Default', 'Extra'], $rows);

        // Check for invalid or null dates
        $invalidDates = DB::table('users')
            ->whereNull('date_of_birth')
            ->orWhere('date_of_birth', '0000-00-00')
            ->get();

        if ($invalidDates->isEmpty()) {
            $this->info("No invalid or null date_of_birth values found.");
        } else {
            $this->info("Rows with invalid or null date_of_birth:");
            $rows = [];
            foreach ($invalidDates as $row) {
                $rows[] = (array)$row;
            }
            $this->table(['id', 'date_of_birth'], $rows);
        }

        return 0;
    }
}

