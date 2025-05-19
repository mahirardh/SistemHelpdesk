@extends('template.master')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 font-weight-bold">Tambah Pengguna</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="form-group">
            <label>Nama</label>
            <input name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input name="password" type="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>No. SAP</label>
            <input name="no_sap" class="form-control" required>
        </div>

        <div class="form-group">
            <label>No. HP</label>
            <input name="no_hp" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Departemen</label>
            <input name="departemen" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="asisten">Asisten TI</option>
                <option value="krani">Krani TI</option>
                <option value="pelapor">Pelapor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
