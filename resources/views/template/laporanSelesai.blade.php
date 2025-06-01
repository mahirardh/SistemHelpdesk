@extends('template.master')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 font-weight-bold">Laporan Selesai</h4>

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('laporanSelesai') }}">
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nomor tiket" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>

    <!-- Tabel Laporan Selesai -->
    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>No. Tiket</th>
                <th>Tanggal Dibuat</th>
                <th>Kategori Masalah</th>
                <th>Pelapor</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporanSelesai as $laporan)
                <tr>
                    <td>{{ $laporan->ticket_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $laporan->pelapor->name ?? '-' }}</td>
                    <td><span class="badge badge-success">{{ ucfirst($laporan->status) }}</span></td>
                    <td><a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada laporan selesai ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $laporanSelesai->withQueryString()->links() }}
    </div>
</div>
@endsection
