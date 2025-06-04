<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Tampilkan form register
    public function showRegistrationForm()
    {
        return view('template.register');  // sesuaikan folder dan nama file blade kamu
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:asisten,krani,pelapor',
            'no_sap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'departemen' => 'required|string|max:100',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelapor',
            'no_sap' => $validated['no_sap'],
            'no_hp' => $validated['no_hp'],
            'departemen' => $validated['departemen'],
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
