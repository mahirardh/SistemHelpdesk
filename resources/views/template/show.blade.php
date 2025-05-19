@extends('template.master')

@section('content')
<div class="container">
    <h3>Detail Pengguna</h3>
    <ul class="list-group">
        <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>No. SAP:</strong> {{ $user->no_sap }}</li>
        <li class="list-group-item"><strong>No. HP:</strong> {{ $user->no_hp }}</li>
        <li class="list-group-item"><strong>Departemen:</strong> {{ $user->departemen }}</li>
        <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
    </ul>
    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
