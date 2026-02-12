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
                ->withErrors(['email' => 'Lien de connexion invalide ou expiré.']);
        }

        if ($user->login_link_expires_at && now()->greaterThan($user->login_link_expires_at)) {
            return redirect('/' . $locale . '/login')
                ->withErrors(['email' => 'Lien de connexion expiré. Demandez un nouveau lien à votre administrateur.']);
        }

        $user->forceFill([
            'login_link_used_at' => now(),
        ])->save();

        $request->session()->flash('prefill_email', $user->email);

        if ($user->status === 'pending') {
            $request->session()->flash('login_link_notice', 'Votre compte est en attente de validation. Vous pouvez tenter de vous connecter mais l\'accès sera refusé tant que le compte n\'est pas approuvé.');
        } elseif ($user->status === 'suspended') {
            $request->session()->flash('login_link_notice', 'Votre compte est suspendu. Contactez l\'administrateur si besoin.');
        } else {
            $request->session()->flash('login_link_notice', 'Veuillez vous connecter pour accéder à votre espace.');
        }

        return redirect('/' . $locale . '/login');
    }
}
