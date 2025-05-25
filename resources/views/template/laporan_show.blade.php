@extends('template.master')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4 font-weight-bold">📄 Detail Laporan</h4>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-3">
                <div class="card-header bg-primary text-white">
                    <strong>No Tiket:</strong> {{ $laporan->ticket_number }}
                </div>

                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Email:</strong><br>{{ $laporan->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Telepon:</strong><br>{{ $laporan->phone }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Departemen:</strong><br>{{ $laporan->department }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Kategori:</strong><br>{{ $laporan->kategori->nama_kategori ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Pelapor:</strong><br>{{ $laporan->pelapor->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Status:</strong><br>
                                <span class="badge 
                                    {{ $laporan->status == 'open' ? 'badge-warning' : 
                                       ($laporan->status == 'in_progress' ? 'badge-info' : 'badge-success') }}">
                                    {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p><strong>Deskripsi:</strong><br>{{ $laporan->description }}</p>
                    </div>

                    @if ($laporan->attachment)
                    <div class="mb-3">
                        <p><strong>Lampiran:</strong><br>
                            <a href="{{ asset('storage/' . $laporan->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                📎 Lihat Lampiran
                            </a>
                        </p>
                    </div>
                    @endif
                </div>

                <div class="card-footer bg-light text-right">
                    <a href="{{ route('totalLaporan') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
