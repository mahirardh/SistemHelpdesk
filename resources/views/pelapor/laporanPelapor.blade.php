@extends('template.master')

@section('content')
<div class="container-fluid">

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="font-weight-bold mb-0">Tabel Laporan</h1>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <form method="GET" action="{{ route('laporan.pelapor') }}" class="w-100">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Contoh: TIKET-12345"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tabel Data --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark text-center">
                <tr>
                    <th>No. Tiket</th>
                    <th>Tanggal Dibuat</th>
                    <th>Pelapor</th>
                    <th>PIC</th>
                    <th>Kategori Masalah</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $laporan)
                <tr class="text-center align-middle">
                    <td>{{ $laporan->ticket_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ $laporan->pelapor->name ?? '-' }}</td>
                    <td>{{ $laporan->pic->name ?? '-' }}</td>
                    <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                        <span class="badge 
                                {{ $laporan->status == 'open' ? 'badge-warning' : 
                                   ($laporan->status == 'in_progress' ? 'badge-info' : 'badge-success') }}">
                            {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-secondary mb-1">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $laporans->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
