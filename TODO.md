# Task: Add Admin Validation Feature for New User Registration

## Steps:

- [x] Create migration to add 'pending' option to 'status' enum in users table and set default to 'pending'.
- [x] Update AuthController@register to save new users with status 'pending'.
- [x] Add admin notification on new user registration (via email or Laravel notification).
- [x] Add AdminController@approveUser method to approve user registration (change status from 'pending' to 'active').
- [x] Add route for approving users PATCH /admin/users/{user}/approve.
- [x] Extend resources/views/admin/users.blade.php to show pending users and add "Approve" button.
- [x] Modify login logic in AuthController to prevent login if status not 'active'.

## Bug Fixes Completed:

- [x] Fixed wrong mail class in AuthController (was using UserLoginNotification instead of UserRegistrationNotification)
- [x] Created missing UserRegistrationNotification mail class
- [x] Created UserApprovedNotification mail class for user approval notifications
- [x] Removed duplicate Mail import in AdminController
- [x] Added isPending() and isActive() helper methods to User model
- [x] Implemented search and filter functionality in admin users page
- [x] Updated registration success message to inform users about pending approval
- [x] Added email notification when admin approves a user account

## Followup:
- [x] Run migration
- [x] Test user registration and admin approval flow
- [x] Verify notifications and login restrictions
- [x] Test search and filter functionality in admin panel

