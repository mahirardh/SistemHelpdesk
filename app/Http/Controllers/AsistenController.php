<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;

class AsistenController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari form
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // Ubah ke format datetime
        $start = $startDate ? $startDate . ' 00:00:00' : null;
        $end   = $endDate   ? $endDate . ' 23:59:59' : null;

        // Semua laporan (terfilter jika ada tanggal)
        $totalLaporan = Laporan::when($start && $end, function ($query) use ($start, $end) {
            return $query->whereBetween('created_at', [$start, $end]);
        })->count();

        $totalSelesai = Laporan::when($start && $end, function ($query) use ($start, $end) {
            return $query->whereBetween('created_at', [$start, $end]);
        })->where('status', 'closed')->count();

        $totalAntrian = Laporan::when($start && $end, function ($query) use ($start, $end) {
            return $query->whereBetween('created_at', [$start, $end]);
        })->where('status', 'open')->count();

        $totalDiproses = Laporan::when($start && $end, function ($query) use ($start, $end) {
            return $query->whereBetween('created_at', [$start, $end]);
        })->where('status', 'in_progress')->count();

        // Laporan per PIC (khusus yang sedang diproses)
        $laporanPerPIC = User::withCount(['laporanPIC as laporan_pic_count' => function ($query) use ($start, $end) {
            $query->where('status', 'in_progress');
            if ($start && $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }
        }])
        ->whereHas('laporanPIC', function ($query) use ($start, $end) {
            $query->where('status', 'in_progress');
            if ($start && $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }
        })->get();

        return view('template.menu', compact(
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
