<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        if (auth()->user()->isAdmin()) {
            return '/admin/dashboard';
        }

        return '/dashboard';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

