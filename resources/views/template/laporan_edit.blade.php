@extends('template.master')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4 fw-bold">
        <i class="fas fa-file-alt"></i> Detail Laporan Masuk
    </h4>

    <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
        @csrf
        @method('PUT')

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
                                <label><strong>Nama</strong></label>
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
                                <input type="text" class="form-control" value="{{ $laporan->pelapor->no_hp }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label><strong>Email</strong></label>
                                <input type="text" class="form-control" value="{{ $laporan->pelapor->email }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Departemen</strong></label>
                                <input type="text" class="form-control" value="{{ $laporan->pelapor->departemen }}" readonly>
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

                        {{-- Editable fields --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label><strong>Ditangani oleh (PIC)</strong></label>
                                <select name="pic_id" class="form-control">
                                    @foreach ($listPIC as $pic)
                                    <option value="{{ $pic->id }}" {{ $laporan->pic_id == $pic->id ? 'selected' : '' }}>
                                        {{ $pic->name }} ({{ $pic->role }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Prioritas</strong></label>
                                <select name="prioritas" class="form-control">
                                    <option value="rendah" {{ $laporan->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ $laporan->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ $laporan->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                </select>
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
                                <input type="date" name="sla_close" class="form-control" value="{{ $laporan->sla_close }}">
                            </div>
                            <div class="col-md-6">
                                <label><strong>Status</strong></label>
                                <!-- Pilihan Status -->
                                <select name="status" id="statusDropdown" class="form-control" onchange="handleStatusChange()">
                                    <option value="open" {{ $laporan->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $laporan->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="closed" {{ $laporan->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal Popup untuk Catatan -->
<div class="modal fade" id="catatanModal" tabindex="-1" role="dialog" aria-labelledby="catatanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('laporan.updateCatatan', $laporan->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Catatan Penyelesaian</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea name="catatan_selesai" class="form-control" rows="4" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusDropdown = document.querySelector('select[name="status"]');
        if (statusDropdown) {
            statusDropdown.addEventListener('change', function() {
                if (this.value === 'closed') {
                    $('#catatanModal').modal('show');
                }
            });
        }
    });
</script>

@endsection