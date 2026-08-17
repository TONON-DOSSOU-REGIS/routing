<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activité virement - NEXALUNE BANK</title>
</head>
<body style="margin:0;padding:0;background-color:#eef2f7;font-family:'Segoe UI',Arial,Helvetica,sans-serif;color:#0f172a;">
@php
    $stageMeta = match ($stage) {
        \App\Mail\AdminTransferActivityMail::STAGE_STARTED => [
            'label' => 'Virement initié',
            'accent' => '#0b5cff',
            'badge_bg' => '#e6efff',
            'badge_text' => '#0b3ea8',
            'intro' => 'Un client vient de lancer un virement. L\'opération est en cours de traitement.',
        ],
        \App\Mail\AdminTransferActivityMail::STAGE_ON_HOLD => [
            'label' => 'Virement en attente',
            'accent' => '#c2410c',
            'badge_bg' => '#fff1e6',
            'badge_text' => '#9a3412',
            'intro' => 'Un virement a été suspendu conformément à la règle de blocage configurée. Une action administrateur peut être requise.',
        ],
        \App\Mail\AdminTransferActivityMail::STAGE_COMPLETED => [
            'label' => 'Virement finalisé',
            'accent' => '#047857',
            'badge_bg' => '#e6f6f0',
            'badge_text' => '#065f46',
            'intro' => 'Un virement a été exécuté avec succès et le solde du client a été débité.',
        ],
        default => [
            'label' => 'Activité virement',
            'accent' => '#334155',
            'badge_bg' => '#f1f5f9',
            'badge_text' => '#334155',
            'intro' => 'Mise à jour d\'une opération de virement.',
        ],
    };

    $clientName = trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? ''));
    $clientName = $clientName !== '' ? $clientName : $client->email;
@endphp

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color:#eef2f7;padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(15,23,42,0.1);">

                <tr>
                    <td style="background-color:#0f172a;padding:26px 28px;">
                        <p style="margin:0;font-size:11px;letter-spacing:3px;text-transform:uppercase;color:rgba(255,255,255,0.6);">
                            NEXALUNE BANK — Supervision
                        </p>
                        <h1 style="margin:10px 0 0;font-size:22px;font-weight:700;color:#ffffff;">
                            {{ $stageMeta['label'] }}
                        </h1>
                        <p style="margin:8px 0 0;font-size:13px;color:rgba(255,255,255,0.72);">
                            Référence #{{ $transaction->id }} · {{ $occurredAt }}
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:26px 28px 8px;">
                        <span style="display:inline-block;padding:6px 14px;border-radius:999px;background-color:{{ $stageMeta['badge_bg'] }};color:{{ $stageMeta['badge_text'] }};font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;">
                            {{ $stageMeta['label'] }}
                        </span>
                        <p style="margin:16px 0 0;font-size:14px;line-height:22px;color:#475569;">
                            {{ $stageMeta['intro'] }}
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 28px 0;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="border:1px solid #e2e8f0;border-radius:12px;">
                            <tr>
                                <td style="padding:18px 20px;border-bottom:1px solid #eef2f7;">
                                    <p style="margin:0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#94a3b8;">Montant</p>
                                    <p style="margin:6px 0 0;font-size:26px;font-weight:700;color:{{ $stageMeta['accent'] }};">{{ $formattedAmount }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:16px 20px;border-bottom:1px solid #eef2f7;">
                                    <p style="margin:0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#94a3b8;">Client</p>
                                    <p style="margin:6px 0 0;font-size:15px;font-weight:600;color:#0f172a;">{{ $clientName }}</p>
                                    <p style="margin:3px 0 0;font-size:13px;color:#64748b;">{{ $client->email }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:16px 20px;border-bottom:1px solid #eef2f7;">
                                    <p style="margin:0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#94a3b8;">Bénéficiaire</p>
                                    <p style="margin:6px 0 0;font-size:15px;font-weight:600;color:#0f172a;">{{ $transaction->recipient_name ?: 'Non renseigné' }}</p>
                                    <p style="margin:3px 0 0;font-size:13px;color:#64748b;">
                                        {{ $transaction->bank_name ?: 'Banque non renseignée' }}
                                        @if($transaction->recipient_iban)
                                            · {{ $transaction->recipient_iban }}
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:16px 20px;">
                                    <p style="margin:0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#94a3b8;">Statut / Progression</p>
                                    <p style="margin:6px 0 0;font-size:15px;font-weight:600;color:#0f172a;">
                                        {{ ucfirst(str_replace('_', ' ', (string) $transaction->status)) }} · {{ (int) $transaction->progress }}%
                                    </p>
                                    @if($ipAddress)
                                        <p style="margin:3px 0 0;font-size:13px;color:#64748b;">IP client : {{ $ipAddress }}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                @if($stage === \App\Mail\AdminTransferActivityMail::STAGE_ON_HOLD && $holdMessage)
                    <tr>
                        <td style="padding:18px 28px 0;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color:#fff7ed;border:1px solid #fed7aa;border-radius:12px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="margin:0;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#9a3412;">Message affiché au client</p>
                                        <p style="margin:8px 0 0;font-size:14px;line-height:21px;color:#7c2d12;">{{ $holdMessage }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif

                <tr>
                    <td style="padding:24px 28px 28px;">
                        <a href="{{ url('/' . app()->getLocale() . '/admin/transactions') }}"
                           style="display:inline-block;padding:13px 26px;border-radius:999px;background-color:#0f172a;color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;">
                            Ouvrir la supervision
                        </a>
                    </td>
                </tr>

                <tr>
                    <td style="background-color:#f8fafc;border-top:1px solid #e2e8f0;padding:18px 28px;">
                        <p style="margin:0;font-size:12px;line-height:19px;color:#64748b;">
                            <strong style="color:#0f172a;">NEXALUNE BANK</strong> — notification automatique de supervision.
                            Ce message est destiné à l'administration et ne doit pas être transféré au client.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
