<?php

namespace App\Mail;

use App\Helpers\CurrencyHelper;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransferActivationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $mailLocale;

    public function __construct(
        public User $user,
        public string $code,
        public array $transferDetails = [],
        public int $expiresInMinutes = 10,
    ) {
        $supportedLocales = ['fr', 'en', 'de', 'nl', 'es', 'pl', 'it'];
        $locale = (string) ($user->locale ?: app()->getLocale());
        $this->mailLocale = in_array($locale, $supportedLocales, true) ? $locale : config('app.locale', 'fr');
        $this->locale($this->mailLocale);

        $this->transferDetails['formatted_amount'] = CurrencyHelper::format(
            (float) ($this->transferDetails['amount'] ?? 0),
            $user->default_currency ?? 'EUR'
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('transactions.activation_email_subject', [], $this->mailLocale),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.transfer_activation_code');
    }
}
