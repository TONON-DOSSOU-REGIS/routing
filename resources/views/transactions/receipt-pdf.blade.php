<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('transactions.receipt_page_title') }}</title>
    @include('partials.favicon')
    <style>
        * { box-sizing: border-box; }

        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "DejaVu Sans", Arial, Helvetica, sans-serif;
            color: #0f172a;
            font-size: 10.3px;
            line-height: 1.32;
            background: #ffffff;
        }

        .sheet {
            border: 1px solid #dbe2ea;
            border-radius: 22px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .header,
        .summary-table,
        .content-table,
        .section-table,
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header {
            background: #0f172a;
            color: #ffffff;
        }

        .header td {
            vertical-align: top;
            padding: 15px 16px;
        }

        .brand-col {
            width: 60%;
        }

        .meta-col {
            width: 40%;
            text-align: right;
        }

        .brand-mark,
        .brand-copy {
            display: inline-block;
            vertical-align: middle;
        }

        .brand-mark {
            width: 54px;
            margin-right: 10px;
        }

        .brand-mark svg {
            display: block;
            width: 54px;
            height: 54px;
        }

        .brand-copy {
            max-width: 270px;
        }

        .brand-name {
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .brand-tag {
            margin-top: 2px;
            font-size: 9px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.72);
        }

        .brand-note {
            margin-top: 8px;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.78);
        }

        .meta-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            background: rgba(249, 115, 22, 0.18);
            color: #fdba74;
            font-size: 9px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .meta-number {
            margin-top: 10px;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .meta-date {
            margin-top: 6px;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.72);
        }

        .summary-wrap {
            padding: 10px 12px 0;
        }

        .summary-table td {
            width: 33.33%;
            vertical-align: top;
            padding-right: 8px;
        }

        .summary-table td:last-child {
            padding-right: 0;
        }

        .summary-card {
            min-height: 82px;
            border-radius: 16px;
            border: 1px solid #dbe2ea;
            padding: 10px 11px;
        }

        .summary-card.amount {
            background: #fff7ed;
            border-color: #fed7aa;
        }

        .summary-card.soft {
            background: #f8fafc;
        }

        .eyebrow {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: #64748b;
        }

        .summary-value {
            margin-top: 8px;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.08;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .summary-copy {
            margin-top: 6px;
            font-size: 10px;
            color: #64748b;
        }

        .status-pill {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .status-success { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-hold { background: #ffedd5; color: #c2410c; }
        .status-failed { background: #fee2e2; color: #b91c1c; }
        .status-refunded { background: #ede9fe; color: #6d28d9; }

        .code {
            margin-top: 8px;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.1em;
            line-height: 1.18;
            overflow-wrap: anywhere;
        }

        .content-wrap {
            padding: 10px 12px 8px;
        }

        .content-table td {
            vertical-align: top;
        }

        .main-col {
            width: 64%;
            padding-right: 10px;
        }

        .side-col {
            width: 36%;
        }

        .section {
            border: 1px solid #dbe2ea;
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            margin-bottom: 9px;
            page-break-inside: avoid;
        }

        .section-head {
            padding: 8px 11px;
            background: #f8fafc;
            border-bottom: 1px solid #dbe2ea;
        }

        .section-title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: #475569;
            font-weight: 700;
        }

        .section-body {
            padding: 4px 11px 5px;
        }

        .section-table td {
            width: 50%;
            padding: 6px 8px 6px 0;
            vertical-align: top;
            border-bottom: 1px dashed #e5e7eb;
        }

        .section-table tr:last-child td {
            border-bottom: none;
        }

        .label {
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: #64748b;
        }

        .value {
            margin-top: 4px;
            font-size: 10.6px;
            font-weight: 700;
            color: #0f172a;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .qr-card {
            border-color: #fed7aa;
            background: #fffaf5;
        }

        .qr-box {
            margin-top: 8px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
        }

        .receipt-qr-image,
        .receipt-qr-svg {
            display: block;
            width: 124px;
            height: 124px;
            margin: 0 auto;
        }

        .side-note {
            margin-top: 7px;
            font-size: 9.2px;
            color: #64748b;
        }

        .mini-line {
            margin-top: 7px;
            padding-top: 7px;
            border-top: 1px dashed #e5e7eb;
        }

        .footer {
            border-top: 1px solid #dbe2ea;
            background: #f8fafc;
            padding: 9px 12px 10px;
            font-size: 9.1px;
            color: #475569;
        }

        .footer td {
            width: 33.33%;
            vertical-align: top;
        }

        .footer-center {
            text-align: center;
        }

        .footer-right {
            text-align: right;
        }

        .footer strong {
            color: #0f172a;
        }
    </style>
</head>
<body>
@php
    $currency = $transaction->user->default_currency ?? 'EUR';
    $amountFormatted = \App\Helpers\CurrencyHelper::format($transaction->amount, $currency);
    $statusKey = match ($transaction->status) {
        'success' => 'status_success',
        'pending' => 'status_pending',
        'on_hold' => 'status_on_hold',
        'failed' => 'status_failed',
        'refunded' => 'status_refunded',
        default => null,
    };
    $statusLabel = $statusKey ? __('transactions.' . $statusKey) : ucfirst(str_replace('_', ' ', $transaction->status));
    $statusClass = match ($transaction->status) {
        'success' => 'status-success',
        'pending' => 'status-pending',
        'on_hold' => 'status-hold',
        'failed' => 'status-failed',
        'refunded' => 'status-refunded',
        default => 'status-pending',
    };
    $typeKey = match ($transaction->type) {
        'transfer' => 'type_transfer',
        'deposit' => 'type_deposit',
        'withdrawal' => 'type_withdrawal',
        default => null,
    };
    $typeLabel = $typeKey ? __('transactions.' . $typeKey) : ucfirst($transaction->type);
    $clientName = trim(implode(' ', array_filter([$transaction->user->first_name, $transaction->user->last_name])));
    $clientName = $clientName !== '' ? $clientName : __('transactions.not_available');
    $clientIban = $transaction->user->iban ?: __('transactions.not_available');
    $clientPhone = $transaction->user->phone ?: __('transactions.not_available');
    $clientLocation = collect([$transaction->user->city, $transaction->user->country])
        ->filter(fn ($value) => filled($value))
        ->implode(', ');
    $clientLocation = $clientLocation !== '' ? $clientLocation : __('transactions.not_available');
    $receiptGeneratedLabel = ($receiptGeneratedAt ?? now())->format('d/m/Y H:i');
    $receiptVerificationCode = $receiptVerificationCode ?? strtoupper(substr(sha1((string) $transaction->id), 0, 14));
    $reasonCompact = filled($transaction->reason) ? \Illuminate\Support\Str::limit($transaction->reason, 90) : null;
    $messageCompact = filled($transaction->message) ? \Illuminate\Support\Str::limit($transaction->message, 90) : null;
@endphp

<div class="sheet">
    <table class="header">
        <tr>
            <td class="brand-col">
                <span class="brand-mark">
                    <svg viewBox="0 0 74 74" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="6" y="6" width="62" height="62" rx="20" fill="#f97316"/>
                        <path d="M21 23H31L37 35L43 23H53L37 50L21 23Z" fill="#ffffff"/>
                        <path d="M24 53H50" stroke="#ffffff" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="brand-copy">
                    <div class="brand-name">Zuider Bank S.A</div>
                    <div class="brand-tag">{{ __('transactions.receipt_brand_tag') }}</div>
                    <div class="brand-note">{{ __('transactions.receipt_title') }} #{{ $transaction->id }}</div>
                </span>
            </td>
            <td class="meta-col">
                <div class="meta-badge">{{ __('transactions.receipt_title') }}</div>
                <div class="meta-number">#{{ $transaction->id }}</div>
                <div class="meta-date">{{ __('transactions.receipt_generated_at', ['date' => $receiptGeneratedLabel]) }}</div>
            </td>
        </tr>
    </table>

    <div class="summary-wrap">
        <table class="summary-table">
            <tr>
                <td>
                    <div class="summary-card amount">
                        <div class="eyebrow">{{ __('transactions.receipt_amount') }}</div>
                        <div class="summary-value">{{ $amountFormatted }}</div>
                        <div class="summary-copy">{{ __('transactions.receipt_currency') }} : {{ $currency }}</div>
                    </div>
                </td>
                <td>
                    <div class="summary-card soft">
                        <div class="eyebrow">{{ __('transactions.receipt_status') }}</div>
                        <div class="status-pill {{ $statusClass }}">{{ $statusLabel }}</div>
                        <div class="summary-copy">{{ __('transactions.receipt_progress') }} : {{ $transaction->progress }}%</div>
                    </div>
                </td>
                <td>
                    <div class="summary-card soft">
                        <div class="eyebrow">{{ __('transactions.receipt_verification_code') }}</div>
                        <div class="code">{{ $receiptVerificationCode }}</div>
                        <div class="summary-copy">{{ __('transactions.receipt_transaction_id') }} : #{{ $transaction->id }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content-wrap">
        <table class="content-table">
            <tr>
                <td class="main-col">
                    <div class="section">
                        <div class="section-head"><div class="section-title">{{ __('transactions.receipt_transaction_details') }}</div></div>
                        <div class="section-body">
                            <table class="section-table">
                                <tr>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_type') }}</div>
                                        <div class="value">{{ $typeLabel }}</div>
                                    </td>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_date') }}</div>
                                        <div class="value">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_status') }}</div>
                                        <div class="value">{{ $statusLabel }}</div>
                                    </td>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_currency') }}</div>
                                        <div class="value">{{ $currency }}</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-head"><div class="section-title">{{ __('transactions.receipt_client_section') }} / {{ __('transactions.receipt_beneficiary_section') }}</div></div>
                        <div class="section-body">
                            <table class="section-table">
                                <tr>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_client_name') }}</div>
                                        <div class="value">{{ $clientName }}</div>
                                    </td>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_recipient_name') }}</div>
                                        <div class="value">{{ $transaction->recipient_name ?: __('transactions.not_available') }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_email') }}</div>
                                        <div class="value">{{ $transaction->user->email }}</div>
                                    </td>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_bank_name') }}</div>
                                        <div class="value">{{ $transaction->bank_name ?: __('transactions.not_available') }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="label">IBAN</div>
                                        <div class="value">{{ $clientIban }}</div>
                                    </td>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_recipient_iban') }}</div>
                                        <div class="value">{{ $transaction->recipient_iban ?: __('transactions.not_available') }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="label">Phone / Location</div>
                                        <div class="value">{{ $clientPhone }} @if($clientLocation !== __('transactions.not_available'))<br>{{ $clientLocation }}@endif</div>
                                    </td>
                                    <td>
                                        <div class="label">{{ __('transactions.receipt_recipient_bic') }}</div>
                                        <div class="value">{{ $transaction->recipient_bic ?: __('transactions.not_available') }}</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($reasonCompact || $messageCompact || $transaction->refund_reason)
                        <div class="section">
                            <div class="section-head"><div class="section-title">{{ __('transactions.receipt_additional_section') }}</div></div>
                            <div class="section-body">
                                <table class="section-table">
                                    <tr>
                                        <td>
                                            <div class="label">{{ __('transactions.receipt_reason') }}</div>
                                            <div class="value">{{ $reasonCompact ?: __('transactions.not_available') }}</div>
                                        </td>
                                        <td>
                                            <div class="label">{{ __('transactions.receipt_message') }}</div>
                                            <div class="value">{{ $messageCompact ?: __('transactions.not_available') }}</div>
                                        </td>
                                    </tr>
                                    @if($transaction->refund_reason)
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">{{ __('transactions.receipt_refund_reason') }}</div>
                                                <div class="value">{{ \Illuminate\Support\Str::limit($transaction->refund_reason, 120) }}</div>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    @endif
                </td>
                <td class="side-col">
                    <div class="section qr-card">
                        <div class="section-head"><div class="section-title">{{ __('transactions.receipt_client_section') }} QR</div></div>
                        <div class="section-body">
                            <div class="qr-box">
                                @if($receiptQrDataUri)
                                    <img src="{{ $receiptQrDataUri }}" alt="Receipt QR code" class="receipt-qr-image">
                                @elseif($receiptQrSvg)
                                    {!! $receiptQrSvg !!}
                                @endif
                            </div>
                            <div class="side-note">{{ __('transactions.receipt_qr_notice') }}</div>
                            <div class="mini-line">
                                <div class="label">{{ __('transactions.receipt_client_name') }}</div>
                                <div class="value">{{ $clientName }}</div>
                            </div>
                            <div class="mini-line">
                                <div class="label">{{ __('transactions.receipt_transaction_id') }}</div>
                                <div class="value">#{{ $transaction->id }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-head"><div class="section-title">{{ __('transactions.receipt_verification_code') }}</div></div>
                        <div class="section-body">
                            <div class="code">{{ $receiptVerificationCode }}</div>
                            <div class="mini-line">
                                <div class="label">Support</div>
                                <div class="value">support@zuiderbank.com</div>
                            </div>
                            <div class="mini-line">
                                <div class="label">{{ __('transactions.receipt_generated_at', ['date' => $receiptGeneratedLabel]) }}</div>
                                <div class="value">{{ $typeLabel }} - {{ $statusLabel }}</div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    <strong>Zuider Bank S.A</strong><br>
                    {{ __('transactions.receipt_notice') }}
                </td>
                <td class="footer-center">
                    <strong>{{ __('transactions.receipt_transaction_id') }}</strong><br>
                    #{{ $transaction->id }}<br>
                    {{ __('transactions.receipt_verification_code') }} {{ $receiptVerificationCode }}
                </td>
                <td class="footer-right">
                    <strong>{{ $amountFormatted }}</strong><br>
                    {{ $typeLabel }} - {{ $statusLabel }}<br>
                    support@zuiderbank.com
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
