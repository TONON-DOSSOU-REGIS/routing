<?php
    $clientName = trim(implode(' ', array_filter([
        $transaction->user->first_name ?? null,
        $transaction->user->last_name ?? null,
    ])));
    $clientName = $clientName !== '' ? $clientName : ($transaction->user->email ?? 'Client');
    $beneficiaryName = trim((string) ($transaction->recipient_name ?? ''));
    $beneficiaryName = $beneficiaryName !== '' ? $beneficiaryName : __('transactions.not_available');
    $bankName = trim((string) ($transaction->bank_name ?? ''));
    $bankName = $bankName !== '' ? $bankName : __('transactions.not_available');
    $reason = trim((string) ($transaction->reason ?? ''));
    $executedAt = optional($transaction->updated_at ?? $transaction->created_at)->format('d/m/Y H:i');
    $mailLanguage = str_replace('_', '-', $mailLocale ?? app()->getLocale());
    $successLabel = __('transactions.status_success');
?>
<!DOCTYPE html>
<html lang="<?php echo e($mailLanguage); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('transactions.transfer_receipt_email_title')); ?></title>
</head>
<body style="margin:0; padding:0; background-color:#eef2f7; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#eef2f7; margin:0; padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px; background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 18px 50px rgba(15,23,42,0.10);">
                    <tr>
                        <td style="padding:32px 36px; background:linear-gradient(135deg, #0f766e 0%, #0f9f84 100%); color:#ffffff;">
                            <div style="font-size:12px; letter-spacing:0.18em; text-transform:uppercase; opacity:0.82;">Valtrix Bank</div>
                            <h1 style="margin:14px 0 10px; font-size:30px; line-height:1.2;"><?php echo e(__('transactions.transfer_receipt_email_title')); ?></h1>
                            <p style="margin:0; font-size:15px; line-height:1.7; max-width:520px; color:rgba(255,255,255,0.88);">
                                <?php echo e(__('transactions.transfer_receipt_email_intro')); ?>

                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:34px 36px 18px;">
                            <p style="margin:0 0 16px; font-size:16px; line-height:1.8;">
                                <?php echo e(__('transactions.transfer_receipt_email_greeting', ['name' => $clientName])); ?>

                            </p>
                            <p style="margin:0; font-size:15px; line-height:1.8; color:#475467;">
                                <?php echo e(__('transactions.transfer_receipt_email_body', ['file' => $receiptFileName])); ?>

                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 36px 28px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:separate; border-spacing:0; background:#f8fafc; border:1px solid #dbe4ee; border-radius:20px; overflow:hidden;">
                                <tr>
                                    <td colspan="2" style="padding:18px 22px; background:#111827; color:#ffffff; font-size:15px; font-weight:700;">
                                        <?php echo e(__('transactions.transfer_receipt_email_summary_title')); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:700; color:#667085; text-transform:uppercase; letter-spacing:0.08em;"><?php echo e(__('transactions.receipt_transaction_id')); ?></td>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:14px; color:#111827;">#<?php echo e($transaction->id); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:700; color:#667085; text-transform:uppercase; letter-spacing:0.08em;"><?php echo e(__('transactions.receipt_amount')); ?></td>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:18px; font-weight:700; color:#0f766e;"><?php echo e($formattedAmount); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:700; color:#667085; text-transform:uppercase; letter-spacing:0.08em;"><?php echo e(__('transactions.receipt_recipient_name')); ?></td>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:14px; color:#111827;"><?php echo e($beneficiaryName); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:700; color:#667085; text-transform:uppercase; letter-spacing:0.08em;"><?php echo e(__('transactions.receipt_bank_name')); ?></td>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:14px; color:#111827;"><?php echo e($bankName); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:700; color:#667085; text-transform:uppercase; letter-spacing:0.08em;"><?php echo e(__('transactions.receipt_status')); ?></td>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb;">
                                        <span style="display:inline-block; padding:8px 12px; border-radius:999px; background:#dcfce7; color:#166534; font-size:12px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;"><?php echo e($successLabel); ?> - 100%</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:700; color:#667085; text-transform:uppercase; letter-spacing:0.08em;"><?php echo e(__('transactions.transfer_receipt_email_processed_at')); ?></td>
                                    <td style="padding:16px 22px; border-bottom:1px solid #e5e7eb; font-size:14px; color:#111827;"><?php echo e($executedAt); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 22px; font-size:13px; font-weight:700; color:#667085; text-transform:uppercase; letter-spacing:0.08em;"><?php echo e(__('transactions.receipt_reason')); ?></td>
                                    <td style="padding:16px 22px; font-size:14px; color:#111827;"><?php echo e($reason !== '' ? $reason : __('transactions.transfer_receipt_email_reason_fallback')); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 36px 28px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#ecfdf3; border:1px solid #b7efcf; border-radius:18px;">
                                <tr>
                                    <td style="padding:18px 20px;">
                                        <div style="font-size:15px; font-weight:700; color:#166534; margin-bottom:8px;"><?php echo e(__('transactions.transfer_receipt_email_attachment_title')); ?></div>
                                        <div style="font-size:14px; line-height:1.7; color:#166534;">
                                            <?php echo e(__('transactions.transfer_receipt_email_attachment_text')); ?>

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 36px 34px;">
                            <table role="presentation" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding-right:12px; padding-bottom:12px;">
                                        <a href="<?php echo e($historyUrl); ?>" style="display:inline-block; padding:14px 22px; border-radius:999px; background:#0f766e; color:#ffffff; text-decoration:none; font-size:14px; font-weight:700;">
                                            <?php echo e(__('transactions.transfer_receipt_email_history_cta')); ?>

                                        </a>
                                    </td>
                                    <td style="padding-bottom:12px;">
                                        <a href="<?php echo e($receiptUrl); ?>" style="display:inline-block; padding:14px 22px; border-radius:999px; background:#ffffff; color:#0f172a; text-decoration:none; font-size:14px; font-weight:700; border:1px solid #cbd5e1;">
                                            <?php echo e(__('transactions.transfer_receipt_email_receipt_cta')); ?>

                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 36px; background:#f8fafc; border-top:1px solid #e5e7eb;">
                            <p style="margin:0 0 10px; font-size:13px; line-height:1.7; color:#667085;">
                                <?php echo e(__('transactions.transfer_receipt_email_footer_intro')); ?>

                            </p>
                            <p style="margin:0 0 10px; font-size:13px; line-height:1.7; color:#667085;">
                                <?php echo e(__('transactions.transfer_receipt_email_footer_support')); ?>

                            </p>
                            <p style="margin:0; font-size:12px; line-height:1.7; color:#98a2b3;">
                                <?php echo e(__('transactions.transfer_receipt_email_footer_notice', ['year' => date('Y')])); ?>

                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\cerveau\resources\views\emails\transfer_confirmation.blade.php ENDPATH**/ ?>