<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InspectIdTypeColumn extends Command
{
    protected $signature = 'inspect:id_type_column';

    protected $description = 'Inspect the id_type column definition and data length in users table';

    public function handle(): int
    {
        // Get column info
        $column_info = DB::select("SHOW COLUMNS FROM users LIKE 'id_type'");

        if (empty($column_info)) {
            $this->error("Column 'id_type' does not exist in users table.");
            return 1;
        }

        $this->info("Column 'id_type' info:");

        $rows = [];
        foreach ($column_info as $row) {
            $rows[] = (array) $row;
        }
        $this->table(['Field', 'Type', 'Null', 'Key', 'Default', 'Extra'], $rows);

        // Find max length of data in id_type
        $max_length = DB::table('users')->selectRaw('MAX(CHAR_LENGTH(id_type)) as max_length')->value('max_length');

        $this->info("Max length of data in 'id_type' column: " . ($max_length ?? 'NULL'));

        return 0;
    }
}

