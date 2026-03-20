<?php

namespace App\Mail;

use App\Helpers\CurrencyHelper;
use App\Models\Transaction;
use App\Services\TransactionReceiptService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransferConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $formattedAmount;
    public $historyUrl;
    public $receiptUrl;
    public $receiptFileName;
    public $mailLocale;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction->loadMissing(['user', 'refundedBy']);

        $supportedLocales = ['fr', 'en', 'de', 'nl', 'es', 'pl', 'it'];
        $locale = (string) ($this->transaction->user?->locale ?: app()->getLocale());
        $this->mailLocale = in_array($locale, $supportedLocales, true)
            ? $locale
            : app()->getLocale();

        $currency = $this->transaction->user?->default_currency ?? 'EUR';
        $receiptService = app(TransactionReceiptService::class);
        $this->locale($this->mailLocale);

        $this->formattedAmount = CurrencyHelper::format($this->transaction->amount, $currency);
        $this->historyUrl = $receiptService->historyUrl($this->transaction, $this->mailLocale);
        $this->receiptUrl = $receiptService->receiptUrl($this->transaction, $this->mailLocale);
        $this->receiptFileName = $receiptService->makeFilename($this->transaction);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('transactions.transfer_receipt_email_subject', [
                'id' => $this->transaction->id,
            ], $this->mailLocale),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.transfer_confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachment = app(TransactionReceiptService::class)->buildEmailAttachment($this->transaction);

        if (!$attachment) {
            return [];
        }

        return [
            Attachment::fromData(
                fn () => $attachment['data'],
                $attachment['name']
            )->withMime($attachment['mime']),
        ];
    }
}
