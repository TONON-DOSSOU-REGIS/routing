# TODO: Fix TransactionController receiptPdf Type Error

## Issue
- Error: `App\Http\Controllers\TransactionController::receiptPdf(): Argument #1 ($transaction) must be of type App\Models\Transaction, string given`
- Caused by route locale prefix not being handled in method signature

## Changes Made
- [x] Updated `receiptPdf` method signature to include `$locale` parameter first
- [x] Method now accepts `($locale, Transaction $transaction)` instead of `(Transaction $transaction)`

## Verification
- [ ] Test the receipt PDF generation to ensure it works correctly
- [ ] Check that the route resolves properly with locale prefix
- [ ] Verify no other methods are affected by similar issues

## Notes
- The route is defined with locale prefix: `/{locale}/transactions/{transaction}/receipt`
- Laravel's route model binding expects parameters in the order they appear in the route
- Locale parameter comes first, then the transaction model binding
