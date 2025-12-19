## Tasks
- [x] Override `registered` method in RegisterController to handle pending users
- [x] Create CheckUserStatus middleware
- [x] Create pending approval view
- [x] Update routes to use status checking middleware
- [x] Test registration flow

## Summary
The registration bug has been successfully fixed. Users with 'pending' status will no longer be automatically logged in after registration. Instead, they will see a pending approval message and be redirected to a dedicated page. They cannot access protected routes until their account is approved by an admin.
=======
## Tasks
- [x] Override `registered` method in RegisterController to handle pending users
- [x] Create CheckUserStatus middleware
- [x] Create pending approval view
- [x] Update routes to use status checking middleware
- [x] Test registration flow

## Summary
The registration bug has been successfully fixed. Users with 'pending' status will no longer be automatically logged in after registration. Instead, they will see a pending approval message and be redirected to a dedicated page. They cannot access protected routes until their account is approved by an admin.

## Files Modified
- `app/Http/Controllers/Auth/RegisterController.php`: Added `registered()` method to handle pending users
- `app/Http/Middleware/CheckUserStatus.php`: Created middleware to check user status
- `resources/views/auth/pending-approval.blade.php`: Created pending approval view
- `routes/web.php`: Added middleware and route for pending approval
- `app/Http/Kernel.php`: Registered the new middleware
