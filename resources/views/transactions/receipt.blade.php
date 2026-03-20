<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('transactions.receipt_page_title') }}</title>
    @include('partials.favicon')
    <style>
        * { box-sizing: border-box; }

        @page {
            size: A4 portrait;
            margin: 14mm;
        }

        body {
            margin: 0;
            font-family: "DejaVu Sans", Arial, Helvetica, sans-serif;
            color: #0f172a;
            background: {{ ($renderMode ?? 'pdf') === 'html' ? '#f3f4f6' : '#ffffff' }};
            font-size: 12px;
            line-height: 1.55;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .html-shell {
            padding: {{ ($renderMode ?? 'pdf') === 'html' ? '28px 18px 36px' : '0' }};
        }

        .receipt-toolbar,
        .receipt-alert {
            display: {{ ($renderMode ?? 'pdf') === 'html' ? 'block' : 'none' }};
            max-width: 980px;
            margin: 0 auto 16px;
        }

        .receipt-toolbar-card,
        .receipt-alert-card {
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid #dbe2ea;
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
            padding: 18px 20px;
        }

        .receipt-toolbar-links {
            margin-top: 12px;
            font-size: 12px;
        }

        .receipt-toolbar-links a {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            font-weight: 700;
        }

        .receipt-toolbar-links .primary {
            background: #f97316;
            color: #ffffff;
        }

        .receipt-toolbar-links .secondary {
            background: #ffffff;
            color: #334155;
            border: 1px solid #dbe2ea;
        }

        .receipt-alert-card {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #9a3412;
        }

        .receipt-wrap {
            max-width: 980px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #dbe2ea;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: {{ ($renderMode ?? 'pdf') === 'html' ? '0 30px 64px rgba(15, 23, 42, 0.12)' : 'none' }};
        }

        .receipt-hero {
            background: #0f172a;
            color: #ffffff;
            padding: 28px 30px;
        }

        .receipt-hero-table,
        .layout-table,
        .overview-table,
        .section-table,
        .mini-table,
        .receipt-footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-brand {
            width: 58%;
            vertical-align: top;
        }

        .receipt-meta {
            width: 42%;
            vertical-align: top;
            text-align: right;
        }

        .brand-stack {
            white-space: nowrap;
        }

        .brand-emblem,
        .brand-copy {
            display: inline-block;
            vertical-align: middle;
        }

        .brand-emblem {
            width: 74px;
            margin-right: 14px;
        }

        .brand-emblem svg {
            display: block;
            width: 74px;
            height: 74px;
        }

        .brand-copy {
            max-width: calc(100% - 94px);
            white-space: normal;
        }

        .brand-name {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .brand-tag {
            margin-top: 4px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.72);
            text-transform: uppercase;
            letter-spacing: 0.16em;
        }

        .brand-micro {
            margin-top: 10px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }

        .meta-card {
            display: inline-block;
            min-width: 220px;
            max-width: 100%;
            border-radius: 22px;
            padding: 18px 20px;
            background: #172033;
            border: 1px solid rgba(255, 255, 255, 0.12);
            text-align: left;
        }

        .receipt-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(249, 115, 22, 0.18);
            color: #fdba74;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .meta-value {
            margin-top: 12px;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.05em;
            overflow-wrap: anywhere;
        }

        .meta-subvalue {
            margin-top: 8px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.72);
        }

        .receipt-body {
            padding: 28px 30px 14px;
        }

        .layout-main,
        .layout-side {
            vertical-align: top;
        }

        .layout-main {
            width: 67%;
            padding-right: 18px;
        }

        .layout-side {
            width: 33%;
            padding-left: 4px;
        }

        .overview-table td {
            vertical-align: top;
            padding: 0 12px 16px 0;
        }

        .overview-table td:last-child {
            padding-right: 0;
        }

        .summary-card {
            min-height: 160px;
            border-radius: 24px;
            padding: 18px 18px 16px;
            border: 1px solid #dbe2ea;
        }

        .summary-card.is-amount {
            background: #fff7ed;
            border-color: #fed7aa;
        }

        .summary-card.is-status,
        .summary-card.is-reference {
            background: #f8fafc;
        }

        .summary-label,
        .section-title,
        .side-eyebrow,
        .mini-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: #64748b;
        }

        .summary-value {
            margin-top: 10px;
            font-size: 31px;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -0.05em;
            color: #0f172a;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .summary-sub {
            margin-top: 8px;
            color: #64748b;
            font-size: 12px;
        }

        .status-pill {
            display: inline-block;
            margin-top: 12px;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .status-success { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-hold { background: #ffedd5; color: #c2410c; }
        .status-failed { background: #fee2e2; color: #b91c1c; }
        .status-refunded { background: #ede9fe; color: #6d28d9; }

        .reference-code {
            margin-top: 12px;
            font-size: 20px;
            line-height: 1.28;
            font-weight: 800;
            letter-spacing: 0.12em;
            color: #0f172a;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .section {
            margin-bottom: 16px;
            border: 1px solid #dbe2ea;
            border-radius: 24px;
            overflow: hidden;
            background: #ffffff;
        }

        .section-header {
            padding: 14px 18px;
            background: #f8fafc;
            border-bottom: 1px solid #dbe2ea;
        }

        .section-body {
            padding: 8px 18px 6px;
        }

        .section-table td {
            width: 50%;
            padding: 12px 10px 14px 0;
            vertical-align: top;
            border-bottom: 1px dashed #e5e7eb;
        }

        .section-table tr:last-child td {
            border-bottom: none;
        }

        .kv-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.14em;
        }

        .kv-value {
            margin-top: 6px;
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .side-card {
            margin-bottom: 16px;
            border-radius: 24px;
            padding: 18px;
            background: #f8fafc;
            border: 1px solid #dbe2ea;
        }

        .qr-card {
            background: #fffaf5;
            border-color: #fed7aa;
        }

        .qr-frame {
            margin-top: 14px;
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 16px;
            text-align: center;
        }

        .receipt-qr-image,
        .receipt-qr-svg {
            display: block;
            width: 172px;
            height: 172px;
            margin: 0 auto;
        }

        .side-note {
            margin-top: 12px;
            font-size: 12px;
            color: #64748b;
        }

        .mini-table {
            margin-top: 14px;
        }

        .mini-table td {
            padding: 10px 0;
            border-bottom: 1px dashed #e5e7eb;
            vertical-align: top;
        }

        .mini-table tr:last-child td {
            border-bottom: none;
            padding-bottom: 0;
        }

        .mini-table .mini-value {
            text-align: right;
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .side-code {
            margin-top: 10px;
            padding: 14px 16px;
            border-radius: 18px;
            background: #ffffff;
            border: 1px solid #dbe2ea;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.12em;
            color: #0f172a;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .support-line {
            margin-top: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            overflow-wrap: anywhere;
        }

        .notice {
            margin: 0 30px 20px;
            border-radius: 22px;
            background: #fff7ed;
            border: 1px solid #fed7aa;
            padding: 14px 16px;
            color: #9a3412;
            font-size: 12px;
        }

        .receipt-footer {
            padding: 18px 30px 24px;
            background: #0f172a;
            color: rgba(255, 255, 255, 0.78);
            font-size: 11px;
        }

        .receipt-footer strong {
            color: #ffffff;
        }

        .receipt-footer-table td {
            width: 33.33%;
            vertical-align: top;
        }

        .receipt-footer-center {
            text-align: center;
        }

        .receipt-footer-right {
            text-align: right;
        }

        @media print {
            .html-shell {
                padding: 0;
            }

            .receipt-toolbar,
            .receipt-alert {
                display: none !important;
            }

            .receipt-wrap {
                border-radius: 0;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
@php
    $renderMode = $renderMode ?? 'pdf';
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
    $clientName = trim(implode(' ', array_filter([
        $transaction->user->first_name,
        $transaction->user->last_name,
    ])));
    $clientName = $clientName !== '' ? $clientName : __('transactions.not_available');
    $clientIban = $transaction->user->iban ?: __('transactions.not_available');
    $clientPhone = $transaction->user->phone ?: __('transactions.not_available');
    $clientLocation = collect([$transaction->user->city, $transaction->user->country])
        ->filter(fn ($value) => filled($value))
        ->implode(', ');
    $clientLocation = $clientLocation !== '' ? $clientLocation : __('transactions.not_available');
    $receiptGeneratedLabel = ($receiptGeneratedAt ?? now())->format('d/m/Y H:i');
    $receiptVerificationCode = $receiptVerificationCode ?? strtoupper(substr(sha1((string) $transaction->id), 0, 14));
    $hasBeneficiary = (bool) ($transaction->recipient_name || $transaction->recipient_iban || $transaction->recipient_bic || $transaction->bank_name);
    $hasAdditional = (bool) ($transaction->reason || $transaction->message || $transaction->refunded_at || $transaction->refund_reason || $transaction->refundedBy);
@endphp

<div class="html-shell">
    @if($renderMode === 'html')
        <div class="receipt-toolbar">
            <div class="receipt-toolbar-card">
                <div class="summary-label">{{ __('transactions.action_receipt') }}</div>
                <div style="margin-top:8px;font-size:24px;font-weight:800;color:#0f172a;">#{{ $transaction->id }}</div>
                <div style="margin-top:8px;color:#64748b;">{{ __('transactions.receipt_generated_at', ['date' => $receiptGeneratedLabel]) }}</div>
                <div class="receipt-toolbar-links">
                    <a href="{{ localized_route('transactions.receipt', $transaction) }}" class="primary">{{ __('transactions.action_download_receipt') }}</a>
                    <a href="{{ localized_route('transactions.history') }}" class="secondary">{{ __('transactions.history_title') }}</a>
                </div>
            </div>
        </div>
    @endif

    @if($renderMode === 'html' && filled($pdfUnavailableReason ?? null))
        <div class="receipt-alert">
            <div class="receipt-alert-card">{{ $pdfUnavailableReason }}</div>
        </div>
    @endif

    <div class="receipt-wrap">
        <div class="receipt-hero">
            <table class="receipt-hero-table">
                <tr>
                    <td class="receipt-brand">
                        <div class="brand-stack">
                            <div class="brand-emblem">
                                <svg viewBox="0 0 74 74" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <rect x="4" y="4" width="66" height="66" rx="22" fill="#f97316"/>
                                    <path d="M20 22H31L37 34L43 22H54L37 51L20 22Z" fill="#ffffff"/>
                                    <path d="M23 54H51" stroke="#ffffff" stroke-width="4" stroke-linecap="round"/>
                                    <circle cx="55" cy="19" r="5" fill="#fdba74"/>
                                </svg>
                            </div>
                            <div class="brand-copy">
                                <div class="brand-name">Valtrix Bank</div>
                                <div class="brand-tag">{{ __('transactions.receipt_brand_tag') }}</div>
                                <div class="brand-micro">{{ __('transactions.receipt_title') }} #{{ $transaction->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="receipt-meta">
                        <div class="meta-card">
                            <div class="receipt-badge">{{ __('transactions.receipt_title') }}</div>
                            <div class="meta-value">#{{ $transaction->id }}</div>
                            <div class="meta-subvalue">{{ __('transactions.receipt_generated_at', ['date' => $receiptGeneratedLabel]) }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="receipt-body">
            <table class="layout-table">
                <tr>
                    <td class="layout-main">
                        <table class="overview-table">
                            <tr>
                                <td style="width:38%;">
                                    <div class="summary-card is-amount">
                                        <div class="summary-label">{{ __('transactions.receipt_amount') }}</div>
                                        <div class="summary-value">{{ $amountFormatted }}</div>
                                        <div class="summary-sub">{{ __('transactions.receipt_currency') }} : {{ $currency }}</div>
                                    </div>
                                </td>
                                <td style="width:28%;">
                                    <div class="summary-card is-status">
                                        <div class="summary-label">{{ __('transactions.receipt_status') }}</div>
                                        <div class="status-pill {{ $statusClass }}">{{ $statusLabel }}</div>
                                        <div class="summary-sub" style="margin-top:12px;">{{ __('transactions.receipt_progress') }} : {{ $transaction->progress }}%</div>
                                    </div>
                                </td>
                                <td style="width:34%;">
                                    <div class="summary-card is-reference">
                                        <div class="summary-label">{{ __('transactions.receipt_verification_code') }}</div>
                                        <div class="reference-code">{{ $receiptVerificationCode }}</div>
                                        <div class="summary-sub">{{ __('transactions.receipt_transaction_id') }} : #{{ $transaction->id }}</div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <div class="section">
                            <div class="section-header">
                                <div class="section-title">{{ __('transactions.receipt_transaction_details') }}</div>
                            </div>
                            <div class="section-body">
                                <table class="section-table">
                                    <tr>
                                        <td>
                                            <div class="kv-label">{{ __('transactions.receipt_transaction_id') }}</div>
                                            <div class="kv-value">#{{ $transaction->id }}</div>
                                        </td>
                                        <td>
                                            <div class="kv-label">{{ __('transactions.receipt_type') }}</div>
                                            <div class="kv-value">{{ $typeLabel }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="kv-label">{{ __('transactions.receipt_date') }}</div>
                                            <div class="kv-value">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                        </td>
                                        <td>
                                            <div class="kv-label">{{ __('transactions.receipt_status') }}</div>
                                            <div class="kv-value">{{ $statusLabel }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="kv-label">{{ __('transactions.receipt_progress') }}</div>
                                            <div class="kv-value">{{ $transaction->progress }}%</div>
                                        </td>
                                        <td>
                                            <div class="kv-label">{{ __('transactions.receipt_currency') }}</div>
                                            <div class="kv-value">{{ $currency }}</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="section">
                            <div class="section-header">
                                <div class="section-title">{{ __('transactions.receipt_client_section') }}</div>
                            </div>
                            <div class="section-body">
                                <table class="section-table">
                                    <tr>
                                        <td>
                                            <div class="kv-label">{{ __('transactions.receipt_client_name') }}</div>
                                            <div class="kv-value">{{ $clientName }}</div>
                                        </td>
                                        <td>
                                            <div class="kv-label">{{ __('transactions.receipt_email') }}</div>
                                            <div class="kv-value">{{ $transaction->user->email }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="kv-label">IBAN</div>
                                            <div class="kv-value">{{ $clientIban }}</div>
                                        </td>
                                        <td>
                                            <div class="kv-label">Phone</div>
                                            <div class="kv-value">{{ $clientPhone }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="kv-label">Location</div>
                                            <div class="kv-value">{{ $clientLocation }}</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($hasBeneficiary)
                            <div class="section">
                                <div class="section-header">
                                    <div class="section-title">{{ __('transactions.receipt_beneficiary_section') }}</div>
                                </div>
                                <div class="section-body">
                                    <table class="section-table">
                                        @if($transaction->recipient_name || $transaction->bank_name)
                                            <tr>
                                                @if($transaction->recipient_name)
                                                    <td>
                                                        <div class="kv-label">{{ __('transactions.receipt_recipient_name') }}</div>
                                                        <div class="kv-value">{{ $transaction->recipient_name }}</div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                                @if($transaction->bank_name)
                                                    <td>
                                                        <div class="kv-label">{{ __('transactions.receipt_bank_name') }}</div>
                                                        <div class="kv-value">{{ $transaction->bank_name }}</div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endif
                                        @if($transaction->recipient_iban || $transaction->recipient_bic)
                                            <tr>
                                                @if($transaction->recipient_iban)
                                                    <td>
                                                        <div class="kv-label">{{ __('transactions.receipt_recipient_iban') }}</div>
                                                        <div class="kv-value">{{ $transaction->recipient_iban }}</div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                                @if($transaction->recipient_bic)
                                                    <td>
                                                        <div class="kv-label">{{ __('transactions.receipt_recipient_bic') }}</div>
                                                        <div class="kv-value">{{ $transaction->recipient_bic }}</div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if($hasAdditional)
                            <div class="section">
                                <div class="section-header">
                                    <div class="section-title">{{ __('transactions.receipt_additional_section') }}</div>
                                </div>
                                <div class="section-body">
                                    <table class="section-table">
                                        @if($transaction->reason || $transaction->message)
                                            <tr>
                                                @if($transaction->reason)
                                                    <td>
                                                        <div class="kv-label">{{ __('transactions.receipt_reason') }}</div>
                                                        <div class="kv-value">{{ $transaction->reason }}</div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                                @if($transaction->message)
                                                    <td>
                                                        <div class="kv-label">{{ __('transactions.receipt_message') }}</div>
                                                        <div class="kv-value">{{ $transaction->message }}</div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endif
                                        @if($transaction->refunded_at || $transaction->refundedBy)
                                            <tr>
                                                @if($transaction->refunded_at)
                                                    <td>
                                                        <div class="kv-label">{{ __('transactions.receipt_refunded_at') }}</div>
                                                        <div class="kv-value">{{ $transaction->refunded_at->format('d/m/Y H:i') }}</div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                                @if($transaction->refundedBy)
                                                    <td>
                                                        <div class="kv-label">{{ __('transactions.receipt_refunded_by') }}</div>
                                                        <div class="kv-value">{{ $transaction->refundedBy->first_name }} {{ $transaction->refundedBy->last_name }}</div>
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endif
                                        @if($transaction->refund_reason)
                                            <tr>
                                                <td colspan="2">
                                                    <div class="kv-label">{{ __('transactions.receipt_refund_reason') }}</div>
                                                    <div class="kv-value">{{ $transaction->refund_reason }}</div>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="layout-side">
                        <div class="side-card qr-card">
                            <div class="side-eyebrow">{{ __('transactions.receipt_client_section') }} QR</div>
                            <div class="qr-frame">
                                @if($receiptQrDataUri)
                                    <img src="{{ $receiptQrDataUri }}" alt="Receipt QR code" class="receipt-qr-image">
                                @elseif($receiptQrSvg)
                                    {!! $receiptQrSvg !!}
                                @else
                                    <div style="font-size:13px;font-weight:700;color:#64748b;padding:56px 12px;">
                                        QR unavailable
                                    </div>
                                @endif
                            </div>
                            <div class="side-note">{{ __('transactions.receipt_qr_notice') }}</div>
                            <table class="mini-table">
                                <tr>
                                    <td class="mini-label">{{ __('transactions.receipt_client_name') }}</td>
                                    <td class="mini-value">{{ $clientName }}</td>
                                </tr>
                                <tr>
                                    <td class="mini-label">{{ __('transactions.receipt_transaction_id') }}</td>
                                    <td class="mini-value">#{{ $transaction->id }}</td>
                                </tr>
                                <tr>
                                    <td class="mini-label">{{ __('transactions.receipt_amount') }}</td>
                                    <td class="mini-value">{{ $amountFormatted }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="side-card">
                            <div class="side-eyebrow">{{ __('transactions.receipt_verification_code') }}</div>
                            <div class="side-code">{{ $receiptVerificationCode }}</div>
                            <div class="side-note">{{ __('transactions.receipt_notice') }}</div>
                        </div>

                        <div class="side-card">
                            <div class="side-eyebrow">Valtrix Bank</div>
                            <div class="support-line">support@valtrixbank.com</div>
                            <div class="support-line">{{ $typeLabel }} - {{ $statusLabel }}</div>
                            <table class="mini-table">
                                <tr>
                                    <td class="mini-label">{{ __('transactions.receipt_generated_at', ['date' => $receiptGeneratedLabel]) }}</td>
                                    <td class="mini-value">{{ $currency }}</td>
                                </tr>
                                <tr>
                                    <td class="mini-label">Secure Area</td>
                                    <td class="mini-value">client.valtrixbank.com</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="notice">{{ __('transactions.receipt_notice') }}</div>

        <div class="receipt-footer">
            <table class="receipt-footer-table">
                <tr>
                    <td>
                        <strong>Valtrix Bank</strong><br>
                        {{ __('transactions.receipt_title') }} #{{ $transaction->id }}<br>
                        {{ __('transactions.receipt_generated_at', ['date' => $receiptGeneratedLabel]) }}
                    </td>
                    <td class="receipt-footer-center">
                        <strong>{{ __('transactions.receipt_transaction_id') }}</strong><br>
                        #{{ $transaction->id }}<br>
                        {{ __('transactions.receipt_verification_code') }} {{ $receiptVerificationCode }}
                    </td>
                    <td class="receipt-footer-right">
                        <strong>support@valtrixbank.com</strong><br>
                        {{ $typeLabel }} - {{ $statusLabel }}<br>
                        {{ $amountFormatted }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>
