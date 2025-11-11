<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function index()
    {
        $user = auth()->user();
        $transactions = $user->transactions()->latest()->take(5)->get();

        return view('dashboard.index', compact('user', 'transactions'));
    }
}
