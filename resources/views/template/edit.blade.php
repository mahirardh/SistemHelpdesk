@extends('template.master')

@section('content')
<div class="container">
    <h3>Edit Pengguna</h3>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <!-- Input Nama -->
        <div class="form-group">
            <label for="name">Nama</label>
            <input name="name" id="name" type="text" class="form-control" value="{{ $user->name }}" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input name="email" id="email" type="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <!-- No SAP -->
        <div class="form-group">
            <label for="no_sap">No SAP</label>
            <input name="no_sap" id="no_sap" type="text" class="form-control" value="{{ $user->no_sap }}">
        </div>

        <!-- No HP -->
        <div class="form-group">
            <label for="no_hp">No HP</label>
            <input name="no_hp" id="no_hp" type="text" class="form-control" value="{{ $user->no_hp }}">
        </div>

        <!-- Departemen -->
        <div class="form-group">
            <label for="departemen">Departemen</label>
            <input name="departemen" id="departemen" type="text" class="form-control" value="{{ $user->departemen }}">
        </div>

        <!-- Role -->
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="asisten" {{ $user->role == 'asisten' ? 'selected' : '' }}>Asisten TI</option>
                <option value="krani" {{ $user->role == 'krani' ? 'selected' : '' }}>Krani TI</option>
                <option value="pelapor" {{ $user->role == 'pelapor' ? 'selected' : '' }}>Pelapor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
