<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;

class PelaporController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // ID user yang sedang login

        $totalLaporan   = Laporan::where('pelapor_id', $userId)->count();
        $totalSelesai   = Laporan::where('pelapor_id', $userId)->where('status', 'closed')->count();
        $totalAntrian   = Laporan::where('pelapor_id', $userId)->where('status', 'open')->count();
        $totalDiproses  = Laporan::where('pelapor_id', $userId)->where('status', 'in_progress')->count();

        return view('pelapor.pelapor_dashboard', compact(
            'totalLaporan',
            'totalSelesai',
            'totalAntrian',
            'totalDiproses'
        ));
    }
}
