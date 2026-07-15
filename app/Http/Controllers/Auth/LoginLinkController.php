<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginLinkController extends Controller
{
    public function login(Request $request, string $locale, string $token)
    {
        $tokenHash = hash('sha256', $token);

        $user = User::where('login_link_token', $tokenHash)->first();
        if (!$user) {
            return redirect('/' . $locale . '/login')
                ->withErrors(['email' => __('auth_ui.login_link_invalid')]);
        }

        if ($user->login_link_expires_at && now()->greaterThan($user->login_link_expires_at)) {
            return redirect('/' . $locale . '/login')
                ->withErrors(['email' => __('auth_ui.login_link_expired')]);
        }

        $user->forceFill([
            'login_link_used_at' => now(),
        ])->save();

        $request->session()->flash('prefill_email', $user->email);

        if ($user->status === 'pending') {
            $request->session()->flash('login_link_notice', __('auth_ui.login_link_pending_notice'));
        } elseif ($user->status === 'suspended') {
            $request->session()->flash('login_link_notice', __('auth_ui.login_link_suspended_notice'));
        } else {
            $request->session()->flash('login_link_notice', __('auth_ui.login_link_ready_notice'));
        }

        return redirect('/' . $locale . '/login');
    }
}
