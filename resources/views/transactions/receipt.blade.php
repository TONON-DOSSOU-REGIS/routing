<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('transactions.receipt_page_title') }}</title>

    <style>
    * {
        box-sizing: border-box;
    }

    html, body {
        margin: 0;
        padding: 0;
        width: 210mm;
        height: 297mm;
        font-family: "DejaVu Sans", Arial, Helvetica, sans-serif;
        background: #ffffff;
        color: #0f172a;
        font-size: 11px;
    }

    .page {
        width: 100%;
        height: 100%;
        padding: 0;
    }

    .receipt {
        width: 100%;
        height: 100%;
        max-height: 277mm;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* ================= HEADER ================= */
    .receipt-header {
        background: #0f172a;
        color: #ffffff;
        padding: 14px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo {
        width: 42px;
        height: 42px;
        background: #ffffff;
        padding: 5px;
        border-radius: 6px;
    }

    .brand-name {
        font-size: 18px;
        font-weight: bold;
    }

    .brand-tag {
        font-size: 11px;
        opacity: 0.85;
    }

    .receipt-meta {
        text-align: right;
        font-size: 11px;
    }

    .receipt-meta strong {
        font-size: 17px;
        display: block;
    }

    /* ================= CONTENT ================= */
    .content {
        flex: 1;
        padding: 14px 18px;
        overflow: hidden;
    }

    .status-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .status {
        padding: 6px 14px;
        font-size: 11px;
        border-radius: 20px;
        font-weight: bold;
        letter-spacing: 0.5px;
    }

    .success { background: #dcfce7; color: #166534; }
    .pending { background: #fef9c3; color: #854d0e; }
    .hold { background: #fee2e2; color: #991b1b; }

    .amount {
        font-size: 20px;
        font-weight: bold;
    }

    .section {
        margin-top: 12px;
    }

    .section-title {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 6px;
        text-transform: uppercase;
    }

    .kv-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 6px 14px;
    }

    .kv-item {
        font-size: 11px;
        border-bottom: 1px dashed #e5e7eb;
        padding-bottom: 4px;
    }

    .kv-label {
        color: #64748b;
        font-size: 9px;
        text-transform: uppercase;
    }

    .kv-value {
        font-weight: 600;
        margin-top: 3px;
        font-size: 12px;
    }

    .notice {
        margin-top: 12px;
        font-size: 10.5px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        padding: 8px;
        border-radius: 6px;
        line-height: 1.4;
    }

    /* ================= FOOTER ================= */
    .footer {
        border-top: 1px solid #e2e8f0;
        padding: 10px 18px;
        font-size: 10.5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
    }

    /* ================= PRINT ================= */
    @media print {
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .receipt {
            page-break-inside: avoid;
        }
    }
</style>

</head>

<body>
@php
    $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/Logosite.png')));
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
        'success' => 'success',
        'pending' => 'pending',
        'on_hold' => 'hold',
        'failed' => 'hold',
        'refunded' => 'pending',
        default => 'pending',
    };
    $typeKey = match ($transaction->type) {
        'transfer' => 'type_transfer',
        'deposit' => 'type_deposit',
        'withdrawal' => 'type_withdrawal',
        default => null,
    };
    $typeLabel = $typeKey ? __('transactions.' . $typeKey) : ucfirst($transaction->type);
    $hasBeneficiary = (bool) ($transaction->recipient_name || $transaction->recipient_iban || $transaction->recipient_bic || $transaction->bank_name);
    $hasAdditional = (bool) ($transaction->reason || $transaction->message || $transaction->refunded_at || $transaction->refund_reason || $transaction->refunded_by);
@endphp

<div class="page">
    <div class="receipt">

        <!-- HEADER -->
        <div class="receipt-header">
            <div class="brand">
                <img src="{{ $logoData }}" class="logo">
                <div>
                    <div class="brand-name">SG BANK</div>
                    <div class="brand-tag">{{ __('transactions.receipt_brand_tag') }}</div>
                </div>
            </div>
            <div class="receipt-meta">
                {{ __('transactions.receipt_title') }}<br>
                <strong>#{{ $transaction->id }}</strong>
                {{ __('transactions.receipt_generated_at', ['date' => now()->format('d/m/Y H:i')]) }}
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <div class="status-row">
                <div class="status {{ $statusClass }}">
                    {{ strtoupper($statusLabel) }}
                </div>
                <div class="amount">{{ $amountFormatted }}</div>
            </div>

            <div class="section">
                <div class="section-title">{{ __('transactions.receipt_transaction_details') }}</div>
                <div class="kv-grid">
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_transaction_id') }}</div>
                        <div class="kv-value">#{{ $transaction->id }}</div>
                    </div>
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_type') }}</div>
                        <div class="kv-value">{{ $typeLabel }}</div>
                    </div>
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_date') }}</div>
                        <div class="kv-value">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_status') }}</div>
                        <div class="kv-value">{{ $statusLabel }}</div>
                    </div>
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_progress') }}</div>
                        <div class="kv-value">{{ $transaction->progress }}%</div>
                    </div>
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_amount') }}</div>
                        <div class="kv-value">{{ $amountFormatted }}</div>
                    </div>
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_currency') }}</div>
                        <div class="kv-value">{{ $currency }}</div>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="section-title">{{ __('transactions.receipt_client_section') }}</div>
                <div class="kv-grid">
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_client_name') }}</div>
                        <div class="kv-value">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</div>
                    </div>
                    <div class="kv-item">
                        <div class="kv-label">{{ __('transactions.receipt_email') }}</div>
                        <div class="kv-value">{{ $transaction->user->email }}</div>
                    </div>
                </div>
            </div>

            @if($hasBeneficiary)
                <div class="section">
                    <div class="section-title">{{ __('transactions.receipt_beneficiary_section') }}</div>
                    <div class="kv-grid">
                        @if($transaction->recipient_name)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_recipient_name') }}</div>
                                <div class="kv-value">{{ $transaction->recipient_name }}</div>
                            </div>
                        @endif
                        @if($transaction->bank_name)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_bank_name') }}</div>
                                <div class="kv-value">{{ $transaction->bank_name }}</div>
                            </div>
                        @endif
                        @if($transaction->recipient_iban)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_recipient_iban') }}</div>
                                <div class="kv-value">{{ $transaction->recipient_iban }}</div>
                            </div>
                        @endif
                        @if($transaction->recipient_bic)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_recipient_bic') }}</div>
                                <div class="kv-value">{{ $transaction->recipient_bic }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($hasAdditional)
                <div class="section">
                    <div class="section-title">{{ __('transactions.receipt_additional_section') }}</div>
                    <div class="kv-grid">
                        @if($transaction->reason)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_reason') }}</div>
                                <div class="kv-value">{{ $transaction->reason }}</div>
                            </div>
                        @endif
                        @if($transaction->message)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_message') }}</div>
                                <div class="kv-value">{{ $transaction->message }}</div>
                            </div>
                        @endif
                        @if($transaction->refunded_at)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_refunded_at') }}</div>
                                <div class="kv-value">{{ $transaction->refunded_at->format('d/m/Y H:i') }}</div>
                            </div>
                        @endif
                        @if($transaction->refundedBy)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_refunded_by') }}</div>
                                <div class="kv-value">{{ $transaction->refundedBy->first_name }} {{ $transaction->refundedBy->last_name }}</div>
                            </div>
                        @endif
                        @if($transaction->refund_reason)
                            <div class="kv-item">
                                <div class="kv-label">{{ __('transactions.receipt_refund_reason') }}</div>
                                <div class="kv-value">{{ $transaction->refund_reason }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="notice">
                {{ __('transactions.receipt_notice') }}
            </div>

        </div>

<!-- FOOTER -->
        <div class="footer">
            <div>SG BANK © {{ date('Y') }}</div>
            <div>support@sgbank.com</div>
        </div>

    </div>
</div>
</body>
</html>
