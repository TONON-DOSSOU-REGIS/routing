<?php

namespace App\Support;

use App\Models\SmtpSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Throwable;

final class SmtpConfiguration
{
    public static function applyStored(): bool
    {
        try {
            if (! Schema::hasTable('smtp_settings')) {
                return false;
            }

            $settings = SmtpSetting::query()->find(1);

            if (! $settings) {
                return false;
            }

            self::apply($settings);

            return true;
        } catch (Throwable $exception) {
            report($exception);

            return false;
        }
    }

    public static function apply(SmtpSetting $settings): void
    {
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.url' => null,
            'mail.mailers.smtp.scheme' => $settings->scheme,
            'mail.mailers.smtp.host' => $settings->host,
            'mail.mailers.smtp.port' => $settings->port,
            'mail.mailers.smtp.username' => $settings->username,
            'mail.mailers.smtp.password' => $settings->password,
            'mail.from.address' => $settings->from_address,
            'mail.from.name' => $settings->from_name,
        ]);

        Mail::purge('smtp');
    }
}
