@extends('template.master')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 font-weight-bold" style="font-size: xx-large;">Daftar Pengguna</h4>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped mt-2">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>No. SAP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>No. HP</th>
                <th>Departemen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                <td>{{ $user->no_sap }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge badge-secondary">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->no_hp }}</td>
                <td>{{ $user->departemen }}</td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">Detail</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada pengguna</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
