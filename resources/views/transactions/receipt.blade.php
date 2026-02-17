<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('transactions.receipt_page_title') }}</title>

  <style>

/* ================= GLOBAL ================= */

*{
    box-sizing:border-box;
}

@page{
    size:A4 portrait;
    margin:10mm;
}

html,body{
    width:210mm;
    height:277mm;
    margin:0;
    padding:0;
    font-family:"DejaVu Sans",Arial,Helvetica,sans-serif;
    background:#ffffff;
    color:#0f172a;
    font-size:10px;
}

/* ================= PAGE ================= */

.page{
    width:100%;
    height:277mm;
}

.receipt{
    width:100%;
    height:277mm;
    border:1px solid #e2e8f0;
    border-radius:6px;
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

/* ================= HEADER ================= */

.receipt-header{
    background:#0f172a;
    color:#ffffff;
    padding:10px 14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    page-break-inside:avoid;
}

.brand{
    display:flex;
    align-items:center;
    gap:10px;
}

.logo{
    width:38px;
    height:38px;
    background:#ffffff;
    padding:4px;
    border-radius:5px;
}

.brand-name{
    font-size:15px;
    font-weight:bold;
}

.brand-tag{
    font-size:9px;
    opacity:.85;
}

.receipt-meta{
    text-align:right;
    font-size:9px;
}

.receipt-meta strong{
    font-size:15px;
    display:block;
}

/* ================= CONTENT ================= */

.content{
    flex:1;
    padding:10px 14px;
    padding-right:110px;
    position:relative;
    overflow:hidden;
    page-break-inside:avoid;
}

.status-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:8px;
}

.status{
    padding:5px 12px;
    font-size:10px;
    border-radius:20px;
    font-weight:bold;
    letter-spacing:.5px;
}

.success{background:#dcfce7;color:#166534;}
.pending{background:#fef9c3;color:#854d0e;}
.hold{background:#fee2e2;color:#991b1b;}

.amount{
    font-size:18px;
    font-weight:bold;
}

/* ================= SECTIONS ================= */

.section{
    margin-top:7px;
    page-break-inside:avoid;
}

.section-title{
    font-size:10.5px;
    font-weight:bold;
    margin-bottom:4px;
    text-transform:uppercase;
}

.kv-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:4px 10px;
}

.kv-item{
    border-bottom:1px dashed #e5e7eb;
    padding-bottom:2px;
    max-height:34px;
    overflow:hidden;
    page-break-inside:avoid;
}

.kv-label{
    color:#64748b;
    font-size:7.5px;
    text-transform:uppercase;
}

.kv-value{
    font-weight:600;
    font-size:9.8px;
    margin-top:2px;
    line-height:1.2;
    word-break:break-word;
    overflow-wrap:break-word;
    max-height:24px;
    overflow:hidden;
}

/* ================= NOTICE ================= */

.notice{
    margin-top:7px;
    font-size:9px;
    background:#fff7ed;
    border:1px solid #fed7aa;
    padding:6px;
    border-radius:6px;
    line-height:1.25;
    max-height:55px;
    overflow:hidden;
    page-break-inside:avoid;
}

/* ================= QR ================= */

.qr-side{
    position:absolute;
    top:10px;
    right:14px;
    width:84px;
    text-align:center;
}

.qr-image{
    width:84px;
    height:84px;
    border:1px solid #e2e8f0;
    border-radius:6px;
    background:#ffffff;
}

.qr-caption{
    margin-top:4px;
    font-size:7.5px;
    color:#475569;
    line-height:1.2;
}

/* ================= FOOTER ================= */

.footer{
    flex-shrink:0;
    border-top:1px solid #dbe5f3;
    padding:6px 14px 7px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(180deg,#f8fafc 0%,#eef2ff 100%);
    page-break-inside:avoid;
}

.footer::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:2px;
    background:linear-gradient(90deg,#1d4ed8 0%,#3b82f6 35%,#0ea5e9 100%);
}

.footer-left{
    display:flex;
    flex-direction:column;
    gap:1px;
}

.footer-brand{
    font-size:9.5px;
    font-weight:700;
}

.footer-meta{
    font-size:8px;
    color:#64748b;
}

.footer-center{
    font-size:8px;
    color:#475569;
    text-align:center;
}

.footer-right{
    text-align:right;
}

.footer-contact-label{
    font-size:7px;
    text-transform:uppercase;
    color:#64748b;
}

.footer-contact-value{
    font-size:8.5px;
    font-weight:600;
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
    $qrPayload = implode('|', [
        'bank=Valtrix Bank',
        'receipt_id=' . $transaction->id,
        'status=' . $transaction->status,
        'amount=' . number_format((float) $transaction->amount, 2, '.', ''),
        'currency=' . $currency,
        'created_at=' . $transaction->created_at->format('Y-m-d H:i:s'),
        'user_email=' . $transaction->user->email,
    ]);
    $qrUrl = 'https://quickchart.io/qr?size=180&text=' . urlencode($qrPayload);
@endphp

<div class="page">
    <div class="receipt">

        <!-- HEADER -->
        <div class="receipt-header">
            <div class="brand">
                <img src="{{ $logoData }}" class="logo">
                <div>
                    <div class="brand-name">Valtrix Bank</div>
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
            <div class="qr-side">
                <img src="{{ $qrUrl }}" alt="Receipt QR Code" class="qr-image">
                <div class="qr-caption">QR Verification<br>#{{ $transaction->id }}</div>
            </div>

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
            <div class="footer-left">
                <div class="footer-brand">Valtrix Bank</div>
                <div class="footer-meta">&copy; {{ date('Y') }} - {{ __('transactions.receipt_title') }}</div>
            </div>
            <div class="footer-center">
                Ref: #{{ $transaction->id }} | {{ $transaction->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="footer-right">
                <div class="footer-contact-label">Support</div>
                <div class="footer-contact-value">support@valtrixbank.com</div>
            </div>
        </div>

    </div>
</div>
</body>
</html>

