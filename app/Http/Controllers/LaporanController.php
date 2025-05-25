<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with(['kategori', 'pelapor']); // eager load kategori dan pelapor (user)

        if ($request->has('search')) {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        $laporans = $query->paginate(10);

        return view('template.totalLaporan', compact('laporans'));
    }

    public function create()
    {
        $kategoris = Kategori::all(); // Ambil semua kategori
        return view('template.laporan_form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'       => 'required|email',
            'phone'       => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'department'  => 'required',
            'description' => 'required',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        Laporan::create([
            'ticket_number' => 'TKT-' . strtoupper(Str::random(6)),
            'email'         => $request->email,
            'phone'         => $request->phone,
            'kategori_id'   => $request->kategori_id,
            'department'    => $request->department,
            'description'   => $request->description,
            'status'        => 'open',
            'pelapor_id'    => Auth::id(), // ambil dari user yang sedang login
            'attachment'    => $attachmentPath,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(Laporan $laporan)
    {
        return view('template.laporan_edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $laporan->update(['status' => $request->status]);

        return redirect()->route('laporan.index')->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function selesai(Request $request)
    {
        $query = Laporan::where('status', 'closed');

        if ($request->has('search') && $request->search != '') {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        $laporanSelesai = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('template.laporanSelesai', compact('laporanSelesai'));
    }

    public function show($id)
    {
        $laporan = Laporan::with(['kategori', 'pelapor'])->findOrFail($id);
        return view('template.laporan_show', compact('laporan'));
    }


    public function antrian()
    {
        $laporans = Laporan::with(['kategori', 'pelapor'])
            ->where('status', 'open')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('template.antrian', compact('laporans'));
    }

    public function diproses()
    {
        $laporans = Laporan::with(['kategori', 'pelapor'])
            ->where('status', 'in_progress')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('template.diproses', compact('laporans'));
    }
}
