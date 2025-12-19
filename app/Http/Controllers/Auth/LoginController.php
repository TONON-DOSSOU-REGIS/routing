<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Get the post-login redirect path with locale.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $locale = app()->getLocale();
        
        if (auth()->user()->isAdmin()) {
            return '/' . $locale . '/admin/dashboard';
        }

        return '/' . $locale . '/dashboard';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

