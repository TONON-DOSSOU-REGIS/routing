<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaction::with('user')->get()->map(function ($transaction) {
            return [
                'ID' => $transaction->id,
                'User' => $transaction->user->first_name . ' ' . $transaction->user->last_name,
                'Type' => $transaction->type,
                'Amount' => $transaction->amount,
                'Status' => $transaction->status,
                'Progress' => $transaction->progress,
                'Created At' => $transaction->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'User',
            'Type',
            'Amount',
            'Status',
            'Progress',
            'Created At',
        ];
    }
}

