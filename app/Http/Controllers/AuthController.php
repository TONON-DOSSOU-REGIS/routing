<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Send login notification to admin if user is not admin
            $user = Auth::user();
            if (!$user->isAdmin()) {
                try {
                    $admin = User::where('email', 'admin@bankpro.com')->first();
                    if ($admin) {
                        \Mail::to($admin->email)->send(new \App\Mail\UserLoginNotification(
                            $user,
                            now(),
                            $request->ip(),
                            $request->userAgent()
                        ));
                    }
                } catch (\Exception $e) {
                    // Log error but don't interrupt login
                    \Log::error('Failed to send login notification: ' . $e->getMessage());
                }
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'id_type' => 'nullable|in:CNI,Passport,Permis',
            'id_number' => 'nullable|string|max:50|unique:users',
            'iban' => 'nullable|string|max:34',
            'bic' => 'nullable|string|max:11',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'date_of_birth' => $request->date_of_birth,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'iban' => $request->iban,
            'bic' => $request->bic,
            'password' => Hash::make($request->password),
            'activation_code' => $request->activation_code,
        ]);

        return redirect('/login')->with('success', 'Inscription réussie ! Veuillez vous connecter maintenant.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
