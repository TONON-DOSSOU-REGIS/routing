<?php

namespace App\Services;

use App\Models\Transaction;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransactionReceiptService
{
    public function buildViewData(
        Transaction $transaction,
        string $renderMode = 'pdf',
        ?string $pdfUnavailableReason = null
    ): array {
        $transaction->loadMissing(['user', 'refundedBy']);

        $receiptGeneratedAt = now();
        $receiptVerificationCode = $this->generateReceiptVerificationCode($transaction);
        $receiptQrPayload = $this->buildReceiptQrPayload($transaction, $receiptVerificationCode);
        $receiptQrSvg = $this->generateReceiptQrSvg($transaction, $receiptQrPayload);
        $receiptQrDataUri = $receiptQrSvg
            ? 'data:image/svg+xml;base64,' . base64_encode($receiptQrSvg)
            : null;

        return [
            'transaction' => $transaction,
            'renderMode' => $renderMode,
            'pdfUnavailableReason' => $pdfUnavailableReason,
            'receiptGeneratedAt' => $receiptGeneratedAt,
            'receiptVerificationCode' => $receiptVerificationCode,
            'receiptQrPayload' => $receiptQrPayload,
            'receiptQrSvg' => $receiptQrSvg,
            'receiptQrDataUri' => $receiptQrDataUri,
        ];
    }

    public function renderPdf(Transaction $transaction): string
    {
        return Pdf::loadView('transactions.receipt-pdf', $this->buildViewData($transaction, 'pdf'))
            ->setPaper('a4')
            ->setOption('defaultFont', 'dejavu sans')
            ->output();
    }

    public function renderHtml(Transaction $transaction, ?string $pdfUnavailableReason = null): string
    {
        return view('transactions.receipt', $this->buildViewData($transaction, 'html', $pdfUnavailableReason))->render();
    }

    public function buildEmailAttachment(Transaction $transaction): ?array
    {
        try {
            return [
                'data' => $this->renderPdf($transaction),
                'name' => $this->makeFilename($transaction, 'pdf'),
                'mime' => 'application/pdf',
            ];
        } catch (\Throwable $exception) {
            Log::warning('Receipt PDF attachment fallback to HTML', [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'error' => $exception->getMessage(),
            ]);
        }

        try {
            return [
                'data' => $this->renderHtml(
                    $transaction,
                    'Le recu PDF premium est temporairement indisponible. Le document officiel HTML securise est joint a la place.'
                ),
                'name' => $this->makeFilename($transaction, 'html'),
                'mime' => 'text/html',
            ];
        } catch (\Throwable $exception) {
            Log::error('Receipt HTML attachment generation failed', [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public function makeFilename(Transaction $transaction, string $extension = 'pdf'): string
    {
        $baseName = $transaction->type === 'transfer' ? 'recu-virement' : 'recu-transaction';

        return sprintf('zuider-%s-%s.%s', $baseName, $transaction->id, $extension);
    }

    public function historyUrl(Transaction $transaction, ?string $locale = null): string
    {
        $locale = $this->resolveLocale($transaction, $locale);

        return url('/' . $locale . '/transactions/history');
    }

    public function receiptUrl(Transaction $transaction, ?string $locale = null): string
    {
        $locale = $this->resolveLocale($transaction, $locale);

        return url('/' . $locale . '/transactions/' . $transaction->id . '/receipt-html');
    }

    private function resolveLocale(Transaction $transaction, ?string $locale = null): string
    {
        if (is_string($locale) && $locale !== '') {
            return $locale;
        }

        return (string) ($transaction->user?->locale ?: app()->getLocale());
    }

    private function generateReceiptVerificationCode(Transaction $transaction): string
    {
        return strtoupper(substr(sha1(implode('|', [
            $transaction->id,
            $transaction->user->email,
            number_format((float) $transaction->amount, 2, '.', ''),
            $transaction->created_at->format('Y-m-d H:i:s'),
        ])), 0, 14));
    }

    private function buildReceiptQrPayload(Transaction $transaction, string $receiptVerificationCode): string
    {
        $user = $transaction->user;
        $currency = $user->default_currency ?? 'EUR';
        $clientName = trim(implode(' ', array_filter([
            $user->first_name,
            $user->last_name,
        ])));
        $clientName = $clientName !== '' ? $clientName : 'NA';
        $beneficiary = trim((string) ($transaction->recipient_name ?? ''));

        $parts = [
            'VALTRIXBANK',
            'TX:' . $transaction->id,
            'VC:' . $receiptVerificationCode,
            'AM:' . number_format((float) $transaction->amount, 2, '.', '') . $currency,
            'DT:' . $transaction->created_at->format('YmdHis'),
            'ST:' . strtoupper((string) $transaction->status),
            'TP:' . strtoupper((string) $transaction->type),
            'CL:' . Str::upper(Str::limit(preg_replace('/\s+/', ' ', $clientName) ?: 'NA', 32, '')),
        ];

        if ($beneficiary !== '') {
            $parts[] = 'BF:' . Str::upper(Str::limit(preg_replace('/\s+/', ' ', $beneficiary) ?: '', 32, ''));
        }

        return implode('|', $parts);
    }

    private function generateReceiptQrSvg(Transaction $transaction, string $receiptQrPayload): ?string
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle(
                    256,
                    4,
                    null,
                    null,
                    Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(15, 23, 42))
                ),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            $svg = $writer->writeString($receiptQrPayload);
            $svg = preg_replace('/<\?xml.*?\?>\s*/', '', $svg) ?: $svg;

            return str_replace('<svg ', '<svg class="receipt-qr-svg" ', $svg);
        } catch (\Throwable $exception) {
            Log::warning('Receipt QR generation failed', [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }
    }
}
