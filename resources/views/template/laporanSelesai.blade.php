@extends('template.master')

@section('content')
<div class="container-fluid">

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('laporanSelesai') }}">
        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <h1 class="mb-0 font-weight-bold" style="font-size: xx-large;">Laporan Selesai</h1>
            </div>
            <div class="col-md-4 offset-md-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nomor tiket" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Tabel Laporan Selesai -->
    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr class="text-center">
                <th>No. Tiket</th>
                <th>Tanggal Dibuat</th>
                <th>Tanggal Selesai</th>
                <th>Nama Pelapor</th>
                <th>PIC</th>
                <th>Kategori Masalah</th>
                <th>Status</th>
                <th>SLA</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporanSelesai as $laporan)
            <tr class="text-center">
                <td>{{ $laporan->ticket_number }}</td>
                <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/y') }}</td>
                <td>{{ $laporan->tanggal_selesai ? \Carbon\Carbon::parse($laporan->tanggal_selesai)->format('d/m/y') : '-' }}</td>
                <td>{{ $laporan->pelapor->name ?? '-' }}</td>
                <td>{{ $laporan->pic->name ?? '-' }}</td>
                <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                <td><span class="badge badge-success">{{ ucfirst($laporan->status) }}</span></td>
                <td>
                    <span class="badge 
                @if($laporan->status_sla === 'Tepat Waktu') bg-success 
                @elseif($laporan->status_sla === 'Terlambat') bg-danger 
                @elseif($laporan->status_sla === 'Melewati Batas Waktu') bg-warning 
                @else bg-secondary 
                @endif">
                        {{ $laporan->status_sla }}
                    </span>
                </td>
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
    <div class="d-flex justify-content-end">
        {{ $laporanSelesai->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection