<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        // dd(Auth::user()); // <-- hapus atau komentar

        $user = Auth::user();

        $total = $user->laporan()->count();
        $selesai = $user->laporan()->where('status', 'closed')->count();
        $antrian = $user->laporan()->where('status', 'open')->count();
        $diproses = $user->laporan()->where('status', 'in_progress')->count();

        $rating = 5;

        return view('template.profile', compact('user', 'total', 'selesai', 'antrian', 'diproses', 'rating'));
    }
}
