# Currency Formatting Fix for Notifications

## Overview
Apply proper currency formatting to all notification messages that contain amounts, ensuring they use the user's default currency instead of hardcoded '€' symbols.

## Methods to Update
- [ ] notifyTransaction (deposit, withdrawal, transfer notifications)
- [ ] notifyLowBalance (low balance alerts)
- [ ] notifyTransactionOnHold (transaction on hold notifications)
- [ ] notifyAdminDeposit (admin deposit notifications)
- [ ] notifyAdminDepositConfirmation (admin deposit confirmation)

## Implementation Steps
1. Import CurrencyHelper in NotificationService
2. Replace hardcoded '€' with CurrencyHelper::formatForUser($user, $amount) in all affected methods
3. Test the changes to ensure proper formatting

## Files to Modify
- app/Services/NotificationService.php

