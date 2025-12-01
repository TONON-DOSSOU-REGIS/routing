<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

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
}

