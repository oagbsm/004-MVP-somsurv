<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function protectedMethod()
    {
                // Get the currently authenticated user
        $user = Auth::user();
        return view('protect', ['user' => $user]);
    }
}
