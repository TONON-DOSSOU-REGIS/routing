<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckIdNumberData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:id_number_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check users table for problematic id_number data';


    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $results = DB::table('users')
            ->select('id', 'id_number', DB::raw('CHAR_LENGTH(id_number) AS length'))
            ->whereRaw('CHAR_LENGTH(id_number) > 255 OR id_number IS NULL OR id_number = ""')
            ->get();

        if ($results->isEmpty()) {
            $this->info('No problematic id_number data found.');
            return 0;
        }

        $this->info("Problematic id_number rows:");

        $rows = [];
        foreach ($results as $row) {
            $rows[] = (array) $row;
        }
        $this->table(['ID', 'id_number', 'Length'], $rows);

        return 0;
    }
}

