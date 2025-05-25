@extends('template.master')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4 font-weight-bold">Laporan Sedang Diproses</h4>

        <!-- Form Pencarian (tidak aktif) -->
        <form method="GET" action="#" disabled>
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nomor tiket" disabled>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" disabled>Cari</button>
                </div>
            </div>
        </form>

        <!-- Tabel Laporan -->
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
                @forelse ($laporans as $laporan)
                    <tr>
                        <td>{{ $laporan->ticket_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y H:i') }}</td>
                        <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $laporan->pelapor->name ?? '-' }}</td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $laporan->status)) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <button class="btn btn-sm btn-outline-secondary" disabled>Status: {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada laporan yang sedang diproses.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $laporans->withQueryString()->links() }}
    </div>
@endsection
