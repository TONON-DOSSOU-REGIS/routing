<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Get the post-password reset redirect path with locale.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $locale = app()->getLocale();
        $user = auth()->user();

        if ($user && $user->isAdmin()) {
            return '/' . $locale . '/admin/dashboard';
        }

        return '/' . $locale . '/dashboard';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
