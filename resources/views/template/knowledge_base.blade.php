@extends('template.master')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 fw-bold">
        <i class="fas fa-book"></i> Knowledge Base / Solusi Masalah Umum
    </h4>

    <form method="GET" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan tiket, masalah, atau kategori..." value="{{ request('search') }}">
    </form>

    @if($laporans->count())
    <div class="faq-list">
        @foreach ($laporans as $laporan)
        <div class="faq-item mb-3 p-3 border rounded shadow-sm">
            <div
                class="faq-question fw-bold d-flex justify-content-between align-items-center"
                onclick="toggleAnswer(this)"
                style="cursor: pointer;">
                <span>
                    <i class="fas fa-ticket-alt text-primary"></i>
                    [{{ $laporan->ticket_number }}]
                    <i class="badge bg-info text-dark">
                        {{ $laporan->kategori->nama_kategori }}
                    </i>
                    - {{ Str::limit($laporan->description, 50) }}
                </span>
                <i class="fas fa-chevron-down toggle-icon text-muted"></i>
            </div>
            <div class="faq-answer mt-3" style="display: none;">
                <p class="mb-2"><strong>Masalah:</strong><br>{{ $laporan->description }}</p>
                <p class="mb-0"><strong>Solusi:</strong><br>{{ $laporan->catatan_selesai }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $laporans->links() }}
    </div>
    @else
    <p class="text-muted">Tidak ada data solusi yang ditemukan.</p>
    @endif
</div>

<script>
    function toggleAnswer(element) {
        const answer = element.nextElementSibling;
        const icon = element.querySelector('.toggle-icon');
        if (answer.style.display === 'none' || answer.style.display === '') {
            answer.style.display = 'block';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            answer.style.display = 'none';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
</script>
@endsection