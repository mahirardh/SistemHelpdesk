<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Timeline;

use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Mulai query laporan
        $query = Laporan::with(['pelapor', 'pic', 'kategori']);

        // Kalau user adalah krani, filter berdasarkan dirinya sebagai PIC
        if ($user->role == 'krani') {
            $query->where('pic_id', $user->id);
        }
        // Kalau user adalah pelapor, filter berdasarkan dirinya sebagai pelapor
        if ($user->role == 'pelapor') {
            $query->where('pelapor_id', $user->id);
        }
        // Fitur pencarian nomor tiket (opsional)
        if ($request->filled('search')) {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        // Ambil hasil akhir
        $laporans = $query->latest()->paginate(10);
        // Return view sesuai dengan role user
        if ($user->role === 'pelapor') {
            return view('pelapor.laporanPelapor', compact('laporans'));
        }
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

    public function edit($id)
    {
        $laporan = Laporan::with(['kategori', 'pelapor'])->findOrFail($id);

        // Ambil semua user yang bisa menjadi PIC (asisten TI dan krani)
        $listPIC = User::whereIn('role', ['krani', 'asisten'])->get();

        return view('template.laporan_edit', compact('laporan', 'listPIC'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'status'      => 'required|in:open,in_progress,closed',
            'pic_id'      => 'nullable|exists:users,id',
            'sla_close'   => 'nullable|date',
            'prioritas'   => 'nullable|in:rendah,sedang,tinggi', // pastikan lowercase sesuai DB
        ]);

        // Jika status baru adalah 'in_progress' dan sebelumnya belum di-set, isi tanggal_mulai
        if ($request->status === 'in_progress' && !$laporan->tanggal_mulai) {
            $laporan->tanggal_mulai = now();
        }

        // Tetap update kolom lain
        $laporan->status    = $request->status;
        $laporan->pic_id    = $request->pic_id;
        $laporan->sla_close = $request->sla_close;
        $laporan->prioritas = $request->prioritas;
        $laporan->save();


        return redirect()->route('laporan.index')->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function selesai(Request $request)
    {
        $user = Auth::user();

        $query = Laporan::with(['pelapor', 'pic', 'kategori'])
            ->where('status', 'closed');

        if ($request->has('search') && $request->search != '') {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        // Jika user adalah krani, filter berdasarkan pic_id (hanya miliknya)
        if ($user->role == 'krani') {
            $query->where('pic_id', $user->id);
        }
        if ($user->role == 'pelapor') {
            $query->where('pelapor_id', $user->id);
        }
        $laporanSelesai = $query->latest()->paginate(10);
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
        $user = Auth::user();

        $query = Laporan::with(['pelapor', 'pic', 'kategori'])
            ->where('status', 'in_progress');

        // Jika user adalah krani, hanya tampilkan laporan yang menjadi tanggung jawabnya
        if ($user->role == 'krani') {
            $query->where('pic_id', $user->id);
        }
        if ($user->role == 'pelapor') {
            $query->where('pelapor_id', $user->id);
        }
        $laporans = $query->latest()->paginate(10);

        return view('template.diproses', compact('laporans'));
    }
    public function close(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status = 'closed';
        $laporan->catatan_selesai = $request->catatan_selesai;
        $laporan->tanggal_selesai = now(); // ✅ ini baris tambahan penting
        $laporan->save();

        return redirect()->back()->with('success', 'Laporan berhasil ditutup dengan catatan.');
    }
    public function updateCatatan(Request $request, $id)
    {
        $request->validate([
            'catatan_selesai' => 'required|string',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->catatan_selesai = $request->catatan_selesai;
        $laporan->status = 'closed';
        $laporan->tanggal_selesai = now(); // ✅ tambahkan ini juga
        $laporan->save();


        return redirect()->route('laporan.index')->with('success', 'Laporan ditutup dengan catatan.');
    }
    public function timeline($id)
    {
        $laporan = Laporan::findOrFail($id);

        return response()->json([
            'created_at'      => $laporan->created_at,
            'tanggal_mulai'   => $laporan->tanggal_mulai,
            'updated_at'      => $laporan->updated_at,
            'tanggal_selesai' => $laporan->tanggal_selesai,           // waktu laporan selesai/close
        ]);
    }

    // LaporanController.php

    public function respon($id)
    {
        $user = request()->user(); // Ini tetap lebih clean daripada auth()->user()
        $laporan = Laporan::findOrFail($id);

        // Pastikan hanya pelapor asli yang bisa konfirmasi laporannya
        if ($user->role !== 'pelapor' || $laporan->pelapor_id !== $user->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $laporan->user_confirmed = true;
        $laporan->save();

        return back()->with('success', 'Laporan telah dikonfirmasi selesai.');
    }
    public function riwayat(Request $request)
    {
        $user = Auth::user();

        // Ambil laporan milik pelapor
        $query = Laporan::with(['pelapor', 'pic', 'kategori'])
            ->where('pelapor_id', $user->id);

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('ticket_number', 'like', '%' . $request->search . '%');
        }

        $laporans = $query->latest()->paginate(10);

        return view('pelapor.riwayat', compact('laporans'));
    }
    public function ratingForm($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('pelapor.rating', compact('laporan'));
    }

    public function submitRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->rating = $request->rating;
        $laporan->user_confirmed = true;
        $laporan->save();

        return redirect()->route('pelapor.riwayat')->with('success', 'Terima kasih atas penilaian Anda.');
    }
}
