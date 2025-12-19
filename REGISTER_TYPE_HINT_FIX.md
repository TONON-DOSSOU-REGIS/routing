# Register Controller Type Hint Fix

## Issue
The application was throwing a `TypeError` during user registration:

```
App\Http\Controllers\Auth\RegisterController::registered(): 
Argument #1 ($request) must be of type App\Http\Controllers\Auth\Request, 
Illuminate\Http\Request given
```

## Root Cause
In the `RegisterController.php` file, the `registered()` method had an incorrect type hint on line 78:

```php
protected function registered(Request $request, $user)
```

Without a proper namespace import or fully qualified class name, PHP interpreted `Request` as `App\Http\Controllers\Auth\Request` (which doesn't exist) instead of `Illuminate\Http\Request`.

## Solution
Changed the type hint to use the fully qualified class name:

```php
protected function registered(\Illuminate\Http\Request $request, $user)
```

## Files Modified
- `app/Http/Controllers/Auth/RegisterController.php` (line 78)

## Testing
After this fix:
1. User registration should work without errors
2. Users with 'pending' status will be logged out and redirected to the pending approval page
3. Users with 'active' status will be logged in and redirected to the dashboard

## Note
The Intelephense warning about `auth()->logout()` is a static analysis false positive and can be safely ignored. Laravel's `auth()` helper fully supports the `logout()` method at runtime.
