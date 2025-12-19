# Fix: CSRF Token Mismatch Error for Chat Attachments

## Problem
When sending attachments via the client chatbot, users encountered the error:
**"Erreur lors de l'envoi du message: CSRF token mismatch."**

## Root Cause
The client chat widget (`resources/views/components/client-chat-widget.blade.php`) was using a hardcoded CSRF token in the JavaScript:
```javascript
'X-CSRF-TOKEN': '{{ csrf_token() }}'
```

This token was rendered once when the Blade template was compiled, but it didn't dynamically fetch the token from the meta tag in the page header. This caused issues when:
- The page had been open for a long time and the session token changed
- Multiple tabs were open
- The token was regenerated for security reasons

## Solution Implemented

### 1. Dynamic CSRF Token Retrieval
Modified the `sendClientMessage` function to dynamically fetch the CSRF token from the page's meta tag:

```javascript
// Get CSRF token dynamically from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (!csrfToken) {
    console.error('[ClientChat] CSRF token not found in page');
    alert('Erreur de sécurité: Token CSRF manquant. Veuillez rafraîchir la page.');
    input.disabled = false;
    return;
}
```

### 2. Enhanced Error Handling
Added specific error handling for different HTTP status codes:

```javascript
if (response.ok && data.success) {
    // Success handling
} else {
    // Handle specific error cases
    if (response.status === 419) {
        alert('Erreur de sécurité: Votre session a expiré. Veuillez rafraîchir la page.');
    } else if (response.status === 422) {
        alert('Erreur de validation: ' + (data.message || 'Données invalides'));
    } else {
        alert('Erreur lors de l\'envoi du message: ' + (data.message || 'Erreur inconnue'));
    }
}
```

### 3. Better Response Validation
Changed from checking only `data.success` to also checking `response.ok` to properly handle HTTP errors.

## Files Modified
- `resources/views/components/client-chat-widget.blade.php`

## Benefits
1. **Dynamic Token**: Always uses the current CSRF token from the page
2. **Better Error Messages**: Users get clear, specific error messages
3. **Session Handling**: Properly handles expired sessions
4. **Validation Errors**: Distinguishes between different types of errors
5. **Reliability**: Works correctly even with long-lived pages or multiple tabs

## Testing
To test the fix:
1. Log in as a regular user
2. Open the dashboard
3. Click on the chat widget
4. Try sending a message with an attachment
5. Verify the message is sent successfully without CSRF errors

## Related Files
- `app/Http/Controllers/ChatController.php` - Handles message sending
- `routes/web.php` - Chat routes with CSRF protection
- `resources/views/dashboard/index.blade.php` - Contains CSRF meta tag

## Date
December 2024

## Status
✅ **FIXED** - CSRF token mismatch error resolved for chat attachments
