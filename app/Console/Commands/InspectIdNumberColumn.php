<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InspectIdNumberColumn extends Command
{
    protected $signature = 'inspect:id_number_column';

    protected $description = 'Inspect the id_number column definition and data length in users table';

    public function handle(): int
    {
        // Get column info
        $column_info = DB::select("SHOW COLUMNS FROM users LIKE 'id_number'");

        if (empty($column_info)) {
            $this->error("Column 'id_number' does not exist in users table.");
            return 1;
        }

        $this->info("Column 'id_number' info:");

        $rows = [];
        foreach ($column_info as $row) {
            $rows[] = (array) $row;
        }
        $this->table(['Field', 'Type', 'Null', 'Key', 'Default', 'Extra'], $rows);

        // Find max length of data in id_number
        $max_length = DB::table('users')->selectRaw('MAX(CHAR_LENGTH(id_number)) as max_length')->value('max_length');

        $this->info("Max length of data in 'id_number' column: " . ($max_length ?? 'NULL'));

        return 0;
    }
}

