<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;

class KraniController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id(); // ID krani yang login

        // Ambil tanggal dari request
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // Format ke datetime lengkap
        $start = $startDate ? $startDate . ' 00:00:00' : null;
        $end   = $endDate   ? $endDate . ' 23:59:59' : null;

        // Hitung total laporan sesuai filter tanggal
        $totalLaporan = Laporan::where('pic_id', $userId)
            ->when($start && $end, fn($query) => $query->whereBetween('created_at', [$start, $end]))
            ->count();

        $totalSelesai = Laporan::where('pic_id', $userId)
            ->where('status', 'closed')
            ->when($start && $end, fn($query) => $query->whereBetween('created_at', [$start, $end]))
            ->count();

        $totalAntrian = Laporan::where('pic_id', $userId)
            ->where('status', 'open')
            ->when($start && $end, fn($query) => $query->whereBetween('created_at', [$start, $end]))
            ->count();

        $totalDiproses = Laporan::where('pic_id', $userId)
            ->where('status', 'in_progress')
            ->when($start && $end, fn($query) => $query->whereBetween('created_at', [$start, $end]))
            ->count();

        // Laporan per PIC (hanya user yg sedang login)
        $laporanPerPIC = User::withCount(['laporanPIC as laporan_pic_count' => function ($query) use ($userId, $start, $end) {
            $query->where('status', 'in_progress')
                  ->where('pic_id', $userId);

            if ($start && $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }
        }])
        ->where('id', $userId)
        ->get();

        return view('krani.krani_dashboard', compact(
            'totalLaporan',
            'totalSelesai',
            'totalAntrian',
            'totalDiproses',
            'laporanPerPIC',
            'startDate',
            'endDate'
        ));
    }
}
