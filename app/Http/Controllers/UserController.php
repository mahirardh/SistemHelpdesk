<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::paginate(10);
        return view('template.user', compact('users'));
    }
    public function create()
    {
        return view('template.user_create');
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|in:asisten,krani,pelapor',
                'no_sap' => 'required|string|max:255',
                'no_hp' => 'nullable|string|max:15',
                'departemen' => 'nullable|string|max:100',
            ]);

            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'no_sap' => $validated['no_sap'],
                'no_hp' => $validated['no_hp'],
                'departemen' => $validated['departemen'],
            ]);

            return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan pengguna. Alasan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('template.show', compact('user'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('template.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:asisten,krani,pelapor',
            'no_sap' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'departemen' => 'nullable|string|max:100',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Gagal menghapus pengguna.');
        }
    }
}
