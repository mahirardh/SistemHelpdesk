<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('template.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'no_sap' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['no_sap' => $credentials['no_sap'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with('error', 'No. SAP atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
}
