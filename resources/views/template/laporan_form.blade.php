@extends('template.master')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0 font-weight-bold">Form Tambah Laporan</h5>
        </div>

        <div class="card-body">
            {{-- Pesan Berhasil --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Pesan Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Pelapor --}}
                <div class="form-group">
                    <label for="reporter_name" class="font-weight-bold">Nama Pelapor</label>
                    <input type="text" name="reporter_name" class="form-control" required>
                </div>

                {{-- Email & Telepon --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="font-weight-bold">Email Pelapor</label>
                        <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone" class="font-weight-bold">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>

                {{-- Kategori & Departemen --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="kategori_id" class="font-weight-bold">Kategori Masalah</label>
                        <select name="kategori_id" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="department" class="font-weight-bold">Departemen Pelapor</label>
                        <select name="department" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Departemen --</option>
                            <option value="HRD">HRD</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Produksi">Produksi</option>
                            <option value="Logistik">Logistik</option>
                            <option value="TI">TI</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                {{-- Deskripsi Masalah --}}
                <div class="form-group">
                    <label for="description" class="font-weight-bold">Deskripsi Masalah</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan masalah secara rinci..." required></textarea>
                </div>

                {{-- File Pendukung --}}
                <div class="form-group">
                    <label for="attachment" class="font-weight-bold">File Pendukung (Opsional)</label>
                    <input type="file" name="attachment" class="form-control-file">
                </div>

                {{-- Tombol Aksi --}}
                <div class="form-group d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
