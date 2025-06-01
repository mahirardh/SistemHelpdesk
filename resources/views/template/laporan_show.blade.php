@extends('template.master')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4 fw-bold">
        <i class="fas fa-file-alt"></i> Detail Laporan
    </h4>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow rounded-3">
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>No. Tiket</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->ticket_number }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Nama Pelapor</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->pelapor->name ?? '-' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Kategori</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->kategori->nama_kategori ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>No. HP</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->phone }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Email</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Departemen</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->department }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><strong>Deskripsi</strong></label>
                        <textarea class="form-control" rows="4" readonly>{{ $laporan->description }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Tanggal Laporan</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->created_at->format('d/m/Y') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Lampiran</strong></label><br>
                            @if ($laporan->attachment)
                            <a href="{{ asset('storage/' . $laporan->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File</a>
                            @else
                            <span class="text-muted">Tidak ada file</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>PIC Penanggung Jawab</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->pic->name ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Prioritas</strong></label>
                            <input type="text" class="form-control" value="{{ ucfirst($laporan->prioritas) ?? '-' }}" readonly>
                            <small class="form-text text-muted mt-1">
                                <a href="{{ route('prioritas.aturan') }}" target="_blank">
                                    Lihat aturan penentuan prioritas
                                </a>
                            </small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>SLA Close</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->sla_close ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Status</strong></label>
                            <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $laporan->status)) }}" readonly>
                        </div>
                    </div>

                    <!-- Tambahkan bagian ini setelah semua informasi laporan -->
                    @if($laporan->status == 'closed' && $laporan->catatan_selesai)
                    <div class="card border-success mt-4">
                        <div class="card-header bg-success text-white">
                            <strong>Catatan Penyelesaian</strong>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $laporan->catatan_selesai }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection