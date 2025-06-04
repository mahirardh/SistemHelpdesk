<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;

class AsistenController extends Controller
{
    public function index()
    {
        $totalLaporan   = Laporan::count();
        $totalSelesai   = Laporan::where('status', 'closed')->count();
        $totalAntrian   = Laporan::where('status', 'open')->count();
        $totalDiproses  = Laporan::where('status', 'in_progress')->count();

        $laporanPerPIC = User::withCount(['laporanPIC as laporan_pic_count' => function ($query) {
            $query->where('status', 'in_progress');
        }])
            ->whereHas('laporanPIC', function ($query) {
                $query->where('status', 'in_progress');
            })
            ->get();

        return view('template.menu', compact(
            'totalLaporan',
            'totalSelesai',
            'totalAntrian',
            'totalDiproses',
            'laporanPerPIC'
        ));
    }
}
