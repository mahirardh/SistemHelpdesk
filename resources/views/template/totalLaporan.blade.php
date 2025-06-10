@extends('template.master')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4 font-weight-bold">Tabel Laporan</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="{{ route('totalLaporan') }}">
        <div class="row mb-3 align-items-center">
            <!-- Tombol Tambah -->
            <div class="col-md-6 text-left">
                <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                    Tambah Laporan
                </a>
            </div>

            <!-- Form Pencarian -->
            <div class="col-md-4 offset-md-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nomor tiket" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>No. Tiket</th>
                <th>Tanggal Dibuat</th>
                <th>Nama Pelapor</th>
                <th>PIC</th>
                <th>Kategori Masalah</th>
                <th>Status</th>
                <th width="160">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $laporan)
            <tr>
                <td>{{ $laporan->ticket_number }}</td>
                <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y H:i') }}</td>
                <td>{{ $laporan->pelapor->name ?? '-' }}</td>
                <td>{{ $laporan->pic ->name ?? '-' }}</td>
                <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                <td>
                    <span class="badge 
                            {{ $laporan->status == 'open' ? 'badge-warning' :
                               ($laporan->status == 'in_progress' ? 'badge-info' : 'badge-success') }}">
                        {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-secondary">Detail</a>
                    <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data laporan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $laporans->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection