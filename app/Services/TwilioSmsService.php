<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class TwilioSmsService
{
    public function send(string $to, string $body): array
    {
        $accountSid = trim((string) config('services.twilio.account_sid'));
        $authToken = trim((string) config('services.twilio.auth_token'));
        $fromNumber = trim((string) config('services.twilio.from_number'));
        $timeout = (int) config('services.twilio.timeout', 10);

        if ($accountSid === '' || $authToken === '' || $fromNumber === '') {
            throw new RuntimeException('Twilio SMS is not configured.');
        }

        $response = Http::asForm()
            ->acceptJson()
            ->timeout($timeout)
            ->withBasicAuth($accountSid, $authToken)
            ->post(sprintf(
                'https://api.twilio.com/2010-04-01/Accounts/%s/Messages.json',
                $accountSid
            ), [
                'To' => $to,
                'From' => $fromNumber,
                'Body' => $body,
            ]);

        if ($response->failed()) {
            $message = (string) ($response->json('message') ?? $response->body() ?: 'Unknown Twilio error.');

            throw new RuntimeException('Twilio SMS request failed: ' . $message);
        }

        return [
            'sid' => (string) $response->json('sid', ''),
            'status' => (string) $response->json('status', ''),
        ];
    }
}
