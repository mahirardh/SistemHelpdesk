@extends('template.master')

@section('content')
<div class="container-fluid">

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="font-weight-bold mb-0">DAFTAR LAPORAN</h1>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <form method="GET" action="{{ route('laporan.pelapor') }}" class="w-100">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Cari ticket"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-search mr-1"></i>
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
        <table class="table table-bordered mt-4">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>Ticket No.</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>PIC</th>
                    <th>Status</th>
                    <th>Lacak</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $laporan)
                <tr class="text-center align-middle">
                    <td>{{ $laporan->ticket_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/y') }}</td>
                    <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $laporan->pic->name ?? '-' }}</td>
                    <td>
                        <span class="badge 
                            {{ $laporan->status == 'open' ? 'badge-warning' : 
                               ($laporan->status == 'in_progress' ? 'badge-info' : 'badge-success') }}">
                            {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-dark"
                            data-bs-toggle="modal"
                            data-bs-target="#timelineModal"
                            data-id="{{ $laporan->id }}"
                            onclick="loadTimeline(this)">
                            Lacak
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-secondary">Detail</a>
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

<!-- Modal Timeline -->
<div class="modal fade" id="timelineModal" tabindex="-1" role="dialog" aria-labelledby="timelineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Timeline Laporan</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="timelineContent">
                <div class="text-center">Memuat data timeline...</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="timelineModal" tabindex="-1" aria-labelledby="timelineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timelineModalLabel">Timeline Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Konten timeline akan dimuat di sini -->
                <p>Loading...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function loadTimeline(button) {
    const laporanId = button.getAttribute('data-id');
    const modalBody = document.querySelector('#timelineContent');

    modalBody.innerHTML = '<p>Loading...</p>';

    fetch(`/laporan/${laporanId}/timeline`)
        .then(response => response.json())
        .then(data => {
            if (!data || Object.keys(data).length === 0) {
                modalBody.innerHTML = '<p>Timeline tidak tersedia.</p>';
                return;
            }

            let html = '<ul class="list-group">';

            if (data.created_at) {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Laporan Dibuat</strong>
                    <span class="badge bg-secondary">${new Date(data.created_at).toLocaleString('id-ID')}</span>
                </li>`;
            }

            if (data.tanggal_mulai) {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Laporan Dimulai (In Progress)</strong>
                    <span class="badge bg-primary">${new Date(data.tanggal_mulai).toLocaleString('id-ID')}</span>
                </li>`;
            }

            if (data.updated_at) {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Laporan Diperbarui</strong>
                    <span class="badge bg-warning text-dark">${new Date(data.updated_at).toLocaleString('id-ID')}</span>
                </li>`;
            }

            if (data.tanggal_selesai) {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Laporan Selesai</strong>
                    <span class="badge bg-success">${new Date(data.tanggal_selesai).toLocaleString('id-ID')}</span>
                </li>`;
            }

            html += '</ul>';
            modalBody.innerHTML = html;
        })
        .catch(() => {
            modalBody.innerHTML = '<p>Error saat memuat timeline.</p>';
        });
}
</script>
@endpush