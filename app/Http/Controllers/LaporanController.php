<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika fitur pencarian aktif, gunakan ini:
        // $query = Laporan::query();
        // if ($request->has('search') && $request->search != '') {
        //     $query->where('ticket_number', 'like', '%' . $request->search . '%');
        // }
        // $laporans = $query->orderBy('created_at', 'desc')->paginate(10);

        // Sementara tanpa pencarian, paginasi 10 data per halaman
        $laporans = Laporan::orderBy('created_at', 'desc')->paginate(10);

        return view('template.totalLaporan', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('template.laporan_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'category' => 'required',
            'department' => 'required',
            'description' => 'required',
            'reporter_name' => 'required',
            // 'status' tidak perlu divalidasi dari user
        ]);


        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        Laporan::create([
            'ticket_number'  => 'TKT-' . strtoupper(Str::random(6)),
            'email'          => $request->email,
            'phone'          => $request->phone,
            'category'       => $request->category,
            'department'     => $request->department,
            'description'    => $request->description,
            'status'         => 'open',
            'reporter_name'  => $request->reporter_name,
            'attachment'     => $attachmentPath,
        ]);

        return redirect()->route('totalLaporan')->with('success', 'Laporan berhasil ditambahkan.');
    }


    public function edit(Laporan $laporan)
    {
        // Tampilkan form edit hanya untuk status
        return view('template.laporan_edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->route('totalLaporan')->with('success', 'Status laporan berhasil diperbarui.');
    }
    
}
