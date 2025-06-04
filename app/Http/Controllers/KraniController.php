<?php

// app/Http/Controllers/KraniController.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;

class KraniController extends Controller
{
    public function index()
    {
       $userId = Auth::id(); // ID user yang sedang login

    $totalLaporan   = Laporan::where('pic_id', $userId)->count();
    $totalSelesai   = Laporan::where('pic_id', $userId)->where('status', 'closed')->count();
    $totalAntrian   = Laporan::where('pic_id', $userId)->where('status', 'open')->count();
    $totalDiproses  = Laporan::where('pic_id', $userId)->where('status', 'in_progress')->count();

    $laporanPerPIC = User::withCount(['laporanPIC as laporan_pic_count' => function ($query) use ($userId) {
        $query->where('status', 'in_progress')->where('pic_id', $userId);
    }])->where('id', $userId)->get();

    return view('krani.krani_dashboard', compact(
        'totalLaporan',
        'totalSelesai',
        'totalAntrian',
        'totalDiproses',
        'laporanPerPIC'
    ));
    }
}
