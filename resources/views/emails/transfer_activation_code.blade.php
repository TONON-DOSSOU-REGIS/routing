@php
    $clientName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->email;
    $recipientName = trim((string) ($transferDetails['recipient_name'] ?? '')) ?: __('transactions.not_available');
    $bankName = trim((string) ($transferDetails['bank_name'] ?? '')) ?: __('transactions.not_available');
    $iban = preg_replace('/\s+/', '', (string) ($transferDetails['recipient_iban'] ?? ''));
    $maskedIban = $iban !== ''
        ? substr($iban, 0, 4) . ' •••• •••• ' . substr($iban, -4)
        : __('transactions.not_available');
    $mailLanguage = str_replace('_', '-', $mailLocale ?? app()->getLocale());
@endphp
<!DOCTYPE html>
<html lang="{{ $mailLanguage }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <title>{{ __('transactions.activation_email_title') }}</title>
</head>
<body style="margin:0;padding:0;background-color:#eef2f6;font-family:Arial,Helvetica,sans-serif;color:#172033;-webkit-font-smoothing:antialiased;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">
        {{ __('transactions.activation_email_preheader', ['minutes' => $expiresInMinutes]) }}
    </div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;background-color:#eef2f6;">
        <tr>
            <td align="center" style="padding:32px 14px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:680px;border-collapse:separate;background-color:#ffffff;border:1px solid #dce4ec;border-radius:24px;overflow:hidden;box-shadow:0 18px 55px rgba(15,23,42,0.10);">
                    <tr>
                        <td style="height:7px;background-color:#14b8a6;font-size:0;line-height:0;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="padding:28px 38px;background-color:#10233f;color:#ffffff;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td valign="middle">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td width="46" height="46" align="center" valign="middle" style="width:46px;height:46px;border-radius:14px;background-color:#14b8a6;color:#ffffff;font-size:22px;font-weight:800;">Z</td>
                                                <td style="padding-left:13px;">
                                                    <div style="font-size:17px;font-weight:800;letter-spacing:0.02em;color:#ffffff;">Zuider Bank</div>
                                                    <div style="margin-top:3px;font-size:10px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#9fb1c8;">Secure Digital Banking</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right" valign="middle" style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#a8bacd;">
                                        {{ __('transactions.activation_email_secure_badge') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:38px 38px 18px;">
                            <div style="font-size:11px;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:#0f8f82;">{{ __('transactions.activation_email_eyebrow') }}</div>
                            <h1 style="margin:10px 0 12px;font-size:30px;line-height:1.2;font-weight:800;letter-spacing:-0.02em;color:#10233f;">{{ __('transactions.activation_email_title') }}</h1>
                            <p style="margin:0 0 12px;font-size:16px;line-height:1.75;color:#26364d;">{{ __('transactions.activation_email_greeting', ['name' => $clientName]) }}</p>
                            <p style="margin:0;font-size:15px;line-height:1.75;color:#59687b;">{{ __('transactions.activation_email_body') }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:10px 38px 26px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:separate;border:1px solid #99e3d9;border-radius:20px;background-color:#effcf9;">
                                <tr>
                                    <td align="center" style="padding:25px 20px 23px;">
                                        <div style="font-size:11px;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:#0f766e;">{{ __('transactions.activation_code') }}</div>
                                        <div style="margin-top:12px;padding-left:0.24em;font-family:'Courier New',Courier,monospace;font-size:40px;line-height:1.1;font-weight:800;letter-spacing:0.24em;color:#10233f;">{{ $code }}</div>
                                        <div style="margin-top:16px;">
                                            <span style="display:inline-block;padding:7px 12px;border-radius:999px;background-color:#d6f5ef;font-size:12px;font-weight:700;color:#0f766e;">{{ __('transactions.activation_email_expiry', ['minutes' => $expiresInMinutes]) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 38px 26px;">
                            <div style="margin-bottom:12px;font-size:13px;font-weight:800;color:#10233f;">{{ __('transactions.activation_email_summary_title') }}</div>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:separate;border:1px solid #dfe6ed;border-radius:18px;background-color:#f8fafc;">
                                <tr>
                                    <td style="padding:15px 18px;border-bottom:1px solid #e5eaf0;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#748196;">{{ __('transactions.receipt_amount') }}</td>
                                    <td align="right" style="padding:15px 18px;border-bottom:1px solid #e5eaf0;font-size:17px;font-weight:800;color:#10233f;">{{ $transferDetails['formatted_amount'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 18px;border-bottom:1px solid #e5eaf0;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#748196;">{{ __('transactions.receipt_recipient_name') }}</td>
                                    <td align="right" style="padding:15px 18px;border-bottom:1px solid #e5eaf0;font-size:14px;font-weight:700;color:#26364d;">{{ $recipientName }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 18px;border-bottom:1px solid #e5eaf0;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#748196;">IBAN</td>
                                    <td align="right" style="padding:15px 18px;border-bottom:1px solid #e5eaf0;font-family:'Courier New',Courier,monospace;font-size:13px;font-weight:700;color:#26364d;">{{ $maskedIban }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:15px 18px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#748196;">{{ __('transactions.receipt_bank_name') }}</td>
                                    <td align="right" style="padding:15px 18px;font-size:14px;font-weight:700;color:#26364d;">{{ $bankName }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 38px 26px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:separate;border-left:4px solid #14b8a6;border-radius:12px;background-color:#f2f7f9;">
                                <tr>
                                    <td style="padding:17px 18px;">
                                        <div style="font-size:13px;font-weight:800;color:#10233f;">{{ __('transactions.activation_email_instruction_title') }}</div>
                                        <div style="margin-top:6px;font-size:14px;line-height:1.65;color:#59687b;">{{ __('transactions.activation_email_instruction') }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 38px 36px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:separate;border:1px solid #f5d58a;border-radius:16px;background-color:#fff9e8;">
                                <tr>
                                    <td width="48" valign="top" style="padding:17px 0 17px 18px;font-size:21px;">&#128274;</td>
                                    <td style="padding:17px 18px 17px 8px;">
                                        <div style="font-size:13px;font-weight:800;color:#7a4d0b;">{{ __('transactions.activation_email_security_title') }}</div>
                                        <div style="margin-top:5px;font-size:13px;line-height:1.65;color:#8a611c;">{{ __('transactions.activation_email_security') }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 38px;background-color:#10233f;text-align:center;">
                            <p style="margin:0;font-size:12px;line-height:1.65;color:#aebdce;">{{ __('transactions.activation_email_footer') }}</p>
                            <p style="margin:8px 0 0;font-size:11px;line-height:1.6;color:#71859e;">{{ __('transactions.activation_email_footer_notice', ['year' => date('Y')]) }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
