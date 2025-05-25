@extends('template.master')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4 font-weight-bold">Antrian Laporan</h4>

        <!-- Form Pencarian -->
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

        <!-- Tabel Antrian -->
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
                            <span class="badge badge-warning">{{ ucfirst($laporan->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm btn-success">Respon</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada laporan dengan status open.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
