<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Get the post-register redirect path with locale.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $locale = app()->getLocale();
        return '/' . $locale . '/dashboard';
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'id_type' => ['required', 'string', 'in:CNI,Passport,Permis'],
            'id_number' => ['required', 'string', 'max:255', 'unique:users'],
            'iban' => ['nullable', 'string', 'max:34'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);
    }

    protected function create(array $data)
    {
        return \App\Models\User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'date_of_birth' => $data['date_of_birth'],
            'id_type' => $data['id_type'],
            'id_number' => $data['id_number'],
            'iban' => $data['iban'] ?? null,
            'role' => 'user',
            'balance' => 0.00,
            'default_currency' => 'EUR',
            'status' => 'pending',
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(\Illuminate\Http\Request $request, $user)
    {
        // If user status is pending, don't log them in
        if ($user->status === 'pending') {
            // Log out the user if they were automatically logged in
            auth()->logout();

            // Redirect to pending approval page
            $locale = app()->getLocale();
            return redirect('/' . $locale . '/pending-approval');
        }

        // For active users, continue with normal flow
        return redirect($this->redirectTo());
    }
}

