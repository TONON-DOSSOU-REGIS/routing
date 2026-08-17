<?php

namespace App\Mail;

use App\Helpers\CurrencyHelper;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminTransferActivityMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public const STAGE_STARTED = 'started';
    public const STAGE_ON_HOLD = 'on_hold';
    public const STAGE_COMPLETED = 'completed';

    public User $client;
    public Transaction $transaction;
    public string $stage;
    public string $formattedAmount;
    public ?string $holdMessage;
    public string $occurredAt;
    public ?string $ipAddress;

    public function __construct(
        User $client,
        Transaction $transaction,
        string $stage,
        ?string $holdMessage = null,
        ?string $ipAddress = null
    ) {
        $this->client = $client;
        $this->transaction = $transaction;
        $this->stage = $stage;
        $this->holdMessage = $holdMessage;
        $this->ipAddress = $ipAddress;
        $this->occurredAt = now()->format('d/m/Y H:i');
        $this->formattedAmount = CurrencyHelper::format(
            $transaction->amount,
            $client->default_currency ?? 'EUR'
        );
    }

    public function envelope(): Envelope
    {
        $clientName = trim($this->client->first_name . ' ' . $this->client->last_name);
        $clientName = $clientName !== '' ? $clientName : $this->client->email;

        $subject = match ($this->stage) {
            self::STAGE_STARTED => "[NEXALUNE BANK] Virement initié #{$this->transaction->id} — {$clientName}",
            self::STAGE_ON_HOLD => "[NEXALUNE BANK] Virement en attente #{$this->transaction->id} — {$clientName}",
            self::STAGE_COMPLETED => "[NEXALUNE BANK] Virement finalisé #{$this->transaction->id} — {$clientName}",
            default => "[NEXALUNE BANK] Activité virement #{$this->transaction->id}",
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_transfer_activity',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
